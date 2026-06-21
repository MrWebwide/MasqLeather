<?php
/**
 * optimize_assets_img.php — assets/img tek-seferlik optimizasyon (perf / PageSpeed).
 *
 * İki iş yapar:
 *  (1) "Küçük gösterilen ama dev çözünürlüklü" logo/ikonları gerçek görüntü boyutuna küçültür
 *      (ör. 1178px logo 140px gösteriliyordu; 512px ikon 40px). Şeffaflık korunur.
 *  (2) Kalan büyük fotoğrafları masq_compress_image ile sıkıştırır (max 1400px, q82).
 *
 * assets/img GIT'te olduğu için orijinaller git geçmişinde durur (ayrı yedek gerekmez).
 *
 * Çalıştırma:
 *   CLI:      php -d extension=gd tools/optimize_assets_img.php [--dry]
 *   Tarayıcı: /tools/optimize_assets_img.php?key=masq-optimize-7Qx2 [&dry=1]
 */
@set_time_limit(0);
@ini_set('memory_limit', '1024M');
require_once __DIR__ . '/../includes/image.php';

$CLI = (php_sapi_name() === 'cli');
$DRY = $CLI ? in_array('--dry', $argv ?? [], true) : isset($_GET['dry']);
$TOKEN = 'masq-optimize-7Qx2';
if (!$CLI) {
    if (($_GET['key'] ?? '') !== $TOKEN) { http_response_code(403); exit('Forbidden'); }
    echo "<!doctype html><meta charset='utf-8'><body style='font:14px/1.5 monospace;padding:16px;white-space:pre-wrap'>";
}
function o($s) { echo $s . "\n"; @flush(); }
if (!extension_loaded('gd')) { o('HATA: GD yok. CLI icin: php -d extension=gd ...'); exit; }

$root = __DIR__ . '/../assets/img';
if (!is_dir($root)) { o("HATA: $root yok."); exit; }

/**
 * Belirli bir görseli hedef max kenara küçült (şeffaflık korunur). Zaten küçükse dokunma.
 */
function resize_to(string $path, int $maxDim): array {
    if (!is_file($path)) return [false, "yok"];
    $info = @getimagesize($path);
    if (!$info) return [false, "okunamadi"];
    [$w, $h] = $info; $type = $info[2];
    if (max($w, $h) <= $maxDim) return [false, "zaten kucuk ({$w}x{$h})"];
    $isPng = ($type === IMAGETYPE_PNG);
    $isJpg = ($type === IMAGETYPE_JPEG);
    if (!$isPng && !$isJpg) return [false, "desteklenmeyen tur"];
    $src = $isPng ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (!$src) return [false, "GD acamadi"];
    $scale = $maxDim / max($w, $h);
    $nw = max(1, (int)round($w * $scale));
    $nh = max(1, (int)round($h * $scale));
    $dst = imagecreatetruecolor($nw, $nh);
    if ($isPng) { imagealphablending($dst, false); imagesavealpha($dst, true); }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
    $ob = filesize($path);
    $ok = $isPng ? imagepng($dst, $path, 7) : imagejpeg($dst, $path, 85);
    imagedestroy($src); imagedestroy($dst);
    if (!$ok) return [false, "yazilamadi"];
    clearstatcache(true, $path);
    return [true, sprintf("%dx%d %dKB -> %dx%d %dKB", $w, $h, $ob/1024, $nw, $nh, filesize($path)/1024)];
}

// (1) Küçük gösterilen, dev çözünürlüklü görseller → hedef boyut
$targets = [
    'logo/Artboard 1 copy 6.png' => 360,   // header logosu (~140px gösteriliyor, 2.5x retina)
    'logo/Artboard 1 copy 3.png' => 500,    // footer logosu (~245px gösteriliyor)
    'animated-icon/account.png' => 120,
    'animated-icon/white-magnifier.png' => 120,
    'animated-icon/shopping-cartwww.png' => 120,
];
o("== (1) Logo/ikon hedef boyuta kuculuyor ==");
$saved = 0;
foreach ($targets as $rel => $max) {
    $p = "$root/$rel"; $before = is_file($p) ? filesize($p) : 0;
    if ($DRY) { $i = @getimagesize($p); o("[dry] $rel  " . ($i ? "{$i[0]}x{$i[1]}" : "yok") . " -> max $max"); continue; }
    [$ok, $msg] = resize_to($p, $max);
    if ($ok) { $saved += $before - filesize($p); o("OK  $rel  $msg"); }
    else o("--  $rel  ($msg)");
}

// (2) Kalan büyük fotoğraflar → masq_compress_image (1400/q82)
o("\n== (2) Buyuk fotograflar sikistiriliyor (max 1400px, q82) ==");
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
$proc = 0; $skip = 0;
foreach ($rii as $fileInfo) {
    if (!$fileInfo->isFile()) continue;
    $path = $fileInfo->getPathname();
    $ext = strtolower($fileInfo->getExtension());
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) continue;
    if (isset($targets[str_replace('\\', '/', substr($path, strlen($root) + 1))])) continue; // (1)'de yapıldı
    $before = filesize($path);
    $isPng = ($ext === 'png');
    if ($DRY) {
        $i = @getimagesize($path);
        if ($i && (max($i[0], $i[1]) > 1400 || $before >= 120 * 1024)) { o("[dry] " . basename($path) . ($isPng ? " [png:resize-only]" : "") . "  {$i[0]}x{$i[1]} " . round($before/1024) . "KB"); $proc++; }
        else $skip++;
        continue;
    }
    // PNG'ler: SADECE yeniden boyutlandır (format/şeffaflık korunur, logo beyazlaşmasın).
    // JPEG'ler: masq_compress_image (resize + q82, jpeg kalır).
    if ($isPng) {
        [$ok, $msg] = resize_to($path, 1400);
        if ($ok) { clearstatcache(true, $path); $saved += $before - filesize($path); $proc++; o("OK  " . basename($path) . "  $msg"); }
        else $skip++;
    } else {
        if (masq_compress_image($path)) {
            clearstatcache(true, $path);
            $saved += $before - filesize($path); $proc++;
            o("OK  " . basename($path) . "  " . round($before/1024) . "KB -> " . round(filesize($path)/1024) . "KB");
        } else { $skip++; }
    }
}
o("\n---- islenen $proc | atlanan $skip | TOPLAM KAZANC " . round($saved/1024/1024, 2) . " MB");
o($DRY ? "(DRY)" : "TAMAMLANDI.");
