<?php
// copy_product.php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();


if (isset($_GET['delete_ip'])) {
    $ip_address = $_GET['delete_ip'];
  
    $stmt = $db->prepare("DELETE FROM ip WHERE IP = :ip");
    $stmt->bindParam(':ip', $ip_address);
  
    if ($stmt->execute()) {
        header("Location: sayac.php"); // İlgili admin sayfasına yönlendir
        exit();
    } else {
        echo "Hata: IP adresi silinemedi.";
    }
  }


?>