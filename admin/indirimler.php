<?php
/**
 * indirimler.php — Aktif İndirimler (hayalet indirim avcısı).
 *
 * Kampanya sistemi indirimi ürün satırına DAMGALIYOR (urunler/jewe/accessories/
 * homedecor tablolarındaki `kampanya` kolonu). Kampanya kaydı silinir ya da
 * kategorisi değiştirilirse damga ürünün üstünde kalıyor; kampanya listesinde
 * hiçbir şey görünmediği için kaynağı bulunamıyordu ("mumluklarda indirim var
 * ama nereden geldiğini bulamadık" vakası).
 *
 * Bu ekran indirimi olan TÜM ürünleri tek yerde gösterir ve her satır için
 * kaynağında geçerli bir kampanya var mı diye kontrol eder:
 *   - "kampanya var"  -> normal, bilinçli indirim
 *   - "HAYALET"       -> arkasında kampanya yok, artık kalmış damga
 * Tek ürün ya da tüm kategori için indirim tek tıkla sıfırlanır.
 */

include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

// Ürün tablosu <-> kampanya tablosu eşlemesi (whitelist — SQL'e sadece buradan isim girer)
$gruplar = [
    'bagpurses'   => ['label' => 'Bags & Purses', 'urun' => 'urunler',     'kampanya' => 'kampanya'],
    'accessories' => ['label' => 'Accessories',   'urun' => 'accessories', 'kampanya' => 'accessorieskampanya'],
    'jewelry'     => ['label' => 'Jewelry',       'urun' => 'jewe',        'kampanya' => 'jewekampanya'],
    'homedecor'   => ['label' => 'Home Decor',    'urun' => 'homedecor',   'kampanya' => 'homedecorkampanya'],
];

$mesaj = '';

