<?php
// Jewelry ürün listesi. Ortak modül: include/product_list.php (MAS-32/MAS-31)
$config = [
    'table'           => 'jewe',
    'eklePage'        => 'jewe-ekle.php',
    'reorderEndpoint' => 'update_order_jewelry.php',
    'addLabel'        => 'Add Product',
];
include 'include/product_list.php';
