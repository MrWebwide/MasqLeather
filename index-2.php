<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = $yazi['urunadi'] ?? 'Masq Mercantile';
$pageDescription = $yazi['yazi3'] ?? '';
$pageKeywords    = $yazi['yazi4'] ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/functions/analytics.php'; ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>
<?php include __DIR__ . '/includes/head-css.php'; ?>
<?php include __DIR__ . '/includes/head-js.php'; ?>
    <style>
        #exzoom { width: 400px; }
        .main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }
    </style>
</head>
<body>


    <style>
       
/* Loading screen */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(48, 48, 48);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

#loading-screen img {
    width: 100px; /* İstediğiniz boyutu ayarlayabilirsiniz */
    animation: spin 2s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
 
}

/* Loading image spin animation */
@keyframes spin {
    0% {
        transform: rotate(0deg);
   
    }
    50% {
        transform: rotate(180deg);
       
    }
    100% {
        transform: rotate(360deg);
       
    }
}

/* Fade out animation */
.fade-out {
    animation: fadeOut 1s forwards;
}

@keyframes fadeOut {
    0% { opacity: 1; }
    100% { opacity: 0; display: none; }
}


    </style>

<style>
    .offcanvas_main_menu li a {
        color:white !important;
    }
</style>
    
     <!--offcanvas menu area start-->
     <div class="body_overlay">

</div>
<?php include("./layout/header-mer.php");?>






<div class="my-slider">
    <div> <img src="assets/img/shutterstock/stock-photo-close-up-view-of-evil-eye-amulet-on-mountain-background-in-cappadocia-turkey-1881048244-transformed.jpeg" alt=""></div>
    <div><img src="assets/img/shutterstock/stock-photo-handwoven-hammam-turkish-cotton-towel-on-wooden-background-1260443416-transformed.jpeg" alt=""></div>
    <div><img src="assets/img/shutterstock/stock-photo-interior-design-of-ethnic-living-room-interior-with-colorful-pillows-brown-sofa-wooden-bench-2256940479-transformed.jpeg" alt=""></div>
  </div>
  <button class="prev"><i class="fas fa-arrow-left fa-2x"
    style="padding-top: 0.5cm; color: white;     text-shadow: 2px 2px 3px black;"></i></button>
<button class="next"><i class="fas fa-arrow-right fa-2x"
    style="padding-top: 0.5cm; color: white;     text-shadow: 2px 2px 3px black;"></i></button>

    <style>
    .chevron{
        margin-top:-1cm;
    }
    
    </style>

    <div class="mouse-btn-down scroll-to-target" style="margin-top:5cm !important;" data-target=".chevron">
            <div class="chevron"></div>
            <div class="chevron"></div>
            <div class="chevron"></div>
        </div>
<!-- product section start -->
<div class="product_section product_style2 mb-50">
    <div class="container">
        <div class="product_tab_button">
            <ul class="nav justify-content-center" role="tablist" id="nav-tab">
                <li>
                    <a class="active" data-toggle="tab" href="#products" role="tab" aria-controls="products"
                        aria-selected="false">New Products </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#seller" role="tab" aria-controls="seller" aria-selected="false">
                        Best Seller </a>
                </li>

            </ul>
        </div>
        <div class="tab-content product_container">
            <div class="tab-pane fade show active" id="products" role="tabpanel">
                <div class="product_gallery">
                    <div class="row">
                     
                    <?php
$hizmett = $db->query("SELECT * FROM homedecor WHERE yazi2 = 'mercantileproducts' order by sira asc");
foreach($hizmett as $hizmet) { ?>
                  <div class="col-lg-3 col-md-6 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
                <div class="product_thumb"  onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                    <a href="homedecor-detail.php?id=<?= $hizmet['id'] ?>"><img src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                    <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?></a>
                  
                </div>
                <figcaption class="product_content">
                    <h4><a href="homedecor-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
                        <?php } ?>

                        <?php
