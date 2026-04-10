<?php if (!isset($basePath)) $basePath = ''; ?>
<div class="offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="offcanvas_menu_wrapper">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">
                                <li class="menu-item-has-children active">
                                    <a href="<?=$basePath?>index.php">Home</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Bags & Purses</a>
                                    <ul class="sub-menu">

                                        <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                         FROM urun_kategori AS bk
                         LEFT JOIN urunler AS b ON bk.adi = b.kategori
                         GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
$adi = $hizmetka['adi'];
$urun_sayisi = $hizmetka['urun_sayisi'];
?>
                                        <li><a href="<?=$basePath?>bagpurses-category.php?kategori=<?= urlencode($adi) ?>">
                                                <?= $adi ?>
                                            </a></li>
                                        <?php } ?>


                                </li>
                            </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Accessories</a>
                                <ul class="sub-menu">

                                <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                            FROM bolge_kategori AS bk
                            LEFT JOIN accessories AS b ON bk.adi = b.kategori
                            GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
   $adi = $hizmetka['adi'];
   $urun_sayisi = $hizmetka['urun_sayisi'];
   ?>
                                            <li><a href="<?=$basePath?>accessories-category.php?kategori=<?= urlencode($adi) ?>">
                                                    <?= $adi ?>
                                                </a></li>
                                            <?php } ?>

                                </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="<?=$basePath?>index-2.php" class="ripple-link22">Masq
                                    Mercantile</a></li>
                            <li class="menu-item-has-children">
                                <a href="<?=$basePath?>blog.php">blog</a>

                            </li>
                            <li>
                            <div class="search-bar">
                            <form action="<?=$basePath?>product.php" method="GET" >
                                    <input type="text" placeholder="Search for Products..." name="search_query" style="width:-webkit-fill-available;"/>
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--offcanvas menu area end-->

    <!--header area start-->
    <header class="header_section mb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main_header d-flex justify-content-between align-items-center">
                        <div class="header_logo logo1">
                            <a href="<?=$basePath?>index.php" class="ripple-link"><img src="<?=$basePath?>assets/img/logo/Artboard 1 copy 6.png"
                                    alt=""></a>
                        </div>

                        <!----    <div class="header_logo logo2">
                            <a href="index-2.html" class="ripple-link2" ><img src="<?=$basePath?>assets/img/logo/mercantil.png" alt=""></a>
                        </div> -->
                        <!--main menu start-->
                        <div class="main_menu d-none d-lg-block" style="
                        padding-right: 0cm;
                        padding-top: 13px;
                    ">
                            <nav>
                                <ul class="d-flex">
                                    <li><a class="active" href="<?=$basePath?>index.php">Home</a></li>

                                    <li><a href="<?=$basePath?>bagpurses.php">Bags & Purses</a>
                                        <ul class="sub_menu">
                                            <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                            FROM urun_kategori AS bk
                            LEFT JOIN urunler AS b ON bk.adi = b.kategori
                            GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
   $adi = $hizmetka['adi'];
   $urun_sayisi = $hizmetka['urun_sayisi'];
   ?>
                                            <li><a href="<?=$basePath?>bagpurses-category.php?kategori=<?= urlencode($adi) ?>">
                                                    <?= $adi ?>
                                                </a></li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                    <li><a href="<?=$basePath?>accessories.php">Accessories</a>

                                        <ul class="sub_menu">

                                            <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                            FROM bolge_kategori AS bk
                            LEFT JOIN accessories AS b ON bk.adi = b.kategori
                            GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
   $adi = $hizmetka['adi'];
   $urun_sayisi = $hizmetka['urun_sayisi'];
   ?>
                                            <li><a href="<?=$basePath?>accessories-category.php?kategori=<?= urlencode($adi) ?>">
                                                    <?= $adi ?>
                                                </a></li>
                                            <?php } ?>


                                        </ul>


                                    </li>
                                    <li><a href="<?=$basePath?>index-2.php" class="ripple-link2">Mercantile</a>

                                    </li>

                                    <li><a href="<?=$basePath?>blog.php">blog</a>

                                    </li>
                                    <li class="header_search_btn custom-margin"><a href="#"><img class="img1" width="40px"
                                                src="<?=$basePath?>assets/img/animated-icon/white-magnifier.png" alt=""></a></li>

                                    <li class="shopping_cart custom-margin"><a href="#"><img class="img2" width="40px"
                                                src="<?=$basePath?>assets/img/animated-icon/shopping-cartwww.png" alt=""></a></li>
                                    <li class="account_link_menu custom-margin">
                                        <div class="link_container">
                                            <?php if (isset($_SESSION['adsoyad'])) : ?>
                                            <a href="#.php">
                                                <div class="flex-container">
                                                    <div class="icon_container">
                                                        <img width="50px" src="<?=$basePath?>assets/img/animated-icon/account.png"
                                                            alt="">
                                                    </div>
                                                    <div class="text_container">
                                                        <span>
                                                            <?php echo $_SESSION['adsoyad']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
