<?php


// Gerekli dosyaları dahil edin
require_once '../../admin/include/baglan.php'; // Veritabanı bağlantısı
require_once '../../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar
require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // AJAX isteğinden gelen verileri al
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $siparisid = $_POST['siparisid'];
    $reason = $_POST['reason'];
    
    // E-posta gönderimi (MAS-83: metin panelden düzenlenebilir; yoksa aşağıdaki default kullanılır)
    require_once __DIR__ . '/../mail_templates.php';
    $tpl = masq_mail_template($db, 'order_cancelled',
        ['name' => $name, 'surname' => $surname, 'order_no' => $siparisid, 'reason' => $reason],
        ['konu' => "Order Cancelled",
         'icerik' => "Dear <strong>$name $surname</strong>, <br><br>Sadly your order with order number of <strong>$siparisid</strong> has been cancelled.<br><br><strong> Order cancellation reason is :</strong><br><br> <strong> $reason </strong> <br><br>Best regards,<br><strong> Masq Leather </strong> "]);
    $konu = $tpl['konu'];
    $icerik = $tpl['icerik'];
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
