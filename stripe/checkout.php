<?php

session_start();
require_once './vendor/autoload.php';
require_once './secrets.php';

if(isset($_SESSION['id'])){
  $totalAmount = $_SESSION['totalAmount'];
} else{
  $totalAmount = $_SESSION['huso'];
}

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://www.masqleather.com';

$checkout_session = $stripe->checkout->sessions->create([
    'ui_mode' => 'embedded',
    'line_items' => [[
      'price_data' => [
        'currency' => 'CAD', // Para birimi olarak CAD kullanılıyor
        'product_data' => [
          'name' => 'Total Amount', // Ürün ismi

        ],
        'unit_amount' => $totalAmount * 100, // Fiyatı cent cinsinden Stripe'a göndermek için 100 ile çarpın
      ],
      'quantity' => 1, // Miktar
    ]],
    'automatic_tax' => ['enabled' => true],
  'mode' => 'payment',
  'return_url' => $YOUR_DOMAIN . '/stripe/return.php?session_id={CHECKOUT_SESSION_ID}',
  
]);

  echo json_encode(array('clientSecret' => $checkout_session->client_secret));

  ?>



