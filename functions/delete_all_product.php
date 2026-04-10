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
    if ($userId === 'noid') {
        // Noid oturumundaki tüm ürünleri sil
        session_name('noid');
        session_start();
        unset($_SESSION['cart']);
        session_write_close();
        echo "success"; // Silme işlemi başarılıysa "success" yanıtını döndür
    } else {
        // Kullanıcının tüm ürünlerini sepetinden silme sorgusu
        $stmt = $db->prepare("DELETE FROM sepet WHERE KullaniciID = ?");
        $stmt->execute([$userId]);
        echo "success"; // Silme işlemi başarılıysa "success" yanıtını döndür
    }
}
?>
