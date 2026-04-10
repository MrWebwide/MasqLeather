<?php
// copy_product.php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

// Mevcut ürünün ID'sini alıyoruz
$productId = $_GET['id'];

// Mevcut ürünün bilgilerini veritabanından alıyoruz
$statement = $db->prepare("SELECT * FROM urunler WHERE id = :id");
$statement->bindParam(':id', $productId);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

// Yeni bir ürün girişi oluşturuyoruz
$newProductStatement = $db->prepare("INSERT INTO urunler (adi, sira, resim, resim1, kategori, durum, onaciklama, aciklama, seo, yazi1, yazi3, yazi2, yazi4, yazi5, yazi6, yazi7, yazi8,yazi9, cargo, stock, cargo_us, tur, eklenme_tarihi) VALUES (:adi, :sira, :resim, :resim1, :kategori, :durum, :onaciklama, :aciklama, :seo, :yazi1, :yazi3, :yazi2, :yazi4, :yazi5, :yazi6,:yazi7,:yazi8,:yazi9, :cargo, :stock, :cargo_us, :tur, NOW())");
// Parametreleri tanımla
$newProductStatement->bindParam(':adi', $product['adi']);
$newProductStatement->bindParam(':sira', $product['sira']);
$newProductStatement->bindParam(':resim', $product['resim']);
$newProductStatement->bindParam(':resim1', $product['resim1']);
$newProductStatement->bindParam(':kategori', $product['kategori']);
$newProductStatement->bindParam(':durum', $product['durum']);
$newProductStatement->bindParam(':onaciklama', $product['onaciklama']);
$newProductStatement->bindParam(':aciklama', $product['aciklama']);
$newProductStatement->bindParam(':seo', $product['seo']);
$newProductStatement->bindParam(':yazi1', $product['yazi1']);
$newProductStatement->bindParam(':yazi3', $product['yazi3']);
$newProductStatement->bindParam(':yazi2', $product['yazi2']);
$newProductStatement->bindParam(':yazi4', $product['yazi4']);
$newProductStatement->bindParam(':yazi5', $product['yazi5']);
$newProductStatement->bindParam(':yazi6', $product['yazi6']);
$newProductStatement->bindParam(':yazi7', $product['yazi7']);
$newProductStatement->bindParam(':yazi8', $product['yazi8']);
$newProductStatement->bindParam(':yazi9', $product['yazi9']);
$newProductStatement->bindParam(':cargo', $product['cargo']);
$newProductStatement->bindParam(':stock', $product['stock']);
$newProductStatement->bindParam(':cargo_us', $product['cargo_us']);
$newProductStatement->bindParam(':tur', $product['tur']);

// Yeni ürünü veritabanına ekle
$newProductStatement->execute();

// Yeni ürünün ID'sini alıyoruz
$newProductId = $db->lastInsertId();

// Mevcut ürünün resimlerini alıyoruz
$cek = $db->prepare("SELECT * FROM urun_img WHERE urun_id = :id");
$cek->bindParam(':id', $productId);
$cek->execute();
$resimler = $cek->fetchAll(PDO::FETCH_ASSOC);

// Yeni ürünün resimlerini ekliyoruz
foreach ($resimler as $resim) {
    $ekle = $db->prepare("INSERT INTO urun_img (urun_id, img) VALUES (:urun_id, :img)");
    $ekle->bindParam(':urun_id', $newProductId);
    $ekle->bindParam(':img', $resim['img']);
    $ekle->execute();
}

echo "Yeni ürünün ID'si: " . $newProductId;
?>
