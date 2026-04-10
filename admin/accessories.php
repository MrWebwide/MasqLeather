<?php
include("admin/include/baglan.php");
include("admin/include/fonksiyonlar.php");


session_start(); // Oturumu başlat
$adsoyad = isset($_SESSION['adsoyad']) ? $_SESSION['adsoyad'] : '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : '';
if ($bakim['kategori'] == 1) {
    header('HTTP/1.1 503 Service Unavailable');
    header('Content-Type: text/html; charset=utf-8');
    header('Retry-After: 3600'); // Bakım modu ne kadar süreceğini belirlemek için Retry-After değerini ayarlayabilirsiniz

    // Bakım modu sayfasına yönlendirme
    include_once('404.php');
    exit();
  }

// Eğer sayfa açıldığında bir URL parametresi varsa
if(isset($_SERVER['REQUEST_URI'])) {
    // URL'yi al
    $url = $_SERVER['REQUEST_URI'];
    
    // URL'yi bir cookie'ye kaydet (cookie adı: memet)
    setcookie('memet', $url, time() + (86400 * 30), "/"); // 30 gün boyunca geçerli
    
  
  
}


?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZEP4PW1YH0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-ZEP4PW1YH0');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?=$yazi['yazi1']?>
    </title>
    <meta name="description" content=" <?=$yazi['blogyazi']?>" />
    <meta name="keywords" content=" <?=$yazi['yazi3']?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="canonical" href="Replace_with_your_PAGE_URL" />

    <!-- Add site Favicon -->

    <link rel="icon" href="../favicon.ico" sizes="192x192" />

    <!-- CSS 
        ========================= -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/font.awesome.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/elegant-icons.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link href="./slider/jquery.exzoom.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--Script CDN -->

    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="./slider/jquery.exzoom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>


    <style>
        #exzoom {
            width: 400px;
            /*height: 400px;*/
        }

        .main_menu nav>ul>li>a {
            Color: rgb(245, 245, 245) !important;
        }
    </style>


    <!-- External JS Files -->

    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/handlewindowsize.js"></script>

    <script src="assets/js/loadingscreen.js"></script>


    <?php
        
       include("functions/analytics.php");
        ?>

</head>

<body class="exclude-script">



    <!--offcanvas menu area start-->
    <div class="body_overlay">

    </div>
    <?php include("./layout/header-2.php");?>

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2>Accessories</h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="index.html">Home</a></li>
                            <li>></li>
                            <li><a>Accessories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- shop page section satrt -->
    <div class="shop_page_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop_page_inner d-flex ">
                        <div class="shop_sidebar_widget">

                            <div class="shop_widget_list categories">
                                <div class="shop_widget_title categories_title">
                                    <h3>Accessories</h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
                                        <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                             FROM bolge_kategori AS bk
                             LEFT JOIN accessories AS b ON bk.adi = b.kategori
                             GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
    $adi = $hizmetka['adi'];
    $urun_sayisi = $hizmetka['urun_sayisi'];
    ?>
                                        <li><a href="accessories-category.php?kategori=<?= urlencode($adi) ?>">
                                                <?= $adi ?>(
                                                <?= $urun_sayisi ?>)
                                            </a></li>

                                        <?php } ?>
                                    </ul>
                                </div>

                            </div>

                            <div class="shop_widget_list categories">
                                <div class="shop_widget_title categories_title">
                                    <h3>Bags & Purses</h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
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
                                                <?= $adi ?>(
                                                <?= $urun_sayisi ?>)
                                            </a></li>
                                        <?php } ?>
                                    </ul>
                                </div>

                            </div>








                        </div>
                        <div class="shop_right_sidaber">



                            <div class="shop_gallery">
                                <div class="row">
                                <?php
        // Sayfalama işlemi için kullanıcı tarafından belirlenecek sayfa numarası
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Sayfada Showilecek ürün sayısı
        $productsPerPage = 9;

        // Ürünlerin başlangıç indeksi
        $startIndex = ($page - 1) * $productsPerPage;

        // Kategoriye ait ürün sayısını hesapla
        $totalProducts = $db->prepare("SELECT COUNT(*) as total FROM accessories ");
        $totalProducts->execute();
        $totalProductsCount = $totalProducts->fetchColumn();

        // Toplam sayfa sayısını hesaplayın
        $totalPages = ceil($totalProductsCount / $productsPerPage);

