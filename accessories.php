<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$productTable   = 'accessories';
$categoryTable  = 'bolge_kategori';
$detailPage     = 'accessories-detail';
$categoryPage   = 'accessories-category';
$headerFile     = 'header-2.php';
$footerFile     = 'footer.php';
$homeLink       = 'index.php';
$sectionTitle   = 'Accessories';
$pageTitle       = $yazi['sssadi'] ?? 'Accessories';
$pageDescription = $yazi['urunyazi'] ?? '';
$pageKeywords    = $yazi['ekipadi'] ?? '';
$extraStyles     = '.main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }';

include __DIR__ . '/templates/product-listing.php';
