<?php
/**
 * post_helper.php — Merkezi POST doğrulama/sanitizasyon. (MAS-33)
 *
 * Eskiden admin/*-ekle.php başında 28+ ham `$_POST['x']` doğrulamasız çıkarılıyordu
 * (GET yüklemede "undefined index" notice'ları + trim yok). Bu helper'lar tek noktadan
 * güvenli erişim sağlar. NOT: HTML içeren alanlar (CKEditor açıklama) için sadece trim
 * yapılır — çıktı kaçışı (htmlspecialchars) GÖSTERİMDE yapılmalı, girişte değil.
 */

function post_str($key, $default = '')
{
    return (isset($_POST[$key]) && !is_array($_POST[$key])) ? trim((string) $_POST[$key]) : $default;
}

function post_int($key, $default = 0)
{
    return isset($_POST[$key]) ? (int) $_POST[$key] : $default;
}

function post_float($key, $default = 0.0)
{
    return isset($_POST[$key]) ? (float) str_replace(',', '.', (string) $_POST[$key]) : $default;
}

function post_arr($key)
{
    return (isset($_POST[$key]) && is_array($_POST[$key])) ? $_POST[$key] : array();
}
