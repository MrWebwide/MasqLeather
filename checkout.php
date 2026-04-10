
<?php
$basePath = '';
$noExzoom = false;
require_once __DIR__ . '/includes/init.php';
include('functions/calculate_shipping_canada.php');
$_SESSION['maxCargo'] = $maxCargo;

$pageTitle = 'Masq';
$pageDescription = '';
$pageKeywords = '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
<?php include __DIR__ . '/functions/analytics.php'; ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>
<?php include __DIR__ . '/includes/head-css.php'; ?>
<?php include __DIR__ . '/includes/head-js.php'; ?>

    <script src="https://js.stripe.com/v3/"></script>
    <script>window.STRIPE_PK = "<?=STRIPE_PUBLISHABLE_KEY?>";</script>
    <script src="./stripe/checkout.js" defer></script>

    <style>
        #exzoom {
            width: 400px;
        }
        .main_menu nav > ul > li > a{
            Color:rgb(245, 245, 245) !important;
        }
    </style>
</head>
    <body>

 

   
 <!--offcanvas menu area start-->
 <div class="body_overlay">

</div>
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
                                <a href="index.php">Home</a>
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
                                    <li><a href="bagpurses-category.php?kategori=<?= urlencode($adi) ?>">
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
                         FROM urun_kategori AS bk
                         LEFT JOIN urunler AS b ON bk.adi = b.kategori
                         GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
$adi = $hizmetka['adi'];
$urun_sayisi = $hizmetka['urun_sayisi'];

?>
                                <li><a href="bagpurses-category.php?kategori=<?= urlencode($adi) ?>">
                                        <?= $adi ?>
                                    </a></li>
                                <?php } ?>

                            </ul>
                        </li>
                        <li class="menu-item-has-children"><a href="index-2.php" class="ripple-link22">Masq Mercantile</a></li>
                        <li class="menu-item-has-children">
                            <a href="#">blog</a>

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
                        <a href="index.php" class="ripple-link"><img src="assets/img/logo/Artboard 1 copy 6.png"
                                alt=""></a>
                    </div>

                    <!----    <div class="header_logo logo2">
                        <a href="index-2.html" class="ripple-link2" ><img src="assets/img/logo/mercantil.png" alt=""></a>
                    </div> -->
                    <!--main menu start-->
                    <div class="main_menu d-none d-lg-block" style="
                    padding-right: 0cm;
                    padding-top: 25px;
                ">
                        <nav>
                            <ul class="d-flex">
                            <li><a class="active" href="index.php">Home</a></li>
                               
                               <li><a href="bagpurses.php">Bags & Purses</a>
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
                               <li><a href="bagpurses-category.php?kategori=<?= urlencode($adi) ?>"><?= $adi ?></a></li>
                                   <?php } ?>

                                   </ul>
                               </li>
                               <li><a href="accessories.php">Accessories</a>

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
                               <li><a href="accessories-category.php?kategori=<?= urlencode($adi) ?>"><?= $adi ?></a></li>
                                   <?php } ?>
                                      
                                       
                                   </ul>


                               </li>
                               <li><a href="index-2.php" class="ripple-link2">Mercantile</a>
                                 
                               </li>

                               <li><a href="blog.php">blog</a>

                               </li>

                             

                                <li class="shopping_cart custom-margin d-none"><a href="#"><img width="40px"
                                            src="assets/img/animated-icon/shopping-cart.png" alt=""></a></li>
                                            <li class="account_link_menu custom-margin">
                                            <div class="link_container">
                                            <?php if (isset($_SESSION['adsoyad'])) : ?>
        <a href="#.php">
            <div class="flex-container">
                <div class="icon_container">
                    <img width="50px" src="assets/img/animated-icon/account.png" alt="">
                </div>
                <div class="text_container">
                    <span><?php echo $_SESSION['adsoyad']; ?></span>
                </div>
            </div>
        </a>
        <?php
