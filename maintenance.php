<?php
/**
 * maintenance.php — Bakım modu sayfası. (MAS-84)
 *
 * Bakım modu açıkken (bakim_modu.kategori == 1) includes/init.php bu dosyayı
 * dahil eder. Admin'in panelden girdiği başlık ($bakim['adi']) ve açıklama
 * ($bakim['aciklama']) burada gösterilir. Kendi kendine yeter (inline CSS).
 *
 * $bakim init.php'de zaten yüklü; garanti için burada da fallback var.
 */
if (!isset($bakim) || !is_array($bakim)) {
    if (isset($db)) {
        $bakim = $db->query("SELECT * FROM bakim_modu WHERE id = 1")->fetch(PDO::FETCH_ASSOC) ?: [];
    } else {
        $bakim = [];
    }
}
$mBaslik   = !empty($bakim['adi'])      ? $bakim['adi']      : 'Under Maintenance';
$mAciklama = !empty($bakim['aciklama']) ? $bakim['aciklama'] : 'Our website is currently undergoing scheduled maintenance. We will be back shortly.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($mBaslik) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: "Segoe UI", -apple-system, Roboto, Helvetica, Arial, sans-serif;
            background: #2b2320; color: #f3ede7; padding: 24px; text-align: center;
        }
        .wrap { max-width: 620px; }
        .logo { width: 120px; height: auto; margin: 0 auto 28px; display: block; opacity: .95; }
        h1 { font-size: 30px; font-weight: 600; margin-bottom: 16px; letter-spacing: .5px; color: #fff; }
        p { font-size: 16px; line-height: 1.7; color: #cbbfb4; }
        .divider { width: 60px; height: 3px; background: #AB6E35; border-radius: 3px; margin: 24px auto; }
        .foot { margin-top: 34px; font-size: 13px; color: #8c8177; letter-spacing: 1px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="wrap">
        <img class="logo" src="/assets/img/logo/Artboard 1 copy 6.png" alt="Masq Leather"
             onerror="this.style.display='none'">
        <h1><?= htmlspecialchars($mBaslik) ?></h1>
        <div class="divider"></div>
        <p><?= nl2br(htmlspecialchars($mAciklama)) ?></p>
        <div class="foot">Masq Leather</div>
    </div>
</body>
</html>
