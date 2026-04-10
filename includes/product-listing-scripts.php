<?php
/**
 * product-listing-scripts.php — Common inline JS for product listing pages.
 * Used by: bagpurses.php, accessories.php, jewelry.php, homedecor.php,
 *          bagpurses-category.php, accessories-category.php, etc.
 */
?>
<script>
    // Exzoom init
    $('.container').imagesLoaded(function () {
        $("#exzoom").exzoom({ autoPlay: false });
        $("#exzoom").removeClass('hidden');
    });

    // Auto-hide flash messages after 6s
    setTimeout(function () {
        var message = document.querySelector('.message');
        if (message) { message.style.display = 'none'; }
    }, 6000);

    // Add-to-cart button animation
    $(document).ready(function () {
        $('.add-to-cart').on('click touchstart', function (event) {
            event.stopPropagation();
            var $btnWrapper = $(this).closest('.btn-wrapper');
            $btnWrapper.addClass('add');
            setTimeout(function () { $btnWrapper.removeClass('add'); }, 2200);
        });
    });
</script>