// --- İşlem: tek ürünün indirimini kaldır ---
if (isset($_POST['temizle_urun'], $_POST['grup'], $_POST['id'])) {
    $g = $_POST['grup'];
    if (isset($gruplar[$g])) {
        try {
            $t = $gruplar[$g]['urun'];
            $db->prepare("UPDATE {$t} SET kampanya = 0 WHERE id = ?")->execute([(int) $_POST['id']]);
            $mesaj = '<div class="alert alert-success">Ürünün indirimi kaldırıldı.</div>';
        } catch (\Throwable $e) {
            $mesaj = '<div class="alert alert-danger">Hata: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// --- İşlem: tüm kategorinin indirimini kaldır ---
if (isset($_POST['temizle_kategori'], $_POST['grup'], $_POST['kategori'])) {
    $g = $_POST['grup'];
    if (isset($gruplar[$g])) {
        try {
            $t = $gruplar[$g]['urun'];
            $st = $db->prepare("UPDATE {$t} SET kampanya = 0 WHERE kategori = ?");
            $st->execute([$_POST['kategori']]);
            $mesaj = '<div class="alert alert-success"><strong>' . htmlspecialchars($_POST['kategori'])
                   . '</strong> kategorisindeki ' . $st->rowCount() . ' ürünün indirimi kaldırıldı.</div>';
        } catch (\Throwable $e) {
            $mesaj = '<div class="alert alert-danger">Hata: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// --- İndirimli ürünleri topla ---
$satirlar = [];
foreach ($gruplar as $key => $g) {
    try {
        $rows = $db->query(
            "SELECT id, adi, kategori, yazi1 AS fiyat, kampanya
             FROM {$g['urun']}
             WHERE kampanya IS NOT NULL AND kampanya <> 0 AND kampanya <> ''
             ORDER BY kategori, adi"
        )->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {
        continue; // tablo yoksa bu grubu atla
    }

    foreach ($rows as $r) {
        // Bu kategori için gerçekten bir kampanya kaydı var mı?
        $kampanyaVar = false;
        try {
            $c = $db->prepare("SELECT COUNT(*) FROM {$g['kampanya']} WHERE kategori = ?");
            $c->execute([$r['kategori']]);
            $kampanyaVar = ((int) $c->fetchColumn()) > 0;
        } catch (\Throwable $e) {}

        $fiyat  = (float) $r['fiyat'];
        $oran   = (float) $r['kampanya'];
        $satirlar[] = [
            'grup'        => $key,
            'grupAdi'     => $g['label'],
            'id'          => $r['id'],
            'adi'         => $r['adi'],
            'kategori'    => $r['kategori'],
            'fiyat'       => $fiyat,
            'oran'        => $oran,
            'indirimli'   => $fiyat - ($fiyat * $oran / 100),
            'kampanyaVar' => $kampanyaVar,
        ];
    }
}

$hayaletSayisi = 0;
foreach ($satirlar as $s) { if (!$s['kampanyaVar']) { $hayaletSayisi++; } }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Aktif İndirimler | <?=$ayar['site_title']?></title>
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
                            <div class="card-body" style="overflow:auto">
                                <h5 class="card-title">Aktif İndirimler</h5>
                                <p class="card-description">
                                    Sitede şu anda indirimli görünen <strong>tüm</strong> ürünler.
                                    <span class="badge bg-danger">HAYALET</span> etiketli olanların arkasında
                                    kampanya kaydı <strong>yok</strong> — silinmiş/değiştirilmiş bir kampanyadan
                                    kalan artıktır ve vitrinde indirim göstermeye devam eder.
                                </p>
                                <?= $mesaj ?>

                                <?php if ($hayaletSayisi > 0) { ?>
                                <div class="alert alert-warning">
                                    <strong><?= $hayaletSayisi ?> ürün</strong> kampanyasız indirim gösteriyor.
                                </div>
                                <?php } ?>

                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Grup</th>
                                            <th>Ürün</th>
                                            <th>Kategori</th>
                                            <th>Fiyat</th>
                                            <th>İndirim</th>
                                            <th>Kaynak</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($satirlar as $s) { ?>
                                        <tr>
                                            <td><small><?= htmlspecialchars($s['grupAdi']) ?></small></td>
                                            <td>
                                                <?= htmlspecialchars($s['adi']) ?>
                                                <br><small class="text-muted">#<?= (int) $s['id'] ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($s['kategori']) ?></td>
                                            <td>
                                                <span style="text-decoration:line-through;color:#999;"><?= number_format($s['fiyat'], 2) ?></span>
                                                <strong><?= number_format($s['indirimli'], 2) ?></strong>
                                            </td>
                                            <td><span class="badge bg-primary">%<?= rtrim(rtrim(number_format($s['oran'], 2, '.', ''), '0'), '.') ?></span></td>
                                            <td>
                                                <?php if ($s['kampanyaVar']) { ?>
                                                    <span class="badge bg-success">kampanya var</span>
                                                <?php } else { ?>
                                                    <span class="badge bg-danger">HAYALET</span>
                                                <?php } ?>
                                            </td>
                                            <td style="white-space:nowrap;">
                                                <form method="post" style="display:inline" onsubmit="return confirm('Bu ürünün indirimi kaldırılacak. Onaylıyor musun?');">
                                                    <input type="hidden" name="grup" value="<?= htmlspecialchars($s['grup']) ?>">
                                                    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                                                    <button type="submit" name="temizle_urun" value="1" class="btn btn-sm btn-outline-danger">Ürünü Temizle</button>
                                                </form>
                                                <form method="post" style="display:inline" onsubmit="return confirm('<?= htmlspecialchars($s['kategori'], ENT_QUOTES) ?> kategorisindeki TÜM ürünlerin indirimi kaldırılacak. Onaylıyor musun?');">
                                                    <input type="hidden" name="grup" value="<?= htmlspecialchars($s['grup']) ?>">
                                                    <input type="hidden" name="kategori" value="<?= htmlspecialchars($s['kategori']) ?>">
                                                    <button type="submit" name="temizle_kategori" value="1" class="btn btn-sm btn-outline-secondary">Kategoriyi Temizle</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (empty($satirlar)) { ?>
                                        <tr><td colspan="7" style="text-align:center;color:#888;">Şu anda indirimli ürün yok. ✅</td></tr>
                                    <?php } ?>
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
