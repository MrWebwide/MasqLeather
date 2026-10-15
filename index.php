<?php
$basePath = '';
$noExzoom = true;
require_once __DIR__ . '/includes/init.php';

$pageTitle       = $yazi['blogadi'] ?? 'Masq Leather';
$pageDescription = $yazi['hizmetadi'] ?? '';
$pageKeywords    = $yazi['sssyazi'] ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/functions/analytics.php'; ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>
<?php include __DIR__ . '/includes/head-css.php'; ?>
<?php if (!empty($sayac['resim4'])): ?>
    <!-- LCP preload: anasayfa banner görseli erken ve yüksek öncelikle çekilsin (PageSpeed LCP) -->
    <link rel="preload" as="image" href="admin/resimler/<?=htmlspecialchars($sayac['resim4'])?>" fetchpriority="high">
<?php endif; ?>
<?php include __DIR__ . '/includes/head-js.php'; ?>

    <!-- Cookie Banner JS -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            var cookieBanner = document.getElementById("cookie-banner");
            var acceptButton = document.getElementById("accept-cookie");
            var bodyOverlay = document.querySelector(".body_overlay");
            if (!getCookie("acceptedCookie")) {
                cookieBanner.style.display = "flex";
                bodyOverlay.classList.add("active");
            }
            acceptButton.addEventListener("click", function () {
                setCookie("acceptedCookie", "true", 365);
                cookieBanner.style.display = "none";
                bodyOverlay.classList.remove("active");
            });
        }, 3000);
    });
    function setCookie(name, value, days) {
        var expires = "";
        if (days) { var d = new Date(); d.setTime(d.getTime() + days*86400000); expires = "; expires=" + d.toUTCString(); }
        document.cookie = name + "=" + value + expires + "; path=/";
    }
    function getCookie(name) {
        var eq = name + "=", ca = document.cookie.split(";");
        for (var i = 0; i < ca.length; i++) { var c = ca[i].trim(); if (c.indexOf(eq) === 0) return c.substring(eq.length); }
        return null;
    }
    </script>

    <!-- Google Ads: ayrı gtag.js kütüphane yüklemesi kaldırıldı (analytics.php zaten yüklüyor);
         tek kütüphane birden fazla ID destekler → ~140KB tasarruf (perf) -->
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('config', 'AW-16643612077');
    function gtag_report_conversion(url) {
        var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } };
        gtag('event', 'conversion', { 'send_to': 'AW-16643612077/x2ziCO_EtskZEK27pYA-', 'event_callback': callback });
        return false;
    }
    </script>
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
    background-color: peru;
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

<?php if ($campaign['durum'] === 'on'):
    // MAS-112: popup tipi panelden (Promo Banner) seçilir: 'link' = görsel banner, 'newsletter' = e-posta formu
    $popTur  = ($campaign['tur'] ?? '') === 'newsletter' ? 'newsletter' : 'link';
    $popDesc = ($campaign['aciklama'] ?? '') !== '' ? $campaign['aciklama'] : ($campaign['onaciklama'] ?? '');
    $popImg  = !empty($campaign['logo']) ? 'admin/resimler/' . $campaign['logo'] : '';
    $popLink = $campaign['yazi2'] ?? '';
    $popBtn  = trim($campaign['yazi3'] ?? '') !== '' ? $campaign['yazi3'] : 'Subscribe';
    $popCard = ($popTur === 'newsletter' || $popImg === ''); // görselsiz banner da kart olarak gösterilir
