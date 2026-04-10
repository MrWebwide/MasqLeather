<?php
// Veritabanı bağlantısı ve gerekli dosyaların dahil edilmesi


include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// AJAX isteği ile gelen seçilen adresin ID'sini al
if (isset($_GET['adsoyad'])) {
    $adsoyad = $_GET['adsoyad'];

    // Veritabanından ilgili adresin verilerini sorgula
    $stmt = $db->prepare("SELECT * FROM useraddress WHERE adsoyad = :adsoyad");
    $stmt->bindParam(':adsoyad', $adsoyad);
    $stmt->execute();
    $addressData = $stmt->fetch(PDO::FETCH_ASSOC);

    // JSON formatında verileri geri döndür
    header('Content-Type: application/json');
    echo json_encode($addressData);
} else {
    // Eğer adres ID'si belirtilmediyse hata döndür
    http_response_code(400);
    echo json_encode(['error' => 'Address ID is missing']);
}
?>
