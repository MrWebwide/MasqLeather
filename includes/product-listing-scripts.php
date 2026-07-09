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

    // MAS-106: "Added ✓" animasyonu artık ajax.js'te AJAX BAŞARISINDA oynatılıyor
    // (touchstart'ta erken tetikleme kaldırıldı → mobilde yanlış "eklendi" görüntüsü giderildi).
    // Burada sadece tıklamanın ürün linkine yayılmasını engelliyoruz.
    $(document).ready(function () {
        $('.add-to-cart').on('click', function (event) {
            event.stopPropagation();
        });
    });
</script>
