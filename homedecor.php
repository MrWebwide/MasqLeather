<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$productTable   = 'homedecor';
$categoryTable  = 'mer_kategori';
$detailPage     = 'homedecor-detail';
$categoryPage   = 'homedecor-category';
$headerFile     = 'header-mer2.php';
$footerFile     = 'footer-mer.php';
$homeLink       = 'index-2.php';
$sectionTitle   = 'Home Decor';
$pageTitle       = $yazi['yazi5'] ?? 'Home Decor';
$pageDescription = $yazi['yazi6'] ?? '';
$pageKeywords    = $yazi['yazi7'] ?? '';
$bodyClass       = '';
$extraStyles     = '.offcanvas_main_menu li a { color:white !important; }';

include __DIR__ . '/templates/product-listing.php';
