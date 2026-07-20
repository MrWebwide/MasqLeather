<?php
/**
 * grup-banner.php — Grup landing sayfaları için başlık arka plan görseli. (MAS-86a)
 * Bags & Purses / Accessories / Home Decor / Jewelry sayfalarının üst başlık görselini yönetir.
 */
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$gruplar = [
    'urun_kategori'  => 'Bags & Purses',
    'bolge_kategori' => 'Accessories',
    'mer_kategori'   => 'Home Decor',
    'jewe_kategori'  => 'Jewelry',
];

$mesaj = '';
$tabloVar = true;

function seflink_gb($string) {
    $find = array('Ç','Ş','Ğ','Ü','İ','Ö','ç','ş','ğ','ü','ö','ı',' ');
    $replace = array('c','s','g','u','i','o','c','s','g','u','o','i','-');
    $string = strtolower(str_replace($find, $replace, $string));
    return preg_replace('/[^a-z0-9\-]/', '', $string);
}

try {
    if (isset($_POST['kaydet'])) {
        $gkey = $_POST['gkey'] ?? '';
        if (!array_key_exists($gkey, $gruplar)) { throw new RuntimeException('geçersiz grup'); }

        // Mevcut görseli çek
        $st = $db->prepare("SELECT resim FROM grup_banner WHERE gkey = ?");
        $st->execute([$gkey]);
        $eski = $st->fetchColumn();

        $resim = ($eski !== false) ? $eski : 'resim-yok';

        // Silme istendiyse
        if (!empty($_POST['resim_sil'])) {
            if (!empty($eski) && $eski !== 'resim-yok') { @unlink("resimler/" . $eski); }
            $resim = 'resim-yok';
        }

        // Yeni yükleme varsa
        if (!empty($_FILES['resim']['tmp_name'])) {
            $tip = $_FILES['resim']['type'];
            if (in_array($tip, ['image/gif','image/png','image/jpg','image/jpeg','image/webp'], true)) {
                if (!empty($eski) && $eski !== 'resim-yok') { @unlink("resimler/" . $eski); }
                $ext = strtolower(pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION));
                $resim = 'grup-' . seflink_gb($gruplar[$gkey]) . '-' . rand(100, 999) . '.' . $ext;
                move_uploaded_file($_FILES['resim']['tmp_name'], "resimler/" . $resim);
            } else {
                $mesaj = '<div class="alert alert-danger">Lütfen geçerli bir görsel (.jpg .png .gif .webp) yükleyin.</div>';
            }
        }

        // UPSERT
        $up = $db->prepare("INSERT INTO grup_banner (gkey, resim) VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE resim = VALUES(resim)");
        $up->execute([$gkey, $resim]);
        if ($mesaj === '') { $mesaj = '<div class="alert alert-success">Kaydedildi.</div>'; }
    }
} catch (\Throwable $e) {
    $tabloVar = false;
}

// Mevcut değerleri çek
$mevcut = [];
try {
    foreach ($db->query("SELECT gkey, resim FROM grup_banner")->fetchAll(PDO::FETCH_ASSOC) as $r) {
        $mevcut[$r['gkey']] = $r['resim'];
    }
} catch (\Throwable $e) { $tabloVar = false; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Group Banners | <?=$ayar['site_title']?></title>
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
                                <h5 class="card-title">Group Banners</h5>
                                <p class="card-description">Ana grup sayfalarının (Bags &amp; Purses, Accessories, Home Decor, Jewelry) üst başlık arka plan görseli. Opsiyonel; boş bırakılabilir.</p>
                                <?= $mesaj ?>
                                <?php if (!$tabloVar): ?>
                                    <div class="alert alert-warning"><strong>grup_banner</strong> tablosu bulunamadı. Lütfen <code>db/migrations/2026_07_08_grup_banner.sql</code> dosyasını çalıştırın.</div>
                                <?php endif; ?>

                                <div class="row">
                                <?php foreach ($gruplar as $gkey => $label):
                                    $img = $mevcut[$gkey] ?? 'resim-yok'; ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="border rounded p-3">
                                            <h6><?= htmlspecialchars($label) ?></h6>
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="gkey" value="<?= htmlspecialchars($gkey) ?>">
                                                <?php if (!empty($img) && $img !== 'resim-yok'): ?>
                                                    <img src="resimler/<?= htmlspecialchars($img) ?>" style="width:100%;max-height:150px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="resim_sil" value="1" id="sil_<?= $gkey ?>">
                                                        <label class="form-check-label" for="sil_<?= $gkey ?>">Bu görseli sil</label>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="text-muted" style="font-size:13px;">Henüz görsel yok.</p>
                                                <?php endif; ?>
                                                <input class="form-control mb-2" type="file" name="resim" accept="image/*" data-crop-ratio="16/5">
                                                <button class="btn btn-primary btn-sm" name="kaydet" value="1">Kaydet</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