// Kullanıcı giriş yapmışsa dropdown menüyü görüntüleyin
if (isset($_SESSION['adsoyad'])) {
    echo '<div class="dropdown_menu">';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="./account/address-details.php">Saved Address</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    echo '<a href="./account/recent-orders.php">Recent Orders</a>';
    echo '</div>';
    echo '<div class="dropdown_menu_item">';
    // Önceki sayfanın URL'sini hidden input ile alın
    echo '<form action="auth/cikis.php" method="post">';
    echo '<input type="hidden" name="previous_page" value="' . $_SERVER['REQUEST_URI'] . '">';
    echo '<button type="submit">Log-Out</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}
?> 
    <?php else : ?>
        <a href="#">
            <div class="flex-container">
                <div class="icon_container">
                    <img width="50px" src="assets/img/animated-icon/account.png" alt="">
                </div>
                <div class="text_container">
                    <span>Checkout</span>
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
                <img width="50px" src="assets/img/animated-icon/account.png" alt="">
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
echo '<div class="text_container" style="padding-bottom:10px;">';
echo '<span>Checkout</span>';
echo '</div>';
echo '</div>';
}
?>
    </a>

    <?php
// Kullanıcı giriş yapmışsa dropdown menüyü görüntüleyin
if (isset($_SESSION['adsoyad'])) {


}
?>
</div>
</li>
<li class="shopping_cart custom-margin d-none" style="list-style-type: none;"><a href="#"
    style="margin-right: 5px;"><img width="40px"
        src="assets/img/animated-icon/shopping-cart.png" alt=""></a></li>
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

// Eğer kullanıcının sepeti boşsa, mesajı Showin
if ($stmt->rowCount() == 0) {
    echo "Your cart is empty.";
} else {
    // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
    $groupedItems = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['UrunID'];
        $productName = $row['UrunAdi'];
        $productQuantity = $row['UrunMiktari'];
        $productPrice = $row['UrunFiyati'];
        $productImage = $row['urun_resim'];
        $productCategory = $row['urun_category']; // Ürünün kategorisini alın
        $producttur = $row['tur']; // Ürünün kategorisini alın


        // Categoriese göre gruplanmış ürünleri diziye ekleyin
        if (!isset($groupedItems[$productCategory])) {
            $groupedItems[$productCategory] = [];
        }

        // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
        $found = false;
        foreach ($groupedItems[$productCategory] as &$item) {
            if ($item['id'] === $productId) {
                $item['quantity'] += $productQuantity;
                $item['totalPrice'] += $productPrice * $productQuantity;
                $found = true;
                break;
            }
        }

        // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
        if (!$found) {
            $groupedItems[$productCategory][] = [
                'id' => $productId,
                'name' => $productName,
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'totalPrice' => $productPrice * $productQuantity,
                'image' => $productImage,
                'tur' => $producttur,
            ];
        }
    }

   // Categoriese göre gruplanmış ürünleri listeleyin
   foreach ($groupedItems as $category => $products) {
    
  

    foreach ($products as $product) {
        echo '<div class="cart_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '">';
        echo '<div class="cart_img">';
        echo '<a href="#"><img src="admin/resimler/' . $product['image'] . '" alt=""></a>';
        echo '</div>';
        echo '<div class="cart_info">';
        echo '<div class="close-sec d-flex">';
        echo ' <a href="#">' . $product['name'] . '</a>';
        echo '<a href="#" class="delete_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '"  style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
        echo ' </div>';
        echo '    <p>' . $product['quantity'] . ' x <span> $' . $product['price'] . '</span></p>';
        echo '  </div>';
        echo '  <div class="cart_remove">';
        echo '    <a href="#"><i class="icon-close icons"></i></a>';
        echo '  </div>';
        echo '</div>';

        // Product Pricenı toplam fiyata ekleyin
        $totalPrice += $product['totalPrice'];
    }
}



}

