<?php
/**
 * Stripe secrets — now loaded from .env via config.php.
 */
require_once __DIR__ . '/../config.php';

$stripeSecretKey = STRIPE_SECRET_KEY;