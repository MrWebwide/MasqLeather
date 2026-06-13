<?php
/**
 * stripe/webhook.php — Stripe webhook endpoint'i. (MAS-10)
 *
 * Siparişin TEK doğru kayıt noktası burasıdır; tarayıcıdan (return.php) bağımsızdır.
 * Akış:
 *   1) Stripe imzasını STRIPE_WEBHOOK_SECRET ile doğrula
 *   2) Sadece checkout.session.completed + payment_status='paid' olanları işle
 *   3) pending_orders'ı ATOMİK kilitle (pending -> processing) — idempotency
 *   4) Saklanan payload'ı oku -> masq_create_order() -> completed
 *
 * Hatalı/işlenemeyen durumda status 'pending'e geri alınır; Stripe otomatik retry eder.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/secrets.php';                       // config.php'yi de yükler (STRIPE_* sabitleri)
require_once __DIR__ . '/../admin/include/baglan.php';       // $db (PDO)
require_once __DIR__ . '/../functions/order_create.php';     // masq_create_order()

// Webhook'un session'a ihtiyacı yok.

$rawPayload = file_get_contents('php://input');
$sigHeader  = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$secret     = defined('STRIPE_WEBHOOK_SECRET') ? STRIPE_WEBHOOK_SECRET : '';

if ($secret === '') {
    error_log('[webhook] STRIPE_WEBHOOK_SECRET tanımsız — .env kontrol et');
    http_response_code(500);
    echo 'webhook secret missing';
    exit;
}

// 1) İmza doğrulama
try {
    $event = \Stripe\Webhook::constructEvent($rawPayload, $sigHeader, $secret);
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    echo 'invalid payload';
    exit;
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    echo 'invalid signature';
    exit;
}

// 2) Sadece tamamlanan checkout session'ları ilgilendiriyor
if ($event->type !== 'checkout.session.completed') {
    http_response_code(200);
    echo 'ignored';
    exit;
}

$session   = $event->data->object;
$sessionId = $session->id ?? '';

// Ödeme gerçekten alınmış mı?
if (($session->payment_status ?? '') !== 'paid') {
    error_log("[webhook] {$sessionId} payment_status != paid (" . ($session->payment_status ?? 'null') . ')');
    http_response_code(200);
    echo 'not paid';
    exit;
}

try {
    // 3) Atomik kilit: yalnızca pending -> processing geçişini yapan istek siparişi işler.
    $claim = $db->prepare("UPDATE pending_orders SET status = 'processing' WHERE session_id = ? AND status = 'pending'");
    $claim->execute([$sessionId]);

    if ($claim->rowCount() !== 1) {
        // Zaten işleniyor/işlendi ya da bu session için kayıt yok.
        error_log("[webhook] {$sessionId} claim edilemedi (zaten işlenmiş veya kayıt yok)");
        http_response_code(200);
        echo 'already handled or unknown';
        exit;
    }

    // 4) Payload'ı oku
    $stmt = $db->prepare("SELECT payload FROM pending_orders WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    $orderPayload = json_decode((string) $stmt->fetchColumn(), true);

    if (!is_array($orderPayload)) {
        error_log("[webhook] {$sessionId} payload bozuk/boş");
        http_response_code(500);
        echo 'bad payload';
        exit; // 'processing'te bırakılır — manuel inceleme
    }

    $result = masq_create_order($db, $orderPayload);

    if ($result['ok']) {
        $db->prepare("UPDATE pending_orders SET status = 'completed', processed_at = NOW() WHERE session_id = ?")
           ->execute([$sessionId]);
        http_response_code(200);
        echo 'ok';
    } else {
        // Tekrar denenebilsin diye pending'e geri al (Stripe retry eder).
        $db->prepare("UPDATE pending_orders SET status = 'pending' WHERE session_id = ?")->execute([$sessionId]);
        error_log("[webhook] {$sessionId} order_create başarısız: " . ($result['error'] ?? '?'));
        http_response_code(500);
        echo 'order create failed';
    }
} catch (\Throwable $e) {
    error_log('[webhook] beklenmeyen hata (' . $sessionId . '): ' . $e->getMessage());
    http_response_code(500);
    echo 'server error';
}
