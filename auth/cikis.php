<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
// Oturumu sonlandır
session_start();
session_destroy();

if (isset($_POST['previous_page'])) {
    $previous_page = $_POST['previous_page'];
} else {
    // Eğer previous_page verisi yoksa varsayılan bir sayfaya yönlendirin
    $previous_page = "../index.php"; // Varsayılan bir sayfa belirtin
}


// Ana sayfaya yönlendir
header("Location: $previous_page");
exit();

?>
