<?php
/**
 * update_order.php — Genel sürükle-bırak sıralama kaydedici (tüm panel).
 *
 * Eskiden her tablo için ayrı update_order_*.php kopyası vardı. Artık tek endpoint:
 *   POST  update_order.php?table=<whitelist>
 *   body: JSON  [{ "id":N, "oldorder":N, "order":N }, ...]
 *
 * Güvenlik: tablo adı whitelist'ten gelir + admin oturumu şart.
 */

include __DIR__ . '/include/baglan.php';        // $db
include __DIR__ . '/include/fonksiyonlar.php';
error_reporting(0);
ini_set('display_errors', 0);

session_start();
header('Content-Type: text/plain; charset=utf-8');

// Sadece giriş yapmış admin
if (empty($_SESSION['eposta'])) {
    http_response_code(403);
    exit('forbidden');
}

// Yalnızca bu tablolarda sira güncellenebilir
$allowed = [
    'urun_kategori', 'bolge_kategori', 'mer_kategori', 'jewe_kategori',
    'urunler', 'accessories', 'jewe', 'homedecor', 'ourcollection',
    'bloglar', 'bloglarmer', 'cupon', 'etiket', 'galeri', 'istatik', 'haberler',
    'amenu', 'cargo_kategori', 'cargo_kategori_us', 'fiyatlar', 'sss', 'yorumlar',
    'new', 'sc', 'spe_kategori', 'menu',
    'slider', 'sliderbir', 'slideriki', 'slideruc', 'sliderdort',
    'portfoy', 'referanslar', 'sayfalar', 'video', 'dil',
];

$table = $_GET['table'] ?? '';
if (!in_array($table, $allowed, true)) {
    http_response_code(400);
    exit('bad table');
}

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
    http_response_code(400);
    exit('bad data');
}

// Gelen yeni sıraları yaz (değişmeyenleri atla)
$upd = $db->prepare("UPDATE {$table} SET sira = :sira WHERE id = :id");
foreach ($data as $item) {
    if (!isset($item['id'], $item['order'])) {
        continue;
    }
    if (isset($item['oldorder']) && (string) $item['oldorder'] === (string) $item['order']) {
        continue;
    }
    $upd->execute([':sira' => (int) $item['order'], ':id' => (int) $item['id']]);
}

// sira'yı bitişik (1..N) hale getir → boşluk/çakışma kalmasın
$db->exec("SET @n := 0");
$db->exec("UPDATE {$table} SET sira = (@n := @n + 1) ORDER BY sira ASC, id ASC");

http_response_code(200);
echo 'ok';
