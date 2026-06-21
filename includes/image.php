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
    $info = @getimagesize($path); // tür İÇERİKTEN belirlenir (yanlış uzantı .peg vb. de yakalanır)
    if (!$info) {
        return false;
    }
    [$w, $h] = $info;
    $type = $info[2];
    $isJpg = ($type === IMAGETYPE_JPEG);
    $isPng = ($type === IMAGETYPE_PNG);
    if (!$isJpg && !$isPng) {
        return false; // webp/gif vb. dokunma
    }

    $bytes = filesize($path);
    // Zaten hem küçük boyut hem küçük dosya ise dokunma
    if ($w <= $maxDim && $h <= $maxDim && $bytes < 120 * 1024) {
        return false;
    }

    // PNG opak mı? (MAS-18) Opak PNG'ler JPEG olarak yazılır (foto PNG'leri ~10x küçülür);
    // gerçekten şeffaf olanlar PNG kalır. Dosya ADI değişmez (içerik JPEG olur).
    $pngOpaque = ($isPng && masq_png_is_opaque($path, $w, $h));
    $asJpeg = $isJpg || $pngOpaque;

    $src = $isPng ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (!$src) {
        return false;
    }

    $scale = min(1, $maxDim / max($w, $h));
    $nw = max(1, (int) round($w * $scale));
    $nh = max(1, (int) round($h * $scale));

    $dst = imagecreatetruecolor($nw, $nh);
    if ($isPng && !$pngOpaque) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true); // şeffaflığı koru
    } elseif ($asJpeg) {
        // JPEG'de şeffaflık yok → beyaz zemin
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $white);
        imagealphablending($dst, true);
    }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

    $ok = $asJpeg ? imagejpeg($dst, $path, $quality) : imagepng($dst, $path, 7);
    imagedestroy($src);
    imagedestroy($dst);
    return (bool) $ok;
}

/**
 * PNG opak mı? IHDR renk tipi + piksel örneklemesiyle hızlı kontrol.
 */
function masq_png_is_opaque(string $path, int $w = 0, int $h = 0): bool
{
    $fh = @fopen($path, 'rb');
    if (!$fh) { return true; }
    $hd = fread($fh, 30); fclose($fh);
    if (strlen($hd) < 26) { return true; }
    $colorType = ord($hd[25]);
    if ($colorType !== 4 && $colorType !== 6) {
        return true; // alpha kanalı yok → opak
    }
    $im = @imagecreatefrompng($path);
    if (!$im) { return true; }
    if ($w <= 0) { $w = imagesx($im); }
    if ($h <= 0) { $h = imagesy($im); }
    $opaque = true;
    for ($i = 0; $i < 300; $i++) {
        $alpha = (imagecolorat($im, mt_rand(0, $w - 1), mt_rand(0, $h - 1)) >> 24) & 0x7F;
        if ($alpha > 10) { $opaque = false; break; }
    }
    imagedestroy($im);
    return $opaque;
}
