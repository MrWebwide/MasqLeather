<?php
/**
 * footer-scripts.php — JavaScript loaded at bottom of every page, before </body>.
 *
 * Variable $basePath must be set before including.
 *   Root pages:   $basePath = '';
 *   Subdirectory: $basePath = '../';
 *
 * Optional:
 *   $pageScripts   — array of extra <script> src paths for this page
 *   $pageInlineJS  — string of inline JS to add after all scripts
 *   $needsEasyzoom — load easyzoom.js for product detail pages
 *   $needsAjaxComment — load ajax.js for comment forms
 */

if (!isset($basePath)) {
    $basePath = '';
}
?>
    <!-- Popper + Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!-- Carousel/Slider -->
    <script src="<?=$basePath?>assets/js/swiper-bundle.min.js"></script>
    <script src="<?=$basePath?>assets/js/slick.min.js"></script>

    <!-- Animations & Scroll -->
    <script src="<?=$basePath?>assets/js/wow.min.js"></script>
    <script src="<?=$basePath?>assets/js/jquery.scrollup.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- UI Plugins -->
    <script src="<?=$basePath?>assets/js/images-loaded.min.js"></script>
    <script src="<?=$basePath?>assets/js/jquery.nice-select.js"></script>
    <script src="<?=$basePath?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?=$basePath?>assets/js/jquery.counterup.min.js"></script>
    <script src="<?=$basePath?>assets/js/jquery-waypoints.js"></script>
    <script src="<?=$basePath?>assets/js/jquery-ui.min.js"></script>

    <!-- Newsletter -->
    <script src="<?=$basePath?>assets/js/mailchimp-ajax.js"></script>

    <!-- Product Detail extras -->
<?php if (!empty($needsEasyzoom)): ?>
    <script src="<?=$basePath?>assets/js/easyzoom.js"></script>
<?php endif; ?>

<?php if (!empty($needsAjaxComment)): ?>
    <script src="<?=$basePath?>assets/js/ajax.js"></script>
<?php endif; ?>

    <!-- Page-specific scripts -->
<?php if (!empty($pageScripts) && is_array($pageScripts)): ?>
    <?php foreach ($pageScripts as $src): ?>
    <?=$src?>
    <?php endforeach; ?>
<?php endif; ?>

    <!-- Main JS -->
    <script src="<?=$basePath?>assets/js/main.js"></script>

    <!-- AOS init -->
    <script>AOS.init();</script>

    <!-- Page-specific inline JS -->
<?php if (!empty($pageInlineJS)): ?>
    <?=$pageInlineJS?>
<?php endif; ?>
