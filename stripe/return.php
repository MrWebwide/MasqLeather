<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

// Token kontrolü yapmadan önce istek sayfasını güvenliği açısından kontrol edebilirsiniz
// Örneğin, başvuru sayfası localhost dışından geldiyse token oluşturulabilir
if ($_SERVER['HTTP_REFERER'] === "https://www.masqleather.com/stripe/checkout.html") {
    // Eğer daha önce bir token oluşturulmuşsa, tekrar oluşturulmaması için kontrol et
    if (!isset($_SESSION['token'])) {
        // İşlem başarılı olduğunda islem.php sayfasına yönlendirme için token oluştur
        $token = bin2hex(random_bytes(16)); // Rastgele 16 byte uzunluğunda bir token oluştur
        $_SESSION['token'] = $token; // Token'ı session'a kaydet
    } else {
        // Eğer daha önce bir token oluşturulmuşsa, onu kullan
        $token = $_SESSION['token'];
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Thanks for your order!</title>
  <link rel="stylesheet" href="style.css">
  <script src="return.js" defer></script>
</head>
<body>





  <section id="success">
    <div class="suc">
      <div class="frame">
        <img src="../assets/shutterstock/confirm.png" width="120px" alt="" class="success-image">
        <p>
          Thank you for your order! A confirmation email will be sent to <span id="customer-email"></span>.
  
          If you have any questions, please don't hesitate to mail us. <a href="mailto:info@masqleather.com">info@masqleather.com</a>.
        </p>
      
      </div>
      <div class="button-container">
      <a href="../index.php" class="button2" style="--clr:#d67900; font-size: 1.1em; text-decoration:none; "><span>Back to Homepage</span><i></i></a>  
    </div>
    </div>
  </section>
  
  <script>
      // Önce sayfanın yüklenmesi ve URL'nin alınması gerekiyor
window.addEventListener('DOMContentLoaded', (event) => {
    // Yerel depolamada bir anahtar oluştur
    let storageKey = 'lastRequest';

    // Eğer depolama anahtarı mevcutsa ve değeri mevcutsa
    if (localStorage.getItem(storageKey)) {
        // Mevcut URL'yi al
        let currentURL = window.location.href;

        // Depolama alanındaki URL'yi al
        let storedURL = localStorage.getItem(storageKey);

        // Eğer mevcut URL ve depolanan URL aynı değilse, işlemi yapma
        if (currentURL !== storedURL) {
            localStorage.setItem(storageKey, currentURL); // Yeni URL'yi depola
            // Token'ı işlem.php sayfasına göndererek sayfanın işlem yapmasını sağla
            fetch('../functions/islem.php?token=<?php echo $token; ?>')
                .then(response => {
                    // İşlem başarılı olduysa
                    if (response.ok) {
                        console.log("İşlem başarıyla tamamlandı.");
                    } else {
                        console.error("İşlem sırasında bir hata oluştu.");
                    }
                })
                .catch(error => {
                    console.error("İşlem sırasında bir hata oluştu:", error);
                });
        }
    } else {
        // İlk defa depolama alanına URL'yi ekle
        localStorage.setItem(storageKey, window.location.href);
        // Token'ı işlem.php sayfasına göndererek sayfanın işlem yapmasını sağla
        fetch('../functions/islem.php?token=<?php echo $token; ?>')
            .then(response => {
                // İşlem başarılı olduysa
                if (response.ok) {
                    console.log("İşlem başarıyla tamamlandı.");
                } else {
                    console.error("İşlem sırasında bir hata oluştu.");
                }
            })
            .catch(error => {
                console.error("İşlem sırasında bir hata oluştu:", error);
            });
    }
});

    </script>
</body>
</html>
<?php
}
?>
