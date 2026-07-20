<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
session_start(); // Oturumu başlat
$adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
$userId = (isset($_SESSION['id']) && $_SESSION['id'] !== '') ? $_SESSION['id'] : null;
$cuponFiyat = isset($_SESSION['cupon_fiyat']) ? $_SESSION['cupon_fiyat'] : 0; // kupon (default oturumdan yakala)

$totalPrice = 0;
$maxCargo = 0; // en yüksek per-ürün US kargosu

// MAS-85: hem giriş yapmış (sepet tablosu) hem misafir (noid oturum sepeti) ele alınır.
// Eskiden yalnız giriş yapmış kullanıcı ele alınıyordu → misafir US'te 0 kargo çıkıyordu.
if ($userId) {
    $stmt = $db->prepare("SELECT UrunFiyati, UrunMiktari, cargo_us FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $totalPrice += (float) $row['UrunFiyati'] * (int) $row['UrunMiktari'];
        if ((float) $row['cargo_us'] > $maxCargo) { $maxCargo = (float) $row['cargo_us']; }
    }
} else {
    session_write_close();
    session_name('noid');
    session_start();
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $qty     = (int) ($item['quantity'] ?? 0);
            $price   = (float) ($item['price'] ?? 0);
            $cargoUs = (float) ($item['cargo_us'] ?? ($item['cargo'] ?? 0));
            $totalPrice += $price * $qty;
            if ($cargoUs > $maxCargo) { $maxCargo = $cargoUs; }
        }
    }
    session_write_close();
}

// MAS-85: US kargo ücretleri panelden yönetilir (icecek id=2 = $cargopricesus).
// Kanada mantığının US karşılığı; config yoksa eski davranış ($150 üstü bedava) korunur.
if (!empty($cargopricesus)) {
    $cp = $cargopricesus;
    if ($totalPrice > (float) $cp['adi']) {
        $maxCargo = 0;
    }
    if ($totalPrice >= (float) $cp['yazi1'] && $totalPrice <= (float) $cp['yazi2']) {
        $maxCargo = $cp['onaciklama'];
    }
    if (($cp['durum'] ?? '') === 'on' && $totalPrice >= (float) $cp['yazi3'] && $totalPrice <= (float) $cp['yazi4']) {
        $maxCargo = $cp['yazi5'];
    }
    if (($cp['durum1'] ?? '') === 'on' && $totalPrice >= (float) $cp['yazi6'] && $totalPrice <= (float) $cp['yazi7']) {
        $maxCargo = $cp['yazi8'];
    }
    if (($cp['durum2'] ?? '') === 'on' && $totalPrice >= (float) $cp['yazi9'] && $totalPrice <= (float) $cp['yazi10']) {
        $maxCargo = $cp['kategori'];
    }
} else {
    if ($totalPrice > 150) {
        $maxCargo = 0;
    }
}

$cupon = ($totalPrice * $cuponFiyat) / 100;
// Toplam miktarı hesaplayın
$totalAmount = $totalPrice + $maxCargo  - $cupon;

// Yanıtı bir JSON nesnesi olarak hazırlayın
$response = [
    'totalAmount' => $totalAmount,
    'maxCargo' => $maxCargo
];

$_SESSION['totalAmount'] = $totalAmount;


// JSON yanıtını döndürün
header('Content-Type: application/json');
echo json_encode($response);
?>