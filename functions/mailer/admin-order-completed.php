<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Gerekli dosyaları dahil edin
require '../../admin/include/baglan.php'; // Veritabanı bağlantısı
require '../../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // AJAX isteğinden gelen verileri al
    $trackingid = $_POST['trackingid'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $siparisid = $_POST['siparisid'];
    
    // E-posta gönderimi
    $konu = "Order Completed";
    $icerik = "Dear <strong>$name $surname</strong>, <br><br>We're delighted to inform you that your order with the order number <strong>$siparisid</strong> has been successfully delivered to your doorstep. We hope you're excited to receive your purchase and that it meets your expectations.<br><br>You can make your comments about the product in the comment section on our website.<br><br>Best regards,<br><strong> Masq Leather <br>info@masqleather.com </strong> ";
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        configureMailer($mail);
        $mail->addAddress($email, $name); // Kullanıcının e-posta adresi ve ismi

        $mail->isHTML(true);
        $mail->Subject = $konu;
        $mail->Body    = $icerik;

        $mail->send();

        // E-posta gönderimi başarılı ise mesajı gönder
        echo "E-posta başarıyla gönderildi!";
    } catch (Exception $e) {
        // E-posta gönderimi başarısız ise hata mesajını gönder
        echo "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
    }
}
?>
