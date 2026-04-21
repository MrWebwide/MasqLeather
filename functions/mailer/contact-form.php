<?php
// Gerekli dosyaları dahil edin
require_once '../../admin/include/baglan.php'; // Veritabanı bağlantısı
require_once '../../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar
require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';

// AJAX isteğinden gelen verileri al
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$title = $_POST['title'];
$senderip = $_POST['senderip'];
$recaptcha_response = $_POST['g-recaptcha-response'];

// reCAPTCHA doğrulama fonksiyonu
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

// reCAPTCHA doğrulama kontrolü
$recaptcha_result = reCaptcha($recaptcha_response);

$response = array(); // Yanıtı oluştur

if ($recaptcha_result['success']) {
    // E-posta gönderimi
    $konu = "$title";
    $icerik = "Full Name: $name <br> Sender IP Address: $senderip <br> Email: $email <br>Message: $message";
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        configureMailer($mail);
        $mail->addAddress(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addAddress(ADMIN_EMAIL, MAIL_FROM_NAME);

        $mail->isHTML(true);
        $mail->Subject = $konu;
        $mail->Body    = $icerik;

        $mail->send();

        // E-posta gönderimi başarılı ise mesajı döndür
        $response['success'] = true;
        $response['message'] = "E-posta başarıyla gönderildi!";
    } catch (Exception $e) {
        // E-posta gönderimi başarısız ise hata mesajını döndür
        $response['success'] = false;
        $response['message'] = "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
    }
} else {
    // reCAPTCHA doğrulaması başarısızsa hata mesajını döndür
    $response['success'] = false;
    $response['message'] = "reCAPTCHA doğrulaması başarısız. Güvenlik adımını doğrulayın.";
}

// JSON formatında yanıtı gönder
header('Content-Type: application/json');
echo json_encode($response);
?>