// Veritabanı sorgusu için LIMIT ve OFFSET değerleri ile sayfalama
$urunler = $db->query("SELECT * FROM accessories where durum = 'on' order by sira asc LIMIT $startIndex, $productsPerPage");

                            foreach($urunler as $urun){
                                $fiyat = $urun['kampanya'] ? ($urun['yazi1'] - ($urun['yazi1'] * $urun['kampanya'] / 100)) : $urun['yazi1'];

                                ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb" onmouseover="showSecondImage(this)"
                                                    onmouseout="hideSecondImage(this)">
                                                    <a href="accessories-detail.php?id=<?= $urun['id'] ?>"><img
                                                            src="admin/resimler/<?=$urun['resim']?>" loading="lazy"
                                                            alt="">
                                                        <?php if ($urun['resim1'] !== null): ?>
                                                        <img class="second_image"
                                                            src="admin/resimler/<?=$urun['resim1']?>" loading="lazy"
                                                            alt="">
                                                        <?php endif; ?>
                                                    </a>
                                                    <div class="label_product">

                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4><a href="accessories-detail.php?id=<?= $urun['id'] ?>">
                                                            <?=$urun['adi']?>
                                                        </a></h4>
                                                    <div class="price_box">

                                                        <?php if ($urun['kampanya']) { ?>
                                                        <span class="old_price">$
                                                            <?=$urun['yazi1']?> CAD
                                                        </span>
                                                        <span class="current_price">$
                                                            <?=$fiyat?> CAD
                                                        </span>

                                                        <?php } else { ?>
                                                        <span class="current_price">$
                                                            <?=$urun['yazi1']?> CAD
                                                        </span>
                                                        <?php } ?>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <?php } ?>






                                </div>
                            </div>
                            <div class="loding_bar">
                            <ul class="d-flex justify-content-center">
    <?php
    // Geçerli sayfa numarasını alın
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Sayfalama bağlantılarını oluşturun
    for ($i = 1; $i <= $totalPages; $i++) {
        // Geçerli sayfa numarasıyla eşleşen bağlantıya özel bir sınıf ekleyin
        $activeClass = ($i == $currentPage) ? 'active' : '';
        echo '<li><a class="' . $activeClass . '" href="?page=' . $i . '">' . $i . '</a></li>';
    }

    // Sonraki sayfa numarasını belirleyin
    $nextPage = $currentPage + 1;

    // Eğer son sayfadaysak, ikonu ve href'i değiştirin
    if ($currentPage >= $totalPages) {
        echo '<li><a style="border:initial !important; font-size:xxx-large; padding-top: 4px;" href="#"><i class="ion-ios-close-outline"></i></a></li>';
    } else {
        echo '<li><a href="?page=' . $nextPage . '"><i class="ion-ios-arrow-right"></i></a></li>';
    }
    ?>
</ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop page section end -->



    <!-- footer section start -->
    <?php include("./layout/footer.php");?>
    <!-- footer section end -->


    <!-- Js 
    ========================= -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.scrollup.min.js"></script>
    <script src="assets/js/images-loaded.min.js"></script>
    <script src="assets/js/jquery.nice-select.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/mailchimp-ajax.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/jquery-waypoints.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/ajax-mail.js"></script>



    <!-- Main JS -->
    <script src="assets/js/main.js"></script>


    <script type="text/javascript">

        $('.container').imagesLoaded(function () {
            $("#exzoom").exzoom({
                autoPlay: false,
            });
            $("#exzoom").removeClass('hidden')
        });

    </script>


    <script>
        // Mesajın otomatik kapanması veya kaybolması için JavaScript kodu
        setTimeout(function () {
            var message = document.querySelector('.message');
            if (message) {
                message.style.display = 'none';
            }
        }, 6000); // Mesajın 3 saniye sonra kaybolmasını sağlar, istediğiniz süreyi buradan ayarlayabilirsiniz.
    </script>

    <script>
        $(document).ready(function () {
            function handleButtonClick(event) {
                event.stopPropagation();

                var $btnWrapper = $(this).closest('.btn-wrapper');
                $btnWrapper.addClass('add');

                setTimeout(function () {
                    $btnWrapper.removeClass('add');
                }, 2200); // 2200 milisaniye (2.2 saniye) sonra animasyon sınıfını kaldır
            }

            $('.add-to-cart').on('click touchstart', handleButtonClick);
        });
    </script>
</body>

</html>