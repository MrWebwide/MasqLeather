<?php
// Our Collection ürün listesi. Ortak modül: include/product_list.php (MAS-32/MAS-31)
$config = [
    'table'           => 'ourcollection',
    'eklePage'        => 'ourcollection-ekle.php',
    'reorderEndpoint' => 'update_order_ourc.php',
    'addLabel'        => 'Our Collection Ekle',
];
include 'include/product_list.php';
