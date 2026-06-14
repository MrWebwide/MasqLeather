<?php
// Accessories ürün listesi. Ortak modül: include/product_list.php (MAS-32/MAS-31)
$config = [
    'table'           => 'accessories',
    'eklePage'        => 'accessories-ekle.php',
    'reorderEndpoint' => 'update_order_acc.php',
    'addLabel'        => 'Add Product',
];
include 'include/product_list.php';
