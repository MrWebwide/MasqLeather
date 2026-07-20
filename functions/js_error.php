<?php
/**
 * js_error.php — Frontend (tarayıcı) JS hatalarını hata_log'a yazar. (MAS-8)
 * head-js.php'deki window.onerror / unhandledrejection buraya POST eder.
 * masq_log_error() ile aynı tabloya (gruplamalı) yazılır → spam olmaz.
 */
require_once __DIR__ . '/../admin/include/baglan.php'; // $db + masq_log_error + handler

http_response_code(204); // her durumda sessiz yanıt (tarayıcıyı meşgul etme)

// Sadece POST + aynı origin (kötüye kullanımı azalt)
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { exit; }
$host   = $_SERVER['HTTP_HOST'] ?? '';
$origin = parse_url($_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? ''), PHP_URL_HOST);
if ($origin && $host && $origin !== $host) { exit; }

$raw = file_get_contents('php://input');
if (strlen($raw) > 20000) { $raw = substr($raw, 0, 20000); }
$d = json_decode($raw, true);
if (!is_array($d)) { exit; }

$mesaj = trim((string) ($d['message'] ?? ''));
if ($mesaj === '') { exit; }

$tur    = (($d['type'] ?? '') === 'promise') ? 'js_promise' : 'js';
$dosya  = (string) ($d['source'] ?? '');
$satir  = (int) ($d['line'] ?? 0);
$iz     = (string) ($d['stack'] ?? '');
$seviye = 'browser';

if (function_exists('masq_log_error')) {
    masq_log_error($tur, $mesaj, $dosya, $satir, $iz, $seviye);
}
exit;