// Toplam fiyatı ekrana yazdırın
echo '<div class="cart_total" id="subTotal">';
echo '  <span>Sub total:</span>';
echo '  <span class="price" id="subtotal-price">$' . number_format($totalPrice, 2) . '</span>';
echo '</div>';
} else {
    
    
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
        // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
        $groupedItems = [];

        foreach ($cart as $productId => $product) {
            $productName = $product['name'];
            $productQuantity = $product['quantity'];
            $productPrice = $product['price'];
            $productImage = $product['image'];
            $productCategory = $product['category']; // Ürünün kategorisini alın
            $producttur = $product['tur']; // Ürünün türünü alın

            // Categoriese göre gruplanmış ürünleri diziye ekleyin
            if (!isset($groupedItems[$productCategory])) {
                $groupedItems[$productCategory] = [];
            }

            // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
            $found = false;
            foreach ($groupedItems[$productCategory] as &$item) {
                if ($item['id'] === $productId) {
                    $item['quantity'] += $productQuantity;
                    $item['totalPrice'] += $productPrice * $productQuantity;
                    $found = true;
                    break;
                }
            }

            // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
            if (!$found) {
                $groupedItems[$productCategory][] = [
                    'id' => $productId,
                    'name' => $productName,
                    'quantity' => $productQuantity,
                    'price' => $productPrice,
                    'totalPrice' => $productPrice * $productQuantity,
                    'image' => $productImage,
                ];
            }
        }

        // Categoriese göre gruplanmış ürünleri listeleyin
        foreach ($groupedItems as $category => $products) {
            foreach ($products as $product) {
                $updatedCartContent .= '<div class="cart_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '">';
                $updatedCartContent .= '<div class="cart_img">';
                $updatedCartContent .= '<a href="#"><img src="admin/resimler/' . $product['image'] . '" alt=""></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '<div class="cart_info">';
                $updatedCartContent .= '<div class="close-sec d-flex">';
                $updatedCartContent .= '<a href="' . $producttur . '-detail.php?id=' . $product['id'] . '">' . $product['name'] . '</a>';
                $updatedCartContent .= '<a href="#" class="delete_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '" style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '<p>' . $product['quantity'] . ' x <span> $' . $product['price'] . '</span></p>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '<div class="cart_remove">';
                $updatedCartContent .= '<a href="#"><i class="icon-close icons"></i></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '</div>';

                // Product Pricenı toplam fiyata ekleyin
                $totalPrice += $product['totalPrice'];
            }
        }

        // Toplam fiyatı ekrana yazdırın
        $updatedCartContent .= '<div class="cart_total">';
        $updatedCartContent .= '<span>Sub total:</span>';
        $updatedCartContent .= '<span class="price">$' . number_format($totalPrice, 2) . '</span>';
        $updatedCartContent .= '</div>';
    }

  

    

    return $updatedCartContent;
}




echo "<script>";
echo "var adsoyad = '" . addslashes($adsoyad) . "';"; // addslashes ile özel karakterlere karşı koruma
echo "</script>";

?>


        </div>
    </div>
    <div class="mini_cart_footer">
        <div class="cart_button">
            <a href="cart.php"><i class="fa fa-shopping-cart"></i> View cart</a>
        </div>
        
    </div>
</div>
<!--mini cart end-->

<!--header area end-->

  <!--breadcrumbs area start-->
  <div class="breadcrumbs_area breadcrumbs_other">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content text-center">
                  
                    <h3>checkout</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->




<!--Checkout page section-->
<div class="checkout_section" id="accordion">
   <div class="container">
  
        <div class="checkout_form">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                <form action="functions/control.php" method="post">
                        <h3>Shipping Address Details</h3>
                        <h4 style="font-weight: 700; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">(Please fill all of the fields for a successful shipment) </h4>
                        <?php
// Önce $adsoyad değişkenini güvenli hale getirin (örneğin htmlspecialchars kullanarak)
$adsoyad = htmlspecialchars($adsoyad);