// Kullanıcı giriş yapmışsa dropdown menüyü görüntüleyin
if (isset($_SESSION['adsoyad'])) {
    echo '<div class="dropdown_menu">';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="<?=$basePath?>account/address-details.php">Saved Address</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="<?=$basePath?>account/recent-orders.php">Recent Orders</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    // Önceki sayfanın URL'sini hidden input ile alın
    echo '<form action="<?=$basePath?>auth/cikis.php" method="post">';
    echo '<input type="hidden" name="previous_page" value="' . $_SERVER['REQUEST_URI'] . '">';
    echo '<button type="submit">Log-Out</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}
?> 
                                            <?php else : ?>
                                                <a href="<?=$basePath?>auth/signin.php">
                                                <div class="flex-container">
                                                    <div class="icon_container">
                                                        <img width="50px" src="<?=$basePath?>assets/img/animated-icon/account.png"
                                                            alt="">
                                                    </div>
                                                    <div class="text_container">
                                                        <span>Log-in / Register</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </nav>
                        </div>
                        <div class="canvas_open">



<li class="account_link_menu custom-margin">
    <div class="link_container" style="border-radius:unset;">
        <a href="#">
            <div class="flex-container">
                <div class="icon_container">
                    <img width="50px" src="<?=$basePath?>assets/img/animated-icon/account.png" alt="">
                </div>
                <?php
                          if (isset($_SESSION['adsoyad'])) {
// Kullanıcı giriş yapmışsa
echo '<div class="text_container" style="padding-bottom:10px;">';
echo '<span>' . $_SESSION['adsoyad'] . '</span>';
echo '</div>';
echo '</div>';
} else {
// Kullanıcı giriş yapmamışsa
echo '<a href="<?=$basePath?>auth/signin.php">';
echo '<div class="text_container" style="padding-bottom:10px;">';
echo '<span>Log-in / Register</span>';
echo '</div>';
echo '</div>';
echo '</a>';
}
?>
        </a>

        <?php
// Kullanıcı giriş yapmışsa dropdown menüyü görüntüleyin
if (isset($_SESSION['adsoyad'])) {
    echo '<div class="dropdown_menu">';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="<?=$basePath?>account/address-details.php">Saved Address</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="<?=$basePath?>account/recent-orders.php">Recent Orders</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    // Önceki sayfanın URL'sini hidden input ile alın
    echo '<form action="<?=$basePath?>auth/cikis.php" method="post">';
    echo '<input type="hidden" name="previous_page" value="' . $_SERVER['REQUEST_URI'] . '">';
    echo '<button type="submit">Log-Out</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}
?> 
    </div>
    </li>
    <li class="shopping_cart custom-margin" style="list-style-type: none;"><a href="#"
                                    style="margin-right: 5px;"><img width="40px"
                                        src="<?=$basePath?>assets/img/animated-icon/shopping-cartwww.png" alt=""></a></li>
                            <a class="opener" href="javascript:void(0)"><i class="ion-navicon"
                                    style="color:white; font-size:40px !important;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


     <!--mini cart-->
  <div class="mini_cart">
        <div class="cart_gallery">
            <div class="cart_close">
                <div class="cart_text">
                    <h3>cart</h3>
                </div>
                <div class="mini_cart_close">
                    <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                </div>
            </div>
   
            <div class="denemelike" id="mini-cart">
            <?php
if (isset($_SESSION['id'])) {
    // Kullanıcı girişi yapılmışsa, kullanıcının kimliğini alın
    $userId = $_SESSION['id'];

    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

    // Toplam fiyatı saklamak için bir değişken tanımlayın
    $totalPrice = 0;

    // Eğer kullanıcının sepeti boşsa, mesajı gösterin
    if ($stmt->rowCount() == 0) {
        echo "Your cart is empty.";
    } else {
        // Sepetteki her bir ürünü listeleyin
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productId = $row['UrunID'];
            $productName = $row['UrunAdi'];
            $productQuantity = $row['UrunMiktari'];
            $productPrice = $row['UrunFiyati'];
            $productImage = $row['urun_resim'];
            $productCategory = $row['urun_category'];
            $producttur = $row['tur'];

            // Gerçek ID'yi almak için id_tur'dan ayırma işlemi
            $id_tur_split = explode('_', $productId);
            $real_id = $id_tur_split[0]; // Gerçek ID'yi alın
            $product_link = $producttur . '-detail.php?id=' . $real_id;

            // Her bir ürünü sepette listeleyin
            echo '<div class="cart_item" data-product-id="' . $productId . '" data-product-category="' . $productCategory . '" data-product-price="' . $productPrice . '" data-product-quantity="' . $productQuantity . '">';
            echo '<div class="cart_img">';
            echo '<a href="#"><img src="<?=$basePath?>admin/resimler/' . $productImage . '" alt=""></a>';
            echo '</div>';
            echo '<div class="cart_info">';
            echo '<div class="close-sec d-flex">';
            echo '<a href="' . $basePath . $product_link . '">' . $productName . '</a>';
            echo '<a href="#" class="delete_item" data-product-id="' . $productId . '" data-product-category="' . $productCategory . '" data-product-price="' . $productPrice . '" data-product-quantity="' . $productQuantity . '" style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
            echo ' </div>';
            echo '    <p>' . $productQuantity . ' x <span> $' . $productPrice . '</span></p>';
            echo '  </div>';
            echo '  <div class="cart_remove">';
            echo '    <a href="#"><i class="icon-close icons"></i></a>';
            echo '  </div>';
            echo '</div>';

            // Toplam fiyata ekleyin
            $totalPrice += $productPrice * $productQuantity;
        }
    }

    // Toplam fiyatı ekrana yazdırın
    echo '<div class="cart_total" id="subTotal">';
    echo '  <span>Sub total:</span>';
    echo '  <span class="price" id="subtotal-price">$' . number_format($totalPrice, 2) . '</span>';
    echo '</div>';
}
 else {

    echo getUpdatedCartContentFromSession();
}

function getUpdatedCartContentFromSession() {
    session_name('noid');
    session_start();

    // Sepet oturumda yoksa boş bir dizi oluşturun
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Toplam fiyatı saklamak için bir değişken tanımlayın
    $totalPrice = 0;

    $updatedCartContent = ''; // Güncellenmiş sepet içeriğini saklayacak değişken

    if (empty($cart)) {
        // Sepet boşsa uygun bir mesaj döndürün
        $updatedCartContent = "Your cart is empty.";
    } else {
        // Sepetteki her bir ürünü listele
        foreach ($cart as $productId => $product) {
            // Gerçek ID'yi almak için id_tur'dan ayırma işlemi
            $id_tur_split = explode('_', $productId);
            $real_id = $id_tur_split[0]; // Gerçek ID'yi alın
            $product_link = $product['tur'] . '-detail.php?id=' . $real_id;

            // Her bir ürünü sepette listele
            $updatedCartContent .= '<div class="cart_item" data-product-id="' . $productId . '" data-product-category="' . $product['category'] . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '">';
            $updatedCartContent .= '<div class="cart_img">';
            $updatedCartContent .= '<a href="#"><img src="<?=$basePath?>admin/resimler/' . $product['image'] . '" alt=""></a>';
            $updatedCartContent .= '</div>';
            $updatedCartContent .= '<div class="cart_info">';
            $updatedCartContent .= '<div class="close-sec d-flex">';
            $updatedCartContent .= '<a href="' . $product_link . '">' . $product['name'] . '</a>';
            $updatedCartContent .= '<a href="#" class="delete_item" data-product-id="' . $productId . '" data-product-category="' . $product['category'] . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '" style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
            $updatedCartContent .= '</div>';
            $updatedCartContent .= '<p>' . $product['quantity'] . ' x <span> $' . $product['price'] . '</span></p>';
            $updatedCartContent .= '</div>';
            $updatedCartContent .= '<div class="cart_remove">';
            $updatedCartContent .= '<a href="#"><i class="icon-close icons"></i></a>';
            $updatedCartContent .= '</div>';
            $updatedCartContent .= '</div>';

            // Toplam fiyata ekleyin
            $totalPrice += $product['price'] * $product['quantity'];
        }

        // Toplam fiyatı ekrana yazdırın
        $updatedCartContent .= '<div class="cart_total">';
        $updatedCartContent .= '<span>Sub total:</span>';
        $updatedCartContent .= '<span class="price">$' . number_format($totalPrice, 2) . '</span>';
        $updatedCartContent .= '</div>';
    }

    session_write_close(); // Oturumu kapat

    return $updatedCartContent;
}


?>


            </div>
        </div>
        <div class="mini_cart_footer">
            <div class="cart_button">
                <a href="<?=$basePath?>cart.php"><i class="fa fa-shopping-cart"></i> View cart</a>
            </div>
          
        </div>
    </div>
    <!--mini cart end-->

    <!-- page search box -->
    <div class="page_search_box">
        <div class="search_close">
            <i class="ion-close-round"></i>
        </div>
        <form class="border-bottom" action="<?=$basePath?>product.php" method="GET">
            <input class="border-0" name="search_query" placeholder="Search products..." type="text">
            <button type="submit"><i class="icofont-search"></i></button>
        </form>
    </div>
    <!--header area end-->

    <style>
    .main_menu nav > ul > li > a {
        color:white !important;
        text-shadow: 2px 2px 0px black; /* Siyah gölge ekler */
    }
</style>
