<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
session_start(); // Oturumu başlat
$adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : '';
// Kullanıcının sepet verilerini veritabanından çekin
$stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
$stmt->execute([$userId]);

// Toplam fiyatı saklamak için bir değişken tanımlayın
$totalPrice = 0;

// Eklenen 'cargo' değerlerini karşılaştırmak için bir değişken tanımlayın
$maxCargo = 0; // Başlangıç değeri 0 veya başka bir uygun değer olabilir

// Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
$groupedItems = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $productId = $row['UrunID'];
    $productQuantity = $row['UrunMiktari'];
    $productPrice = $row['UrunFiyati'];
    $productCategory = $row['urun_category'];
    $productCargos = $row['cargo_us'];
    $productName = $row['UrunAdi'];


    // Categoriese göre gruplanmış ürünleri diziye ekleyin
    if (!isset($groupedItems[$productCategory])) {
        $groupedItems[$productCategory] = [];
    }

    // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
    $found = false;
    foreach ($groupedItems[$productCategory] as &$item) {
        if ($item['id'] === $productId) {
            $item['quantity'] += $productQuantity;
            $item['totalPrice'] += $productPrice * $productQuantity;
            $found = true;
            break;
        }
    }

    // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
    if (!$found) {
        $groupedItems[$productCategory][] = [
            'id' => $productId,
            'name' => $productName,
            'quantity' => $productQuantity,
            'price' => $productPrice,
            'totalPrice' => $productPrice * $productQuantity,
            'cargo_us' => $productCargos,
        ];
    }

    if (isset($_SESSION['cupon_fiyat'])) {
        $cuponFiyat = $_SESSION['cupon_fiyat'];
    }
    // Toplam fiyatı güncelleyin
    $totalPrice += $productPrice * $productQuantity;

    // Eklenen 'cargo' değerini kontrol edin ve en yüksek değeri güncelleyin
    if ($productCargos > $maxCargo) {
        $maxCargo = $productCargos;
    }
}

if ($totalPrice > 150) {
    $maxCargo = 0;
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