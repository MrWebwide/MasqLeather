<?php
/**
 * order_create.php — Siparişi kalıcı olarak oluşturan TEK ortak fonksiyon. (MAS-10)
 *
 * Eskiden bu mantık functions/islem.php içinde, biri üye biri misafir için
 * ~130 satırlık İKİ KOPYA blok halindeydi ve return.php'deki client-side fetch
 * ile tetikleniyordu (sekme kapanınca sipariş düşmüyordu). Artık:
 *   - Bu fonksiyon $_SESSION'a BAĞIMSIZDIR; tüm veriyi $payload'dan alır.
 *   - Hem Stripe webhook'u (asıl) hem gerekirse fallback bu fonksiyonu çağırır.
 *
 * Sorumlulukları:
 *   1) siparis tablosuna kalemleri yazar
 *   2) Stoğu DOĞRU tablodan düşer  (tur -> tablo eşlemesi; eski 4x döngü bug'ı giderildi)
 *   3) mailgelen kaydını yazar
 *   4) Üye ise useraddress'i (yoksa) ekler ve sepeti temizler
 *   5) Müşteriye + admine mail gönderir (best-effort; mail hatası sipariş kaydını bozmaz)
 *
 * İdempotency: aynı siparişin iki kez işlenmemesi çağıran tarafça (webhook'un
 * pending_orders üzerinde atomik 'pending'->'processing' kilidiyle) sağlanır.
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Ürün türünü (tur) doğru stok tablosuna eşler.
 * DB'den doğrulandı: bagpurses=urunler, jewelry=jewe, accessories, homedecor.
 */
function masq_stock_table_for_tur(?string $tur): ?string
{
    static $map = [
        'bagpurses'   => 'urunler',
        'jewelry'     => 'jewe',
        'accessories' => 'accessories',
        'homedecor'   => 'homedecor',
    ];
    return $tur !== null && isset($map[$tur]) ? $map[$tur] : null;
}

/**
 * Siparişi oluşturur. DB yazımları tek transaction içinde yapılır.
 *
 * Beklenen $payload yapısı:
 *   [
 *     'siparisId'   => string,
 *     'userId'      => int|string ('No account' = misafir),
 *     'isGuest'     => bool,
 *     'totalAmount' => string|float,
 *     'maxCargo'    => float,
 *     'adsoyad'     => string,
 *     'addname'     => string,
 *     'customer'    => ['name','surname','address','city','province','postal','phone','email','country'],
 *     'billing'     => ['namebill','surnamebill','addressbill','citybill','provincebill','postalbill'],
 *     'items'       => [ ['id','name','quantity','totalPrice','tur'], ... ],   // düz liste
 *   ]
 *
 * @return array ['ok'=>bool, 'siparisId'=>string, 'error'=>?string]
 */
