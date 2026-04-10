<?php
session_start();
include("../../admin/include/baglan.php");
include("../../admin/include/fonksiyonlar.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = array('success' => false, 'message' => '');

// Rate limiting ayarları
$rateLimit = 5; // Belirli bir süre içinde izin verilen maksimum talep sayısı
$rateLimitTime = 60 * 5; // Süre sınırı (saniye olarak) - bu örnekte 5 dakika

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $currentTime = time();

    // IP adresi kontrolü
    if (isset($_SESSION['last_submit_time'])) {
        $lastSubmitTime = $_SESSION['last_submit_time'];
        $submitCount = $_SESSION['submit_count'];
    } else {
        $lastSubmitTime = 0;
        $submitCount = 0;
    }

    if (($currentTime - $lastSubmitTime) < $rateLimitTime) {
        if ($submitCount >= $rateLimit) {
            $response['message'] = "You are submitting too frequently. Please try again later.";
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } else {
            $_SESSION['submit_count'] = $submitCount + 1;
        }
    } else {
        $_SESSION['last_submit_time'] = $currentTime;
        $_SESSION['submit_count'] = 1;
    }

    // E-posta formatını kontrol et
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Please enter a valid email address.";
    } else {
        // Email adresinin zaten mevcut olup olmadığını kontrol et
        $checkQuery = $db->prepare("SELECT COUNT(*) FROM mail WHERE site_mail = :email");
        $checkQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $checkQuery->execute();
        $emailExists = $checkQuery->fetchColumn();

        if ($emailExists) {
            $response['message'] = "This email address is already subscribed.";
        } else {
            // Email adresini mail tablosunun site_mail kolonuna ekle
            $query = $db->prepare("INSERT INTO mail (site_mail) VALUES (:email)");
            $query->bindParam(':email', $email, PDO::PARAM_STR);

            if ($query->execute()) {
                $response['success'] = true;
                $response['message'] = "Subscription successful!";
            } else {
                $response['message'] = "There was an error. Please try again.";
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
