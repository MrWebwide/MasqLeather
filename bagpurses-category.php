<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$productTable   = 'urunler';
$categoryTable  = 'urun_kategori';
$detailPage     = 'bagpurses-detail';
$categoryPage   = 'bagpurses-category';
$headerFile     = 'header-2.php';
$footerFile     = 'footer.php';
$homeLink       = 'index.php';
$sectionTitle   = 'Bags & Purses';
$pageTitle       = $yazi['sssadi'] ?? 'Bags & Purses';
$pageDescription = $yazi['urunyazi'] ?? '';
$pageKeywords    = $yazi['ekipadi'] ?? '';
$extraStyles     = '.main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }';

include __DIR__ . '/templates/product-category.php';
