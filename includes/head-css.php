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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700&amp;display=swap" rel="stylesheet" />

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?=$basePath?>assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/slick.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/animate.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/nice-select.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/jquery-ui.min.css">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="<?=$basePath?>assets/css/font.awesome.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/icofont.min.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/elegant-icons.min.css">

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Exzoom Slider (product pages) -->
<?php if (empty($noExzoom)): ?>
    <link href="<?=$basePath?>slider/jquery.exzoom.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

    <!-- EasyZoom (product detail pages) -->
<?php if (!empty($needsEasyzoom)): ?>
    <link rel="stylesheet" href="<?=$basePath?>assets/css/easyzoom.css">
<?php endif; ?>

    <!-- Responsive & Main Style (load last to override) -->
    <link rel="stylesheet" href="<?=$basePath?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?=$basePath?>assets/css/style.css">

    <!-- Page-specific CSS -->
<?php if (!empty($pageCSS) && is_array($pageCSS)): ?>
    <?php foreach ($pageCSS as $css): ?>
    <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
<?php endif; ?>