$hizmett = $db->query("SELECT * FROM jewe WHERE yazi2 = 'mercantileproducts' order by sira asc");
foreach($hizmett as $hizmet) { ?>
                  <div class="col-lg-3 col-md-6 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
                <div class="product_thumb"  onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                    <a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>"><img src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                    <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?></a>
                    
                </div>
                <figcaption class="product_content">
                    <h4><a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
                        <?php } ?>
                       

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="seller" role="tabpanel">
                <div class="product_gallery">
                    <div class="row">
                     
                    <?php
$hizmett = $db->query("SELECT * FROM homedecor WHERE yazi2 = 'mercantilebestseller' order by sira asc");
foreach($hizmett as $hizmet) { ?>
                  <div class="col-lg-3 col-md-6 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
                <div class="product_thumb"  onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                    <a href="homedecor-detail.php?id=<?= $hizmet['id'] ?>"><img src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                    <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?></a>
                   
                </div>
                <figcaption class="product_content">
                    <h4><a href="homedecor-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
                        <?php } ?>

                        <?php
$hizmett = $db->query("SELECT * FROM jewe WHERE yazi2 = 'mercantilebestseller' order by sira asc");
foreach($hizmett as $hizmet) { ?>
                  <div class="col-lg-3 col-md-6 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
                <div class="product_thumb"  onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                    <a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>"><img src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                    <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?></a>
                 
                </div>
                <figcaption class="product_content">
                    <h4><a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
                        <?php } ?>
                     

                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
<!-- product section end -->



<!-- instagram area start -->
<section class="instagram_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="instagram_inner2 d-flex align-items-center justify-content-between">
                    <div class="instagram_text">
                        <a class="instagram-button" href="">
                            <h3 class="wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
                                <a href="https://www.instagram.com/masqmercantile/"> <span>@</span>masqmercantile</h3></a>
                              
                        </a>
                        <p class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1.2s">You can follow us on
                            instagram <br> to be informed about our latest products! </p>
                    </div>
                    <div class="instagram_gallery">
                        <div class="instagram_gallery_list d-flex">
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram5.png" alt=""></a>
                            </div>
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram6.png" alt=""></a>
                            </div>
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram7.png" alt=""></a>
                            </div>
                        </div>
                        <div class="instagram_gallery_list d-flex">
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram8.png" alt=""></a>
                            </div>
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram9.png" alt=""></a>
                            </div>
                            <div class="instagram_img">
                                <a href="#"><img src="assets/img/others/instagram10.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- instagram area end -->

<!-- blog section start -->
<section class="blog_section mb-100">
        <div class="container">
            <div class="section_title text-center mb-60">
                <h2>LATEST BLOGS</h2>
            </div>
            <div class="blog_inner">
                <div class="row">
                <?php
$hizmett = $db->query("SELECT * FROM bloglarmer ORDER BY id DESC LIMIT 3");
foreach($hizmett as $hizmet) { ?>
                <div class="col-lg-4 col-md-6">
                        <article class="single_blog wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="blogmercantile-details.php?id=<?= $hizmet['id'] ?>"><img src="admin/resimler/<?=$hizmet['resim']?>" alt=""></a>
                                </div>
                                <figcaption class="blog_content">
                                    <h3><a href="blogmercantile-details.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?> </a></h3>
                                    <div class="blog_meta">
                                        <ul class="d-flex">
                                            <li><?=$hizmet['eklenme_tarihi']?></li>
                                           
                                        </ul>
                                    </div>
                                    <div class="blog_footer">
                                        <a class="btn btn-link" href="blogmercantile-details.php?id=<?= $hizmet['id'] ?>"><?= $hizmet['yazi1'] ?></a>
                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                    </div>
                    <?php } ?>
                 
              
                </div>
            </div>
        </div>
    </section>
    <!-- blog section end -->


    <?php include("./layout/footer-mer.php");?>
<?php
$pageInlineJS = <<<'JSEOF'
<script>
$(document).ready(function(){
    $('.my-slider').slick({
        dots: false,
        infinite: true,
        speed: 800,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 4000,
        prevArrow: '.prev',
        nextArrow: '.next'
    });
});
</script>
JSEOF;
include __DIR__ . '/includes/footer-scripts.php';
?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>