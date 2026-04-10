<?php
if ($_POST) {
    include '../../include/baglan.php';

    // Rastgele 6 haneli sayı oluştur
    $randomNumber = sprintf('%06d', mt_rand(0, 999999));

    // Resmin adını benzersiz bir şekilde oluştur
    $time_al = $randomNumber . '-' . time() . '-' . uniqid();

    // Güvenlik doğrulama token'ı
    $verifyToken = 'sayim' . @$_POST['timestamp'] . 'sayim';

    // Dosyanın türlerini ve bilgilerini al
    $fileTypes = array('jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG', 'svg', 'gif');
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    // Dosyanın geçici yüklendiği konum
    $tempFile = $_FILES['Filedata']['tmp_name'];

    // Ana dizinin adı
    $anaDizin = '';

    // Resmin yükleneceği hedef klasör
    $targetFolder = '/' . $anaDizin .'/admin'. '/resimler';
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

    // Dosyanın hedefteki adını oluştur
    $targetFile = rtrim($targetPath, '/') . '/' . $time_al . '.' . $fileParts['extension'];

    // Eğer dosya türü uygunsa, dosyayı taşı
    if (in_array($fileParts['extension'], $fileTypes)) {
        move_uploaded_file($tempFile, $targetFile);
        echo $time_al . '.' . $fileParts['extension'];
    } else {
        echo 2; // Geçersiz dosya türü
    }
} else {
    echo 3; // POST verisi yok
}

?>
