<?php
session_start();
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diğer giriş alanlarından verileri alın (adres bilgileri ve diğer müşteri bilgileri)

    // Sepet verilerini gizli alandan alın
    $cartData = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : [];
    $accessoriesCartData = isset($_POST['accessories_cart']) ? json_decode($_POST['accessories_cart'], true) : [];
    $jewelryCartData = isset($_POST['jewelry_cart']) ? json_decode($_POST['jewelry_cart'], true) : [];
    $homedecorCartData = isset($_POST['homedecor_cart']) ? json_decode($_POST['homedecor_cart'], true) : [];

    // $maxCargo değerini $_POST['cargo'] üzerinden alın
   

    $userId = $_POST['userid'];
    // Sipariş bilgilerini al
    $siparis = json_decode($_POST['siparis'], true);
    
    // MaxCargo değerini al
    $maxCargo = floatval($_POST['cargo_transfer']);
    
    // Her bir ürün için sipariş oluştur
    foreach ($siparis as $category => $products) {
        foreach ($products as $product) {
            $productName = $product['name'];
            $productQuantity = $product['quantity'];
            $productTotalPrice = $product['totalPrice'];
          
            // Benzersiz bir sipariş ID'si oluştur
            $siparisId = time() . '_' . $userId;
    
            // Sipariş tablosuna ekleme sorgusunu hazırla ve çalıştır
            $stmt = $db->prepare("INSERT INTO siparis (siparisid, name, quantity, total_price, cargo, userid) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$siparisId, $productName, $productQuantity, $productTotalPrice, $maxCargo, $userId]);
        }
    }
    

    

   
   
   
   
   
    // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
    foreach ($cartData as $category => $products) {
        foreach ($products as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];

            // Ürün stokunu azaltmak için gerekli SQL sorgusu
            $updateStockSQL = "UPDATE urunler SET stock = stock - :quantity WHERE id = :productId AND kategori = :category";
            $stmt = $db->prepare($updateStockSQL);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    foreach ($accessoriesCartData as $category => $products) {
        foreach ($products as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];

            // Ürün stokunu azaltmak için gerekli SQL sorgusu
            $updateStockSQL = "UPDATE accessories SET stock = stock - :quantity WHERE id = :productId AND kategori = :category";
            $stmt = $db->prepare($updateStockSQL);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    foreach ($jewelryCartData as $category => $products) {
        foreach ($products as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];

            // Ürün stokunu azaltmak için gerekli SQL sorgusu
            $updateStockSQL = "UPDATE jewe SET stock = stock - :quantity WHERE id = :productId AND kategori = :category";
            $stmt = $db->prepare($updateStockSQL);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    foreach ($homedecorCartData as $category => $products) {
        foreach ($products as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];

            // Ürün stokunu azaltmak için gerekli SQL sorgusu
            $updateStockSQL = "UPDATE homedecor SET stock = stock - :quantity WHERE id = :productId AND kategori = :category";
            $stmt = $db->prepare($updateStockSQL);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();
        }
    }



    // Diğer müşteri bilgilerini ve sipariş verilerini işleme devam edin

    // Benzersiz bir sipariş ID'si oluştur
    $siparisId = time() . '_' . $userId; // Zaman damgası ve kullanıcı ID'sini birleştirerek
    // Örnek olarak adres bilgilerini mailgelen tablosuna ekleyebilirsiniz
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
    $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : '';

    
   


    
   // Tüm gerekli alanları kontrol et
if (empty($name) || empty($surname) || empty($address) || empty($city) || empty($province) || empty($postal) || empty($phone) || empty($email) || empty($country)  || empty($userId) || empty($totalAmount)) {
    // Eğer userId boşsa, kullanıcıya giriş yapması gerektiğini belirten bir uyarı gösterin
    if (empty($userId)) {
        echo '
        <div id="error-message" class="message">
            <p>Lütfen önce giriş yapınız.</p>
        </div>
        ';
        // Giriş yapma sayfasına yönlendirme
        header("Location: ../auth/signin.php");
        exit;
    }

    // Diğer eksik alan kontrolü
    echo 
    header("Location: ../checkout.php");

} else {
    // Eksik alan yoksa, diğer işlemleri devam ettirin ve formu işleyin.
    
    // Örnek olarak adres bilgilerini mailgelen tablosuna eklemeye devam edin
    $sql = "INSERT INTO mailgelen (totalAmount, siparisid, name, surname, address, city, province, postal, phone, email, namebill, surnamebill, addressbill, citybill, provincebill, postalbill, country, userid, eklenme_tarihi)
    VALUES (:totalAmount, :siparisid, :name, :surname, :address, :city, :province, :postal, :phone, :email, :namebill, :surnamebill, :addressbill, :citybill, :provincebill, :postalbill, :country, :userid, NOW())";

// Sorguyu hazırla
$stmt = $db->prepare($sql);

// Sorgudaki parametreleri ata
$stmt->bindParam(':siparisid', $siparisId);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':surname', $surname);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':city', $city);
$stmt->bindParam(':province', $province);
$stmt->bindParam(':postal', $postal);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':country', $country);
$stmt->bindParam(':namebill', $namebill);
$stmt->bindParam(':surnamebill', $surnamebill);
$stmt->bindParam(':addressbill', $addressbill);
$stmt->bindParam(':citybill', $citybill);
$stmt->bindParam(':provincebill', $provincebill);
$stmt->bindParam(':postalbill', $postalbill);
$stmt->bindParam(':userid', $userId);
$stmt->bindParam(':totalAmount', $totalAmount);
   


    if ($stmt->execute()) {
        // Form başarıyla gönderildiyse Stripe ödeme sayfasına yönlendir
        header("Location: ../stripe/checkout.html");
        exit;
    } else {
        echo '
        <div id="error-message" class="message">
            <p>Form gönderimi başarısız oldu.</p>
        </div>
        ';
    }
}
}

// Diğer sayfa içeriği devam edebilir
?>
