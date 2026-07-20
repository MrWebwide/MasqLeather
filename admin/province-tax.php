<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

// MAS-25: Province (eyalet) vergi oranlarını panelden yönet.
$mesaj = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rates']) && is_array($_POST['rates'])) {
    $upd = $db->prepare("UPDATE province_tax SET rate = ? WHERE id = ?");
    foreach ($_POST['rates'] as $id => $rate) {
        $id   = intval($id);
        $rate = (float) str_replace(',', '.', $rate);
        if ($rate < 0)   { $rate = 0; }
        if ($rate > 100) { $rate = 100; }
        $upd->execute([$rate, $id]);
    }
    $mesaj = 'Tax rates updated.';
}

$rows = $db->query("SELECT id, code, name, rate FROM province_tax ORDER BY name", PDO::FETCH_ASSOC);
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
    <title>Province Tax Rates | <?=$ayar['site_title']?></title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

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
                                <h5 class="card-title">Province Tax Rates (Canada)</h5>
                                <?php if ($mesaj) { ?>
                                <div class="alert alert-success"><?= htmlspecialchars($mesaj) ?></div>
                                <?php } ?>
                                <p>These rates are shown on the checkout page and charged on the Stripe payment screen (GST/HST).</p>
                                <form method="post">
                                    <table class="table invoice-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Province</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Tax Rate (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rows as $r) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($r['name']) ?></td>
                                                <td><?= htmlspecialchars($r['code']) ?></td>
                                                <td style="max-width:160px;">
                                                    <input type="number" step="0.01" min="0" max="100"
                                                        name="rates[<?= (int) $r['id'] ?>]"
                                                        value="<?= htmlspecialchars($r['rate']) ?>"
                                                        class="form-control" required>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Save Rates</button>
                                </form>
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
