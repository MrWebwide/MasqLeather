<?php
/**
 * bekleyen-siparisler.php — Düşmemiş (kurtarılmayı bekleyen) siparişler. (MAS-10 devamı)
 *
 * Sipariş kaydının TEK noktası stripe/webhook.php'dir. Webhook arızalanırsa
 * (yanlış imza secret'ı, DB hatası, endpoint down) müşterinin parası çekilir ama
 * sipariş düşmez — ve bu hiçbir yerde görünmezdi. Bu ekran o boşluğu kapatır:
 *
 *   - pending_orders'ta 'completed' olmayan satırları listeler
 *   - payload'ı okuyup müşteri/tutar özetini gösterir
 *   - Stripe'a sorup ödemenin gerçekten alındığını (payment_status=paid) DOĞRULAR
 *   - tek tıkla masq_create_order() ile siparişi yazar (webhook ile AYNI fonksiyon)
 *
 * Neden Stripe doğrulaması şart: pending_orders satırı checkout session'ı
 * oluşurken (ödemeden ÖNCE) yazılır. Terk edilmiş sepetler de 'pending' kalır;
 * onları siparişe çevirmek ödenmemiş sipariş yaratır.
 *
 * Çift kayıt koruması: (1) siparis tablosunda o siparisid zaten varsa reddedilir,
 * (2) pending->processing geçişi atomik yapılır (webhook ile yarışmaz).
 */

include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

require_once __DIR__ . '/../functions/order_create.php';   // masq_create_order()

$mesaj    = '';
$tabloYok = false;

// Stripe SDK (ödeme doğrulaması için). Yoksa doğrulama yapılamaz, sayfa yine çalışır.
$stripe = null;
try {
    if (defined('STRIPE_SECRET_KEY') && STRIPE_SECRET_KEY !== '') {
        require_once __DIR__ . '/../stripe/vendor/autoload.php';
        $stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);
    }
} catch (\Throwable $e) {
    $stripe = null;
}

/**
 * Stripe'tan checkout session'ın ödeme durumunu çeker.
 * @return array ['ok'=>bool, 'paid'=>bool, 'status'=>string, 'amount'=>?float]
 */
function masq_stripe_session_durumu($stripe, string $sessionId): array
{
    if (!$stripe || $sessionId === '') {
        return ['ok' => false, 'paid' => false, 'status' => 'bilinmiyor', 'amount' => null];
    }
    try {
        $s = $stripe->checkout->sessions->retrieve($sessionId, []);
        $ps = (string) ($s->payment_status ?? '');
        return [
            'ok'     => true,
            'paid'   => $ps === 'paid',
            'status' => $ps !== '' ? $ps : 'bilinmiyor',
            'amount' => isset($s->amount_total) ? ((float) $s->amount_total / 100) : null,
        ];
    } catch (\Throwable $e) {
        return ['ok' => false, 'paid' => false, 'status' => 'sorgulanamadi', 'amount' => null];
    }
}

