<?php
/**
 * stripe/checkout.php — Stripe Embedded Checkout session'ı oluşturur. (MAS-10)
 *
 * checkout.js bu endpoint'e POST atar, clientSecret döner.
 * Ek olarak: session oluşur oluşmaz sipariş payload'ını pending_orders'a yazar
 * (webhook bunu okuyup siparişi kaydeder). return_url artık SITE_URL'den gelir.
 */

session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/secrets.php';                  // config.php -> STRIPE_*, SITE_URL
require_once __DIR__ . '/../admin/include/baglan.php';  // $db (PDO)

$isLoggedIn  = isset($_SESSION['id']);

// Tutar ve siparisId'yi öncelikle payload'dan al (control.php otoriter olarak hesapladı);
// yoksa eski session anahtarlarına düş.
$payload     = isset($_SESSION['masq_order_payload']) && is_array($_SESSION['masq_order_payload'])
    ? $_SESSION['masq_order_payload'] : null;
$totalAmount = $payload['totalAmount'] ?? ($isLoggedIn ? ($_SESSION['totalAmount'] ?? 0) : ($_SESSION['huso'] ?? 0));
$siparisId   = $payload['siparisId'] ?? ($_SESSION['siparisId'] ?? '');

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

$domain = rtrim(SITE_URL, '/');

// number_format'tan gelen "1,234.56" gibi değerleri de güvenle cent'e çevir
$amountCents = (int) round(((float) str_replace(',', '', (string) $totalAmount)) * 100);

$checkout_session = $stripe->checkout->sessions->create([
    'ui_mode' => 'embedded',
    'line_items' => [[
        'price_data' => [
            'currency' => 'CAD',
            'product_data' => ['name' => 'Total Amount'],
            'unit_amount' => $amountCents,
        ],
        'quantity' => 1,
    ]],
    'automatic_tax' => ['enabled' => true],
    'mode' => 'payment',
    'metadata' => ['siparis_id' => $siparisId],
    'return_url' => $domain . '/stripe/return.php?session_id={CHECKOUT_SESSION_ID}',
]);

// Sipariş payload'ını pending_orders'a yaz — webhook buradan okuyacak.
if (isset($_SESSION['masq_order_payload']) && is_array($_SESSION['masq_order_payload'])) {
    try {
        $stmt = $db->prepare(
            "INSERT INTO pending_orders (session_id, siparis_id, payload, status)
             VALUES (?, ?, ?, 'pending')
             ON DUPLICATE KEY UPDATE payload = VALUES(payload), status = 'pending'"
        );
        $stmt->execute([
            $checkout_session->id,
            $siparisId,
            json_encode($_SESSION['masq_order_payload'], JSON_UNESCAPED_UNICODE),
        ]);
    } catch (\Throwable $e) {
        error_log('[checkout] pending_orders yazılamadı (' . $checkout_session->id . '): ' . $e->getMessage());
    }
}

echo json_encode(['clientSecret' => $checkout_session->client_secret]);
