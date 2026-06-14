<?php
// Home Decor ürün listesi. Ortak modül: include/product_list.php (MAS-32/MAS-31)
$config = [
    'table'           => 'homedecor',
    'eklePage'        => 'homedecor-ekle.php',
    'reorderEndpoint' => 'update_order_home.php',
    'addLabel'        => 'Add Product',
];
include 'include/product_list.php';
