<?php
session_start();
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");


error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    // Adres bilgilerini al
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $province = isset($_POST['province']) ? $_POST['province'] : '';
    $postal = isset($_POST['postal']) ? $_POST['postal'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $namebill = isset($_POST['namebill']) ? $_POST['namebill'] : '';
    $surnamebill = isset($_POST['surnamebill']) ? $_POST['surnamebill'] : '';
    $addressbill = isset($_POST['addressbill']) ? $_POST['addressbill'] : '';
    $citybill = isset($_POST['citybill']) ? $_POST['citybill'] : '';
    $provincebill = isset($_POST['provincebill']) ? $_POST['provincebill'] : '';
    $postalbill = isset($_POST['postalbill']) ? $_POST['postalbill'] : '';
    $userId = isset($_POST['userid']) ? $_POST['userid'] : '';
    $totalAmount = isset($_SESSION['totalAmount']) ? $_SESSION['totalAmount'] : '';
    $adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
    $addname = isset($_POST['addname']) ? $_POST['addname'] : '';

    // Tüm gerekli alanları kontrol et
    if (empty($name) || empty($surname) || empty($address) || empty($city) || empty($province) || empty($postal) || empty($phone) || empty($email) || empty($country) || empty($userId) || empty($adsoyad)|| empty($addname)) {
     
      

        // Diğer eksik alan kontrolü
        echo header("Location: ../checkout.php");

    } else {
        // Eksik alan yoksa, diğer işlemleri devam ettirin ve formu işleyin.
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['address'] = $address;
        $_SESSION['city'] = $city;
        $_SESSION['province'] = $province;
        $_SESSION['postal'] = $postal;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['country'] = $country;
        $_SESSION['namebill'] = $namebill;
        $_SESSION['surnamebill'] = $surnamebill;
        $_SESSION['addressbill'] = $addressbill;
        $_SESSION['citybill'] = $citybill;
        $_SESSION['provincebill'] = $provincebill;
        $_SESSION['postalbill'] = $postalbill;
        $_SESSION['userId'] = $userId;
        $_SESSION['totalAmount'] = $totalAmount;
        $_SESSION['adsoyad'] = $adsoyad;
        $_SESSION['addname'] = $addname;


        // Benzersiz bir sipariş ID'si oluştur
        $siparisId = time() . '_' . $userId;
        $_SESSION['siparisId'] = $siparisId; // Sipariş ID'sini session'a kaydedin

        // Sepet verilerini gizli alandan alın
    $cartData = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : [];
    $accessoriesCartData = isset($_POST['accessories_cart']) ? json_decode($_POST['accessories_cart'], true) : [];
    $jewelryCartData = isset($_POST['jewelry_cart']) ? json_decode($_POST['jewelry_cart'], true) : [];
    $homedecorCartData = isset($_POST['homedecor_cart']) ? json_decode($_POST['homedecor_cart'], true) : [];
    $siparis = json_decode($_POST['siparis'], true);
    
    // MaxCargo değerini al
    $maxCargo = floatval($_POST['cargo_transfer']);

        // Diğer gizli inputlardan gelen değerleri session'a kaydedin
        $_SESSION['maxCargo'] = $maxCargo;
        $_SESSION['userId'] = $userId;
        $_SESSION['cart'] = $cartData;
        $_SESSION['accessories_cart'] = $accessoriesCartData;
        $_SESSION['jewelry_cart'] = $jewelryCartData;
        $_SESSION['homedecor_cart'] = $homedecorCartData;
        $_SESSION['siparis'] = $siparis; // JSON olarak gelen tüm sipariş verilerini de sessiona kaydedin
        
        // Ödeme sayfasına yönlendir
        header("Location: ../stripe/checkout.html");
        exit;
    }
}else {




    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $province = isset($_POST['province']) ? $_POST['province'] : '';
    $postal = isset($_POST['postal']) ? $_POST['postal'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $namebill = isset($_POST['namebill']) ? $_POST['namebill'] : '';
    $surnamebill = isset($_POST['surnamebill']) ? $_POST['surnamebill'] : '';
    $addressbill = isset($_POST['addressbill']) ? $_POST['addressbill'] : '';
    $citybill = isset($_POST['citybill']) ? $_POST['citybill'] : '';
    $provincebill = isset($_POST['provincebill']) ? $_POST['provincebill'] : '';
    $postalbill = isset($_POST['postalbill']) ? $_POST['postalbill'] : '';
    $totalAmount = isset($_SESSION['huso']) ? $_SESSION['huso'] : '';
    $addname = isset($_POST['addname']) ? $_POST['addname'] : '';

    // Tüm gerekli alanları kontrol et
    if (empty($name) || empty($surname) || empty($address) || empty($city) || empty($province) || empty($postal) || empty($phone) || empty($email) || empty($country) || empty($totalAmount) ) {
     
      

        // Diğer eksik alan kontrolü
        echo header("Location: ../checkout.php");

    } else {

        
        // Eksik alan yoksa, diğer işlemleri devam ettirin ve formu işleyin.
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['address'] = $address;
        $_SESSION['city'] = $city;
        $_SESSION['province'] = $province;
        $_SESSION['postal'] = $postal;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['country'] = $country;
        $_SESSION['namebill'] = $namebill;
        $_SESSION['surnamebill'] = $surnamebill;
        $_SESSION['addressbill'] = $addressbill;
        $_SESSION['citybill'] = $citybill;
        $_SESSION['provincebill'] = $provincebill;
        $_SESSION['postalbill'] = $postalbill;
        $_SESSION['huso'] = $totalAmount;
        $_SESSION['addname'] = $addname;


        // Benzersiz bir sipariş ID'si oluştur
        $siparisId = time() . '_' . mt_rand(0, 9999);
        $_SESSION['siparisId'] = $siparisId; // Sipariş ID'sini session'a kaydedin

        // Sepet verilerini gizli alandan alın
    $cartData = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : [];
    $accessoriesCartData = isset($_POST['accessories_cart']) ? json_decode($_POST['accessories_cart'], true) : [];
    $jewelryCartData = isset($_POST['jewelry_cart']) ? json_decode($_POST['jewelry_cart'], true) : [];
    $homedecorCartData = isset($_POST['homedecor_cart']) ? json_decode($_POST['homedecor_cart'], true) : [];
    $siparis = json_decode($_POST['siparis'], true);
    
    // MaxCargo değerini al
    $maxCargo = floatval($_POST['cargo_transfer']);

        // Diğer gizli inputlardan gelen değerleri session'a kaydedin
        $_SESSION['maxCargo2'] = $maxCargo;
        $_SESSION['cart2'] = $cartData;
        $_SESSION['accessories_cart2'] = $accessoriesCartData;
        $_SESSION['jewelry_cart2'] = $jewelryCartData;
        $_SESSION['homedecor_cart2'] = $homedecorCartData;
        $_SESSION['siparis2'] = $siparis;
 
       
        
        // Ödeme sayfasına yönlendir
        header("Location: ../stripe/checkout.html");
        exit;
    }
}
?>
