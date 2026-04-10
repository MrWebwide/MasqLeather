<?php
session_start();

// Gerekli dosyaları dahil edin
require '../admin/include/baglan.php'; // Veritabanı bağlantısı
require '../admin/include/fonksiyonlar.php'; // Gerekli fonksiyonlar
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Token'ı kontrol et
if (isset($_GET['token']) && $_GET['token'] === $_SESSION['token'] && isset($_SESSION['id']) ) {
    // Token geçerli ise işlem yap
    unset($_SESSION['token']); // Token'ı session'dan kaldır

    // Session'dan bilgileri al
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];
    $address = $_SESSION['address'];
    $city = $_SESSION['city'];
    $province = $_SESSION['province'];
    $postal = $_SESSION['postal'];
    $phone = $_SESSION['phone'];
    $email = $_SESSION['email'];
    $country = $_SESSION['country'];
    $namebill = $_SESSION['namebill'];
    $surnamebill = $_SESSION['surnamebill'];
    $addressbill = $_SESSION['addressbill'];
    $citybill = $_SESSION['citybill'];
    $provincebill = $_SESSION['provincebill'];
    $postalbill = $_SESSION['postalbill'];
    $userId = $_SESSION['userId'];
    $totalAmount = $_SESSION['totalAmount'];
    $adsoyad = $_SESSION['adsoyad'];
    $addname = $_SESSION['addname'];
    
    

    // Diğer gizli inputlardan gelen değerleri al
    $maxCargo = $_SESSION['maxCargo'];
    $cartData = $_SESSION['cart'];
    $accessoriesCartData = $_SESSION['accessories_cart'];
    $jewelryCartData = $_SESSION['jewelry_cart'];
    $homedecorCartData = $_SESSION['homedecor_cart'];
    $siparis = $_SESSION['siparis'];

    // Her bir ürün için sipariş oluştur
    foreach ($siparis as $category => $products) {
        foreach ($products as $product) {
            $productName = $product['name'];
            $productQuantity = $product['quantity'];
            $productTotalPrice = $product['totalPrice'];
            $producttur = $product['tur'];
            $productid = $product['id'];

            // Benzersiz bir sipariş ID'si oluştur
            $siparisId = $_SESSION['siparisId']; // Daha önce oluşturulmuş sipariş ID'sini kullan

            // Sipariş tablosuna ekleme sorgusunu hazırla ve çalıştır
            $stmt = $db->prepare("INSERT INTO siparis (siparisid, name, quantity, total_price, cargo, userid, tur, urunid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$siparisId, $productName, $productQuantity, $productTotalPrice, $maxCargo, $userId, $producttur, $productid]);
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

     // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
     foreach ($cartData as $category => $products) {
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

     // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
     foreach ($cartData as $category => $products) {
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

     // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
     foreach ($cartData as $category => $products) {
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

    

    // Diğer ürün kategorileri için stoktan düşürme işlemi



    // Örnek olarak adres bilgilerini mailgelen tablosuna eklemeye devam edin
    $sql = "INSERT INTO mailgelen (adsoyad, siparisid, name, totalAmount, surname, address, city, province, postal, phone, email, namebill, surnamebill, addressbill, citybill, provincebill, postalbill, country, userid, eklenme_tarihi)
    VALUES (:adsoyad, :siparisid, :name, :totalAmount, :surname, :address, :city, :province, :postal, :phone, :email, :namebill, :surnamebill, :addressbill, :citybill, :provincebill, :postalbill, :country, :userid, NOW())";

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
    $stmt->bindParam(':totalAmount', $totalAmount ,PDO::PARAM_STR);
    $stmt->bindParam(':adsoyad', $adsoyad);
    



    // Veritabanında 'adsoyad' alanını kontrol et
$checkSql = "SELECT COUNT(*) AS count FROM useraddress WHERE adsoyad = :adsoyad";
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':adsoyad', $adsoyad);
$checkStmt->execute();
$row = $checkStmt->fetch(PDO::FETCH_ASSOC);




if ($row['count'] == 0) {
    // 'adsoyad' veritabanında bulunmuyorsa işlemi gerçekleştir
    $sql1 = "INSERT INTO useraddress (addname, adsoyad, name, surname, address, city, province, postal, phone, email, country, userid, eklenme_tarihi)
             VALUES (:addname,:adsoyad, :name, :surname, :address, :city, :province, :postal, :phone, :email, :country, :userid, NOW())";

    $stmt2 = $db->prepare($sql1);

    $stmt2->bindParam(':name', $name);
    $stmt2->bindParam(':surname', $surname);
    $stmt2->bindParam(':address', $address);
    $stmt2->bindParam(':city', $city);
    $stmt2->bindParam(':province', $province);
    $stmt2->bindParam(':postal', $postal);
    $stmt2->bindParam(':phone', $phone);
    $stmt2->bindParam(':email', $email);
    $stmt2->bindParam(':country', $country);
    $stmt2->bindParam(':userid', $userId);
    $stmt2->bindParam(':adsoyad', $adsoyad);
    $stmt2->bindParam(':addname', $addname);
    $stmt2->execute();
    // Veritabanına kayıt ekle
    
} 





    
    
  
    

    

    if ($stmt->execute()) {

       
        
   

   // SEPETTEN KULLANICININ ÜRÜNLERİNİ SİL
   $stmt3 = $db->prepare("DELETE FROM sepet WHERE KullaniciID = :userId");
   $stmt3->bindParam(':userId', $userId, PDO::PARAM_INT); // Kullanıcı ID'sini bind edin
   $stmt3->execute();

        $_SESSION['usedcode'] = 1;

        // Veritabanına kayıt başarılı olduysa, e-posta gönderimi yapın ve teşekkür mesajı gösterin
        $konu = "Order Confirmation";
        $icerik = "Dear $name $surname, <br><br>We are pleased to inform you that your order has been confirmed. Your order number is <strong>$siparisId</strong>. We sincerely appreciate your business and thank you for choosing Masq Leather. If you have any further inquiries or require assistance, please do not hesitate to contact us.<br><br>
        Best regards,<br>
<strong> Masq Leather </strong> ";
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            configureMailer($mail);

            $mail->addAddress($email, $name); // Kullanıcının e-posta adresi ve ismi

            $mail->isHTML(true);
            $mail->Subject = $konu;
            $mail->Body    = $icerik;

            $mail->send();

            // E-posta gönderimi başarılı ise mesajı gösterin
            echo "E-posta başarıyla gönderildi!";
        } catch (Exception $e) {
            // E-posta gönderimi başarısız ise hata mesajını gösterin
            echo "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
        }


        // Veritabanına kayıt başarılı olduysa, e-posta gönderimi yapın ve teşekkür mesajı gösterin
        $konu = "New Order Alert!";
        $icerik = "A new order has been placed on your website, please review the order details on the administration panel.<br><br>
<strong> Masq Leather </strong> ";
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            configureMailer($mail);

            $mail->addAddress(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress(ADMIN_EMAIL, MAIL_FROM_NAME);

            $mail->isHTML(true);
            $mail->Subject = $konu;
            $mail->Body    = $icerik;

            $mail->send();

            // E-posta gönderimi başarılı ise mesajı gösterin
            echo "E-posta başarıyla gönderildi!";
        } catch (Exception $e) {
            // E-posta gönderimi başarısız ise hata mesajını gösterin
            echo "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
        }







    } else {
        // Ödeme başarısız olduysa, hata mesajı gösterin
        echo "Ödeme işlemi başarısız oldu. Lütfen tekrar deneyin.";
    }

    




} elseif (isset($_GET['token']) && $_GET['token'] === $_SESSION['token'] )  { // EĞER GİRİŞ YAPMAMIŞ KULLANICI VARSA BU ÇALIŞACAK 

    
     // Token geçerli ise işlem yap
     unset($_SESSION['token']); 

     // Session'dan bilgileri al
     $name = $_SESSION['name'];
     $surname = $_SESSION['surname'];
     $address = $_SESSION['address'];
     $city = $_SESSION['city'];
     $province = $_SESSION['province'];
     $postal = $_SESSION['postal'];
     $phone = $_SESSION['phone'];
     $email = $_SESSION['email'];
     $country = $_SESSION['country'];
     $namebill = $_SESSION['namebill'];
     $surnamebill = $_SESSION['surnamebill'];
     $addressbill = $_SESSION['addressbill'];
     $citybill = $_SESSION['citybill'];
     $provincebill = $_SESSION['provincebill'];
     $postalbill = $_SESSION['postalbill'];
     $userId = 'No account';
     $totalAmount = $_SESSION['huso'];
     $adsoyad = 'No account';
     $addname = 'No account';
     
     
 
     // Diğer gizli inputlardan gelen değerleri al
     $maxCargo = $_SESSION['maxCargo2'];
     $cartData = $_SESSION['cart2'];
     $accessoriesCartData = $_SESSION['accessories_cart2'];
     $jewelryCartData = $_SESSION['jewelry_cart2'];
     $homedecorCartData = $_SESSION['homedecor_cart2'];
     $siparis = $_SESSION['siparis2'];
 
     // Her bir ürün için sipariş oluştur
     foreach ($siparis as $category => $products) {
         foreach ($products as $product) {
             $productName = $product['name'];
             $productQuantity = $product['quantity'];
             $productTotalPrice = $product['totalPrice'];
             $producttur = $product['tur'];
             $productid = $product['id'];
 
             // Benzersiz bir sipariş ID'si oluştur
             $siparisId = $_SESSION['siparisId']; // Daha önce oluşturulmuş sipariş ID'sini kullan
 
             // Sipariş tablosuna ekleme sorgusunu hazırla ve çalıştır
             $stmt = $db->prepare("INSERT INTO siparis (siparisid, name, quantity, total_price, cargo, userid,  urunid) VALUES (?, ?, ?, ?, ?, ?, ?)");
             $stmt->execute([$siparisId, $productName, $productQuantity, $productTotalPrice, $maxCargo, $userId,  $productid]);
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
 
      // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
      foreach ($cartData as $category => $products) {
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
 
      // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
      foreach ($cartData as $category => $products) {
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
 
      // Gruplanmış verileri işleyerek stoktan düşürme işlemini gerçekleştirin
      foreach ($cartData as $category => $products) {
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
 
     
 
 
 
 
     // Örnek olarak adres bilgilerini mailgelen tablosuna eklemeye devam edin
     $sql = "INSERT INTO mailgelen (adsoyad, siparisid, name, totalAmount, surname, address, city, province, postal, phone, email, namebill, surnamebill, addressbill, citybill, provincebill, postalbill, country, userid, eklenme_tarihi)
     VALUES (:adsoyad, :siparisid, :name, :totalAmount, :surname, :address, :city, :province, :postal, :phone, :email, :namebill, :surnamebill, :addressbill, :citybill, :provincebill, :postalbill, :country, :userid, NOW())";
 
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
     $stmt->bindParam(':totalAmount', $totalAmount ,PDO::PARAM_STR);
     $stmt->bindParam(':adsoyad', $adsoyad);
     
 
 
 

 
      
 
     
 
     if ($stmt->execute()) {
 
        
         
    
 
    
 
         $_SESSION['usedcode'] = 1;
 
         // Veritabanına kayıt başarılı olduysa, e-posta gönderimi yapın ve teşekkür mesajı gösterin
         $konu = "Order Confirmation";
         $icerik = "Dear $name $surname, <br><br>We are pleased to inform you that your order has been confirmed. Your order number is <strong>$siparisId</strong>. We sincerely appreciate your business and thank you for choosing Masq Leather. If you have any further inquiries or require assistance, please do not hesitate to contact us.<br><br>
         Best regards,<br>
 <strong> Masq Leather </strong> ";
         $mail = new PHPMailer\PHPMailer\PHPMailer(true);
 
         try {
             configureMailer($mail);
 
             $mail->addAddress($email, $name); // Kullanıcının e-posta adresi ve ismi
 
             $mail->isHTML(true);
             $mail->Subject = $konu;
             $mail->Body    = $icerik;
 
             $mail->send();
 
             // E-posta gönderimi başarılı ise mesajı gösterin
             echo "E-posta başarıyla gönderildi!";
         } catch (Exception $e) {
             // E-posta gönderimi başarısız ise hata mesajını gösterin
             echo "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
         }
 
 
         // Veritabanına kayıt başarılı olduysa, e-posta gönderimi yapın ve teşekkür mesajı gösterin
         $konu = "New Order Alert!";
         $icerik = "A new order has been placed on your website, please review the order details on the administration panel.<br><br>
 <strong> Masq Leather </strong> ";
         $mail = new PHPMailer\PHPMailer\PHPMailer(true);
 
         try {
             configureMailer($mail);
 
             $mail->addAddress(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
             $mail->addAddress(ADMIN_EMAIL, MAIL_FROM_NAME);
 
             $mail->isHTML(true);
             $mail->Subject = $konu;
             $mail->Body    = $icerik;
 
             $mail->send();
 
             // E-posta gönderimi başarılı ise mesajı gösterin
             echo "E-posta başarıyla gönderildi!";
         } catch (Exception $e) {
             // E-posta gönderimi başarısız ise hata mesajını gösterin
             echo "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
         }



         session_name('noid');
         session_destroy();
 
} else {

echo "Geçersiz istek. Lütfen tekrar deneyin.";
}


}
?>
