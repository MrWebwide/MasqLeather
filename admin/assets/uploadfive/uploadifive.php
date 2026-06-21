<?php
/**
 * Görsel yükleme endpoint'i (uploadifive) — sertleştirildi (MAS-17).
 *
 * Eski hali GÜVENLİK AÇIĞIYDI: kimlik doğrulaması yoktu (internetteki herkes
 * dosya POST'layabiliyordu), yalnızca uzantı kontrolü vardı; içerik/boyut
 * doğrulaması ve no-exec koruması yoktu. Artık:
 *   1) Yalnızca giriş yapmış admin (session) erişebilir.
 *   2) Boyut limiti uygulanır.
 *   3) getimagesize ile GERÇEKTEN görsel mi diye içerik doğrulanır (sahte uzantı
 *      reddedilir); svg artık kabul edilmez (XSS taşıyıcısı).
 *   4) Uzantı, kullanıcı adından değil gerçek görsel türünden türetilir.
 * Ayrıca hedef klasörde (admin/resimler) .htaccess ile script yürütme kapalı.
 *
 * Yanıt sözleşmesi (JS ile uyumlu): başarı => dosya adı; '2' => geçersiz görsel;
 * '3' => yetkisiz / boyut / işlem hatası.
 */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    session_start();
}

// Admin oturumu zorunlu
if (empty($_SESSION['eposta'])) {
    http_response_code(403);
    echo 3;
    exit;
}

if (!$_POST || !isset($_FILES['Filedata']) || $_FILES['Filedata']['error'] !== UPLOAD_ERR_OK) {
    echo 3;
    exit;
}

$file = $_FILES['Filedata'];

// Boyut limiti: 15 MB (JS fileSizeLimit ile uyumlu)
$maxBytes = 15 * 1024 * 1024;
if ($file['size'] <= 0 || $file['size'] > $maxBytes) {
    echo 3;
    exit;
}

// İçerik doğrulama: gerçek görsel türü (uzantı yalanını yakalar)
$allowed = array(
    IMAGETYPE_JPEG => 'jpg',
    IMAGETYPE_PNG  => 'png',
    IMAGETYPE_GIF  => 'gif',
    IMAGETYPE_WEBP => 'webp',
);
$info = @getimagesize($file['tmp_name']);
if ($info === false || !isset($allowed[$info[2]])) {
    echo 2;
    exit;
}
$ext = $allowed[$info[2]];

// Benzersiz, güvenli dosya adı
$fileName = sprintf('%06d', mt_rand(0, 999999)) . '-' . time() . '-' . uniqid() . '.' . $ext;

$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/admin/resimler';
$targetFile = $targetPath . '/' . $fileName;

if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    // MAS-18: yüklenen görseli otomatik küçült (GD yoksa dokunmaz)
    require_once __DIR__ . '/../../../includes/image.php';
    masq_compress_image($targetFile);
    echo $fileName;
} else {
    echo 3;
}