// Veritabanından 'useraddress' tablosunu sorgula
$stmt = $db->prepare("SELECT COUNT(*) AS count FROM useraddress WHERE adsoyad = :adsoyad");
$stmt->bindParam(':adsoyad', $adsoyad);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// 'useraddress' tablosunda $adsoyad değeri varsa veya yoksa koşullarını kontrol et
if ($row['count'] > 0) {
    // Eğer $adsoyad değeri 'useraddress' tablosunda varsa, seçim kutusunu göster
?>
<div class="checkout_form_input">
    <h3 for="country" style="color: brown; margin: 5px;">Saved Address:</h3>
    <select class="select_option"  name="saved_address" id="saved_address">
        <option value="1">Select Address</option>
        <option value="2">
            <?php
            // 'useraddress' tablosundan kullanıcının adını al
            $addressNameStmt = $db->prepare("SELECT addname FROM useraddress WHERE adsoyad = :adsoyad");
            $addressNameStmt->bindParam(':adsoyad', $adsoyad);
            $addressNameStmt->execute();
            $addressName = $addressNameStmt->fetchColumn();

            // 'addname' değerini seçenek olarak yazdır
            echo htmlspecialchars($addressName);
            ?>
        </option>
        
    </select>
</div>
<script>
$(document).ready(function() {
    $('#saved_address').change(function() {
        var selectedValue = $(this).val(); // Seçilen option değeri (1, 2 veya 3)

        if (selectedValue == 1) {
            // Eğer option 1 seçildiyse, tüm form alanlarını temizle
            clearFormFields();
        } else {
            // Diğer durumlarda AJAX isteği gönder
            $.ajax({
                url: './functions/get_address_data.php',
                type: 'GET',
                data: { adsoyad: adsoyad },
                success: function(data) {
                    // AJAX isteği başarılıysa, verileri form alanlarına doldur
                    $('input[name="addname"]').val(data.addname);
                    $('input[name="name"]').val(data.name);
                    $('input[name="surname"]').val(data.surname);
                    $('textarea[name="address"]').val(data.address);
                    $('input[name="city"]').val(data.city);
                    $('input[name="province"]').val(data.province);
                    $('input[name="postal"]').val(data.postal);
                    $('input[name="phone"]').val(data.phone);
                    $('input[name="email"]').val(data.email);

                    // Ülke bilgisine göre seçili option'u belirle
                    var countryValue = data.country;

                    // Ülke bilgisine göre doğru option'u seçili hale getir
                    if (countryValue == 2) {
                        $('select[name="country"]').val('2'); // Canada seçeneğini seçili yap
                    } else if (countryValue == 3) {
                        $('select[name="country"]').val('3'); // United States seçeneğini seçili yap
                    }
                    
    var countryText = "";

    if (countryValue == 2) {
        countryText = "Canada";
    } else if (countryValue == 3) {
        countryText = "United States";
    }

    // 'current' class'ına sahip span elementinin metnini güncelle
    $('.cenk').find('.current').text(countryText);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }
    });

    // Form alanlarını temizleyen yardımcı fonksiyon
    function clearFormFields() {
        $('input[name="addname"]').val('');
        $('input[name="name"]').val('');
        $('input[name="surname"]').val('');
        $('textarea[name="address"]').val('');
        $('input[name="city"]').val('');
        $('input[name="province"]').val('');
        $('input[name="postal"]').val('');
        $('input[name="phone"]').val('');
        $('input[name="email"]').val('');
        $('select[name="country"]').val('1'); // Select Country seçeneğini seçili hale getir

        $('.cenk').find('.current').text('Select Country');

    }
});


</script>

<?php
} // 'useraddress' tablosunda $adsoyad değeri yoksa, bu kısım görüntülenmez

?>



<style>
    .with-tax span {
    font-size: 12px;
    color: black !important;
    font-weight: bold;
}

.tax-included{
    display: block;
    margin-top: 5px;
}

</style>

<?php if(isset($_SESSION['id'])) { ?>

                        <div class="checkout_form_input">   
                            <label>Address Name<span>*</span></label>
                            <input type="text" name="addname" required>
                        </div>
<?php } ?>
                        <div class="checkout_form_input">
                            <label for="country">Country <span>*</span></label>
                            <select class="select_option cenk" name="country" id="country" >
                                <option value="1">Select Country</option>
                                <option value="2">Canada</option>
                                <option value="3">United States</option>
                            </select>
                            
                        </div>



              

                        <div id="eyalet" class="checkout_form_input">
    <label for="province">Province <span>*</span></label>
    <select class="select_option cenk" id="issiot" name="province" required>
        <option value="USA">Select Province</option>
        <option value="AB">Alberta</option>
        <option value="BC">British Columbia</option>
        <option value="MB">Manitoba</option>
        <option value="NB">New Brunswick</option>
        <option value="NL">Newfoundland and Labrador</option>
        <option value="NS">Nova Scotia</option>
        <option value="ON">Ontario</option>
        <option value="PE">Prince Edward Island</option>
        <option value="QC">Quebec</option>
        <option value="SK">Saskatchewan</option>
        <option value="NT">Northwest Territories</option>
        <option value="NU">Nunavut</option>
        <option value="YT">Yukon</option>
    </select>
</div>





                       
                        <div class="checkout_form_input">
                            <label>First Name <span>*</span></label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="checkout_form_input">
                            <label>Last Name <span>*</span></label>
                            <input type="text" name="surname" required><br>
                        </div>
                           <div class="checkout_form_input">
                            <label id="province_label">City <span>*</span></label>
                            <input type="text" name="city" required><br>
                        </div>
                        <div class="checkout_form_input">
                            <label>Address <span>*</span></label>
                            <textarea type="text" name="address" required></textarea>
                        </div>
                        
                     
                      
                        <div class="checkout_form_input">
                            <label id="postal_code_label">Postal Code <span>*</span></label>
                            <input type="text" name="postal" required>
                        </div>
                        <div class="checkout_form_input">
                            <label>Phone <span>*</span></label>
                            <input type="text" name="phone" required>
                        </div>
                        <div class="checkout_form_input">
                            <label>Email <span>*</span></label>
                            <input type="text" name="email" required>
                        </div>
                     
                        <input type="hidden" name="adsoyad" value="<?php $adsoyad ?>">
                       
                        <?php if(isset($_SESSION['id'])) { ?>
                        <input type="hidden" name="userid" value="<?php echo $userId; ?>">

                        <?php }?>

                        <input type="hidden" name="cart" id="cart" value='<?php echo json_encode($groupedItems); ?>'>
                        <input type="hidden" name="accessories_cart" id="accessories_cart" value='<?php echo json_encode($groupedItems); ?>'>
                        <input type="hidden" name="jewelry_cart" id="jewelry_cart" value='<?php echo json_encode($groupedItems); ?>'>
                        <input type="hidden" name="homedecor_cart" id="homedecor_cart" value='<?php echo json_encode($groupedItems); ?>'>
                        
                        <input type="hidden" name="siparis" id="siparis" value='<?php echo json_encode($groupedItems); ?>'>

                        <div class="checkout_form_input">
                            <input type="checkbox" id="campaign" checked>
                            <label for="campaign">I would like to receive e-mails about future sales and campaigns.</label>
                        </div>
                        <div class="checkout_form_input">
                            <input type="checkbox" id="billing_address_checkbox">
                            <label for="billing_address_checkbox">I want my billing address to be different from my order address.</label>
                        </div>

                         
                            <div class="billing">
                            <h3>Billing Address Details</h3>
                          

                            <div class="checkout_form_input">
                                <label>First Name <span>*</span></label>
                                <input type="text" name="namebill" required>
                            </div>
                            <div class="checkout_form_input">
                                <label>Last Name <span>*</span></label>
                                <input type="text" name="surnamebill" required>
                            </div>
                            <div class="checkout_form_input">
                                <label>Address <span>*</span></label>
                                <textarea type="text" name="addressbill" ></textarea>
                            </div>
                            <div class="checkout_form_input">
                                <label >City <span>*</span></label>
                                <textarea type="text" name="citybill" ></textarea>
                            </div>
                            <div class="checkout_form_input">
                                <label id="province_label">Province / State <span>*</span></label>
                                <textarea type="text" name="provincebill" ></textarea>
                            </div>
                            <div class="checkout_form_input">
                                <label id="postal_code_label">Postal Code / Zip Code <span>*</span></label>
                                <textarea type="text" name="postalbill" ></textarea>
                            </div>
                        </div>
                      

                     
                    
                       
                     

                        
                    
                </div>
                <script>
                    $(document).ready(function() {
                        // Ülke seçeneği değiştiğinde bu işlev çağrılacak
                        $("#country").change(function() {
                            var selectedCountry = $(this).val();
                            var provinceLabel = $("#province_label");
                            var postalCodeLabel = $("#postal_code_label");
                            var eyalet =$("#eyalet")
            
                            if (selectedCountry === "2") { // Kanada seçildiğinde
                                
                                provinceLabel.text("City");
                                postalCodeLabel.text("Postal Code *");
                                eyalet.show(); // Görünürlüğü kapatmak için
                                

                            } else if (selectedCountry === "3") { // Amerika seçildiğinde
                                provinceLabel.text("State and City");
                                postalCodeLabel.text("Zip Code *");
                                eyalet.hide(); // Görünürlüğü kapatmak için

                            }
                        });

                        
                    });

                 


                    // BILLING CHECKBOX FUNCTION

                    $(document).ready(function() {
    // Checkbox durumuna göre fatura adresi bölümünü Show veya gizle
    $("#billing_address_checkbox").change(function() {
        if (this.checked) {
            $(".billing").show(); // Checkbox işaretlendiğinde fatura bölümünü Show
        } else {
            $(".billing").hide(); // Checkbox işareti kaldırıldığında fatura bölümünü gizle
        }
    });

    // Sayfa yüklendiğinde fatura bölümünü gizle
    $(".billing").hide();
});
                </script>
                <div class="col-lg-5 col-md-6">
                    <div class="order_table_right">
                        <form action="#">
                            <h3>Your order</h3>
                            <div class="order_table table-responsive">
                         
                            
<?php
                            $userId = null;
$totalPrice = 0;
$groupedItems = [];

// Kullanıcı oturumda mı kontrol edin
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['UrunID'];
        $productQuantity = $row['UrunMiktari'];
        $productPrice = $row['UrunFiyati'];
        $productCategory = $row['urun_category'];
        $productName = $row['UrunAdi']; // Ürün adı ekleme
        $productImage = $row['urun_resim']; // Ürün resmi ekleme
        $productCargo = $row['cargo']; // Ürün kargo ücreti ekleme

        // Categoriese göre gruplanmış ürünleri diziye ekleyin
        if (!isset($groupedItems[$productCategory])) {
            $groupedItems[$productCategory] = [];
        }

        // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
        $found = false;
        foreach ($groupedItems[$productCategory] as &$item) {
            if ($item['id'] === $productId) {
                $item['quantity'] += $productQuantity;
                $item['totalPrice'] += $productPrice * $productQuantity;
                $found = true;
                break;
            }
        }

        // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
        if (!$found) {
            $groupedItems[$productCategory][] = [
                'id' => $productId,
                'name' => $productName,
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'totalPrice' => $productPrice * $productQuantity,
                'image' => $productImage,
                'cargo' => $productCargo,
            ];
        }

        // Toplam fiyatı güncelleyin
        $totalPrice += $productPrice * $productQuantity;

        // Kupon fiyatı oturum değişkeni başlangıçta 0 olarak ayarlanır
$cuponFiyat = 0;
$giftfiyat = 0;

if (isset($_SESSION['cupon_fiyat'])) {
    $cuponFiyat = $_SESSION['cupon_fiyat'];
}

if (isset($_SESSION['gift_card_amount'])) {
    $giftfiyat = $_SESSION['gift_card_amount'];
}

$cupon = ($totalPrice * $cuponFiyat) / 100;
// Kupon fiyatını toplam fiyattan çıkartın
$totalsubAmount = $totalPrice - $cupon;
$totalAmount1 = $totalsubAmount + $maxCargo;

if ($totalAmount1 < 0) {
    $totalAmount1 = 0;
}

$totalAmount = $totalAmount1 - $giftfiyat;
if ($totalAmount < 0) {
    $totalAmount = 0;
}
$_SESSION['totalAmount'] = number_format($totalAmount, 2);

    }
} else {
    
    // Kullanıcı oturumda değilse, sepet verilerini noid oturumundan al
    session_name('noid');
    session_start();
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $item) {
            $productQuantity = $item['quantity'];
            $productPrice = $item['price'];
            $productCategory = $item['category'];
            $productName = $item['name']; // Ürün adı
            $productImage = $item['image']; // Ürün resmi
            $productCargo = $item['cargo']; // Ürün kargo ücreti

            // Categoriese göre gruplanmış ürünleri diziye ekleyin
            if (!isset($groupedItems[$productCategory])) {
                $groupedItems[$productCategory] = [];
            }

            // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
            $found = false;
            foreach ($groupedItems[$productCategory] as &$cartItem) {
                if ($cartItem['id'] === $productId) {
                    $cartItem['quantity'] += $productQuantity;
                    $cartItem['totalPrice'] += $productPrice * $productQuantity;
                    $found = true;
                    break;
                }
            }

            // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
            if (!$found) {
                $groupedItems[$productCategory][] = [
                    'id' => $productId,
                    'name' => $productName,
                    'quantity' => $productQuantity,
                    'price' => $productPrice,
                    'totalPrice' => $productPrice * $productQuantity,
                    'image' => $productImage,
                    'cargo' => $productCargo,
                ];
            }

            // Toplam fiyatı güncelleyin
            $totalPrice += $productPrice * $productQuantity;
        }
    }
    // Kupon fiyatı oturum değişkeni başlangıçta 0 olarak ayarlanır
