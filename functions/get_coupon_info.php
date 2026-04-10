<?php
session_start();

// Veritabanı bağlantısını dahil edin
include("../admin/include/baglan.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Kupon bilgilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM cupon WHERE KullaniciID = ?");
    $stmt->execute([$userId]);
    $couponInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // JSON formatında kupon bilgilerini döndürün
    echo json_encode($couponInfo);
}
?>
