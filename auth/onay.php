<?php
// onay.php

include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $onayKodu = $_POST["onay_kodu"];

    // Onay kodunun veritabanında varlığını kontrol edin
    $sql = "SELECT * FROM uyeler WHERE onay_kodu = :onay_kodu";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':onay_kodu', $onayKodu);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $uye = $stmt->fetch(); // Veritabanından üyeyi alalım

        // Onay durumunu kontrol edelim
        if ($uye['onay_durumu'] == 0) {
            // Onay kodu eşleşirse, onay_durumu'nu 1 olarak güncelleyin
            $sql = "UPDATE uyeler SET onay_durumu = 1 WHERE onay_kodu = :onay_kodu";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':onay_kodu', $onayKodu);

            if ($stmt->execute()) {
                echo "<p class='error' style='color: green !important; font-weight:800;'>Your registration is completed. You will be redirected to sign-in page.</p>";
echo "<script>
    // 2 saniye bekle
    setTimeout(function() {
        // Bekleme süresince cursor: wait
        document.body.style.cursor = 'wait';
        // Sayfayı yenileme
        window.location.href = './signin.php';
    }, 2000); // 2 saniye (2000 milisaniye) bekle
</script>";
            
            
              
            } else {
                echo "<p class='error'>Hata: " . $stmt->errorInfo()[2] . "</p>";
            }
        } else {
            echo "<p class='error'>This confirmation code has been used before.</p>";
        }
    } else {
        echo "<p class='error'>The confirmation code is incorrect. Please enter the correct confirmation code.</p>";
    }
} else {
    echo "<p class='error'>Invalid request.</p>";
}
?>
