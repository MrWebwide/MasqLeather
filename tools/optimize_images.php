<?php
/**
 * optimize_images.php — Tek seferlik görsel küçültme (MAS-18).
 * admin/resimler/ altındaki büyük görselleri yerinde küçültür; orijinalleri
 * admin/resimler_orig/ altına yedekler. Dosya ADLARI/YOLLARI korunur → şablon
 * değişikliği GEREKMEZ. GD gerektirir (prod/Natro'da var, local XAMPP'ta yok).
 *
 * ÇALIŞTIRMA (Terminal YOKSA — tarayıcıdan):
 *   1) Önce ADMIN panele giriş yap (dev.masqleather.com/admin).
 *   2) Tarayıcıda aç: https://dev.masqleather.com/tools/optimize_images.php
 *      - Her sayfa ~40 görsel işler ve KENDİLİĞİNDEN yenilenip devam eder.
 *      - Sekmeyi açık bırak; "TAMAMLANDI" yazana kadar bekle.
 *   3) Sadece rapor/önizleme için:  .../tools/optimize_images.php?dry=1
 *
 * ÇALIŞTIRMA (Terminal varsa): php tools/optimize_images.php  [--dry]
 */

@set_time_limit(0);
@ini_set('memory_limit', '512M');

$CLI = (php_sapi_name() === 'cli');
$DRY = $CLI ? in_array('--dry', $argv ?? [], true) : isset($_GET['dry']);
$BATCH = $CLI ? PHP_INT_MAX : 40; // tarayıcıda timeout'a takılmamak için partiler halinde

// Tek-seferlik araç: tarayıcıdan erişim gizli anahtar ister (oturum/login gerekmez).
$TOKEN = 'masq-optimize-7Qx2';

if (!$CLI) {
    if (($_GET['key'] ?? '') !== $TOKEN) {
        http_response_code(403);
        exit('Forbidden — gecerli ?key gerekli.');
    }
    echo "<!doctype html><meta charset='utf-8'><body style='font:14px/1.5 monospace;padding:16px;white-space:pre-wrap'>";
}

function out($s) { echo $s . "\n"; @flush(); }

if (!extension_loaded('gd')) {
    out("HATA: GD eklentisi yok. cPanel > Select PHP Version > Extensions > 'gd' isaretle, sonra tekrar dene.");
    exit;
}

$dir       = __DIR__ . '/../admin/resimler';
$backup    = __DIR__ . '/../admin/resimler_orig';
$MAXDIM    = 1400;
$QUALITY   = 82;
$MIN_BYTES = 120 * 1024;

if (!is_dir($dir))   { out("HATA: $dir yok."); exit; }
if (!is_dir($backup)) { @mkdir($backup, 0775, true); }

$exts = ['jpg', 'jpeg', 'png'];

// --- TEŞHİS MODU: ?diag=1 ---  (hiçbir şeyi değiştirmez)
if (!$CLI && isset($_GET['diag'])) {
    out("GD yuklu: " . (extension_loaded('gd') ? 'EVET' : 'HAYIR'));
    out("imagejpeg var: " . (function_exists('imagejpeg') ? 'EVET' : 'HAYIR'));
    out("resimler yazilabilir: " . (is_writable($dir) ? 'EVET' : 'HAYIR (sorun bu olabilir!)'));
    out("resimler_orig yazilabilir: " . (is_writable($backup) ? 'EVET' : 'HAYIR'));
    $bk = is_dir($backup) ? max(0, count(scandir($backup)) - 2) : 0;
    out("yedek (zaten islenmis) dosya sayisi: $bk");
    // canlı test: ilk büyük jpg'yi geçici dosyaya küçült
    foreach (scandir($dir) as $tf) {
        $tp = "$dir/$tf"; if (!is_file($tp)) continue;
        $te = strtolower(pathinfo($tf, PATHINFO_EXTENSION)); if (!in_array($te, ['jpg','jpeg'], true)) continue;
        $ti = @getimagesize($tp); if (!$ti || max($ti[0],$ti[1]) <= $MAXDIM) continue;
        $ob = filesize($tp);
        $im = @imagecreatefromjpeg($tp);
        if (!$im) { out("TEST: '$tf' GD ile ACILAMADI (GD/jpeg sorunu)"); break; }
        $sc = $MAXDIM / max($ti[0],$ti[1]); $nw=(int)round($ti[0]*$sc); $nh=(int)round($ti[1]*$sc);
        $d = imagecreatetruecolor($nw,$nh); imagecopyresampled($d,$im,0,0,0,0,$nw,$nh,$ti[0],$ti[1]);
        $tmp = "$backup/_test_$tf"; $ok = imagejpeg($d,$tmp,$QUALITY); imagedestroy($im); imagedestroy($d);
        if ($ok) { out("TEST OK: '$tf' {$ti[0]}x{$ti[1]} ".round($ob/1024)."KB -> {$nw}x{$nh} ".round(filesize($tmp)/1024)."KB"); @unlink($tmp); }
        else { out("TEST: '$tf' imagejpeg YAZAMADI (yazma izni/disk sorunu)"); }
        break;
    }
    exit;
}

