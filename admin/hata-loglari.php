<?php
/**
 * hata-loglari.php — Panel içi hata izleme görüntüleyici. (MAS-8 / INF-4)
 * hata_log tablosundaki backend+frontend hatalarını gösterir; çöz/sil.
 */
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$mesaj = '';
$tabloVar = true;

// Aksiyonlar
try {
    if (isset($_POST['coz']))    { $db->prepare("UPDATE hata_log SET cozuldu = 1 WHERE id = ?")->execute([(int) $_POST['coz']]); $mesaj = 'Hata çözüldü olarak işaretlendi.'; }
    if (isset($_POST['ac']))     { $db->prepare("UPDATE hata_log SET cozuldu = 0 WHERE id = ?")->execute([(int) $_POST['ac']]); }
    if (isset($_POST['sil']))    { $db->prepare("DELETE FROM hata_log WHERE id = ?")->execute([(int) $_POST['sil']]); $mesaj = 'Hata kaydı silindi.'; }
    if (isset($_POST['temizle'])){ $db->exec("DELETE FROM hata_log WHERE cozuldu = 1"); $mesaj = 'Çözülen kayıtlar temizlendi.'; }
} catch (\Throwable $e) { $tabloVar = false; }

// Filtre
$filtre = $_GET['f'] ?? 'acik';
$where = '1';
if ($filtre === 'acik')      { $where = 'cozuldu = 0'; }
elseif ($filtre === 'php')   { $where = "tur LIKE 'php%'"; }
elseif ($filtre === 'js')    { $where = "tur LIKE 'js%'"; }
elseif ($filtre === 'cozulen') { $where = 'cozuldu = 1'; }

$rows = [];
$sayac = ['acik' => 0, 'toplam' => 0];
try {
    $rows = $db->query("SELECT * FROM hata_log WHERE $where ORDER BY cozuldu ASC, son_gorulme DESC LIMIT 300")->fetchAll(PDO::FETCH_ASSOC);
    $sayac['acik']   = (int) $db->query("SELECT COUNT(*) FROM hata_log WHERE cozuldu = 0")->fetchColumn();
    $sayac['toplam'] = (int) $db->query("SELECT COUNT(*) FROM hata_log")->fetchColumn();
} catch (\Throwable $e) { $tabloVar = false; }

function turBadge($tur) {
    $renk = strpos($tur, 'js') === 0 ? '#6f42c1' : (strpos($tur, 'fatal') !== false || strpos($tur, 'exception') !== false ? '#c0392b' : '#e67e22');
    return '<span style="background:' . $renk . ';color:#fff;padding:2px 8px;border-radius:4px;font-size:11px;">' . htmlspecialchars($tur) . '</span>';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Error Logs | <?=$ayar['site_title']?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <style>
        .hata-row td { vertical-align: top; font-size: 13px; }
        .hata-iz { max-height: 220px; overflow: auto; background: #1e1e1e; color: #ddd; padding: 10px; border-radius: 6px; font: 12px/1.5 monospace; white-space: pre-wrap; margin-top: 6px; }
        .hata-meta { color: #888; font-size: 12px; }
        details summary { cursor: pointer; color: #AB6E35; font-size: 12px; }
    </style>
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
                            <div class="card-body" style="overflow:auto">
                                <h5 class="card-title">Error Logs
                                    <span style="font-size:13px;color:#888;">— açık: <b style="color:#c0392b;"><?=$sayac['acik']?></b> / toplam: <?=$sayac['toplam']?></span>
                                </h5>
                                <p class="card-description">Backend (PHP) ve frontend (JS) hataları burada toplanır; aynı hata tek satırda gruplanır (adet). Mail/Slack gönderilmez.</p>

                                <?php if ($mesaj): ?><div class="alert alert-info"><?=$mesaj?></div><?php endif; ?>
                                <?php if (!$tabloVar): ?>
                                    <div class="alert alert-warning"><strong>hata_log</strong> tablosu bulunamadı. Lütfen <code>db/migrations/2026_07_04_hata_log.sql</code> dosyasını çalıştırın.</div>
                                <?php endif; ?>

                                <div class="mb-3" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                    <?php
                                    $filtreler = ['acik' => 'Açık', 'php' => 'PHP', 'js' => 'JS', 'cozulen' => 'Çözülen', 'hepsi' => 'Hepsi'];
                                    foreach ($filtreler as $k => $lbl) {
                                        $aktif = $filtre === $k ? 'btn-primary' : 'btn-outline-secondary';
                                        echo '<a href="?f=' . $k . '" class="btn btn-sm ' . $aktif . '">' . $lbl . '</a>';
                                    } ?>
                                    <form method="post" style="margin-left:auto;" onsubmit="return confirm('Çözülen tüm kayıtlar silinsin mi?');">
                                        <button name="temizle" value="1" class="btn btn-sm btn-outline-danger">Çözülenleri Temizle</button>
                                    </form>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tür</th><th>Hata</th><th>Konum</th><th>Adet</th><th>Son</th><th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $r): ?>
                                        <tr class="hata-row" style="<?= $r['cozuldu'] ? 'opacity:.5;' : '' ?>">
                                            <td><?= turBadge($r['tur']) ?><?php if ($r['seviye']): ?><br><span class="hata-meta"><?=htmlspecialchars($r['seviye'])?></span><?php endif; ?></td>
                                            <td style="max-width:520px;">
                                                <div style="font-weight:500; word-break:break-word;"><?= htmlspecialchars(mb_substr($r['mesaj'], 0, 300)) ?></div>
                                                <div class="hata-meta"><?= htmlspecialchars($r['url']) ?><?php if ($r['kullanici']): ?> · <?=htmlspecialchars($r['kullanici'])?><?php endif; ?><?php if ($r['ip']): ?> · <?=htmlspecialchars($r['ip'])?><?php endif; ?></div>
                                                <?php if (trim((string)$r['iz']) !== ''): ?>
                                                <details><summary>stack trace</summary><div class="hata-iz"><?= htmlspecialchars($r['iz']) ?></div></details>
                                                <?php endif; ?>
                                            </td>
                                            <td style="word-break:break-word; max-width:260px; font:12px monospace;"><?= htmlspecialchars($r['dosya']) ?><?php if ($r['satir']): ?>:<b><?=$r['satir']?></b><?php endif; ?></td>
                                            <td><span class="badge bg-secondary"><?= (int)$r['adet'] ?></span></td>
                                            <td class="hata-meta"><?= htmlspecialchars($r['son_gorulme']) ?></td>
                                            <td>
                                                <form method="post" style="display:inline;">
                                                    <?php if ($r['cozuldu']): ?>
                                                        <button name="ac" value="<?=$r['id']?>" class="btn btn-sm btn-outline-secondary" title="Yeniden aç"><i class="fa fa-undo"></i></button>
                                                    <?php else: ?>
                                                        <button name="coz" value="<?=$r['id']?>" class="btn btn-sm btn-outline-success" title="Çözüldü"><i class="fa fa-check"></i></button>
                                                    <?php endif; ?>
                                                </form>
                                                <form method="post" style="display:inline;" onsubmit="return confirm('Silinsin mi?');">
                                                    <button name="sil" value="<?=$r['id']?>" class="btn btn-sm btn-outline-danger" title="Sil"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($rows) && $tabloVar): ?>
                                        <tr><td colspan="6" style="text-align:center; color:#888; padding:24px;">Bu filtrede hata yok. 🎉</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
