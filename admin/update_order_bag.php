<?php
// Veritabanı bağlantısı
include './include/baglan.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Gelen JSON verisini al
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Yeni sıralama değerlerini güncelle
foreach ($data as $item) {
    $productId = $item['id'];
    $productOldOrder = $item['oldorder'];
    $productOrder = $item['order'];

    // Eğer sıralama değişmediyse, güncelleme yapmayın
    if ($productOldOrder == $productOrder) {
        continue;
    }

    // Sıralama değiştiyse, yeni sıralama değerlerini güncelle
    $sql = "UPDATE urunler SET sira = :sira WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $productId);
    $stmt->bindParam(':sira', $productOrder);
    $stmt->execute();
}

// Sıralama değişikliklerini algılayıp sıralamayı yeniden düzenle
$sql = "SET @new_order := 0;
        UPDATE urunler
        SET sira = (@new_order := @new_order + 1)
        ORDER BY sira ASC";
$stmt = $db->prepare($sql);
$stmt->execute();

// Başarılı yanıtı gönder
http_response_code(200);
echo "Sıralama güncellendi";
?>
