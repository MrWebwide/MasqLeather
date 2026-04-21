<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
error_reporting(0);
ini_set('display_errors', 0);

session_start(); // Oturumu başlat
$adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : ''; // Undefined index hatasını önlemek için isset() fonksiyonu kullanıldı.

if (isset($_SESSION['id'])) {
    // Kullanıcı girişi yapılmışsa, kullanıcının kimliğini alın
    $userId = $_SESSION['id'];
    
    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);
    
    // Toplam fiyatı saklamak için bir değişken tanımlayın
    $totalPrice = 0;
    
    // Eğer kullanıcının sepeti boşsa, mesajı Showin
    if ($stmt->rowCount() == 0) {
        echo "Your cart is empty.";
    } else {
        // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
        $groupedItems = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productId = $row['UrunID'];
            $productName = $row['UrunAdi'];
            $productQuantity = $row['UrunMiktari'];
            $productPrice = $row['UrunFiyati'];
            $productImage = $row['urun_resim'];
            $productCategory = $row['urun_category']; // Ürünün kategorisini alın
    
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
                    'image' => $productImage,
                ];
            }
        }

        $tables = array('jewe', 'accessories', 'urunler', 'homedecor');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($groupedItems as $category => $products) {
        foreach ($products as $product) {
            // Her tablo için döngü
            foreach ($tables as $table) {
                // Ürünü bulmak için sorgu hazırla
                $stmt = $db->prepare("SELECT stock FROM $table WHERE id = ? AND adi = ?");
                $stmt->execute([$product['id'], $product['name']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Eğer stok bulunursa, stok miktarını al ve ürün adedini güncelle
                if ($row) {
                    $productStock = $row['stock'];
                    if ($product['quantity'] > $productStock) {
                        $maxStock = $productStock; // Ürün adedini maksimum stoğa eşitle
                        $stmtUpdate = $db->prepare("UPDATE sepet SET UrunMiktari = ? WHERE UrunID = ? AND UrunAdi = ?");
                        $stmtUpdate->execute([$maxStock, $product['id'], $product['name']]);
                    }
                    break; // Döngüyü sonlandır
                }
            }
        }
    }
    session_write_close();
    
    // JavaScript ile sayfanın kendisini yeniden yükleme
    header("Location: ../cart.php");
    exit();
}

    }
} else {
    // Oturum kimliği yoksa, yani kullanıcı girişi yapılmadıysa

    session_name('noid');
    session_start();

    // Sepet oturumda yoksa boş bir dizi oluşturun
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
    $groupedItems = [];

    foreach ($cart as $productId => $product) {
        $productName = $product['name'];
        $productQuantity = $product['quantity'];
        $productPrice = $product['price'];
        $productImage = $product['image'];
        $productCategory = $product['category']; // Ürünün kategorisini alın
        $producttur = $product['tur']; // Ürünün türünü alın

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
                'image' => $productImage,
            ];
        }
    }

    // Ürün tablolarını içeren bir dizi tanımlayın
    $tables = array('jewe', 'accessories', 'urunler', 'homedecor');

    // Eğer sayfa post edilmişse (ürün miktarları güncellenmişse)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Gruplanmış ürünler dizisindeki her bir kategoriyi dolaşın
        foreach ($groupedItems as $category => $products) {
            // Her ürünü döngüye alın
            foreach ($products as $product) {
                // Her tablo için döngü
                foreach ($tables as $table) {
                    // Ürünü bulmak için sorgu hazırla
                    $stmt = $db->prepare("SELECT stock FROM $table WHERE id = ? AND adi = ?");
                    $stmt->execute([$product['id'], $product['name']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    // Eğer stok bulunursa, stok miktarını al ve sepet verilerini güncelle
                    if ($row) {
                        $productStock = $row['stock'];
                        if ($product['quantity'] > $productStock) {
                            // Ürün adedini maksimum stoğa eşitle
                            $_SESSION['cart'][$product['id']]['quantity'] = $productStock;
                        }
                        break; // Döngüyü sonlandır
                    }
                }
            }
        }

        // JavaScript ile sayfanın kendisini yeniden yükleme
        header("Location: ../cart.php");
        exit();
    }
}




?>
