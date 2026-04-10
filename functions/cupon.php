<?php
session_start();
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

// Kupon veya gift card kodunu POST verilerinden alın
if (isset($_POST['kupon_kodu'])) {
    $kupon_kodu = $_POST['kupon_kodu'];

    // Önce 'cupon' tablosunda kupon kodunu arayın
    $query = "SELECT adi, fiyat, durum FROM cupon WHERE adi = :adi";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Eğer kupon 'cupon' tablosunda bulunursa
        $adi = $row['adi'];
        $fiyat = $row['fiyat'];
        $durum = $row['durum'];

        if ($durum == 1) {
            echo "<p>This coupon was used before.</p>";
        } else {
            echo "Kupon Kodu: $kupon_kodu<br>";
            echo "Product Name: $adi<br>";
            echo "Product Price: $fiyat";

            $updateQuery = "UPDATE cupon SET durum = 1 WHERE adi = :adi";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
            $updateStmt->execute();

            $_SESSION['cupon_fiyat'] = $fiyat;
            header("Location: ../cart.php");
            exit;
        }
    } else {
        // Eğer 'cupon' tablosunda kupon bulunamazsa, 'portfoy' tablosunda gift card arayın
        $query = "SELECT yazi1 FROM portfoy WHERE adi = :adi AND durum = 0"; // Sadece kullanılmamış gift card'ları seç
        $stmt = $db->prepare($query);
        $stmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Eğer gift card 'portfoy' tablosunda bulunursa
            $yazi1 = $row['yazi1'];

            echo "Gift Card Kodu: $kupon_kodu<br>";
            echo "Amount: $yazi1";

            // Gift card kullanıldı olarak işaretleme
            $updateQuery = "UPDATE portfoy SET durum = 1 WHERE adi = :adi";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
            $updateStmt->execute();

            $_SESSION['gift_card_amount'] = $yazi1;
            header("Location: ../cart.php");
            exit;
        } else {
            // Ne kupon ne de gift card bulunursa hata mesajı göster
            echo "<p>Invalid Coupon Code or Gift Card.</p>";
        }
    }
}
?>
