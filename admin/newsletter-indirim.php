<?php
/**
 * newsletter-indirim.php — MAS-110
 * Newsletter kayıt indirimini panelden yönet: açık/kapalı, indirim oranı, kupon kod öneki
 * + kayıt olana giden mailin konu/içeriği (mail_sablon 'newsletter_welcome').
 */
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$mesaj = '';
$tabloYok = false;

// --- İndirim ayarlarını kaydet
if (isset($_POST['kaydet_ayar'])) {
    $aktif = isset($_POST['aktif']) ? 1 : 0;
    $oran  = (float) str_replace(',', '.', $_POST['oran'] ?? '0');
    $onek  = strtoupper(trim($_POST['kod_onek'] ?? 'WELCOME'));
    $onek  = preg_replace('/[^A-Z0-9]/', '', $onek);
    if ($onek === '') { $onek = 'WELCOME'; }
    if ($oran < 0)   { $oran = 0; }
    if ($oran > 100) { $oran = 100; }

    try {
        $upd = $db->prepare("UPDATE newsletter_indirim SET aktif = ?, oran = ?, kod_onek = ? WHERE id = 1");
        $upd->execute([$aktif, $oran, $onek]);
        // Satır yoksa oluştur
        if ($upd->rowCount() === 0) {
            $chk = $db->query("SELECT COUNT(*) FROM newsletter_indirim WHERE id = 1")->fetchColumn();
            if ((int) $chk === 0) {
                $db->prepare("INSERT INTO newsletter_indirim (id, aktif, oran, kod_onek) VALUES (1, ?, ?, ?)")
                   ->execute([$aktif, $oran, $onek]);
            }
        }
        $mesaj = '<div class="alert alert-success">İndirim ayarları güncellendi.</div>';
    } catch (\Throwable $e) {
        $tabloYok = true;
    }
}

// --- Mail metnini kaydet (mail_sablon)
if (isset($_POST['kaydet_mail'])) {
    $konu   = trim($_POST['konu'] ?? '');
    $icerik = trim($_POST['icerik'] ?? '');
    if ($konu !== '' && $icerik !== '') {
        try {
            $upd = $db->prepare("UPDATE mail_sablon SET konu = ?, icerik = ?, guncelleme = NOW() WHERE mkey = 'newsletter_welcome'");
            $upd->execute([$konu, $icerik]);
            if ($upd->rowCount() === 0) {
                // Satır yoksa ekle
                $chk = $db->prepare("SELECT COUNT(*) FROM mail_sablon WHERE mkey = 'newsletter_welcome'");
                $chk->execute();
                if ((int) $chk->fetchColumn() === 0) {
                    $db->prepare("INSERT INTO mail_sablon (mkey, baslik, konu, icerik, degiskenler) VALUES ('newsletter_welcome', 'Newsletter Hosgeldin Indirimi', ?, ?, '{code}, {oran}')")
                       ->execute([$konu, $icerik]);
                }
            }
            $mesaj = '<div class="alert alert-success">Mail metni güncellendi.</div>';
        } catch (\Throwable $e) {
            $tabloYok = true;
        }
    } else {
        $mesaj = '<div class="alert alert-warning">Konu ve içerik boş olamaz.</div>';
    }
}

// --- Mevcut değerleri çek
$cfg = ['aktif' => 1, 'oran' => '10.00', 'kod_onek' => 'WELCOME'];
$tpl = ['konu' => '', 'icerik' => ''];
try {
    $row = $db->query("SELECT aktif, oran, kod_onek FROM newsletter_indirim WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
    if ($row) { $cfg = $row; }
    $mr = $db->query("SELECT konu, icerik FROM mail_sablon WHERE mkey = 'newsletter_welcome'")->fetch(PDO::FETCH_ASSOC);
    if ($mr) { $tpl = $mr; }
} catch (\Throwable $e) {
    $tabloYok = true;
}
if ($tabloYok) {
    $mesaj = '<div class="alert alert-danger"><strong>newsletter_indirim</strong> / <strong>mail_sablon</strong> tablosu bulunamadı. Lütfen önce <code>db/migrations/2026_07_09_newsletter_indirim.sql</code> dosyasını çalıştırın.</div>';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Newsletter İndirimi | <?=$ayar['site_title']?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <div class="page-header"><?php include("include/header.php"); ?></div>
        <?php include("include/menu.php"); ?>
        <div class="page-content">
            <div class="main-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Newsletter Kayıt İndirimi</h5>
                                <p class="card-description">Newsletter'a e-posta ile kayıt olan kullanıcıya <strong>bir kerelik</strong> indirim kuponu üretilir ve mail ile gönderilir. Kupon, checkout'taki kupon alanında bir kez kullanılır.</p>
                                <?= $mesaj ?>

                                <div class="card mb-4" style="border:1px solid #e5e5e5;">
                                    <div class="card-body">
                                        <h6 style="font-weight:600;">İndirim Ayarları</h6>
                                        <form method="post">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="aktif" name="aktif" <?= ((int)($cfg['aktif'] ?? 0) === 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="aktif">İndirim maili gönderimi <strong>aktif</strong></label>
                                            </div>
                                            <div class="mb-3" style="max-width:220px;">
                                                <label class="form-label">İndirim Oranı (%)</label>
                                                <input type="number" step="0.01" min="0" max="100" class="form-control" name="oran" value="<?= htmlspecialchars($cfg['oran'] ?? '10') ?>">
                                            </div>
                                            <div class="mb-3" style="max-width:220px;">
                                                <label class="form-label">Kupon Kod Öneki</label>
                                                <input type="text" class="form-control" name="kod_onek" value="<?= htmlspecialchars($cfg['kod_onek'] ?? 'WELCOME') ?>">
                                                <small class="text-muted">Örn. WELCOME → kod: <code>WELCOME-1A2B3C</code></small>
                                            </div>
                                            <button type="submit" name="kaydet_ayar" value="1" class="btn btn-primary">Ayarları Kaydet</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="card mb-4" style="border:1px solid #e5e5e5;">
                                    <div class="card-body">
                                        <h6 style="font-weight:600;">Gönderilen Mail Metni</h6>
                                        <p style="font-size:13px;color:#888;margin-bottom:10px;">Değişkenler: <code>{code}</code> (kupon kodu), <code>{oran}</code> (indirim yüzdesi) — gönderim sırasında otomatik doldurulur, aynen bırakın.</p>
                                        <form method="post">
                                            <div class="mb-3">
                                                <label class="form-label">Konu (Subject)</label>
                                                <input type="text" class="form-control" name="konu" value="<?= htmlspecialchars($tpl['konu'] ?? '') ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">İçerik (HTML destekler — &lt;br&gt;, &lt;strong&gt; vb.)</label>
                                                <textarea class="form-control" name="icerik" rows="8"><?= htmlspecialchars($tpl['icerik'] ?? '') ?></textarea>
                                            </div>
                                            <button type="submit" name="kaydet_mail" value="1" class="btn btn-primary">Mail Metnini Kaydet</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="https://use.fontawesome.com/ca9a29c061.js"></script>
</body>
</html>
