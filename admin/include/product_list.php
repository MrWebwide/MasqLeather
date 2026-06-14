<?php
/**
 * product_list.php — Ortak admin ürün listeleme modülü. (MAS-32 + MAS-31)
 *
 * Eskiden urun/accessories/jewe/homedecor/ourcollection-listele.php birbirinin
 * (çoğu bozuk şekilde iki kez kopyalanmış) ~400-500 satırlık kopyasıydı; tüm tabloyu
 * çekiyor, sayfalama/arama yoktu. Artık her wrapper sadece bir $config verir:
 *
 *   $config = [
 *     'table'           => 'urunler',
 *     'eklePage'        => 'urun-ekle.php',
 *     'reorderEndpoint' => 'update_order_bag.php',
 *     'addLabel'        => 'Add Product',     // opsiyonel
 *   ];
 *   include 'include/product_list.php';
 *
 * Özellikler: isim/ID arama (?q), sayfalama (?page), sürükle-bırak sıralama
 * (sadece arama yokken; sayfa offset'i korunur → global sira bozulmaz).
 */

require_once __DIR__ . '/baglan.php';        // $db
require_once __DIR__ . '/fonksiyonlar.php';  // $ayar, oturumkontrolana()

ob_start();
session_start();
oturumkontrolana();

// --- Config ---
$table     = preg_replace('/[^a-zA-Z0-9_]/', '', $config['table']); // güvenlik: tablo adı whitelisting
$eklePage  = $config['eklePage'];
$reorder   = $config['reorderEndpoint'];
$addLabel  = $config['addLabel'] ?? 'Add Product';

// --- Sil ---
if (isset($_GET['sil'])) {
    $idd = intval($_GET['sil']);
    if ($idd > 0) {
        $db->prepare("DELETE FROM {$table} WHERE id = ?")->execute([$idd]);
    }
}

// --- Arama ---
$q      = isset($_GET['q']) ? trim($_GET['q']) : '';
$where  = '1';
$params = [];
if ($q !== '') {
    if (ctype_digit($q)) {
        $where = '(adi LIKE :q OR id = :idq)';
        $params[':q']   = '%' . $q . '%';
        $params[':idq'] = (int) $q;
    } else {
        $where = 'adi LIKE :q';
        $params[':q'] = '%' . $q . '%';
    }
}

// --- Sayfalama ---
$perPage = 20;
$page    = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$countStmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$where}");
$countStmt->execute($params);
$total      = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($total / $perPage));
if ($page > $totalPages) { $page = $totalPages; }
$startIndex = ($page - 1) * $perPage;

$listStmt = $db->prepare("SELECT * FROM {$table} WHERE {$where} ORDER BY sira ASC LIMIT {$startIndex}, {$perPage}");
$listStmt->execute($params);
$urunler = $listStmt->fetchAll(PDO::FETCH_ASSOC);

// Sürükle-bırak sıralama sadece arama yokken anlamlı (filtre varsa sira bitişik değil).
$reorderable = ($q === '');

// Pagination link query'si (q korunur)
$baseQs = $q !== '' ? ('?q=' . urlencode($q) . '&page=') : '?page=';

