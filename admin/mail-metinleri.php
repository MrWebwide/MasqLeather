<?php
/**
 * mail-metinleri.php — Müşteri mail metinleri editörü. (MAS-83)
 * mail_sablon tablosundaki şablonların konu + içeriğini panelden düzenler.
 */
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$mesaj = '';

// Kaydet
if (isset($_POST['kaydet_mkey'])) {
    $mkey   = $_POST['kaydet_mkey'];
    $konu   = trim($_POST['konu'] ?? '');
    $icerik = trim($_POST['icerik'] ?? '');
    if ($mkey !== '' && $konu !== '' && $icerik !== '') {
        $upd = $db->prepare("UPDATE mail_sablon SET konu = ?, icerik = ?, guncelleme = NOW() WHERE mkey = ?");
        $upd->execute([$konu, $icerik, $mkey]);
        $mesaj = '<div class="alert alert-success">"' . htmlspecialchars($mkey) . '" şablonu güncellendi.</div>';
    } else {
        $mesaj = '<div class="alert alert-warning">Konu ve içerik boş olamaz.</div>';
    }
}

$sablonlar = [];
try {
    $sablonlar = $db->query("SELECT * FROM mail_sablon ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $e) {
    $mesaj = '<div class="alert alert-danger"><strong>mail_sablon</strong> tablosu bulunamadı. Lütfen önce db/migrations/2026_07_03_mail_sablon.sql dosyasını çalıştırın.</div>';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Mail Metinleri | <?=$ayar['site_title']?></title>
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
                                <h5 class="card-title">Müşteri Mail Metinleri</h5>
                                <p class="card-description">Sipariş maillerinin konu ve içeriğini buradan düzenleyebilirsiniz. Süslü parantezli değişkenler (ör. <code>{name}</code>, <code>{order_no}</code>) gönderim sırasında otomatik doldurulur — onları aynen bırakın.</p>
                                <?= $mesaj ?>

                                <?php foreach ($sablonlar as $s): ?>
                                <div class="card mb-4" style="border:1px solid #e5e5e5;">
                                    <div class="card-body">
                                        <h6 style="font-weight:600;"><?= htmlspecialchars($s['baslik']) ?>
                                            <span style="font-size:12px;color:#999;">(<?= htmlspecialchars($s['mkey']) ?>)</span></h6>
                                        <?php if (!empty($s['degiskenler'])): ?>
                                        <p style="font-size:13px;color:#888;margin-bottom:10px;">Kullanılabilir değişkenler: <code><?= htmlspecialchars($s['degiskenler']) ?></code></p>
                                        <?php endif; ?>
                                        <form method="post">
                                            <input type="hidden" name="kaydet_mkey" value="<?= htmlspecialchars($s['mkey']) ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Konu (Subject)</label>
                                                <input type="text" class="form-control" name="konu" value="<?= htmlspecialchars($s['konu']) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">İçerik (HTML destekler — &lt;br&gt;, &lt;strong&gt; vb.)</label>
                                                <textarea class="form-control" name="icerik" rows="7"><?= htmlspecialchars($s['icerik']) ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </form>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <?php if (empty($sablonlar) && $mesaj === ''): ?>
                                <p>Şablon bulunamadı.</p>
                                <?php endif; ?>
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