// ─────────────────────────────────────────────────────────────
// İŞLEM: Siparişe çevir
// ─────────────────────────────────────────────────────────────
if (isset($_POST['dusur']) && !empty($_POST['session_id'])) {
    $sid     = trim($_POST['session_id']);
    $eminim  = !empty($_POST['eminim']);   // Stripe sorgulanamadıysa admin manuel onayı

    try {
        $q = $db->prepare("SELECT session_id, siparis_id, payload, status FROM pending_orders WHERE session_id = ?");
        $q->execute([$sid]);
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $mesaj = '<div class="alert alert-danger">Kayıt bulunamadı.</div>';
        } else {
            // 1) Bu sipariş zaten düşmüş mü? (asıl çift-kayıt koruması)
            $chk = $db->prepare("SELECT COUNT(*) FROM siparis WHERE siparisid = ?");
            $chk->execute([$row['siparis_id']]);

            if ((int) $chk->fetchColumn() > 0) {
                $db->prepare("UPDATE pending_orders SET status = 'completed', processed_at = NOW() WHERE session_id = ?")
                   ->execute([$sid]);
                $mesaj = '<div class="alert alert-warning">Bu sipariş (<strong>' . htmlspecialchars($row['siparis_id'])
                       . '</strong>) zaten sistemde kayıtlı. Tekrar oluşturulmadı, kayıt "tamamlandı" olarak işaretlendi.</div>';
            } else {
                // 2) Ödeme gerçekten alınmış mı?
                $ps = masq_stripe_session_durumu($stripe, $sid);

                if (!$ps['paid'] && !($eminim && !$ps['ok'])) {
                    $neden = $ps['ok']
                        ? 'Stripe bu ödemeyi <strong>' . htmlspecialchars($ps['status']) . '</strong> olarak bildiriyor (paid değil).'
                        : 'Stripe\'a bağlanılamadı, ödeme durumu doğrulanamadı.';
                    $mesaj = '<div class="alert alert-danger">Sipariş oluşturulmadı. ' . $neden
                           . ' Ödemenin alındığından eminsen "Ödemeyi Stripe\'ta doğruladım" kutusunu işaretleyip tekrar dene.</div>';
                } else {
                    // 3) Atomik kilit — webhook aynı anda işlemesin
                    $claim = $db->prepare("UPDATE pending_orders SET status = 'processing' WHERE session_id = ? AND status IN ('pending','processing')");
                    $claim->execute([$sid]);

                    if ($claim->rowCount() !== 1) {
                        $mesaj = '<div class="alert alert-warning">Kayıt şu anda başka bir işlem tarafından işleniyor. Sayfayı yenileyip tekrar bak.</div>';
                    } else {
                        $payload = json_decode((string) $row['payload'], true);

                        if (!is_array($payload)) {
                            $mesaj = '<div class="alert alert-danger">Payload bozuk/okunamadı — sipariş oluşturulamadı.</div>';
                        } else {
                            $res = masq_create_order($db, $payload);

                            if ($res['ok']) {
                                $db->prepare("UPDATE pending_orders SET status = 'completed', processed_at = NOW() WHERE session_id = ?")
                                   ->execute([$sid]);
                                $mesaj = '<div class="alert alert-success"><strong>Sipariş oluşturuldu:</strong> '
                                       . htmlspecialchars($res['siparisId'])
                                       . '. Stok düşüldü, müşteriye onay maili ve size admin uyarısı gönderildi.</div>';
                            } else {
                                $db->prepare("UPDATE pending_orders SET status = 'pending' WHERE session_id = ?")->execute([$sid]);
                                $mesaj = '<div class="alert alert-danger">Sipariş oluşturulamadı: '
                                       . htmlspecialchars((string) $res['error']) . '</div>';
                            }
                        }
                    }
                }
            }
        }
    } catch (\Throwable $e) {
        $mesaj = '<div class="alert alert-danger">Hata: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

// ─────────────────────────────────────────────────────────────
// İŞLEM: Yok say (terk edilmiş sepet / test kaydı)
// ─────────────────────────────────────────────────────────────
if (isset($_POST['yoksay']) && !empty($_POST['session_id'])) {
    try {
        $db->prepare("UPDATE pending_orders SET status = 'completed', processed_at = NOW() WHERE session_id = ?")
           ->execute([trim($_POST['session_id'])]);
        $mesaj = '<div class="alert alert-secondary">Kayıt listeden kaldırıldı (sipariş oluşturulmadı).</div>';
    } catch (\Throwable $e) {
        $mesaj = '<div class="alert alert-danger">Hata: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

// ─────────────────────────────────────────────────────────────
// LİSTE
// ─────────────────────────────────────────────────────────────
$rows = [];
try {
    $rows = $db->query(
        "SELECT session_id, siparis_id, payload, status, created_at
         FROM pending_orders
         WHERE status <> 'completed'
         ORDER BY created_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $e) {
    $tabloYok = true;
    $mesaj = '<div class="alert alert-danger"><strong>pending_orders</strong> tablosu bulunamadı. '
           . '<code>db/migrations/2026_06_13_01_create_pending_orders.sql</code> çalıştırılmalı.</div>';
}

// Her satır için: payload özeti + siparis tablosunda var mı + Stripe ödeme durumu
$liste = [];
foreach ($rows as $r) {
    $p = json_decode((string) $r['payload'], true);
    $c = is_array($p) ? ($p['customer'] ?? []) : [];

    $dustu = 0;
    try {
        $s = $db->prepare("SELECT COUNT(*) FROM siparis WHERE siparisid = ?");
        $s->execute([$r['siparis_id']]);
        $dustu = (int) $s->fetchColumn();
    } catch (\Throwable $e) {}

    $liste[] = [
        'session_id' => $r['session_id'],
        'siparis_id' => $r['siparis_id'],
        'status'     => $r['status'],
        'created_at' => $r['created_at'],
        'ad'         => trim(($c['name'] ?? '') . ' ' . ($c['surname'] ?? '')),
        'email'      => $c['email'] ?? '',
        'tutar'      => is_array($p) ? ($p['totalAmount'] ?? '') : '',
        'adet'       => is_array($p) && !empty($p['items']) ? count($p['items']) : 0,
        'bozuk'      => !is_array($p),
        'dustu'      => $dustu,
        'stripe'     => masq_stripe_session_durumu($stripe, $r['session_id']),
    ];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
    <title>Düşmemiş Siparişler | <?=$ayar['site_title']?></title>
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
                                <h5 class="card-title">Düşmemiş Siparişler</h5>
                                <p class="card-description">
                                    Ödeme sayfasına gidilmiş ama sipariş kaydı oluşmamış işlemler. Ödemesi
                                    <strong>alınmış</strong> olanlar buradan tek tıkla siparişe çevrilir
                                    (stok düşer, müşteriye onay maili gider). Ödemesi alınmamış olanlar terk edilmiş
                                    sepettir — "Yok Say" ile listeden kaldırılır.
                                </p>
                                <?= $mesaj ?>

                                <?php if (!$tabloYok) { ?>
                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Sipariş No</th>
                                            <th>Tarih</th>
                                            <th>Müşteri</th>
                                            <th>Tutar</th>
                                            <th>Ödeme (Stripe)</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($liste as $l) { ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($l['siparis_id']) ?></strong><br>
                                                <small class="text-muted"><?= $l['adet'] ?> ürün · <?= htmlspecialchars($l['status']) ?></small>
                                                <?php if ($l['bozuk']) { ?><br><span class="badge bg-danger">payload bozuk</span><?php } ?>
                                                <?php if ($l['dustu'] > 0) { ?><br><span class="badge bg-success">zaten kayıtlı</span><?php } ?>
                                            </td>
                                            <td><?= htmlspecialchars($l['created_at']) ?></td>
                                            <td>
                                                <?= htmlspecialchars($l['ad']) ?><br>
                                                <small class="text-muted"><?= htmlspecialchars($l['email']) ?></small>
                                            </td>
                                            <td><?= htmlspecialchars((string) $l['tutar']) ?> CAD</td>
                                            <td>
                                                <?php if ($l['stripe']['paid']) { ?>
                                                    <span class="badge bg-success">ödendi</span>
                                                    <?php if ($l['stripe']['amount'] !== null) { ?>
                                                        <br><small class="text-muted"><?= number_format($l['stripe']['amount'], 2) ?> CAD</small>
                                                    <?php } ?>
                                                <?php } elseif ($l['stripe']['ok']) { ?>
                                                    <span class="badge bg-secondary"><?= htmlspecialchars($l['stripe']['status']) ?></span>
                                                <?php } else { ?>
                                                    <span class="badge bg-warning">sorgulanamadı</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($l['dustu'] > 0) { ?>
                                                    <form method="post" style="display:inline">
                                                        <input type="hidden" name="session_id" value="<?= htmlspecialchars($l['session_id']) ?>">
                                                        <button type="submit" name="yoksay" value="1" class="btn btn-sm btn-secondary">Listeden Kaldır</button>
                                                    </form>
                                                <?php } else { ?>
                                                    <form method="post" style="display:inline" onsubmit="return confirm('Bu sipariş sisteme kaydedilecek, stok düşülecek ve müşteriye onay maili gidecek. Onaylıyor musun?');">
                                                        <input type="hidden" name="session_id" value="<?= htmlspecialchars($l['session_id']) ?>">
                                                        <?php if (!$l['stripe']['ok']) { ?>
                                                            <label style="display:block;font-size:12px;margin-bottom:4px;">
                                                                <input type="checkbox" name="eminim" value="1"> Ödemeyi Stripe'ta doğruladım
                                                            </label>
                                                        <?php } ?>
                                                        <button type="submit" name="dusur" value="1"
                                                                class="btn btn-sm btn-primary"
                                                                <?= ($l['bozuk'] || ($l['stripe']['ok'] && !$l['stripe']['paid'])) ? 'disabled' : '' ?>>
                                                            Siparişe Çevir
                                                        </button>
                                                    </form>
                                                    <form method="post" style="display:inline" onsubmit="return confirm('Bu kayıt listeden kaldırılacak, sipariş OLUŞTURULMAYACAK. Emin misin?');">
                                                        <input type="hidden" name="session_id" value="<?= htmlspecialchars($l['session_id']) ?>">
                                                        <button type="submit" name="yoksay" value="1" class="btn btn-sm btn-outline-secondary">Yok Say</button>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (empty($liste)) { ?>
                                        <tr><td colspan="6" style="text-align:center;color:#888;">Bekleyen sipariş yok — her şey yolunda. ✅</td></tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>

                                <?php if ($stripe === null) { ?>
                                <div class="alert alert-warning" style="margin-top:15px;">
                                    <strong>Not:</strong> Stripe anahtarı yüklenemedi, ödeme durumları doğrulanamıyor.
                                    Siparişe çevirmeden önce ödemeyi Stripe panelinden kendin kontrol et.
                                </div>
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
</body>
</html>