// Üst sekme barı — ürün tipleri arası tek sayfadan geçiş (sol menü sadeleştirme)
$productTabs = [
    ['label' => 'Bags & Purses',  'url' => 'urun-listele.php',          'table' => 'urunler'],
    ['label' => 'Accessories',    'url' => 'accessories-listele.php',   'table' => 'accessories'],
    ['label' => 'Jewelry',        'url' => 'jewe-listele.php',          'table' => 'jewe'],
    ['label' => 'Home Decor',     'url' => 'homedecor-listele.php',     'table' => 'homedecor'],
    ['label' => 'Our Collection', 'url' => 'ourcollection-listele.php', 'table' => 'ourcollection'],
];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$ayar['site_description']?>">
    <meta name="keywords" content="<?=$ayar['site_keyword']?>">
    <meta name="author" content="<?=$ayar['site_author']?>">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>List Product | <?=$ayar['site_title']?></title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/plugins/DataTables/datatables.min.css" rel="stylesheet">

    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="page-container">
        <div class="page-header">
            <?php include __DIR__ . '/header.php'; ?>
        </div>
        <?php include __DIR__ . '/menu.php'; ?>
        <div class="page-content">
            <div class="main-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body" style="overflow:scroll">
                                <h5 class="card-title">Products</h5>

                                <ul class="nav nav-tabs mb-3">
                                    <?php foreach ($productTabs as $t) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $t['table'] === $table ? 'active' : '' ?>" href="<?= $t['url'] ?>"><?= htmlspecialchars($t['label']) ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>

                                <a href="<?=$eklePage?>" class="btn btn-primary m-b-md"><?=htmlspecialchars($addLabel)?></a>

                                <form method="get" class="form-inline mb-3" style="gap:8px; flex-wrap:wrap;">
                                    <input type="text" name="q" class="form-control mr-2"
                                        placeholder="Search by name or ID" value="<?=htmlspecialchars($q)?>">
                                    <button type="submit" class="btn btn-primary mr-2">Search</button>
                                    <?php if ($q !== '') { ?>
                                        <a href="?" class="btn btn-secondary">Clear</a>
                                    <?php } ?>
                                    <span class="ml-2" style="align-self:center;"><?=$total?> products</span>
                                </form>

                                <?php if (!$reorderable) { ?>
                                    <p style="color:#888;">Drag-to-reorder is disabled while searching.</p>
                                <?php } ?>

                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Change Order</th>
                                            <th scope="col">Product Order</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Stok Sayısı</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Main Picture</th>
                                            <th scope="col">Date of upload</th>
                                            <th scope="col">Process</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($urunler as $urungoster) {
                                            // Bazı tablolarda (ör. ourcollection) stock kolonu yok.
                                            $hasStock = array_key_exists('stock', $urungoster);
                                            $stock = $hasStock ? $urungoster['stock'] : null;
                                            if (!$hasStock) {
                                                $colorClass = '';
                                            } elseif ($stock > 20) {
                                                $colorClass = 'green';
                                            } elseif ($stock >= 5 && $stock <= 10) {
                                                $colorClass = 'yellow';
                                            } else {
                                                $colorClass = 'red';
                                            }
                                        ?>
                                        <tr <?php if ($reorderable) { ?>draggable="true" ondragstart="start()" ondragover="dragover()" ondragend="dragEnd()"<?php } ?>
                                            data-oldorder="<?= $urungoster['sira'] ?>" data-id="<?= $urungoster['id'] ?>">
                                            <th class="drag-handle" scope="row">
                                                <button type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10"/>
                                                    </svg>
                                                </button>
                                            </th>
                                            <th scope="row"><?=$urungoster['sira']?></th>
                                            <th scope="row"><?= ($urungoster['durum'] == 'on') ? 'on' : 'off' ?></th>
                                            <td>
                                                <div class="stock-box <?= $colorClass ?>"><?= $hasStock ? $urungoster['stock'] : '-' ?></div>
                                            </td>
                                            <td><?=$urungoster['adi']?></td>
                                            <td><img src="resimler/<?=$urungoster['resim']?>" alt="<?=htmlspecialchars($urungoster['adi'])?>"></td>
                                            <td><span class="badge bg-primary"><?=$urungoster['eklenme_tarihi']?></span></td>
                                            <td>
                                                <a href="<?=$eklePage?>?islem=duzenle&id=<?=$urungoster['id']?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                                <a href="../menu.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                                <a class="silmeAlani" href="<?= $baseQs . $page ?>&sil=<?=$urungoster['id']?>"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php if (empty($urunler)) { ?>
                                        <tr><td colspan="8" style="text-align:center; color:#888;">No products found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <?php if ($totalPages > 1) { ?>
                                <nav>
                                    <ul class="pagination">
                                        <?php if ($page > 1) { ?>
                                            <li class="page-item"><a class="page-link" href="<?= $baseQs . ($page - 1) ?>">&laquo;</a></li>
                                        <?php } ?>
                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= $baseQs . $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($page < $totalPages) { ?>
                                            <li class="page-item"><a class="page-link" href="<?= $baseQs . ($page + 1) ?>">&raquo;</a></li>
                                        <?php } ?>
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

    <?php if ($reorderable) { ?>
    <script>
        var reorderOffset = <?= $startIndex ?>;
        var reorderEndpoint = <?= json_encode($reorder) ?>;
        var row;

        function start() {
            row = event.target.closest('tr');
            row.classList.add('selected-row');
            event.dataTransfer.setDragImage(new Image(), 0, 0);
        }

        function dragover() {
            event.preventDefault();
            var target = event.target.closest('tr');
            if (!target || target === row) return;
            var children = Array.from(target.parentNode.children);
            if (children.indexOf(target) > children.indexOf(row)) {
                target.after(row);
            } else {
                target.before(row);
            }
        }

        function dragEnd() {
            if (row) row.classList.remove('selected-row');
            var productData = [];
            document.querySelectorAll('tbody tr[data-id]').forEach(function (r, i) {
                productData.push({
                    oldorder: r.getAttribute('data-oldorder'),
                    order: reorderOffset + i + 1,
                    id: r.getAttribute('data-id')
                });
            });
            var xhr = new XMLHttpRequest();
            xhr.open('POST', reorderEndpoint, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(productData));
        }
    </script>
    <?php } ?>

    <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/DataTables/datatables.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>
    <script src="https://use.fontawesome.com/ca9a29c061.js"></script>
    <?php include __DIR__ . '/../silme.php'; ?>
</body>

</html>
