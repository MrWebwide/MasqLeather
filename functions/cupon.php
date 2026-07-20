<?php
/**
 * cupon.php — Kupon / gift card uygulama (MAS-98).
 * Artık JSON döner; cart.php AJAX ile çağırıp mesajı kupon alanının ALTINDA gösterir
 * (eskiden boş bir sayfaya "This coupon was used before." yazıyordu).
 */
session_start();
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

header('Content-Type: application/json; charset=utf-8');

$resp = ['success' => false, 'message' => 'Invalid Coupon Code or Gift Card.'];

if (isset($_POST['kupon_kodu'])) {
    $kupon_kodu = trim($_POST['kupon_kodu']);

    // Önce 'cupon' tablosunda ara
    $stmt = $db->prepare("SELECT adi, fiyat, durum FROM cupon WHERE adi = :adi");
    $stmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if ($row['durum'] == 1) {
            $resp = ['success' => false, 'message' => 'This coupon was used before.'];
        } else {
            $upd = $db->prepare("UPDATE cupon SET durum = 1 WHERE adi = :adi");
            $upd->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
            $upd->execute();

            $_SESSION['cupon_fiyat'] = $row['fiyat'];
            $resp = ['success' => true, 'reload' => true, 'message' => 'Coupon applied.'];
        }
    } else {
        // 'cupon' yoksa gift card ('portfoy') ara — yalnızca kullanılmamışlar
        $stmt = $db->prepare("SELECT yazi1 FROM portfoy WHERE adi = :adi AND durum = 0");
        $stmt->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
        $stmt->execute();
        $gift = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gift) {
            $upd = $db->prepare("UPDATE portfoy SET durum = 1 WHERE adi = :adi");
            $upd->bindParam(':adi', $kupon_kodu, PDO::PARAM_STR);
            $upd->execute();

            $_SESSION['gift_card_amount'] = $gift['yazi1'];
            $resp = ['success' => true, 'reload' => true, 'message' => 'Gift card applied.'];
        } else {
            $resp = ['success' => false, 'message' => 'Invalid Coupon Code or Gift Card.'];
        }
    }
}

echo json_encode($resp);
