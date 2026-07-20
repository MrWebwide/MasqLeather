<?php
// Veritabanı bağlantısı ve gerekli dosyaların dahil edilmesi


include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

error_reporting(0);
ini_set('display_errors', 0);

// MAS-109: adres artık id ile getirilir (kullanıcının birden çok adresi olabilir).
// Geriye dönük uyumluluk için adsoyad ile de çalışır (tek adres kalan eski akış).
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM useraddress WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $addressData = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($addressData);
} elseif (isset($_GET['adsoyad'])) {
    $adsoyad = $_GET['adsoyad'];
    $stmt = $db->prepare("SELECT * FROM useraddress WHERE adsoyad = :adsoyad");
    $stmt->bindParam(':adsoyad', $adsoyad);
    $stmt->execute();
    $addressData = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($addressData);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Address ID is missing']);
}
?>
