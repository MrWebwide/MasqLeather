<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';

include_once("../admin/include/baglan.php");
include_once("../admin/include/fonksiyonlar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = $_POST["adsoyad"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    $unqid = $_POST["unqid"];
    $resim = $_POST["resim"];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // E-postanın daha önce kaydedilip kaydedilmediğini kontrol et (onay_durumu=1 olanlar için)
        $sql = "SELECT * FROM uyeler WHERE email = :email AND onay_durumu = 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Onay_durumu=1 olan üye tekrar kayıt yapamaz, hata mesajı döndürün
            $response = array(
                'success' => false,
                'message' => "This email has been used before."
            );
            echo json_encode($response);
        } else {
            // Onay_durumu=1 olmayan kullanıcılar için kayıt işlemlerine devam edin
            if (strlen($sifre) < 8) {
                $response = array(
                    'success' => false,
                    'message' => "Password must be at least 8 characters."
                );
                echo json_encode($response);
            } else {
                if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                    $response = array(
                        'success' => false,
                        'message' => "Verify the security step."
                    );
                    echo json_encode($response);
                } else {
                    $recaptcha_response = $_POST['g-recaptcha-response'];
                    $recaptcha_result = reCaptcha($recaptcha_response);

                    if ($recaptcha_result['success']) {
                        // E-postanın daha önce kaydedilip kaydedilmediğini kontrol et
                        $sql = "SELECT * FROM uyeler WHERE email = :email";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($user['onay_durumu'] == 0) {
                                // Onay_durumu 0 olan kullanıcılar için onay formunu gösterin ve tekrar e-posta gönderin
                                $onayKodu = generateRandomString(6);

                                $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

                                $sql = "UPDATE uyeler SET sifre = :sifre, resim = :resim, onay_kodu = :onay_kodu, onay_durumu = 0 WHERE email = :email";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':resim', $resim);
                                $stmt->bindParam(':sifre', $hashed_password);
                                $stmt->bindParam(':onay_kodu', $onayKodu);

                                if ($stmt->execute()) {
                                    $konu = "Account Verification Code";
                                    $icerik = "Use the confirmation code below to activate your account: $onayKodu";
                                    $gonderen = "info@masqleather.com";

                                    $mail = new PHPMailer(true);

                                    try {
                                        configureMailer($mail);

                                        $mail->addAddress($email, 'Your Mail');

                                        $mail->isHTML(true);
                                        $mail->Subject = $konu;
                                        $mail->Body    = $icerik;

                                        $mail->send();

                                        $member_id = $user['id'];
                                        $response = array(
                                            'success' => true,
                                            'message' => 'A new verification code has been sent to your email.',
                                            'show_second_form' => true,
                                            'member_id' => $member_id
                                        );
                                        echo json_encode($response);
                                    } catch (Exception $e) {
                                        $response = array(
                                            'success' => false,
                                            'message' => "An error occurred while sending the email: {$mail->ErrorInfo}"
                                        );
                                        echo json_encode($response);
                                    }
                                } else {
                                    $response = array(
                                        'success' => false,
                                        'message' => "Hata: " . $stmt->errorInfo()[2]
                                    );
                                    echo json_encode($response);
                                }
                            } else {
                                // Onay_durumu 0 olmayan kullanıcılar için doğrudan kayıt işlemini yapın ve onay formunu göstermeyin
                                $onayKodu = generateRandomString(6);

                                $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

                                $sql = "INSERT INTO uyeler (adsoyad, resim, unqid, email, sifre, onay_kodu, onay_durumu) VALUES (:adsoyad, :resim, :unqid, :email, :sifre, :onay_kodu, 0)";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':adsoyad', $adsoyad); // Yeni satır
                                $stmt->bindParam(':unqid', $unqid); 
                                $stmt->bindParam(':resim', $resim);

                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':sifre', $hashed_password);
                                $stmt->bindParam(':onay_kodu', $onayKodu);

                                if ($stmt->execute()) {
                                    $konu = "Account Verification Code";
                                    $icerik = "Use the confirmation code below to activate your account: $onayKodu";
                                    $gonderen = "info@masqleather.com";

                                    $mail = new PHPMailer(true);

                                    try {
                                        configureMailer($mail);

                                        $mail->addAddress($email, 'Your Mail');

                                        $mail->isHTML(true);
                                        $mail->Subject = $konu;
                                        $mail->Body    = $icerik;

                                        $mail->send();

                                        $member_id = $db->lastInsertId(); // Yeni eklenen üyenin ID'sini alın
                                        $response = array(
                                            'success' => true,
                                            'message' => "Member registered. Please check your email and enter the confirmation code to activate your account.",
                                            'show_second_form' => true,
                                            'member_id' => $member_id
                                        );
                                        echo json_encode($response);
                                    } catch (Exception $e) {
                                        $response = array(
                                            'success' => false,
                                            'message' => "An error occurred while sending the email: {$mail->ErrorInfo}"
                                        );
                                        echo json_encode($response);
                                    }
                                } else {
                                    $response = array(
                                        'success' => false,
                                        'message' => "Hata: " . $stmt->errorInfo()[2]
                                    );
                                    echo json_encode($response);
                                }
                            }
                        } else {
                            // E-posta daha önce kaydedilmemişse, yeni kayıt işlemlerini gerçekleştirin
                            $onayKodu = generateRandomString(6);

                            $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

                            $sql = "INSERT INTO uyeler (adsoyad, resim, unqid,email, sifre, onay_kodu, onay_durumu) VALUES ( :adsoyad, :resim, :unqid, :email,  :sifre, :onay_kodu, 0)";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':adsoyad', $adsoyad);
                            $stmt->bindParam(':unqid', $unqid); 
                            $stmt->bindParam(':resim', $resim);

                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':sifre', $hashed_password);
                            $stmt->bindParam(':onay_kodu', $onayKodu);

                            if ($stmt->execute()) {
                                $konu = "Account Verification Code";
                                $icerik = "Use the confirmation code below to activate your account: $onayKodu";
                                $gonderen = "info@masqleather.com";

                                $mail = new PHPMailer(true);

                                try {
                                    configureMailer($mail);

                                    $mail->addAddress($email, 'Your Mail');

                                    $mail->isHTML(true);
                                    $mail->Subject = $konu;
                                    $mail->Body    = $icerik;

                                    $mail->send();

                                    $member_id = $db->lastInsertId(); // Yeni eklenen üyenin ID'sini alın
                                    $response = array(
                                        'success' => true,
                                        'message' => "Member registered. Please check your email and enter the confirmation code to activate your account.",
                                        'show_second_form' => true,
                                        'member_id' => $member_id
                                    );
                                    echo json_encode($response);
                                } catch (Exception $e) {
                                    $response = array(
                                        'success' => false,
                                        'message' => "An error occurred while sending the email: {$mail->ErrorInfo}"
                                    );
                                    echo json_encode($response);
                                }
                            } else {
                                $response = array(
                                    'success' => false,
                                    'message' => "Hata: " . $stmt->errorInfo()[2]
                                );
                                echo json_encode($response);
                            }
                        }
                    } else {
                        $response = array(
                            'success' => false,
                            'message' => "Verify the security step."
                        );
                        echo json_encode($response);
                    }
                }
            }
        }
    } else {
        $response = array(
            'success' => false,
            'message' => "Invalid e-mail address."
        );
        echo json_encode($response);
    }
}

function reCaptcha($response) {
    $fields = [
        'secret' => '6LeKXjEnAAAAAO9paP2_8k0L4lPcqtEb-4JEkQIB',
        'response' => $response
    ];
    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_RETURNTRANSFER => true
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function generateRandomString($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
