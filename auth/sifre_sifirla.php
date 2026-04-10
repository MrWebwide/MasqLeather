<?php
// sifre_sifirla.php dosyası

include("../admin/include/baglan.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $yeniSifre = $_POST["yeniSifre"];

    // Şifre uzunluğunu kontrol et
    if (strlen($yeniSifre) < 8) {
        $response = array(
            'success' => false,
            'message' => 'Password must be at least 8 characters long.'
        );
        echo json_encode($response);
        exit; // Kodun devam etmemesi için çıkış yap
    }

    try {
        // Veritabanında şifreyi güncelle, sadece belirli email adresine sahip kullanıcı için
        $sql_update = "UPDATE uyeler SET sifre = :yeniSifre WHERE email = :email";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bindParam(':yeniSifre', $yeniSifre);
        $stmt_update->bindParam(':email', $email);

        if ($stmt_update->execute()) {
            $response = array(
                'success' => true,
                'message' => 'Your password has been successfully reset.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'success' => false,
                'message' => 'Şifre sıfırlanırken bir hata oluştu.'
            );
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Veritabanı hatası oluşursa
        $response = array(
            'success' => false,
            'message' => 'Veritabanı hatası oluştu. Lütfen daha sonra tekrar deneyin.'
        );
        echo json_encode($response);
    }
}
?>
