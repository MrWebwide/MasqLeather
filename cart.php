
<?php
$basePath = '';
$noExzoom = false;
require_once __DIR__ . '/includes/init.php';

$id = $_GET['id'];

// Veritabanından ilgili id'ye sahip ürünün verilerini çek
$stmt = $db->prepare("SELECT * FROM urunler WHERE id = ?");
$stmt->execute([$id]);
$urunler = $stmt->fetch();

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

    <style>
        #exzoom {
            width: 400px;
        }
        .main_menu nav > ul > li > a{
            Color:rgb(245, 245, 245) !important;
        }
        #message-container p{
            color:red;
            font-weight:700;
            font-size: larger;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>
<body class="exclude-script">

<div class="body_overlay"></div>
    
<?php include __DIR__ . '/layout/header-2.php'; ?>

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area breadcrumbs_other">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                      
                        <h3>Shopping Cart</h3>
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

     <!--shopping cart area start -->
    <div class="shopping_cart_area">
        <div class="container">
        
                <div class="cart_page_inner mb-60">
                    <div class="row">
                        <div class="col-12">
                            <div class="cart_page_tabel">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>product </th>
                                            <th>information</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
                           

                                    <?php


function getCartContentFromSession() {
    session_name('noid');
    session_start();

    // Sepet oturumda yoksa boş bir dizi oluşturun
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    session_write_close(); // Oturumu kapat

    return $cart;
}

$hasInsufficientStock = false; // Yetersiz stok var mı kontrol eden bir bayrak
$outOfStockProducts = array(); // Stoğu biten ürünleri tutacak dizi

// Kontrol edilecek tabloların adları
$tables = array('jewe', 'accessories', 'urunler', 'homedecor');

