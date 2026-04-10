<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$productTable   = 'jewe';
$categoryTable  = 'jewe_kategori';
$detailPage     = 'jewelry-detail';
$categoryPage   = 'jewelry-category';
$headerFile     = 'header-mer2.php';
$footerFile     = 'footer-mer.php';
$homeLink       = 'index-2.php';
$sectionTitle   = 'Jewelry';
$pageTitle       = $yazi['yazi5'] ?? 'Jewelry';
$pageDescription = $yazi['yazi6'] ?? '';
$pageKeywords    = $yazi['yazi7'] ?? '';
$bodyClass       = '';
$extraStyles     = '.offcanvas_main_menu li a { color:white !important; }';

include __DIR__ . '/templates/product-category.php';
