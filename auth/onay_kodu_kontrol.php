<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gönderilen e-posta adresini al
    $email = $_POST["email"];
    // Veritabanında e-posta adresini kontrol et
    $sql = "SELECT * FROM uyeler WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // E-posta adresi veritabanında bulunuyor, onay kodunu oluştur ve e-posta gönder
        $onayKodu = generateRandomString(8); // Rastgele 8 karakterli bir onay kodu oluştur

        // Onay kodunu veritabanına kaydetme işlemlerini yapabilirsiniz
        $sql_update = "UPDATE uyeler SET onay_kodu = :onayKodu WHERE email = :email";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bindParam(':onayKodu', $onayKodu);
        $stmt_update->bindParam(':email', $email);
        $stmt_update->execute();

        // E-postayı gönderme işlemlerini yapabilirsiniz
        $mail = new PHPMailer(true);

        try {
            configureMailer($mail);
            $mail->addAddress($email); // Alıcı e-posta adresi
            $mail->Subject = 'Confirmation code'; // E-posta konusu
            $mail->Body    = 'Your confirmation code: ' . $onayKodu; // E-posta içeriği

            $mail->send();

            $response = array(
                'success' => true,
                'message' => 'Consent form has been sent. Please check your email.'
            );
            echo json_encode($response);
        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => 'An error occurred while sending the email: ' . $mail->ErrorInfo
            );
            echo json_encode($response);
        }
    } else {
        // E-posta adresi veritabanında bulunmuyor, hata mesajını döndür
        $response = array(
            'success' => false,
            'message' => 'Email address not available.'
        );
        echo json_encode($response);
    }
}

// Rastgele onay kodu oluşturmak için yardımcı fonksiyon
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>