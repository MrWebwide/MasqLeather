<?php
/**
 * stripe/return.php — Ödeme sonrası "teşekkürler" ekranı. (MAS-10)
 *
 * ARTIK sipariş kaydı TETİKLEMEZ (eski client-side islem.php fetch'i kaldırıldı).
 * Sipariş kaydı tarayıcıdan bağımsız olarak stripe/webhook.php ile yapılır.
 * Burada sadece teşekkür gösterilir ve misafir sepeti temizlenir.
 */
session_start();
require_once __DIR__ . '/../functions/order_payload.php';

// Misafir sepetini temizle (üye sepeti webhook'ta DB'den temizlenir).
if (!isset($_SESSION['id'])) {
    masq_clear_noid_cart();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Thanks for your order!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css?v=<?= @filemtime(__DIR__ . '/style.css') ?>">
  <script src="return.js" defer></script>
</head>
<body>
  <section id="success">
    <div class="suc">
      <div class="frame">
        <img src="../assets/shutterstock/confirm.png" width="120px" alt="" class="success-image">
        <p>
          Thank you for your order! A confirmation email will be sent to <span id="customer-email"></span>.
          If you have any questions, please don't hesitate to mail us.
          <a href="mailto:info@masqleather.com">info@masqleather.com</a>.
        </p>
      </div>
      <div class="button-container">
        <a href="../index.php" class="button2" style="--clr:#d67900; font-size: 1.1em; text-decoration:none;"><span>Back to Homepage</span><i></i></a>
      </div>
    </div>
  </section>
</body>
</html>
