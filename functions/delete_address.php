<?php
session_start();
require '../admin/include/baglan.php'; // Veritabanı bağlantısı
require '../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar

$userId = $_SESSION['id'] ?? '';

// MAS-109: adres id ile silinir + yalnızca oturum sahibinin kaydı silinebilir (güvenlik)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $userId !== '') {
    $id = intval($_POST['id']);

    $stmt = $db->prepare("DELETE FROM useraddress WHERE id = :id AND userid = :userid");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userid', $userId);

    if ($stmt->execute()) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adsoyad'])) {
    // Geriye dönük uyumluluk (eski çağrılar) — adsoyad ile sil
    $adsoyad = $_POST['adsoyad'];
    $stmt = $db->prepare("DELETE FROM useraddress WHERE adsoyad = :adsoyad");
    $stmt->bindParam(':adsoyad', $adsoyad);
    if ($stmt->execute()) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
} else {
    http_response_code(400);
}
?>
