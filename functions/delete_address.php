<?php
require '../admin/include/baglan.php'; // Veritabanı bağlantısı
require '../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adsoyad'])) {
    $adsoyad = $_POST['adsoyad'];

    // Adresi sil
    $stmt = $db->prepare("DELETE FROM useraddress WHERE adsoyad = :adsoyad");
    $stmt->bindParam(':adsoyad', $adsoyad);
    
    if ($stmt->execute()) {
        // İşlem başarılıysa
        http_response_code(200);
    } else {
        // İşlem başarısızsa
        http_response_code(500);
    }
} else {
    http_response_code(400);
}
?>