// Kümülatif toplam (sayfalar arası) — gerçek toplam kazancı göstermek için
$progFile = $backup . '/_progress.json';
$prog = @json_decode(@file_get_contents($progFile), true) ?: ['saved' => 0, 'done' => 0];
$files = scandir($dir);
$processed = 0; $skipped = 0; $errors = 0; $saved = 0; $remaining = 0;

foreach ($files as $f) {
    $path = $dir . '/' . $f;
    if (!is_file($path)) { continue; }
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if (!in_array($ext, $exts, true)) { continue; }

    $bpath = $backup . '/' . $f;
    if (file_exists($bpath)) { $skipped++; continue; } // zaten islenmis (idempotent)

    $bytes = filesize($path);
    $info = @getimagesize($path);
    if (!$info) { $errors++; out("ATLA (okunamadi): $f"); continue; }
    [$w, $h] = $info;

    if ($w <= $MAXDIM && $h <= $MAXDIM && $bytes < $MIN_BYTES) { $skipped++; continue; }

    // Parti dolduysa: bu turda daha fazla işleme, devamı sonraki refresh'te
    if ($processed >= $BATCH) { $remaining++; continue; }

    if ($DRY) {
        out(sprintf("[dry] %s  %dx%d  %dKB", $f, $w, $h, round($bytes/1024)));
        $processed++; continue;
    }

    $src = ($ext === 'png') ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (!$src) { $errors++; out("ATLA (yuklenemedi): $f"); continue; }

    $scale = min(1, $MAXDIM / max($w, $h));
    $nw = max(1, (int) round($w * $scale));
    $nh = max(1, (int) round($h * $scale));

    if (!@copy($path, $bpath)) { imagedestroy($src); $errors++; out("ATLA (yedeklenemedi): $f"); continue; }

    $dst = imagecreatetruecolor($nw, $nh);
    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
    $ok = ($ext === 'png') ? imagepng($dst, $path, 7) : imagejpeg($dst, $path, $QUALITY);
    imagedestroy($src); imagedestroy($dst);

    if ($ok) {
        clearstatcache(true, $path); // filesize() cache'i temizle (yoksa eski boyut okunur → "kazanç 0" yanılgısı)
        $newBytes = filesize($path);
        $saved += ($bytes - $newBytes);
        $processed++;
        out(sprintf("OK %s  %dx%d->%dx%d  %dKB->%dKB", $f, $w, $h, $nw, $nh, round($bytes/1024), round($newBytes/1024)));
    } else {
        @copy($bpath, $path); $errors++; out("HATA (geri alindi): $f");
    }
}

out("\n---- Bu tur: islenen $processed | atlanan $skipped | hata $errors | kazanc " . round($saved/1024/1024, 2) . " MB");

// Tarayıcıda devamı varsa otomatik yenile
if (!$CLI && !$DRY && $processed >= $BATCH && $remaining > 0) {
    out("Devam ediyor... (sayfa otomatik yenilenecek, sekmeyi kapatma)");
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    out($DRY ? "(DRY — degisiklik yapilmadi)" : "TAMAMLANDI. Orijinaller: admin/resimler_orig/");
}
