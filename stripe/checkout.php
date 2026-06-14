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
// MAS-25: vergisiz base + ayrı vergi satırı. Eski tek-tutar session'ları base'e düşer.
$baseAmount  = $payload['baseAmount'] ?? ($isLoggedIn ? ($_SESSION['totalAmount'] ?? 0) : ($_SESSION['huso'] ?? 0));
$taxAmount   = $payload['taxAmount'] ?? 0;
$taxRate     = $payload['taxRate'] ?? 0;
$siparisId   = $payload['siparisId'] ?? ($_SESSION['siparisId'] ?? '');

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

$domain = rtrim(SITE_URL, '/');

// number_format'tan gelen "1,234.56" gibi değerleri de güvenle cent'e çevir
$toCents   = function ($v) { return (int) round(((float) str_replace(',', '', (string) $v)) * 100); };
$baseCents = $toCents($baseAmount);
$taxCents  = $toCents($taxAmount);

// Base satır + (vergi varsa) ayrı "Sales Tax" satırı → Stripe ekranında vergi görünür.
$lineItems = [[
    'price_data' => [
        'currency' => 'CAD',
        'product_data' => ['name' => 'Order Total'],
        'unit_amount' => $baseCents,
    ],
    'quantity' => 1,
]];
if ($taxCents > 0) {
    $ratePretty = rtrim(rtrim(number_format((float) $taxRate, 2), '0'), '.');
    $taxLabel   = 'Sales Tax' . ($ratePretty !== '' && $ratePretty !== '0' ? " ({$ratePretty}%)" : '');
    $lineItems[] = [
        'price_data' => [
            'currency' => 'CAD',
            'product_data' => ['name' => $taxLabel],
            'unit_amount' => $taxCents,
        ],
        'quantity' => 1,
    ];
}

$checkout_session = $stripe->checkout->sessions->create([
    'ui_mode' => 'embedded',
    'line_items' => $lineItems,
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
