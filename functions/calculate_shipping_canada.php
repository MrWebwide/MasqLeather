<?php
include_once(__DIR__ . "/../admin/include/baglan.php");
include_once(__DIR__ . "/../admin/include/fonksiyonlar.php");
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

$cuponFiyat = 0;

if (isset($_SESSION['cupon_fiyat'])) {
    $cuponFiyat = $_SESSION['cupon_fiyat'];
}

// Toplam fiyatı saklamak için bir değişken tanımlayın
$totalPrice = 0;

// Eklenen 'cargo' değerlerini karşılaştırmak için bir değişken tanımlayın
$maxCargo = 0; // Başlangıç değeri 0 veya başka bir uygun değer olabilir

// Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
$groupedItems = [];

if ($userId) {
    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['UrunID'];
        $productQuantity = $row['UrunMiktari'];
        $productPrice = $row['UrunFiyati'];
        $productCategory = $row['urun_category'];
        $productCargo = $row['cargo'];
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
                'cargo' => $productCargo,
            ];
        }

        // Toplam fiyatı güncelleyin
        $totalPrice += $productPrice * $productQuantity;

        // Eklenen 'cargo' değerini kontrol edin ve en yüksek değeri güncelleyin
        if ($productCargo > $maxCargo) {
            $maxCargo = $productCargo;
        }
    }
} else {
    // Kullanıcı oturumda değilse, sepet verilerini noid oturumundan al
    session_name('noid');
    session_start();
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $item) {
            $productQuantity = $item['quantity'];
            $productPrice = $item['price'];
            $productCategory = $item['category'];
            $productName = $item['name'];
            $productCargo = $item['cargo'];

            // Categoriese göre gruplanmış ürünleri diziye ekleyin
            if (!isset($groupedItems[$productCategory])) {
                $groupedItems[$productCategory] = [];
            }

            // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
            $found = false;
            foreach ($groupedItems[$productCategory] as &$cartItem) {
                if ($cartItem['id'] === $productId) {
                    $cartItem['quantity'] += $productQuantity;
                    $cartItem['totalPrice'] += $productPrice * $productQuantity;
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
                    'cargo' => $productCargo,
                ];
            }

            // Toplam fiyatı güncelleyin
            $totalPrice += $productPrice * $productQuantity;

            // Eklenen 'cargo' değerini kontrol edin ve en yüksek değeri güncelleyin
            if ($productCargo > $maxCargo) {
                $maxCargo = $productCargo;
            }
        }
    }
    session_write_close(); // Oturumu kapat
}

$cupon = ($totalPrice * $cuponFiyat) / 100;
$totalPrice1 = $totalPrice - $cupon;

if ($totalPrice1 > $cargoprices['adi']) {
    $maxCargo = 0;
}

if ($totalPrice1 >= $cargoprices['yazi1'] && $totalPrice1 <= $cargoprices['yazi2']) {
    $maxCargo = $cargoprices['onaciklama'];
}

if ($cargoprices['durum'] === 'on') {
    if ($totalPrice1 >= $cargoprices['yazi3'] && $totalPrice1 <= $cargoprices['yazi4']) {
        $maxCargo = $cargoprices['yazi5'];
    }
}

if ($cargoprices['durum1'] === 'on') {
    if ($totalPrice1 >= $cargoprices['yazi6'] && $totalPrice1 <= $cargoprices['yazi7']) {
        $maxCargo = $cargoprices['yazi8'];
    }
}

if ($cargoprices['durum2'] === 'on') {
    if ($totalPrice1 >= $cargoprices['yazi9'] && $totalPrice1 <= $cargoprices['yazi10']) {
        $maxCargo = $cargoprices['kategori'];
    }
}
?>
