<?php
/**
 * head-css.php — All CSS <link> tags shared by every page.
 *
 * Variable $basePath must be set before including this file.
 *   Root pages:   $basePath = '';
 *   Subdirectory: $basePath = '../';
 *
 * Optional variables:
 *   $pageCSS  — array of extra <link> hrefs specific to this page
 *   $noExzoom — set true to skip exzoom slider CSS
 */

if (!isset($basePath)) {
    $basePath = '';
}
?>
    <!-- Preconnect: dış kaynaklara erken bağlantı (kritik zincir kısalır) — MAS-22/perf -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <!-- Google Fonts: <link> ile paralel yükleme (eskiden style.css içinde @import vardı = seri/yavaş). display=swap. -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Dancing+Script:wght@600;700&family=Lugrasimo&display=swap">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Vendor CSS — kritik (slider'lar) bloke kalır: slick CSS async olunca "OUR COLLECTION"
         slider'ı JS kurulurken CSS inmediği için bozuluyordu (FOUC). -->
    <link rel="stylesheet" href="<?=$basePath?>assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/slick.css">
    <!-- nice-select & jquery-ui: JS açılışta DOM'u dönüştürdüğü için (niceSelect, price slider) bloke kalmalı -->
    <link rel="stylesheet" href="<?=$basePath?>assets/css/nice-select.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/jquery-ui.min.css">

    <?php
    // icofont kaldırıldı (525KiB font tek ikon için → fa fa-search).
    // Kritik OLMAYAN CSS'ler asenkron yüklenir (render-blocking azaltma — PageSpeed).
    // media="print" + onload hilesi: ilk render'ı bloke etmez; JS kapalıysa <noscript> devreye girer.
    $asyncCss = [
        'assets/css/animate.css',
        'assets/css/magnific-popup.css',
        'assets/css/font.awesome.css',
        'assets/css/ionicons.min.css',
        'assets/css/elegant-icons.min.css',
    ];
    foreach ($asyncCss as $css):
        $href = $basePath . $css; ?>
    <link rel="stylesheet" href="<?=$href?>" media="print" onload="this.media='all';this.onload=null;">
    <noscript><link rel="stylesheet" href="<?=$href?>"></noscript>
    <?php endforeach; ?>

    <!-- AOS Animations (asenkron) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" media="print" onload="this.media='all';this.onload=null;">
    <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>

    <!-- Exzoom Slider (product pages) -->
<?php if (empty($noExzoom)): ?>
    <link href="<?=$basePath?>slider/jquery.exzoom.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

    <!-- EasyZoom (product detail pages) -->
<?php if (!empty($needsEasyzoom)): ?>
    <link rel="stylesheet" href="<?=$basePath?>assets/css/easyzoom.css">
<?php endif; ?>

    <!-- Responsive & Main Style (load last to override) -->
    <?php
    // Cache-bust: dosya her değiştiğinde ?v=filemtime otomatik değişir → 30 günlük cache elle temizlenmeden kırılır.
    $cssV = function ($rel) { $abs = __DIR__ . '/../' . $rel; return is_file($abs) ? '?v=' . filemtime($abs) : ''; };
    ?>
    <link rel="stylesheet" href="<?=$basePath?>assets/css/responsive.css<?=$cssV('assets/css/responsive.css')?>">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/style.css<?=$cssV('assets/css/style.css')?>">

    <!-- Page-specific CSS -->
<?php if (!empty($pageCSS) && is_array($pageCSS)): ?>
    <?php foreach ($pageCSS as $css): ?>
    <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
<?php endif; ?>
