<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

// MAS-26: Bülten aboneleri = mail tablosu (id=1 SMTP ayar satırı, hariç tutulur).

// Abone sil
if (isset($_GET['sil'])) {
    $idd = intval($_GET['sil']);
    if ($idd > 1) { // id=1 SMTP ayarı, asla silme
        $db->prepare("DELETE FROM mail WHERE id = ?")->execute([$idd]);
    }
}

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="newsletter-subscribers.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['id', 'email']);
    $rows = $db->query("SELECT id, site_mail FROM mail WHERE id <> 1 ORDER BY id DESC", PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        fputcsv($out, [$r['id'], $r['site_mail']]);
    }
    fclose($out);
    exit;
}
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
    <title>Newsletter Subscribers | <?=$ayar['site_title']?></title>

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
            <?php include("include/header.php");?>
        </div>
        <?php include("include/menu.php");?>
        <div class="page-content">
            <div class="main-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Newsletter Subscribers</h5>
                                <?php
                                $aboneler = $db->query("SELECT id, site_mail FROM mail WHERE id <> 1 ORDER BY id DESC", PDO::FETCH_ASSOC);
                                $toplam = $aboneler->rowCount();
                                ?>
                                <p>Total subscribers: <strong><?= $toplam ?></strong></p>
                                <a href="abone-listele.php?export=csv" class="btn btn-primary m-b-md">Export CSV</a>
                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">E-Mail</th>
                                            <th scope="col">Process</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($toplam) { foreach ($aboneler as $abone) { ?>
                                        <tr>
                                            <th scope="row"><?= $abone['id'] ?></th>
                                            <td><?= htmlspecialchars($abone['site_mail']) ?></td>
                                            <td>
                                                <a class="silmeAlani" href="?sil=<?= $abone['id'] ?>"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <?php } } ?>
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
    <script src="assets/plugins/DataTables/datatables.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>
    <script src="https://use.fontawesome.com/ca9a29c061.js"></script>
    <?php include("silme.php");?>
</body>

</html>
