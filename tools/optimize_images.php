<?php
/**
 * optimize_images.php — Tek seferlik görsel küçültme (MAS-18). Mevcut büyük görselleri
 * (admin/resimler/) yerinde küçültür; orijinalleri admin/resimler_orig/ altına yedekler.
 * Dosya ADLARI/YOLLARI korunur → şablon değişikliği GEREKMEZ, site anında hızlanır.
 *
 * GD gerektirir (local XAMPP'ta yok; PROD/Natro cPanel'de var).
 * Çalıştırma (cPanel → Terminal, repo kökünde):
 *     php tools/optimize_images.php            # uygula
 *     php tools/optimize_images.php --dry      # sadece raporla (değiştirme)
 *
 * Ayarlar: en büyük kenar 1400px, JPEG kalite 82. Zaten küçük olanlar atlanır.
 * İdempotent: yedeği olan (zaten işlenmiş) dosyalar tekrar küçültülmez.
 */

@set_time_limit(0);
@ini_set('memory_limit', '512M');

$DRY = in_array('--dry', $argv ?? [], true);

if (php_sapi_name() !== 'cli') {
    // Web'den erişim: yalnızca giriş yapmış admin
    session_start();
    require_once __DIR__ . '/../admin/include/baglan.php';
    require_once __DIR__ . '/../admin/include/fonksiyonlar.php';
    oturumkontrolana();
    header('Content-Type: text/plain; charset=utf-8');
}

if (!extension_loaded('gd')) {
    exit("HATA: GD eklentisi yok. Bu script GD olan ortamda (prod) çalıştırılmalı.\n");
}

$dir    = __DIR__ . '/../admin/resimler';
$backup = __DIR__ . '/../admin/resimler_orig';
$MAXDIM = 1400;
$QUALITY = 82;
$MIN_BYTES = 120 * 1024; // 120KB altındakileri atla

if (!is_dir($dir)) { exit("HATA: $dir yok.\n"); }
if (!is_dir($backup)) { @mkdir($backup, 0775, true); }

$exts = ['jpg', 'jpeg', 'png'];
$files = scandir($dir);
$done = 0; $skipped = 0; $saved = 0; $errors = 0;

foreach ($files as $f) {
    $path = $dir . '/' . $f;
    if (!is_file($path)) { continue; }
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if (!in_array($ext, $exts, true)) { continue; }

    $bytes = filesize($path);
    $bpath = $backup . '/' . $f;

    // Zaten yedeği varsa (işlenmiş) atla — idempotent
    if (file_exists($bpath)) { $skipped++; continue; }

    $info = @getimagesize($path);
    if (!$info) { $errors++; echo "ATLA (okunamadi): $f\n"; continue; }
    [$w, $h] = $info;

    // Hem küçük boyut hem küçük dosya ise dokunma
    if ($w <= $MAXDIM && $h <= $MAXDIM && $bytes < $MIN_BYTES) { $skipped++; continue; }

    if ($DRY) {
        echo sprintf("[dry] %s  %dx%d  %dKB\n", $f, $w, $h, round($bytes/1024));
        $done++; continue;
    }

    // Yükle
    $src = ($ext === 'png') ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (!$src) { $errors++; echo "ATLA (yuklenemedi): $f\n"; continue; }

    // Yeni boyut (oran korunur)
    $scale = min(1, $MAXDIM / max($w, $h));
    $nw = max(1, (int) round($w * $scale));
    $nh = max(1, (int) round($h * $scale));

    // Yedekle (orijinali koru)
    if (!@copy($path, $bpath)) { imagedestroy($src); $errors++; echo "ATLA (yedeklenemedi): $f\n"; continue; }

    $dst = imagecreatetruecolor($nw, $nh);
    if ($ext === 'png') {
        imagealphablending($dst, false); imagesavealpha($dst, true);
    }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

    $ok = ($ext === 'png') ? imagepng($dst, $path, 7) : imagejpeg($dst, $path, $QUALITY);
    imagedestroy($src); imagedestroy($dst);

    if ($ok) {
        $newBytes = filesize($path);
        $saved += ($bytes - $newBytes);
        $done++;
        echo sprintf("OK %s  %dx%d->%dx%d  %dKB->%dKB\n", $f, $w, $h, $nw, $nh, round($bytes/1024), round($newBytes/1024));
    } else {
        // başarısızsa yedekten geri yükle
        @copy($bpath, $path);
        $errors++; echo "HATA (kaydedilemedi, geri alindi): $f\n";
    }
}

echo "\n----\n";
echo "Islenen: $done | Atlanan: $skipped | Hata: $errors | Kazanc: " . round($saved/1024/1024, 1) . " MB\n";
echo $DRY ? "(DRY RUN — degisiklik yapilmadi)\n" : "Bitti. Orijinaller: admin/resimler_orig/\n";