$cuponFiyat = 0;
$giftfiyat = 0;

if (isset($_SESSION['cupon_fiyat'])) {
    $cuponFiyat = $_SESSION['cupon_fiyat'];
}

if (isset($_SESSION['gift_card_amount'])) {
    $giftfiyat = $_SESSION['gift_card_amount'];
}

$cupon = ($totalPrice * $cuponFiyat) / 100;
// Kupon fiyatını toplam fiyattan çıkartın
$totalsubAmount = $totalPrice - $cupon;
$totalAmount1 = $totalsubAmount + $maxCargo;

if ($totalAmount1 < 0) {
    $totalAmount1 = 0;
}

$totalAmount = $totalAmount1 - $giftfiyat;
if ($totalAmount < 0) {
    $totalAmount = 0;
}
$_SESSION['huso'] = number_format($totalAmount, 2);
  
}



?>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groupedItems as $category => $products) {
            foreach ($products as $product) {
                ?>
                <tr>
                    <td><?php echo $product['name'] . ' x ' . $product['quantity']; ?></td>
                    <td class="text-right">$<?php echo number_format($product['totalPrice'], 2); ?></td>
                </tr>
                <?php
            }
        } ?>
    </tbody>
    <tfoot>

    
    

    <?php     
    
    
    
 
    ?>
        <tr>
            <td>Cart Subtotal</td>
            <td class="text-right">$<?php echo number_format($totalPrice, 2); ?></td>
        </tr>
        <?php if ($cuponFiyat !== 0) { ?>
            <tr>
                <td>Coupon</td>
                <td class="text-right">- %<?php echo number_format($cuponFiyat, 2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td id="shipping-label">Shipping </td>
            <td id="shipping_id" class="text-right">$<?php echo number_format($maxCargo, 2); ?></td>
        </tr>
        <?php if ($giftfiyat !== 0) { ?>
            <tr>
                <td>Gift Card </td>
                <td class="text-right">- $<?php echo number_format($giftfiyat, 2); ?></td>
            </tr>
        <?php } ?>
        <tr class="order_total" id="order_total_id">
            <th>Order Total</th>
            <td id="order_id" class="text-right">$<?php echo number_format($totalAmount, 2); ?></td>
        </tr>
    </tfoot>
</table>

<input type="hidden" name="cargo_transfer" id="cargo_transfer" value="<?php echo $maxCargo; ?>">



      





                                <div class="panel-default">
                                    <p style="text-align:center; color:red;"></p>
                                </div>
                             
                               
                             
                            </div>
                           
                            <div class="order-button">
                            <button class="order" type="submit" id="submit-button">
                                    <span class="default">Proceed to Payment</span>
                                    <span class="success">Order Placed
                                        <svg viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <div class="box"></div>
                                    <div class="truck">
                                        <div class="back"></div>
                                        <div class="front">
                                        <div class="window"></div>
                                        </div>
                                        <div class="light top"></div>
                                        <div class="light bottom"></div>
                                    </div>
                                    <div class="lines"></div>
                                    </button>
                                </div>
                                  <script>
                                    $('.order').click(function(e) {
                    
                    let button = $(this);
                    
                    if(!button.hasClass('animate')) {
                        button.addClass('animate');
                        setTimeout(() => {
                            button.removeClass('animate');
                        }, 10000);
                    }
                    
                    });



                    
                                  </script>

                                  

                        </form>
                        <?php
$taxRates = [
    'AB' => 5, 'BC' => 5, 'MB' => 5,
    'NB' => 15, 'NL' => 15, 'NS' => 15,
    'ON' => 13, 'PE' => 15, 'QC' => 5,
    'SK' => 5, 'NT' => 5, 'NU' => 5, 'YT' => 5,
];
?>

<script>
$(document).ready(function() {
    // Ülke seçeneği değiştiğinde bu işlev çağrılacak
    $("#issiot").change(function() {
        console.log("Province selection changed.");
        
        // Vanilla JavaScript kodu buraya entegre ediliyor
        const taxRates = <?php echo json_encode($taxRates); ?>;
        const baseAmount = <?php echo isset($totalAmount) ? json_encode($totalAmount) : 0; ?>;

        console.log("Tax rates:", taxRates);
        console.log("Base order total:", baseAmount);

        const province = $(this).val();
        console.log("Selected province:", province);

        const orderTotalElement = document.getElementById('order_id');
        const orderTotalRow = document.getElementById('order_total_id');

        if (taxRates[province]) {
            const taxRate = taxRates[province];
            console.log("Tax rate for selected province:", taxRate);

            const taxAmount = (baseAmount * taxRate) / 100;
            console.log("Calculated tax amount:", taxAmount);

            const newTotal = baseAmount + taxAmount;
            console.log("New order total (with tax):", newTotal);

            if (orderTotalElement && orderTotalRow) {
                orderTotalElement.innerHTML = `$${newTotal.toFixed(2)} <span class="tax-included">(+ ${taxRate}% GST/HST Tax added)</span>`;
                orderTotalRow.classList.add('with-tax');
            }
        } else {
            console.log("No tax rate found for the selected province.");
            if (orderTotalElement && orderTotalRow) {
                orderTotalElement.innerHTML = `$${baseAmount.toFixed(2)}`;
                orderTotalRow.classList.remove('with-tax');
            }
        }
    });
});
</script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Checkout page section end-->







    <!-- footer section start -->
    <?php include("./layout/footer.php");?>
    <!-- footer section end -->

    <?php
    $pageInlineJS = '';
    // Initialize (Stripe/checkout related)
    $pageInlineJS .= "<script>initialize();</script>\n";
    // Exzoom init
    $pageInlineJS .= <<<'JSEOF'
<script>
$('.container').imagesLoaded(function () {
    $("#exzoom").exzoom({ autoPlay: false });
    $("#exzoom").removeClass('hidden');
});
</script>
JSEOF;
    // Flash message auto-hide
    $pageInlineJS .= <<<'JSEOF'
<script>
setTimeout(function () { var m = document.querySelector('.message'); if (m) { m.style.display = 'none'; } }, 6000);
</script>
JSEOF;
    // Add-to-cart button animation
    $pageInlineJS .= <<<'JSEOF'
<script>
$(document).ready(function () {
    function handleButtonClick(event) {
        event.stopPropagation();
        var $btnWrapper = $(this).closest('.btn-wrapper');
        $btnWrapper.addClass('add');
        setTimeout(function () { $btnWrapper.removeClass('add'); }, 2200);
    }
    $('.add-to-cart').on('click touchstart', handleButtonClick);
});
</script>
JSEOF;
    // Form submit + country validation
    $pageInlineJS .= <<<'JSEOF'
<script>
$(document).ready(function() {
    $('#submit-button').click(function(e) { $('form').submit(); });
});
document.getElementById('submit-button').addEventListener('click', function(event) {
    var countrySelect = document.getElementById('country');
    var selectedCountry = countrySelect.options[countrySelect.selectedIndex].value;
    if (selectedCountry == "1") {
        event.preventDefault();
        alert("Please select a country before proceeding to payment.");
        location.reload();
    }
});
</script>
JSEOF;
    include __DIR__ . '/includes/footer-scripts.php';
    ?>

</body>
</html>
