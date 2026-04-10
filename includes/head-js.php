<?php
/**
 * head-js.php — JavaScript files loaded in <head>.
 *
 * Consolidates jQuery to a SINGLE version (3.7.1).
 * Removes duplicate jQuery loads (1.9.1, 1.12.4, 3.4.1, vendor.min.js).
 *
 * Variable $basePath must be set before including.
 *   Root pages:   $basePath = '';
 *   Subdirectory: $basePath = '../';
 *
 * Optional:
 *   $noExzoom — set true to skip exzoom slider JS
 */

if (!isset($basePath)) {
    $basePath = '';
}
?>
    <!-- jQuery 3.7.1 (single version for entire site) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Modernizr -->
    <script src="<?=$basePath?>assets/js/vendor/modernizr-3.7.1.min.js"></script>

    <!-- imagesLoaded -->
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>

    <!-- Exzoom Slider -->
<?php if (empty($noExzoom)): ?>
    <script src="<?=$basePath?>slider/jquery.exzoom.js"></script>
<?php endif; ?>

    <!-- Site utilities -->
    <script src="<?=$basePath?>assets/js/handlewindowsize.js"></script>
    <script src="<?=$basePath?>assets/js/loadingscreen.js"></script>