?>
    <style>
        /* CSS Animasyonu */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .campaign {
            opacity: 0; /* Başlangıçta görünmez olacak */
            animation: fadeIn 1s ease-in-out 1s forwards; /* Animasyonu ekliyoruz */
        }
        /* MAS-112: newsletter popup kartı */
        .campaign.campaign--card {
            width: 420px; max-width: calc(100vw - 32px); max-height: calc(100vh - 32px); overflow-y: auto;
            background: #fff; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,.35);
            text-align: center;
        }
        .campaign--card .campaign-card__img { display: block; width: 100%; max-height: 240px; object-fit: cover; border-radius: 12px 12px 0 0; }
        .campaign--card .campaign-card__body { padding: 28px 28px 30px; }
        .campaign--card .close-btn { top: 6px; right: 10px; font-size: 30px; line-height: 1; color: #333; text-shadow: 0 0 6px #fff; }
        .campaign--card .campaign-card__title { font-family: "Playfair Display", serif; font-size: 28px; line-height: 1.25; margin: 0 0 10px; color: #222; }
        .campaign--card .campaign-card__desc { font-size: 15px; line-height: 1.55; color: #555; margin: 0 0 20px; }
        .campaign--card form { display: flex; flex-direction: column; gap: 10px; }
        .campaign--card input[type=email] { height: 46px; border: 1px solid #ccc; border-radius: 6px; padding: 0 14px; font-size: 15px; width: 100%; }
        .campaign--card button[type=submit] { height: 46px; border: 0; border-radius: 6px; background: #1f2430; color: #fff; font-weight: 600; font-size: 15px; cursor: pointer; }
        .campaign--card button[type=submit]:disabled { opacity: .6; cursor: default; }
        .campaign--card .campaign-card__msg { display: none; margin-top: 12px; font-size: 14px; }
        .campaign--card .campaign-card__msg.ok { display: block; color: #2e7d32; }
        .campaign--card .campaign-card__msg.err { display: block; color: #c0392b; }
        .campaign--card .campaign-card__cta { display: inline-block; padding: 12px 28px; background: #1f2430; color: #fff; border-radius: 6px; font-weight: 600; }
        /* popup, cookie bandının (aynı max z-index, DOM'da sonra) üstünde kalsın */
        .campaign { z-index: 2147483647; }
        .cookie-banner { z-index: 2147483000 !important; }
        @media (max-width: 575px) {
            .campaign--card .campaign-card__img { max-height: 150px; }
            .campaign--card .campaign-card__body { padding: 20px 20px 22px; }
            .campaign--card .campaign-card__title { font-size: 24px; }
            .campaign--card .campaign-card__desc { font-size: 14px; margin-bottom: 16px; }
        }
    </style>
<?php if ($popCard): ?>
    <div class="campaign campaign--card" role="dialog" aria-modal="true" aria-label="<?= htmlspecialchars($campaign['adi'] ?? '') ?>">
        <button type="button" onclick="closeCampaign()" class="close-btn" aria-label="Close">×</button>
        <?php if ($popImg !== ''): ?><img class="campaign-card__img" src="<?= htmlspecialchars($popImg) ?>" alt=""><?php endif; ?>
        <div class="campaign-card__body">
            <?php if (trim($campaign['adi'] ?? '') !== ''): ?><h2 class="campaign-card__title"><?= htmlspecialchars($campaign['adi']) ?></h2><?php endif; ?>
            <?php if (trim($popDesc) !== ''): ?><p class="campaign-card__desc"><?= nl2br(htmlspecialchars($popDesc)) ?></p><?php endif; ?>
            <?php if ($popTur === 'newsletter'): ?>
                <form id="campaign_newsletter_form" action="functions/mailer/newsletter.php" method="post" novalidate>
                    <input type="email" name="email" placeholder="Your email address" autocomplete="email" required>
                    <button type="submit"><?= htmlspecialchars($popBtn) ?></button>
                </form>
                <div class="campaign-card__msg" id="campaign_newsletter_msg"></div>
            <?php elseif ($popLink !== ''): ?>
                <a class="campaign-card__cta" href="./<?= htmlspecialchars($popLink) ?>">Shop now</a>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="campaign">
        <?php if ($popLink !== ''): ?><a href="./<?= htmlspecialchars($popLink) ?>"><?php endif; ?>
            <img src="<?= htmlspecialchars($popImg) ?>" alt="">
        <?php if ($popLink !== ''): ?></a><?php endif; ?>
        <button onclick="closeCampaign()" class="close-btn">×</button>
        <h1 class="campaign_title"><?= htmlspecialchars($campaign['adi'] ?? '') ?></h1>
        <p class="campaign_desc"><?= htmlspecialchars($popDesc) ?></p>
    </div>
<?php endif; ?>

    <script>
        function closeCampaign(maxAge) {
            // Cookie oluştur — MAS-112: kapatınca 1 gün, newsletter'a kayıt olunca 1 yıl gösterme
            document.cookie = "campaign_closed=true; path=/; max-age=" + (maxAge || 86400);

            var overlay = document.querySelector('.body_overlay2');
            var campaignDiv = document.querySelector('.campaign');
            if (overlay && campaignDiv) {
                overlay.classList.remove('active');
                campaignDiv.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Cookie kontrolü
            if (document.cookie.indexOf("campaign_closed=true") !== -1) {
                var campaignDiv = document.querySelector('.campaign');
                if (campaignDiv) {
                    campaignDiv.style.display = 'none';
                }
                return; // Campaign zaten kapatılmış, işlemi sonlandır
            }

            setTimeout(function() {
                var overlay = document.querySelector('.body_overlay2');
                var campaignDiv = document.querySelector('.campaign');
                if (overlay && campaignDiv) {
                    overlay.classList.add('active');
                    campaignDiv.style.opacity = 1; // Resim gözükmeye başlamadan önce opaklığı ayarla
                    overlay.addEventListener('click', function () { closeCampaign(); }); // MAS-112: dışarı tıklayınca kapan
                }
            }, 1000);

            // MAS-112: popup newsletter formu → footer ile aynı uç (abone + indirim kuponu maili)
            var nlForm = document.getElementById('campaign_newsletter_form');
            if (nlForm) {
                nlForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var msg = document.getElementById('campaign_newsletter_msg');
                    var btn = nlForm.querySelector('button[type=submit]');
                    var email = nlForm.email.value.trim();
                    function show(cls, text) { msg.className = 'campaign-card__msg ' + cls; msg.textContent = text; }
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) { show('err', 'Please enter a valid email address.'); return; }
                    btn.disabled = true;
                    fetch(nlForm.getAttribute('action'), { method: 'POST', body: new FormData(nlForm) })
                        .then(function (r) { return r.json(); })
                        .then(function (res) {
                            if (res.success) {
                                show('ok', res.message || 'Subscription successful!');
                                nlForm.style.display = 'none';
                                document.cookie = "campaign_closed=true; path=/; max-age=31536000";
                                setTimeout(function () { closeCampaign(31536000); }, 4000);
                            } else {
                                show('err', res.message || 'There was an error. Please try again.');
                                btn.disabled = false;
                            }
                        })
                        .catch(function () { show('err', 'There was an error. Please try again.'); btn.disabled = false; });
                });
            }
        });
    </script>
<?php endif; ?>



<?php if ($campaign['yazi1'] === 'on'): ?>
<div class="top-bar">
        <p><?= $campaign['onaciklama'] ?></p>
    </div>

    <?php endif; ?>

<div id="cookie-banner" class="cookie-banner">
    <p>We utilize cookies to optimize your browsing experience. By selecting 'Accept Cookies,' you will have the opportunity to navigate our website and leverage its full range of features. For additional information, please refer to our <strong><a href="legal/terms.php">'Terms of Service'</a></strong></a>.</p>
   
    <button id="accept-cookie" class="accept-cookie-button">Accept Cookies</button>
   
</div>

<div class="body_overlay2">

    </div>


<style>
    .product_thumb img{
        width:340px
    }

 

</style>

    <!--offcanvas menu area start-->
    <div class="body_overlay">

    </div>
    <?php include("./layout/header-2.php");?>
    <!--header area end-->
    <section class="banner_advice_section mb-100">
        <div class="container" style="all: initial;">
            <div class="banner_advice_inner">
                <div class="row">
                    <div class="col-lg-5 offset-lg-7 col-md-5 offset-md-7">

                    </div>
                </div>
                <div class="banner_position_img">
                    <div class="divcik" style=" background-image: url(./admin/resimler/<?=$sayac['resim4'] ?>);"></div>
                </div>
            </div>
        </div>
        <div class="banner_position_text">
            <h2> <span id="element"></span></h2>
        </div>







        <div class="mouse-btn-down scroll-to-target" data-target=".chevron">
            <div class="chevron"></div>
            <div class="chevron"></div>
            <div class="chevron"></div>
        </div>

    </section>


     <!-- choice section start -->
     <section class="choice_section mb-135">
        <div class="container">
            <div class="section_title text-center ">
                <h2>Our Collection</h2>
            </div>
            <div class="choice_container">
                <div class="row choice_slick slick_slider_activation" data-slick='{
                    "slidesToShow": 4,
                    "slidesToScroll": 1,
                    "arrows": true,
                    "dots": false,
                    "autoplay": false,
                    "speed": 300,
                    "infinite": true,
                    "responsive":[
                        {"breakpoint":992, "settings": { "slidesToShow": 2 } },  
                        {"breakpoint":768, "settings": { "slidesToShow": 2 } },  
                        {"breakpoint":480, "settings": { "slidesToShow": 1 } }  
                    ]                                                         
                }'>
                <?php $hizmett = $db->query("SELECT * FROM ourcollection order by sira asc");
                            foreach($hizmett as $hizmet){?>   
                <div class="col-lg-4">
                    <a href="<?=$hizmet['kategori']?>">
                        <div class="single_choice wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            <div class="choice_thumb">
                                <img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                            </div>
                            <div class="choice_text">
                                <h4><a href="<?=$hizmet['kategori']?>"><?=$hizmet['adi']?></a></h4>
                            </div>
                        </div>
                    </a>
                    </div>
                    <?php } ?>
                    
               
                </div>
            </div>
        </div>
    </section>
    <!-- choice section end -->

    <!-- product section start -->
    <div class="product_section">
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
$hizmett = $db->query("SELECT * FROM urunler WHERE yazi2 = 'products' order by sira asc LIMIT 6");
foreach($hizmett as $hizmet) { ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
            <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
    <a href="bagpurses-detail.php?id=<?= $hizmet['id'] ?>">
        <img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt="">
        <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?>
    </a>
</div>
                <figcaption class="product_content">
                    <h4><a href="bagpurses-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
<?php } ?>

<?php
$hizmett = $db->query("SELECT * FROM accessories WHERE yazi2 = 'products' order by sira asc LIMIT 6");
foreach($hizmett as $hizmet) { ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
            <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
    <a href="accessories-detail.php?id=<?= $hizmet['id'] ?>">
        <img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt="">
        <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?>
    </a>
</div>



                <figcaption class="product_content ">
                    <h4><a href="accessories-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
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
$hizmett = $db->query("SELECT * FROM accessories WHERE yazi2 = 'bestseller' order by sira asc LIMIT 6");
foreach($hizmett as $hizmet) { ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
            <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
    <a href="accessories-detail.php?id=<?= $hizmet['id'] ?>">
        <img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt="">
        <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?>
    </a>
</div>
                <figcaption class="product_content">
                    <h4><a href="accessories-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?=$hizmet['yazi1']?> CAD</span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
<?php } ?>

<?php
$hizmett = $db->query("SELECT * FROM urunler WHERE yazi2 = 'bestseller' order by sira asc LIMIT 6");
foreach($hizmett as $hizmet) { ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <article class="single_product wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
            <figure>
            <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
    <a href="bagpurses-detail.php?id=<?= $hizmet['id'] ?>">
        <img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt="">
        <?php if ($hizmet['resim1'] !== null): ?>
            <img class="second_image" loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim1']?>" alt="">
        <?php endif; ?>
    </a>
</div>
                <figcaption class="product_content">
                    <h4><a href="bagpurses-detail.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?></a></h4>
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

   <!-- shipping area start -->
   <section class="shipping_section mb-105">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shipping_inner d-flex justify-content-between flex-wrap">
                        <div class="single_shipping shipping1" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-offset="5">
                            <div class="shipping_title d-flex align-items-center wow fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1.1s">

                                <h3> <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V240c0 8.8-7.2 16-16 16s-16-7.2-16-16V64c0-17.7-14.3-32-32-32s-32 14.3-32 32V336c0 1.5 0 3.1 .1 4.6L67.6 283c-16-15.2-41.3-14.6-56.6 1.4s-14.6 41.3 1.4 56.6L124.8 448c43.1 41.1 100.4 64 160 64H304c97.2 0 176-78.8 176-176V128c0-17.7-14.3-32-32-32s-32 14.3-32 32V240c0 8.8-7.2 16-16 16s-16-7.2-16-16V64c0-17.7-14.3-32-32-32s-32 14.3-32 32V240c0 8.8-7.2 16-16 16s-16-7.2-16-16V32z" />
                                    </svg>
                                    <?=$sayac['sayi1'] ?></h3>
                            </div>
                            <div class="shipping_desc wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1.2s">
                                <p><?=$sayac['yazi1'] ?></p>
                            </div>
                        </div>
                        <div class="single_shipping shipping2 " data-aos="fade-down" data-aos-duration="1000"
                            data-aos-offset="5">
                            <div class="shipping_title d-flex align-items-center wow fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1.1s">
                                <h3> <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                    <?=$sayac['sayi2'] ?></h3>
                            </div>
                            <div class="shipping_desc wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1.2s">
                                <p><?=$sayac['yazi2'] ?> </p>
                            </div>
                        </div>
                        <div class="single_shipping shipping3   " data-aos="fade-up" data-aos-duration="1000"
                            data-aos-offset="5">
                            <div class="shipping_title d-flex align-items-center wow fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1.1s">
                                <h3> <svg xmlns="http://www.w3.org/2000/svg" height="0.92em"
                                        viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                    </svg>
                                    <?=$sayac['sayi4'] ?></h3>
                            </div>
                            <div class="shipping_desc wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1.2s">
                                <p><?=$sayac['yazi4'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- shipping area end -->

    <!-- featured section start-->
    <!-- 
    <section class="featured_banner_section">
        <div class="container">
            <div class="section_title text-center mb-105">
                <h2>Featured Collections(Toplu Ürün Satışı)</h2>
            </div>
            <div class="featured_banner_inner">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="featured_thumb wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            <a href="#"><img src="assets/img/masq-photo/MasMercantile-Final-25.jpg" alt=""></a>
                            <div class="featured_text">
                                <h3>MASQ LEATHER</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="featured_banner_sidebar">
                            <div class="featured_thumb mb-30 wow fadeInUp" data-wow-delay="0.2s"
                                data-wow-duration="1.2s">
                                <a href="#"><img src="assets/img/bg/bg2.png" alt=""></a>
                                <div class="featured_text">
                                    <h3>MASQ LEATHER</h3>
                                </div>
                            </div>
                            <div class="featured_thumb wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s">
                                <a href="#"><img src="assets/img/bg/bg3.png" alt=""></a>
                                <div class="featured_text">
                                    <h3>MASQ LEATHER</h3>
                                </div>
                            </div>
                            <div class="featured_thumb wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s">
                                <a href="#"><img src="assets/img/bg/bg3.png" alt=""></a>
                                <div class="featured_text">
                                    <h3>MASQ LEATHER</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->
    <!-- featured section end-->

    <!-- testimonial section start -->
    <section class="testimonial_section mb-75">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title text-center mb-90">
                        <h2>What Our Customers Say</h2>
                    </div>
                    <div class="testimonial_container testimonial_swiper swiper-container wow fadeInUp"
                        data-wow-delay="0.1s" data-wow-duration="1.1s">
                        <div class="swiper-wrapper">
                        <?php
$hizmett = $db->query("SELECT * FROM bloggelen where durum = 'on'");
foreach($hizmett as $hizmet) { ?>
                        <div class="single_testimonial swiper-slide">
                                <div class="testimonial_desc">
                                    <img src="assets/img/icon/blockcode.png" alt="">
                                    <p><?=$hizmet['messagee']?></p>
                                </div>
                                <div class="testimonial_author">
                              
                                    <h3><a href="<?=$hizmet['tur']?>-detail.php?id=<?=$hizmet['yorumid']?>"><?=$hizmet['name']?></a></h3>
                                </div>
                            </div>
                            <?php } ?>
                          
                      
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider section start 
    <section class="slider_section mb-170">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slider_swiper swiper-container">
                        <div class="swiper-wrapper">
                            <div class="single_slider swiper-slide d-flex align-items-center">
                                <div class="slider_text">
                                    <h2>Masq Leather 2023 <br> New Collection</h2>
                                    <div class="slider_text_shape">
                                        <img src="assets/img/slider/slider-text-shape.png" alt="">
                                        <div class="slider_btn">
                                            <a class="btn btn-link" href="shop-left-sidebar.html">SHOP NOW</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="slider_thumb">
                                    <div data-aos="fade-up" data-aos-duration="3000" class="image_wrapper">
                                        <img src="assets/img/masq-photo/MasMercantile-Final-9.jpg"
                                            style="border-radius:20px 0 0 20px;" alt="">
                                    </div>
                                    <div data-aos="fade-down" data-aos-duration="3000" class="image_wrapper"
                                        style="border-radius:unset!important;">
                                        <img src="assets/img/masq-photo/MasMercantile-Final-3.jpg"
                                            style="border-radius:unset;" alt="">
                                    </div>
                                    <div data-aos="fade-up" data-aos-duration="3000" class="image_wrapper">
                                        <img src="assets/img/masq-photo/MasMercantile-Final-1.jpg"
                                            style="border-radius:0 20px 20px 0;" alt="">
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>
                </div>
            </div>
        </div>
    </section>   -->
    <!-- slider section end -->
    <!-- testimonial section end -->

    <!-- banner advice section start -->

    <!-- banner advice section end -->

    <!-- blog section start -->
    <section class="blog_section mb-100">
        <div class="container">
            <div class="section_title text-center mb-60">
                <h2>LATEST BLOGS</h2>
            </div>
            <div class="blog_inner">
                <div class="row">
                <?php
$hizmett = $db->query("SELECT * FROM bloglar ORDER BY id DESC LIMIT 3");
foreach($hizmett as $hizmet) { ?>
                <div class="col-lg-4 col-md-6">
                        <article class="single_blog wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="blog-details.php?id=<?= $hizmet['id'] ?>"><img loading="lazy" decoding="async" src="admin/resimler/<?=$hizmet['resim']?>" alt=""></a>
                                </div>
                                <figcaption class="blog_content">
                                    <h3><a href="blog-details.php?id=<?= $hizmet['id'] ?>"><?=$hizmet['adi']?> </a></h3>
                                    <div class="blog_meta">
                                        <ul class="d-flex">
                                            <li><?=$hizmet['eklenme_tarihi']?></li>
                                           
                                        </ul>
                                    </div>
                                    <div class="blog_footer">
                                        <a class="btn btn-link" href="blog-details.php?id=<?= $hizmet['id'] ?>"><?= $hizmet['yazi1'] ?></a>
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

    <!-- footer section start -->
    <?php include("./layout/footer.php");?>
    <!-- footer section end -->

   
    <?php
    $pageScripts = ['<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>'];
    $pageInlineJS = '';
    if (!empty($sayac['yazi5']) || !empty($sayac['yazi6']) || !empty($sayac['yazi7'])) {
        $pageInlineJS .= "<script>var typingEffect = new Typed('#element', { strings: ['" . addslashes($sayac['yazi5']) . "', '" . addslashes($sayac['yazi6']) . "', '" . addslashes($sayac['yazi7']) . "'], typeSpeed: 100, loop: true, backSpeed: 80, backdelay: 1500 });</script>\n";
    }
    $pageInlineJS .= '<script>$(document).ready(function(){$(\'.add-to-cart\').on(\'click\',function(){var $b=$(\'.btn-wrapper\');$b.addClass(\'add\');setTimeout(function(){$b.removeClass(\'add\');},2200);});});</script>' . "\n";
    include __DIR__ . '/includes/footer-scripts.php';
    ?>

</body>
</html>