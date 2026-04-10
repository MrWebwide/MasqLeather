<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gelen verileri kontrol et
    if (isset($_POST["onay_kodu"])) {
        $onayKodu = $_POST["onay_kodu"];

        try {
            // Veritabanında onay kodunu kontrol et
            $sql = "SELECT * FROM uyeler WHERE onay_kodu = :onayKodu";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':onayKodu', $onayKodu);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // Onay kodu doğruysa, başarılı cevap döndür
                $response = array(
                    'success' => true,
                    'message' => 'Verification code verified.',
                    'showResetForm' => true // Şifre sıfırlama formunu Showmek için true
                );
                echo json_encode($response);
            } else {
                // Onay kodu yanlışsa, hata mesajını Show
                $response = array(
                    'success' => false,
                    'message' => 'The confirmation code is incorrect. Please try again.'
                );
                echo json_encode($response);
            }
        } catch (PDOException $e) {
            // Veritabanı bağlantı hatası oluşursa, hata mesajını Show
            $response = array(
                'success' => false,
                'message' => 'A database error occurred. please try again later.'
            );
            echo json_encode($response);
        }
    } else {
        // Eksik veri hatası
        $response = array(
            'success' => false,
            'message' => 'Incomplete data sent.'
        );
        echo json_encode($response);
    }
}
?>