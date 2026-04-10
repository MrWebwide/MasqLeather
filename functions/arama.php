<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");


session_start(); // Oturumu başlat

// Formdan gelen arama terimini alın
if (isset($_POST['arama_terimi'])) {
    $arama_terimi = trim($_POST['arama_terimi']);

    // Veritabanında ürünleri adlarına göre arayın (prepared statement)
    $stmt = $db->prepare("SELECT * FROM urunler WHERE adi LIKE :arama");
    $stmt->execute([':arama' => '%' . $arama_terimi . '%']);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Product Name: " . htmlspecialchars($row["adi"]) . "<br>";
        }
    } else {
        echo "Ürün bulunamadı.";
    }
}


?>