if (isset($_SESSION['id'])) {
    // Kullanıcı giriş yapmışsa, sepet verilerini veritabanından alın
    $userId = $_SESSION['id'];

    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

    // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
    $groupedItems = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['UrunID'];
        $productName = $row['UrunAdi'];
        $productQuantity = $row['UrunMiktari'];
        $productPrice = $row['UrunFiyati'];
        $productImage = $row['urun_resim'];
        $productCategory = $row['urun_category'];
        $producttur = $row['tur'];

        // Categoriese göre gruplanmış ürünleri diziye ekleyin
        if (!isset($groupedItems[$productCategory])) {
            $groupedItems[$productCategory] = [];
        }

        // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
        $found = false;
        foreach ($groupedItems[$productCategory] as &$item) {
            if ($item['id'] === $productId && $item['name'] === $productName) {
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
} else {
    // Kullanıcı giriş yapmamışsa, sepet verilerini oturumdan alın
    $groupedItems = [];

    $cart = getCartContentFromSession();
    foreach ($cart as $productId => $product) {
        $productName = $product['name'];
        $productQuantity = $product['quantity'];
        $productPrice = $product['price'];
        $productImage = $product['image'];
        $productCategory = $product['category'];
        $producttur = $product['tur'];

        // Categoriese göre gruplanmış ürünleri diziye ekleyin
        if (!isset($groupedItems[$productCategory])) {
            $groupedItems[$productCategory] = [];
        }

        // Eğer aynı ürün daha önce eklenmişse, miktarı artırın
        $found = false;
        foreach ($groupedItems[$productCategory] as &$item) {
            if ($item['id'] === $productId && $item['name'] === $productName) {
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
}

foreach ($groupedItems as $category => $products) {
    foreach ($products as $product) {
        $foundStock = false; // Stok bulundu mu kontrol eden bayrak
        
        // Her tablo için döngü
        foreach ($tables as $table) {
            // Ürünü bulmak için sorgu hazırla
            $stmt = $db->prepare("SELECT stock FROM $table WHERE id = ? AND adi = ?");
            $stmt->execute([$product['id'], $product['name']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Eğer stok bulunduysa, bayrağı ayarla ve stoku güncelle
            if ($row) {
                $foundStock = true;
                $productStock = $row['stock'];
                break; // Döngüyü sonlandır
            }
        }
        
        // Eğer stok bulunamadıysa, hata mesajı göster
        if (!$foundStock) {
            echo '<p>Stok bulunamadı: ' . $product['name'] . '</p>';
            continue; // Sonraki ürüne geç
        }
        
        // Stok kontrolü yapılıyor
        if ($product['quantity'] > $productStock) {
            $hasInsufficientStock = true; // Yetersiz stok varsa bayrağı ayarla
            $outOfStockProducts[] = $product['name']; // Stoğu biten ürünü listeye ekle
        }

        // Ürünleri listeleme işlemi devam ediyor
        echo '<tr class="border-top">';
        echo '<td>';
        echo '<div class="cart_product_thumb">';
        echo '<img src="admin/resimler/' . $product['image'] . '" alt="">';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="cart_product_text">';
        echo '<a href="' . $producttur . '-detail.php?id=' . $product['id'] . '"><h4>' . $product['name'] . '</h4></a>';
        echo '<ul>';
        echo '<li><i class="ion-ios-arrow-right"></i> Category : <span>' . $category . '</span></li>';
        echo '</ul>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="cart_product_price">';
        echo '<span>' .'$'  . $product['price'] . '</span>';
        echo '</div>';
        echo '</td>';
        echo '<td class="product_quantity">';
        echo '<div class="cart_product_quantity">';
        echo '<p>' . $product['quantity'] . '</p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="cart_product_price">';
        echo '<span>' .'$'. number_format($product['totalPrice'], 2) . '</span>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="cart_product_remove text-right">';
        echo '<a href="#" <a href="#" class="delete_item_cart" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '"  "><i class="ion-android-close"></i></a>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
}

// Stoğu yetersiz ürünleri listele


// Güncelleme işlemi
?>


</tbody>


<div class="outstock" <?php echo $hasInsufficientStock ? '' : 'style="display:none;"'; ?>>
    <p class="outstock1" style="padding-right: 20px; padding-left: 20px">There is not enough stock of the products listed below in your cart. When you press "Proceed", your cart will be updated with the maximum stock of those products.</p>
    <?php if ($hasInsufficientStock): ?>
        <?php foreach ($outOfStockProducts as $productName): ?>
           <strong> <p class="outstockitems"><?php echo $productName; ?></p> </strong>
        <?php endforeach; ?>
    <?php endif; ?>
    <form method="POST" action="./functions/outofstock.php">
        <div class="shopping_continue_btn">
    <button type="submit" name="updateStock" class="btn btn-primary outstockbutton">Proceed</button>
    </div>
        </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var outstockDiv = document.querySelector('.outstock');
        if (outstockDiv && outstockDiv.style.display !== 'none') {
            var bodyOverlay = document.querySelector('.body_overlay');
            if (bodyOverlay) {
                bodyOverlay.classList.add('active');
            }

            // Tüm butonları seç ve "Proceed" butonu haricindeki butonları devre dışı bırak
            var buttons = document.querySelectorAll('button');
            buttons.forEach(function(button) {
                if (!button.classList.contains('outstockbutton')) {
                    button.disabled = true;
                }
            });
        }
    });
</script>
 

                                
                             <script>
                                $(document).ready(function() {
    // Sayfa yüklendiğinde ve her click olayında kontrol edilir
    checkEmptyTable();

    $(".delete_item_cart").on("click", function(event) {
        // Silme işlemi gerçekleştiğinde de kontrol edilir
        checkEmptyTable();
    });
});

function checkEmptyTable() {
    // tbody içindeki tr sayısını kontrol eder
    if ($("tbody tr").length === 0) {
        // tbody boş ise message-container3 divini göster
        $("#message-container3").html("This cart is empty.").show().css({
            "padding-top": "2cm",
            "padding-bottom": "2cm",
            "text-align": "center"
        });
    }
}

                             </script>

                             
                                </table>
                        
                                <div style="font-size:28px; font-weight:500;" id="message-container3">
                                    
                                    </div>
                        
                            </div>
                            <div class="cart_page_button border-top d-flex justify-content-between">
                                <div class="shopping_cart_btn">
                                    <a href="#" class="btn btn-primary border delete_item_cart_all">CLEAR SHOPPING CART</a>
                                   
                                </div>
                                <div class="shopping_continue_btn">
                                    <button class="btn btn-primary" onclick="window.location.href='index.php'">CONTINUE SHOPPING</button>
                                </div>
                            </div>
                         </div>
                     </div>
                 </div>
                 <!--coupon code area start-->
                <div class="cart_page_bottom">
                    <div class="row">
                    
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shopping_coupon_calculate">
                                <h3 class="border-bottom">Coupon or Gift Card   </h3>
                               
                                <form action="functions/cupon.php" id="couponf" method="post">
    <input   type="text" name="kupon_kodu" placeholder="Enter your code" class="border" required>
    <div id="message-container">
                                            <!-- AJAX ile güncellenecek alan -->
                                        </div>
    <button class="btn btn-primary" style="background-color: peru; border-color: peru;" type="submit">apply code</button>
 </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8" style="">
                            <div class="grand_totall_area">
                                <div class="grand_totall_inner border-bottom">
                                    
                                <?php
                                

// Kupon fiyatı oturum değişkeni başlangıçta 0 olarak ayarlanır
$cuponFiyat = 0;
$giftfiyat = 0;

if (isset($_SESSION['cupon_fiyat'])) {
    $cuponFiyat = $_SESSION['cupon_fiyat'];
}

if (isset($_SESSION['gift_card_amount'])) {
    $giftfiyat = $_SESSION['gift_card_amount'];
}

// Kullanıcının sepet verilerini alacak değişkenleri tanımlayın
$totalPrice = 0;
$maxCargo = 0; // Başlangıç değeri 0 veya başka bir uygun değer olabilir
$groupedItems = [];

if (isset($_SESSION['id'])) {
    // Kullanıcı giriş yapmışsa, sepet verilerini veritabanından alın
    $userId = $_SESSION['id'];

    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productId = $row['UrunID'];
        $productQuantity = $row['UrunMiktari'];
        $productPrice = $row['UrunFiyati'];
        $productCategory = $row['urun_category'];
        $productCargo = $row['cargo'];

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
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'totalPrice' => $productPrice * $productQuantity,
                'cargo' => $productCargo,
            ];
        }

        // Toplam fiyatı güncelleyin
        $totalPrice += $productPrice * $productQuantity;

        // Eklenen 'cargo' değerini kontrol edin ve en yüksek değeri güncelleyin
        if ($productCargo > $maxCargo) {
            $maxCargo = $productCargo;
        }
    }
} else {
    // Kullanıcı giriş yapmamışsa, sepet verilerini oturumdan alın
    $cart = getCartContentFromSession();

    foreach ($cart as $productId => $product) {
        $productQuantity = $product['quantity'];
        $productPrice = $product['price'];
        $productCategory = $product['category'];
        $productCargo = $product['cargo'];

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
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'totalPrice' => $productPrice * $productQuantity,
                'cargo' => $productCargo,
            ];
        }

        // Toplam fiyatı güncelleyin
        $totalPrice += $productPrice * $productQuantity;

        // Eklenen 'cargo' değerini kontrol edin ve en yüksek değeri güncelleyin
        if ($productCargo > $maxCargo) {
            $maxCargo = $productCargo;
        }
    }
}

if (isset($_SESSION['usedcode']) && $_SESSION['usedcode'] == 1) {
    unset($_SESSION['gift_card_amount']);
    unset($_SESSION['cupon_fiyat']);

    echo '<script>window.location.reload();</script>';
}

$cupon = ($totalPrice * $cuponFiyat) / 100;
// Kupon fiyatını toplam fiyattan çıkartın
$totalsubAmount = $totalPrice - $cupon;
$totalAmount = $totalsubAmount - $giftfiyat;

if ($totalAmount < 0) {
    $totalAmount = 0;
}

unset($_SESSION['usedcode']);
?>

<div class="cart_subtotal d-flex justify-content-between">
    <span>Sub total:</span>
    <span class="price sub-amount">$<?php echo number_format($totalPrice, 2); ?></span>
</div>

<div class="cart_subtotal d-flex justify-content-between">
    <p>Coupon</p>
    <span>%<?php echo number_format($cuponFiyat, 2); ?></span>
</div>

<div class="cart_subtotal d-flex justify-content-between">
    <p>Gift Card</p>
    <span>$<?php echo number_format($giftfiyat, 2); ?></span>
</div>

<div class="cart_grandtotal d-flex justify-content-between">
    <p>Total Amount</p>
    <span class="price total-amount">$<?php echo number_format($totalAmount, 2); ?></span>
</div>
                                </div >
                                <div class="proceed_checkout_btn" >
                                <button class="liq" id="checkoutButton">
    <span>Proceed to Checkout</span>
    <div class="liquid"></div>
</button>

<?php if(isset($_SESSION['id'])){ ?>

    <script>
    document.getElementById("checkoutButton").addEventListener("click", function() {
        window.location.href = "checkout.php";
    });
</script>

    <?php } ?>

<?php if(!isset($_SESSION['id'])){  ?>

<script>
    
    
    
// İlgili butonun elementini al
var checkoutButton = document.getElementById("checkoutButton");

// Butona tıklanınca procall adlı div'i görünür yap
checkoutButton.addEventListener("click", function() {
    var procallDiv = document.querySelector(".procall");
    procallDiv.style.display = "block";

    // Eğer zaten bir kapatma işareti varsa, tekrar oluşturma
    var closeIcon = procallDiv.querySelector(".closeIcon");
    if (!closeIcon) {
        // Kapatma işaretini eklemek için div'i içeren bir span oluştur
        closeIcon = document.createElement("span");
        closeIcon.innerHTML = "&#10006;"; // Bu, HTML'de çarpı sembolünün kodudur
        closeIcon.className = "closeIcon";

        // İçeriğin başına kapatma işaretini ekle
        procallDiv.insertBefore(closeIcon, procallDiv.firstChild);

        // Kapatma işaretine tıklandığında div'i gizle
        closeIcon.addEventListener("click", function() {
            procallDiv.style.display = "none";
        });
    }
});


    </script>

    <style>
        /* Kapatma işareti için CSS */
.closeIcon {
    position: absolute;
    top: 10px; /* İstediğiniz yere göre ayarlayabilirsiniz */
    right: 10px; /* İstediğiniz yere göre ayarlayabilirsiniz */
    cursor: pointer;
    color:white;
    text-shadow: 2px 2px 0px black; /* Siyah gölge ekler */
}


        </style>


<div class="outstock procall" style="display:none">
<p class="outstock1" style="padding-right: 20px; padding-left: 20px;">Are you sure you want to continue without signing up? Discover all the benefits by easily creating an account!</p>
<a href="./auth/signin.php"  class="cacc"><span>Sign in</span></a>
    <a href="./auth/signup.php"  class="cacc"><span>Create an Account</span></a>
  
    <a href="checkout.php" class="pacc"><span>Proceed without an Account</span></a>
</div>






<?php } ?>

<style>

.outstock {
    /* İlgili stil bilgileri */
}

.outstock1 {
    /* İlgili stil bilgileri */
}

.cacc, .pacc {
    display: inline-block;
    text-decoration: none;
    margin-right: 10px; /* İstenirse butonlar arasındaki boşluğu ayarlamak için */
 
}

.cacc span {
    background-color: peru;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    border: 1px solid black;
}

.pacc span {
    background-color: #fff;
    color: peru;
    padding: 10px 20px;
    border-radius: 5px;
    border: 1px solid black;
}

.cacc:hover span, .pacc:hover span {
    opacity: 0.8;
}


    

.liq {
    font: 600 8px consolas;
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    padding: 10px 15px;
    margin-right:1.4cm;
    overflow: hidden;
    border-radius: 5px;
    transition: 0.2s;
	transform: scale(2);
}

.liq span {
    position: relative;
    z-index: 0;
    color: #fff;
}

.liq .liquid {
    position: absolute;
    top: -40px;
    left: 0;
    width: 100%;
    height: 200px;
    background: peru;
    box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.7);
    z-index: -1;
    transition: 0.6s;
}

