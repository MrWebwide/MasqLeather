<?php
// Bag & Purses ürün listesi. Ortak modül: include/product_list.php (MAS-32/MAS-31)
$config = [
    'table'           => 'urunler',
    'eklePage'        => 'urun-ekle.php',
    'reorderEndpoint' => 'update_order_bag.php',
    'addLabel'        => 'Add Product',
];
include 'include/product_list.php';
