<?php
// Suppress error display globally (errors still logged)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);

// Load central config
require_once __DIR__ . '/../../config.php';

// ─── Session cookie sertleştirme (MAS-17) ───
// session_start()'tan önce çalışır (admin sayfaları baglan'ı session_start'tan önce include eder).
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || (($_SERVER['SERVER_PORT'] ?? '') == 443);
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.cookie_secure', $isHttps ? '1' : '0');
}

$site = SITE_URL;
$targetFolder = UPLOAD_FOLDER;

try {
 $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $exception){
 error_log("DB Connection Error: " . $exception->getMessage());
 die("A database error occurred. Please try again later.");
}
?>