<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Üye ID'sini veritabanından silme işlemini gerçekleştirin
    $sql = "DELETE FROM uyeler WHERE id = :member_id AND onay_durumu = 0 AND kayit_tarihi < (NOW() - INTERVAL 20 SECOND)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':member_id', $_POST["member_id"]);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}


?>