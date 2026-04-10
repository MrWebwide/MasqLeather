<?php
/**
 * init.php — Shared bootstrap for all frontend pages.
 * Include this ONCE at the top of every page BEFORE any output.
 *
 * Provides: $db, $bakim, $yazi, $ayarlar, $sayac, session, maintenance check, cookie tracking.
 * 
 * Usage:
 *   <?php require_once __DIR__ . '/includes/init.php'; ?>
 */

// Error reporting — disable display in production
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Database & global settings
require_once __DIR__ . '/../admin/include/baglan.php';
require_once __DIR__ . '/../admin/include/fonksiyonlar.php';

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adsoyad = $_SESSION['adsoyad'] ?? '';
$userId  = $_SESSION['id'] ?? '';

// Maintenance mode check
if (!empty($bakim['kategori']) && $bakim['kategori'] == 1) {
    header('HTTP/1.1 503 Service Unavailable');
    header('Content-Type: text/html; charset=utf-8');
    header('Retry-After: 3600');
    include_once __DIR__ . '/../404.php';
    exit();
}

// Track current URL in cookie
if (isset($_SERVER['REQUEST_URI'])) {
    $url = $_SERVER['REQUEST_URI'];
    setcookie('memet', $url, time() + (86400 * 30), '/');
}
