<?php
/**
 * category_list.php — Ortak kategori listeleme modülü (sekmeli, tek sayfa). (MAS-71 devamı)
 *
 * Products (product_list.php) ile aynı tasarım: üstte 4 tip sekmesi, arama, sayfalama.
 * Eskiden urun-kategori / bolge-kat / mer-kategori / jewe-kat-listele.php birbirinin
 * (bozuk çift kopyalı) kopyasıydı; artık her wrapper sadece $clActive verir.
 *
 * Wrapper kullanımı:
 *   $clActive = 'urun_kategori';
 *   include 'include/category_list.php';
 */

require_once __DIR__ . '/baglan.php';
require_once __DIR__ . '/fonksiyonlar.php';

ob_start();
session_start();
oturumkontrolana();

$catTabs = [
    ['key' => 'urun_kategori',  'label' => 'Bags & Purses',  'table' => 'urun_kategori',  'ekle' => 'urun-kategori-ekle.php', 'list' => 'urun-kategori-listele.php', 'view' => 'detay'],
    ['key' => 'bolge_kategori', 'label' => 'Accessories',    'table' => 'bolge_kategori', 'ekle' => 'bolge-kat-ekle.php',      'list' => 'bolge-kat-listele.php',     'view' => 'seo'],
    ['key' => 'mer_kategori',   'label' => 'Home Decor',     'table' => 'mer_kategori',   'ekle' => 'mer-kategori-ekle.php',   'list' => 'mer-kategori-listele.php',  'view' => 'detay'],
    ['key' => 'jewe_kategori',  'label' => 'Jewelry',        'table' => 'jewe_kategori',  'ekle' => 'jewe-kat-ekle.php',       'list' => 'jewe-kat-listele.php',      'view' => 'seo'],
];

$active = isset($clActive) ? $clActive : 'urun_kategori';
$tab = null;
foreach ($catTabs as $t) { if ($t['key'] === $active) { $tab = $t; break; } }
if (!$tab) { $tab = $catTabs[0]; }
$table = $tab['table']; // whitelist'ten geldiği için güvenli

// --- Sil (görseli de kaldır) ---
if (isset($_GET['sil'])) {
    $idd = intval($_GET['sil']);
    if ($idd > 0) {
        $r = $db->prepare("SELECT resim FROM {$table} WHERE id = ?");
        $r->execute([$idd]);
        $img = $r->fetchColumn();
        if ($img && file_exists(__DIR__ . '/../resimler/' . $img)) { @unlink(__DIR__ . '/../resimler/' . $img); }
        $db->prepare("DELETE FROM {$table} WHERE id = ?")->execute([$idd]);
    }
}

// --- Arama ---
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = '1'; $params = [];
if ($q !== '') {
    if (ctype_digit($q)) {
        $where = '(adi LIKE :q OR id = :idq)';
        $params[':q'] = '%' . $q . '%'; $params[':idq'] = (int) $q;
    } else {
        $where = 'adi LIKE :q';
        $params[':q'] = '%' . $q . '%';
    }
}

// --- Sayfalama ---
$perPage = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$countStmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$where}");
$countStmt->execute($params);
$total = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($total / $perPage));
if ($page > $totalPages) { $page = $totalPages; }
$startIndex = ($page - 1) * $perPage;

$listStmt = $db->prepare("SELECT * FROM {$table} WHERE {$where} ORDER BY sira ASC LIMIT {$startIndex}, {$perPage}");
$listStmt->execute($params);
$rows = $listStmt->fetchAll(PDO::FETCH_ASSOC);

$baseQs = $q !== '' ? ('?key=' . urlencode($active) . '&q=' . urlencode($q) . '&page=') : '?page=';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Categories | <?=$ayar['site_title']?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <div class="page-header"><?php include __DIR__ . '/header.php'; ?></div>
        <?php include __DIR__ . '/menu.php'; ?>
        <div class="page-content">
            <div class="main-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body" style="overflow:scroll">
                                <h5 class="card-title">Categories</h5>

                                <ul class="nav nav-tabs mb-3">
                                    <?php foreach ($catTabs as $t) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $t['key'] === $active ? 'active' : '' ?>" href="<?= $t['list'] ?>"><?= htmlspecialchars($t['label']) ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>

                                <a href="<?=$tab['ekle']?>" class="btn btn-primary m-b-md">Add Category</a>

                                <form method="get" class="form-inline mb-3" style="gap:8px; flex-wrap:wrap;">
                                    <input type="text" name="q" class="form-control mr-2" placeholder="Search by name or ID" value="<?=htmlspecialchars($q)?>">
                                    <button type="submit" class="btn btn-primary mr-2">Search</button>
                                    <?php if ($q !== '') { ?><a href="<?=$tab['list']?>" class="btn btn-secondary">Clear</a><?php } ?>
                                    <span class="ml-2" style="align-self:center;"><?=$total?> categories</span>
                                </form>

                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Date of upload</th>
                                            <th scope="col">Process</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $urungoster) { ?>
                                        <tr>
                                            <th scope="row"><?=$urungoster['sira']?></th>
                                            <td><?=htmlspecialchars($urungoster['adi'])?></td>
                                            <td><span class="badge bg-primary"><?=$urungoster['eklenme_tarihi']?></span></td>
                                            <td>
                                                <a href="<?=$tab['ekle']?>?islem=duzenle&id=<?=$urungoster['id']?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                                <?php $viewHref = $tab['view'] === 'detay'
                                                    ? '../urun-detay-kategori.php?id=' . $urungoster['id'] . '&seo=' . urlencode($urungoster['seo'])
                                                    : '../' . $urungoster['seo']; ?>
                                                <a href="<?=$viewHref?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                                <a class="silmeAlani" href="<?= $baseQs . $page ?>&sil=<?=$urungoster['id']?>"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php if (empty($rows)) { ?>
                                        <tr><td colspan="4" style="text-align:center; color:#888;">No categories found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <?php if ($totalPages > 1) { ?>
                                <nav>
                                    <ul class="pagination">
                                        <?php if ($page > 1) { ?><li class="page-item"><a class="page-link" href="<?= $baseQs . ($page - 1) ?>">&laquo;</a></li><?php } ?>
                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="<?= $baseQs . $i ?>"><?= $i ?></a></li>
                                        <?php } ?>
                                        <?php if ($page < $totalPages) { ?><li class="page-item"><a class="page-link" href="<?= $baseQs . ($page + 1) ?>">&raquo;</a></li><?php } ?>
                                    </ul>
                                </nav>
                                <?php } ?>
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
    <?php include __DIR__ . '/../silme.php'; ?>
</body>
</html>
