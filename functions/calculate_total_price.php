<?php
session_start();

// Veritabanı bağlantısını dahil edin
include("../admin/include/baglan.php");

$userId = null;
$totalPrice = 0;

// Kullanıcı oturumda mı kontrol edin
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Kullanıcı oturumda değilse, sepet verilerini noid oturumundan al
    session_name('noid');
    session_start();
    if (isset($_SESSION['cart'])) {
        $userId = 'noid';
    }
    session_write_close(); // Oturumu kapat
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && $userId !== null) {
    if ($userId === 'noid') {
        // Noid oturumundaki sepet verilerini alın
        session_name('noid');
        session_start();
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
        }
        session_write_close(); // Oturumu kapat
    } else {
        // Kullanıcının sepet verilerini veritabanından çekin
        $stmt = $db->prepare("SELECT SUM(UrunFiyati * UrunMiktari) AS total_price FROM sepet WHERE KullaniciID = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPrice = $row['total_price'];
    }

    // Kupon fiyatını alın
    $cuponFiyat = isset($_SESSION['cupon_fiyat']) ? $_SESSION['cupon_fiyat'] : 0;

    $giftfiyat = isset($_SESSION['gift_card_amount']) ? $_SESSION['gift_card_amount'] : 0;

    // Toplam fiyatı kupon indirimi ile güncelleyin
    $totalsubAmount = $totalPrice - ($totalPrice * $cuponFiyat / 100);

    $totalAmount = $totalsubAmount - $giftfiyat;

    if ($totalAmount < 0) {
        $totalAmount = 0;
    }

    // JSON formatında totalAmount ve toplam fiyatı döndürün
    echo json_encode(['totalAmount' => $totalAmount, 'totalPrice' => $totalPrice], JSON_NUMERIC_CHECK);
}
?>
