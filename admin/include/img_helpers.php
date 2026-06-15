<?php
/**
 * img_helpers.php — Ürün galeri görselleri için yardımcılar. (MAS-30)
 *
 * Eskiden görseller DELETE edilip döngüde tek tek INSERT ediliyordu (N+1) ve yeni ürün id'si
 * `ORDER BY id DESC` ile alınıyordu (yarış koşulu riski). Bu fonksiyon görselleri tek
 * (multi-row) INSERT ile yazar; yeni id için çağıran taraf lastInsertId() kullanmalı.
 *
 * @param string $imgTable  Görsel tablosu (urun_img/accessories_img/jewe_img/home_img)
 * @param int    $productId Ürün id'si
 * @param mixed  $imgs      $_POST['img'] (dizi) — görsel dosya adları
 * @param string $tur       Ürün türü
 */
function masq_save_product_images(PDO $db, string $imgTable, int $productId, $imgs, string $tur): void
{
    $imgTable = preg_replace('/[^a-zA-Z0-9_]/', '', $imgTable); // güvenlik

    // Edit'te mevcut satırları sil (yeni üründe no-op)
    $db->prepare("DELETE FROM {$imgTable} WHERE urun_id = ?")->execute([$productId]);

    if (!is_array($imgs)) { return; }
    $imgs = array_values(array_filter($imgs, function ($x) { return $x !== '' && $x !== null; }));
    if (!$imgs) { return; }

    $place = implode(',', array_fill(0, count($imgs), '(?, ?, ?)'));
    $vals = [];
    foreach ($imgs as $img) { $vals[] = $productId; $vals[] = $img; $vals[] = $tur; }
    $db->prepare("INSERT INTO {$imgTable} (urun_id, img, tur) VALUES {$place}")->execute($vals);
}