.liq .liquid::after,
.liq .liquid::before {
    position: absolute;
    content: "";
    width: 200%;
    height: 200%;
    top: 0;
    left: 0;
    transform: translate(-25%, -75%);
}

.liq .liquid::after {
    border-radius: 45%;
    background: rgba(20, 20, 20, 1);
    box-shadow: 0 0 10px 5px rgb(250, 183, 117), inset 0 0 5px rgb(255, 187, 119);
    animation: animate 5s linear infinite;
    opacity: 0.8;
}

.liq .liquid::before {
    border-radius: 40%;
    box-shadow: 0 0 10px rgba(26, 26, 26, 0.5),
        inset 0 0 5px rgba(26, 26, 26, 0.5);
    background: rgba(26, 26, 26, 0.5);

    animation: animate 7s linear infinite;
}

@keyframes animate {
    0% {
        transform: translate(-25%, -75%) rotate(0);
    }
    100% {
        transform: translate(-25%, -75%) rotate(360deg);
    }
}
.liq:hover .liquid {
    top: -120px;
}

.liq:hover {
    box-shadow: 0 0 13px #000000, inset 0 0 13px #000000;
    transition-delay: 0.2s;
}
</style>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <!--coupon code area end-->
        </div>
    </div>
     <!--shopping cart area end -->


  <!-- footer section start -->
  <?php include("./layout/footer.php");?>
    <!-- footer section end -->

    <?php
    $pageInlineJS = '';
    // Delete category AJAX
    $pageInlineJS .= <<<'JSEOF'
<script>
$(document).ready(function() {
    $('.delete-category').on('click', function(e) {
        e.preventDefault();
        var category = $(this).data('category');
        var productId = $(this).data('product-id');
        $.ajax({
            type: 'POST', url: 'delete_category.php',
            data: { category: category, productId: productId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var deletedItems = $('.category_title:contains("' + category + '")').nextUntil('.category_title', '.cart_item');
                    deletedItems.remove();
                    var newTotalPrice = parseFloat(response.totalPrice);
                    $('#totalPrice').text('$' + newTotalPrice.toFixed(2));
                } else { console.error('Delete failed.'); }
            },
            error: function(xhr, status, error) { console.error('AJAX Error:', error); }
        });
    });
});
</script>
JSEOF;
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
    include __DIR__ . '/includes/footer-scripts.php';
    ?>
</body>
</html>
