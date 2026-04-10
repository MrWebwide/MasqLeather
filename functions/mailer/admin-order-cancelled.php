<?php


// Gerekli dosyaları dahil edin
require '../../admin/include/baglan.php'; // Veritabanı bağlantısı
require '../../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // AJAX isteğinden gelen verileri al
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $siparisid = $_POST['siparisid'];
    $reason = $_POST['reason'];
    
    // E-posta gönderimi
    $konu = "Order Cancelled";
    $icerik = "Dear <strong>$name $surname</strong>, <br><br>Sadly your order with order number of <strong>$siparisid</strong> has been cancelled.<br><br><strong> Order cancellation reason is :</strong><br><br> <strong> $reason </strong> <br><br>Best regards,<br><strong> Masq Leather </strong> ";
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
