<?php
/**
 * png_to_jpeg.php — İkinci geçiş (MAS-18): kalan büyük PNG'leri ve yanlış uzantılı
 * (.peg vb.) görselleri sıkıştırır. OPAK PNG'ler dosya ADI .png kalacak şekilde JPEG
 * içeriğine çevrilir (~10x küçülür); GERÇEKTEN şeffaf olanlar PNG kalır (sadece küçültülür).
 * JPG/JPEG dosyalarına DOKUNMAZ (onlar ilk geçişte yapıldı). includes/image.php kullanır.
 *
 * Çalıştırma:
 *   CLI:       php tools/png_to_jpeg.php  [--dry]
 *   Tarayıcı:  /tools/png_to_jpeg.php?key=masq-optimize-7Qx2   (batch + auto-refresh)
 */
@set_time_limit(0);
@ini_set('memory_limit', '1024M');
require_once __DIR__ . '/../includes/image.php';

$CLI = (php_sapi_name() === 'cli');
$DRY = $CLI ? in_array('--dry', $argv ?? [], true) : isset($_GET['dry']);
$BATCH = $CLI ? PHP_INT_MAX : 40;
$TOKEN = 'masq-optimize-7Qx2';

if (!$CLI) {
    if (($_GET['key'] ?? '') !== $TOKEN) { http_response_code(403); exit('Forbidden'); }
    echo "<!doctype html><meta charset='utf-8'><body style='font:14px/1.5 monospace;padding:16px;white-space:pre-wrap'>";
}
function o($s) { echo $s . "\n"; @flush(); }

if (!extension_loaded('gd')) { o("HATA: GD yok (cPanel > Select PHP Version > gd)."); exit; }

$dir    = __DIR__ . '/../admin/resimler';
$backup = __DIR__ . '/../admin/resimler_orig';
if (!is_dir($dir)) { o("HATA: $dir yok."); exit; }
if (!is_dir($backup)) { @mkdir($backup, 0775, true); }

$processed = 0; $skipped = 0; $errors = 0; $saved = 0; $remaining = 0;

foreach (scandir($dir) as $f) {
    $path = $dir . '/' . $f;
    if (!is_file($path)) { continue; }
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if ($ext === 'jpg' || $ext === 'jpeg') { continue; } // ilk geçişte yapıldı, dokunma

    $info = @getimagesize($path);
    if (!$info) { $skipped++; continue; }
    [$w, $h] = $info;
    $bytes = filesize($path);
    if ($w <= 1400 && $h <= 1400 && $bytes < 120 * 1024) { $skipped++; continue; } // zaten küçük

    if ($processed >= $BATCH) { $remaining++; continue; }
    if ($DRY) { o(sprintf("[dry] %s  %dx%d  %dKB", $f, $w, $h, round($bytes/1024))); $processed++; continue; }

    // Orijinal yedeği yoksa al (ilk geçişte PNG'ler yedeklenmişti; çift yedeklemeyiz)
    $bpath = $backup . '/' . $f;
    if (!file_exists($bpath)) { @copy($path, $bpath); }

    if (masq_compress_image($path)) {
        clearstatcache(true, $path);
        $nb = filesize($path);
        $saved += ($bytes - $nb);
        $processed++;
        o(sprintf("OK %s  %dx%d  %dKB->%dKB", $f, $w, $h, round($bytes/1024), round($nb/1024)));
    } else {
        $skipped++; // şeffaf+zaten küçük ya da desteklenmeyen
    }
}

o("\n---- islenen $processed | atlanan $skipped | hata $errors | kazanc " . round($saved/1024/1024, 2) . " MB");
if (!$CLI && !$DRY && $processed >= $BATCH && $remaining > 0) {
    o("Devam ediyor... (otomatik yenilenecek)");
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    o($DRY ? "(DRY)" : "TAMAMLANDI.");
}
