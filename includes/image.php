<?php
/**
 * image.php — Yüklenen görselleri otomatik küçült/sıkıştır. (MAS-18)
 *
 * Amaç: admin'den ne yüklenirse yüklensin (tekli veya çoklu) site şişmesin.
 * Görsel yerinde küçültülür (en büyük kenar $maxDim, JPEG kalite $quality).
 * GD yoksa veya görsel zaten küçükse DOKUNMAZ (orijinali bırakır) → asla bozmaz.
 *
 * Kullanım: move_uploaded_file(...) başarılı olduktan SONRA hedef yola çağır:
 *     masq_compress_image($hedefDosyaYolu);
 *
 * @return bool true=küçültüldü, false=dokunulmadı (zaten küçük / GD yok / desteklenmeyen)
 */
function masq_compress_image(string $path, int $maxDim = 1400, int $quality = 82): bool
{
    if (!extension_loaded('gd') || !is_file($path)) {
        return false;
    }
    $info = @getimagesize($path);
    if (!$info) {
        return false;
    }
    [$w, $h] = $info;
    $type = $info[2];
    $isJpg = ($type === IMAGETYPE_JPEG);
    $isPng = ($type === IMAGETYPE_PNG);
    if (!$isJpg && !$isPng) {
        return false; // webp/gif vb. dokunma (zaten verimli / şeffaflık)
    }

    $bytes = filesize($path);
    // Zaten hem küçük boyut hem küçük dosya ise dokunma
    if ($w <= $maxDim && $h <= $maxDim && $bytes < 120 * 1024) {
        return false;
    }

    $src = $isPng ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (!$src) {
        return false;
    }

    $scale = min(1, $maxDim / max($w, $h));
    $nw = max(1, (int) round($w * $scale));
    $nh = max(1, (int) round($h * $scale));

    $dst = imagecreatetruecolor($nw, $nh);
    if ($isPng) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

    $ok = $isPng ? imagepng($dst, $path, 7) : imagejpeg($dst, $path, $quality);
    imagedestroy($src);
    imagedestroy($dst);
    return (bool) $ok;
}