function masq_create_order(PDO $db, array $payload): array
{
    $siparisId   = (string) $payload['siparisId'];
    $userId      = $payload['userId'];
    $isGuest     = !empty($payload['isGuest']);
    $maxCargo    = $payload['maxCargo'] ?? 0;
    $totalAmount = $payload['totalAmount'] ?? 0;
    $adsoyad     = $payload['adsoyad'] ?? '';
    $addname     = $payload['addname'] ?? '';
    $c           = $payload['customer'] ?? [];
    $b           = $payload['billing'] ?? [];
    $items       = $payload['items'] ?? [];

    // Eksik kritik veri kontrolü
    if ($siparisId === '' || empty($items) || empty($c['email'])) {
        return ['ok' => false, 'siparisId' => $siparisId, 'error' => 'eksik payload (siparisId/items/email)'];
    }

    // PDO hataları exception fırlatsın ki transaction rollback güvenle çalışsın.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $db->beginTransaction();

        // 1) Sipariş kalemleri  +  2) Stok düşme (tur -> doğru tablo)
        $insItem    = $db->prepare(
            "INSERT INTO siparis (siparisid, name, quantity, total_price, cargo, userid, tur, urunid, secimler)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stockStmts = []; // tablo başına tek prepared statement

        foreach ($items as $p) {
            $tur = $p['tur'] ?? '';
            $insItem->execute([
                $siparisId, $p['name'], $p['quantity'], $p['totalPrice'],
                $maxCargo, $userId, $tur, $p['id'], $p['secimler'] ?? null,
            ]);

            $table = masq_stock_table_for_tur($tur);
            if ($table === null) {
                error_log("[order_create] bilinmeyen tur '{$tur}' (urun id {$p['id']}) — stok düşülemedi");
                continue;
            }
            if (!isset($stockStmts[$table])) {
                // Tablo adı sabit bir whitelist'ten (masq_stock_table_for_tur) geldiği için interpolation güvenli.
                $stockStmts[$table] = $db->prepare("UPDATE {$table} SET stock = stock - ? WHERE id = ?");
            }
            $stockStmts[$table]->execute([$p['quantity'], $p['id']]);
        }

        // 3) mailgelen (sipariş + adres özeti)
        $insMail = $db->prepare(
            "INSERT INTO mailgelen
               (adsoyad, siparisid, name, totalAmount, surname, address, city, province, postal, phone,
                email, namebill, surnamebill, addressbill, citybill, provincebill, postalbill, country, userid, eklenme_tarihi)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())"
        );
        $insMail->execute([
            $adsoyad, $siparisId, $c['name'] ?? '', $totalAmount, $c['surname'] ?? '', $c['address'] ?? '',
            $c['city'] ?? '', $c['province'] ?? '', $c['postal'] ?? '', $c['phone'] ?? '', $c['email'],
            $b['namebill'] ?? '', $b['surnamebill'] ?? '', $b['addressbill'] ?? '', $b['citybill'] ?? '',
            $b['provincebill'] ?? '', $b['postalbill'] ?? '', $c['country'] ?? '', $userId,
        ]);

        // 4) Üye ise: useraddress (yoksa) ekle + sepeti temizle
        if (!$isGuest && is_numeric($userId)) {
            $chk = $db->prepare("SELECT COUNT(*) FROM useraddress WHERE adsoyad = ?");
            $chk->execute([$adsoyad]);
            if ((int) $chk->fetchColumn() === 0) {
                $insAddr = $db->prepare(
                    "INSERT INTO useraddress
                       (addname, adsoyad, name, surname, address, city, province, postal, phone, email, country, userid, eklenme_tarihi)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())"
                );
                $insAddr->execute([
                    $addname, $adsoyad, $c['name'] ?? '', $c['surname'] ?? '', $c['address'] ?? '', $c['city'] ?? '',
                    $c['province'] ?? '', $c['postal'] ?? '', $c['phone'] ?? '', $c['email'], $c['country'] ?? '', $userId,
                ]);
            }
            $db->prepare("DELETE FROM sepet WHERE KullaniciID = ?")->execute([$userId]);
        }

        $db->commit();
    } catch (\Throwable $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        error_log('[order_create] DB hatası (siparis ' . $siparisId . '): ' . $e->getMessage());
        return ['ok' => false, 'siparisId' => $siparisId, 'error' => $e->getMessage()];
    }

    // 5) Mailler — sipariş zaten kayıtlı; mail hatası kaydı bozmaz, sadece loglanır.
    masq_send_order_emails($c['name'] ?? '', $c['surname'] ?? '', $c['email'], $siparisId);

    return ['ok' => true, 'siparisId' => $siparisId, 'error' => null];
}

/**
 * Sipariş maillerini gönderir: müşteriye onay + admine uyarı.
 * Eski kod hataları echo ile yutuyordu; artık loglanıyor (MAS-15 ile bağlantılı).
 */
function masq_send_order_emails(string $name, string $surname, string $email, string $siparisId): void
{
    // Müşteri onayı
    try {
        $mail = new PHPMailer(true);
        configureMailer($mail);
        $mail->addAddress($email, $name);
        $mail->Subject = 'Order Confirmation';
        $mail->Body    = "Dear {$name} {$surname}, <br><br>We are pleased to inform you that your order has been confirmed. "
            . "Your order number is <strong>{$siparisId}</strong>. We sincerely appreciate your business and thank you for "
            . "choosing Masq Leather. If you have any further inquiries, please do not hesitate to contact us.<br><br>"
            . "Best regards,<br><strong>Masq Leather</strong>";
        $mail->send();
    } catch (\Throwable $e) {
        error_log('[order_create] müşteri maili başarısız (' . $siparisId . '): ' . $e->getMessage());
    }

    // Admin uyarısı
    try {
        $mail = new PHPMailer(true);
        configureMailer($mail);
        $mail->addAddress(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        if (defined('ADMIN_EMAIL') && ADMIN_EMAIL) {
            $mail->addAddress(ADMIN_EMAIL, MAIL_FROM_NAME);
        }
        $mail->Subject = 'New Order Alert!';
        $mail->Body    = "A new order (<strong>{$siparisId}</strong>) has been placed on your website. "
            . "Please review the order details on the administration panel.<br><br><strong>Masq Leather</strong>";
        $mail->send();
    } catch (\Throwable $e) {
        error_log('[order_create] admin maili başarısız (' . $siparisId . '): ' . $e->getMessage());
    }
}
