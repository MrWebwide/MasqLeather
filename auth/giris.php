<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gönderilen verileri alın
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];

    

    // Kullanıcıyı doğrulama
    $sql = "SELECT * FROM uyeler WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashliSifre = $kullanici['sifre']; // Veritabanında hashlenmiş şifreyi al

        // Kullanıcının girdiği şifre ile hashlenmiş şifreyi karşılaştır
        if (password_verify($sifre, $hashliSifre)) {
            // Giriş başarılıysa, oturumu başlat
            

            // Kullanıcı bilgilerini oturumda sakla
            $_SESSION['id'] = $kullanici['id'];
            $_SESSION['email'] = $kullanici['email'];
            $_SESSION['adsoyad'] = $kullanici['adsoyad'];

             // Onay durumunu kontrol et
        if ($kullanici['onay_durumu'] == 0) {
            // Kullanıcı onay durumu 0 ise hata mesajını ayarla ve girişe izin verme
            $_SESSION['error_message'] = "Your account is not activated.<br> Please register again.";
            header("Location: signin.php");
            exit();
        }
           

            if (isset($_COOKIE['memet'])) {
                function getRedirectURL(){
                    if(isset($_COOKIE['memet'])) {
                        // Cookie'den URL'yi al
                        $url = $_COOKIE['memet'];
                        
                        // URL'yi güvenli hale getir
                        $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
                        
                        // HTML içindeki link olarak kullanmak için a etiketi oluştur
                        return "$url";
                    } else {
                        echo "Cookie'den URL bulunamadı.";
                    }    
                }
                session_write_close();
                session_name('noid');
                session_start();
                   
                if(isset($_SESSION['cart'])){
                    // Giriş yapan kullanıcının sepetindeki tüm girdileri sil
                    $stmtDelete = $db->prepare("DELETE FROM sepet WHERE KullaniciID = ?");
                    $stmtDelete->execute([$kullanici['id']]);
                
                    // noid adlı veritabanından sepet verilerini al
                    $noidCartData = $_SESSION['cart'];
                
                    // Her ürün için sepete ekleme işlemini yap
                    foreach ($noidCartData as $productId => $product) {
                        // Veritabanına ekleme işlemini yap
                        $stmt = $db->prepare("INSERT INTO sepet (KullaniciID, UrunID, UrunAdi, UrunFiyati, UrunMiktari, FiyatToplam, urun_resim, urun_category, cargo, cargo_us, tur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$kullanici['id'], $productId, $product['name'], $product['price'], $product['quantity'], $product['totalPrice'], $product['image'], $product['category'], $product['cargo'], $product['cargo_us'], $product['tur']]);
                    }
                
                    header("Location: ". getRedirectURL());
                    exit;
                } else {
                    header("Location: ". getRedirectURL());
                    exit;
                }
                

              
             
               
            } else {
                // Eğer son ziyaret edilen ürün bulunamazsa, başka bir sayfaya yönlendirme yapabilirsiniz.
                header("Location: ../index.php");
                exit;
            }
        } else {
            // Hatalı giriş durumunda hata mesajını oturuma kaydedin
            $_SESSION['error_message'] = "Incorrect Password or E-mail.";
            header("Location: signin.php");
            exit();
        }
    } else {
        // Kullanıcı bulunamadıysa veya birden fazla kullanıcı varsa, hata mesajını oturuma kaydedin
        $_SESSION['error_message'] = "User not found or multiple users found.";
        header("Location: signin.php");
        exit();
    }
}
?>
