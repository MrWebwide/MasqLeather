<?php
/**
 * contact-form.php — İletişim formu gönderimi (AJAX, JSON yanıt).
 *
 * Spam koruması: honeypot ("website" alanı) + sunucu tarafı doğrulama + basit
 * rate-limit. (Eskiden reCAPTCHA zorunluydu ama widget render olmuyordu →
 * form HİÇ gönderilmiyordu. reCAPTCHA kaldırıldı.)
 */

require_once '../../admin/include/baglan.php';        // config.php + $db (PDO)
require_once '../../admin/include/fonksiyonlar.php';
require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function jsonOut(bool $ok, string $msg): void
{
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}

// Sadece POST
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    jsonOut(false, 'Invalid request.');
}

// --- Honeypot: bot bu gizli alanı doldurur; gerçek kullanıcı boş bırakır.
// Bot'a "başarılı" göster ama HİÇBİR ŞEY gönderme (tuzağı belli etme).
if (!empty(trim((string) ($_POST['website'] ?? '')))) {
    jsonOut(true, 'Your message has been delivered.');
}

// --- Basit rate-limit: aynı oturumdan 20 sn'de bir gönderim.
$now = time();
if (isset($_SESSION['last_contact_ts']) && ($now - $_SESSION['last_contact_ts']) < 20) {
    jsonOut(false, 'Please wait a few seconds before sending another message.');
}

// --- Girdileri al + temizle
$name    = trim((string) ($_POST['name'] ?? ''));
$email   = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$title   = trim((string) ($_POST['title'] ?? ''));
$senderip = $_SERVER['REMOTE_ADDR'] ?? 'unknown'; // SUNUCUDAN — client'a güvenme

// --- Sunucu tarafı doğrulama
$allowedTitles = ['Refund', 'Question about Product', 'Shipment', 'Payment Issues', 'Other'];

if ($name === '' || $email === '' || $message === '') {
    jsonOut(false, 'Please fill in all required fields.');
}
if (mb_strlen($name) > 100) {
    jsonOut(false, 'Name is too long.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonOut(false, 'Please enter a valid e-mail address.');
}
if (mb_strlen($message) > 500) {
    jsonOut(false, 'Your message should be at most 500 characters long.');
}
if (!in_array($title, $allowedTitles, true)) {
    jsonOut(false, 'Please choose a valid title.');
}

// --- E-posta gövdesi: kullanıcı girdisi ESCAPE edilir (HTML injection önlenir)
$esc = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
$konu   = 'Contact Form: ' . $title;
$icerik = 'Full Name: ' . $esc($name) . '<br>'
        . 'Email: ' . $esc($email) . '<br>'
        . 'Sender IP: ' . $esc($senderip) . '<br>'
        . 'Title: ' . $esc($title) . '<br><br>'
        . 'Message:<br>' . nl2br($esc($message));

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
try {
    configureMailer($mail);
    $mail->addAddress(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    if (defined('ADMIN_EMAIL') && ADMIN_EMAIL && ADMIN_EMAIL !== MAIL_FROM_ADDRESS) {
        $mail->addAddress(ADMIN_EMAIL, MAIL_FROM_NAME);
    }
    $mail->addReplyTo($email, $name); // yanıtla → gönderen kişiye gitsin
    $mail->isHTML(true);
    $mail->Subject = $konu;
    $mail->Body    = $icerik;
    $mail->AltBody = "Full Name: $name\nEmail: $email\nSender IP: $senderip\nTitle: $title\n\n$message";

    $mail->send();

    $_SESSION['last_contact_ts'] = $now; // rate-limit zaman damgası
    jsonOut(true, 'Your message has been delivered.');
} catch (Exception $ex) {
    error_log('Contact form mail error: ' . $mail->ErrorInfo);
    jsonOut(false, 'Message could not be sent. Please try again later.');
}
