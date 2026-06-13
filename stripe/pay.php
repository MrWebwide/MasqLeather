<?php
/**
 * stripe/pay.php — Stripe Embedded Checkout'un gömüldüğü ödeme sayfası. (MAS-10)
 *
 * Eski stripe/checkout.html statikti ve window.STRIPE_PK'yı set etmiyordu
 * (checkout.js Stripe(window.STRIPE_PK) ile patlardı). Bu .php sürüm PK'yı
 * config'ten enjekte eder. control.php buraya yönlendirir.
 */
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Payment — Masq Leather</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./style.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script>window.STRIPE_PK = "<?= htmlspecialchars(STRIPE_PUBLISHABLE_KEY, ENT_QUOTES) ?>";</script>
    <script src="checkout.js" defer></script>
  </head>
  <body style="background-image: none;">
    <div id="checkout" style="background-color: lightgrey;">
      <!-- Stripe ödeme formu buraya gelir -->
    </div>
  </body>
</html>
