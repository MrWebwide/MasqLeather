<?php
// delete_product.php

session_start();

// Veritabanı bağlantısını dahil edin
include("../admin/include/baglan.php");

$userId = null;

// Kullanıcı oturumda mı kontrol edin
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Kullanıcı oturumda değilse, sepet verilerini noid oturumundan al
    session_name('noid');
    session_start();
    if (isset($_SESSION['cart'])) {
        $userId = 'noid';
    }
    session_write_close(); // Oturumu kapat
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $userId !== null) {
    $productId = $_POST["productId"];
    $productCategory = $_POST["productCategory"]; // İlgili ürünün kategorisi

    // Kullanıcının sepetindeki ürünü ve kategorisiyle silme sorgusu
    $stmt = $db->prepare("DELETE FROM sepet WHERE KullaniciID = ? AND UrunID = ? AND urun_category = ?");
    $stmt->execute([$userId, $productId, $productCategory]);

    // Aynı ürünü noid oturumundan da sil
    session_name('noid');
    session_start();
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    session_write_close(); // Oturumu kapat

    // Silme işlemi başarılıysa, kullanıcının sepetini kontrol edin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

    if ($stmt->rowCount() === 0 && $userId !== 'noid') {
        echo "empty"; // Kullanıcı sepeti boşsa "empty" yanıtını döndür
    } else {
        echo "success"; // Diğer durumlarda "success" döndür
    }
}
?>
