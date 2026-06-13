<?php
/**
 * control.php — Checkout formunu işler ve Stripe ödeme sayfasına yönlendirir. (MAS-10)
 *
 * Eskiden üye/misafir için ~80'er satırlık İKİ kopya bloktu. Artık tek yol:
 *   1) Form alanlarını al + zorunlu alan kontrolü
 *   2) Sipariş kalemlerini OTORİTER kaynaktan topla (sepet / noid cart — tur garantili)
 *   3) Tek bir $payload kur ve session'a koy ($_SESSION['masq_order_payload'])
 *   4) Stripe ödeme sayfasına (pay.php) yönlendir
 *
 * Sipariş artık burada DB'ye YAZILMAZ; ödeme onayı geldikten sonra
 * stripe/webhook.php -> masq_create_order() ile yazılır.
 */

session_start();
require_once __DIR__ . '/../admin/include/baglan.php';   // $db (+ config.php)
require_once __DIR__ . '/order_payload.php';

error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../checkout.php');
    exit;
}

$isLoggedIn = isset($_SESSION['id']);

// --- Form alanları ---
$textFields = [
    'name', 'surname', 'address', 'city', 'province', 'postal', 'phone', 'email', 'country',
    'namebill', 'surnamebill', 'addressbill', 'citybill', 'provincebill', 'postalbill', 'addname',
];
$in = [];
foreach ($textFields as $f) {
    $in[$f] = isset($_POST[$f]) ? trim($_POST[$f]) : '';
}

$adsoyad  = $isLoggedIn ? ($_SESSION['adsoyad'] ?? '') : 'No account';
$userId   = $isLoggedIn ? $_SESSION['id'] : 'No account';
$maxCargo = isset($_POST['cargo_transfer']) ? floatval($_POST['cargo_transfer']) : 0;

// Sipariş kalemlerini OTORİTER kaynaktan topla (sepet / noid cart — tur garantili)
$items = masq_collect_order_items($db);

// Tutarı kalemlerden HESAPLA. Misafirde $_SESSION['huso'] noid session'da kalıp boş
// gelebildiği için session tutarına güvenmiyoruz; tek otoriter kaynak sepet kalemleri.
$subtotal  = 0.0;
foreach ($items as $it) {
    $subtotal += (float) $it['totalPrice'];
}
$couponPct = isset($_SESSION['cupon_fiyat']) ? (float) $_SESSION['cupon_fiyat'] : 0;
$gift      = isset($_SESSION['gift_card_amount']) ? (float) $_SESSION['gift_card_amount'] : 0;
$total     = max(0, $subtotal - ($subtotal * $couponPct / 100) + $maxCargo - $gift);
$totalAmount = number_format($total, 2, '.', '');

// --- Zorunlu alan kontrolü ---
$required = ['name', 'surname', 'address', 'city', 'province', 'postal', 'phone', 'email', 'country'];
$missing  = empty($items); // sepet boşsa devam etme
foreach ($required as $r) {
    if ($in[$r] === '') {
        $missing = true;
        break;
    }
}
if ($isLoggedIn && ($in['addname'] === '' || $adsoyad === '')) {
    $missing = true;
}
// Kanada (country=2) için geçerli bir province (eyalet) zorunlu. "USA" placeholder/sentinel'i
// Kanada'da geçersiz (vergi/kargo için kritik). Client-side ile aynı kural; JS kapalıyken de korur.
if ($in['country'] === '2' && ($in['province'] === '' || $in['province'] === 'USA')) {
    $missing = true;
}
if ($missing) {
    header('Location: ../checkout.php');
    exit;
}

// --- Session'a temel bilgiler (geriye dönük uyumluluk + stripe/checkout.php tutar için) ---
foreach ($textFields as $f) {
    $_SESSION[$f] = $in[$f];
}
$_SESSION['userId']  = $userId;
$_SESSION['adsoyad'] = $adsoyad;
$_SESSION['maxCargo'] = $maxCargo;
if ($isLoggedIn) {
    $_SESSION['totalAmount'] = $totalAmount;
} else {
    $_SESSION['huso'] = $totalAmount;
}

// Benzersiz sipariş no
$siparisId = time() . '_' . ($isLoggedIn ? $userId : mt_rand(0, 9999));
$_SESSION['siparisId'] = $siparisId;

// --- Tek payload --- ($items ve $totalAmount yukarıda hesaplandı)
$_SESSION['masq_order_payload'] = [
    'siparisId'   => $siparisId,
    'userId'      => $userId,
    'isGuest'     => !$isLoggedIn,
    'totalAmount' => $totalAmount,
    'maxCargo'    => $maxCargo,
    'adsoyad'     => $adsoyad,
    'addname'     => $isLoggedIn ? $in['addname'] : 'No account',
    'customer'    => [
        'name'     => $in['name'],
        'surname'  => $in['surname'],
        'address'  => $in['address'],
        'city'     => $in['city'],
        'province' => $in['province'],
        'postal'   => $in['postal'],
        'phone'    => $in['phone'],
        'email'    => $in['email'],
        'country'  => $in['country'],
    ],
    'billing'     => [
        'namebill'     => $in['namebill'],
        'surnamebill'  => $in['surnamebill'],
        'addressbill'  => $in['addressbill'],
        'citybill'     => $in['citybill'],
        'provincebill' => $in['provincebill'],
        'postalbill'   => $in['postalbill'],
    ],
    'items'       => $items,
];

// Stripe ödeme sayfasına yönlendir
header('Location: ../stripe/pay.php');
exit;
