<?php
/**
 * product_gallery.php — Modern ürün detay galerisi. (MAS-34)
 *
 * Eski easyzoom + slick + exzoom (demode/sorunlu) yerine:
 *   - Swiper (projede mevcut, v6) ile ana görsel + senkron thumbnail slider
 *   - Mobilde Swiper Zoom modülü ile pinch / çift dokunuş zoom
 *   - Masaüstünde Drift ile hover-magnify (görselin yanında büyütülmüş görünüm)
 *
 * Beklenen değişkenler: $resimler (her biri ['img'=>...]), $urunler (['resim'=>...] fallback),
 *                       $basePath (varsayılan '').
 */
if (!isset($basePath)) { $basePath = ''; }

// Galeri görsellerini normalize et: galeri tablosu boşsa ana görsele düş.
$galImgs = [];
if (!empty($resimler) && is_array($resimler)) {
    foreach ($resimler as $r) {
        if (!empty($r['img'])) { $galImgs[] = $r['img']; }
    }
}
if (empty($galImgs) && !empty($urunler['resim'])) { $galImgs[] = $urunler['resim']; }
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drift-zoom@1.5.1/dist/drift-basic.min.css">
<style>
    .masq-gallery { position: relative; max-width: 560px; }
    .masq-gallery-top { width: 100%; border: 1px solid #eee; background: #fff; }
    .masq-gallery-top .swiper-slide { display: flex; align-items: center; justify-content: center; height: 460px; }
    .masq-gallery-top .swiper-zoom-container { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .masq-gallery-top img { max-width: 100%; max-height: 440px; width: auto; height: auto; object-fit: contain; display: block; }
    .masq-gallery-thumbs { margin-top: 10px; }
    .masq-gallery-thumbs .swiper-slide { height: 90px; display: flex; align-items: center; justify-content: center; opacity: .5; cursor: pointer; border: 1px solid #eee; transition: opacity .2s; }
    .masq-gallery-thumbs .swiper-slide-thumb-active { opacity: 1; border-color: #999; }
    .masq-gallery-thumbs img { max-width: 100%; max-height: 84px; width: auto; height: auto; }
    .masq-gallery .swiper-button-next, .masq-gallery .swiper-button-prev { color: #333; }
    /* Drift hover-zoom paneli — görselin sağında; boşken ŞEFFAF (Drift kendi panelini hover'da açar).
       Arka plan/çerçeve YOK ki idle'da sağ kolonu (fiyat/sepet) örtmesin. */
    .masq-zoom-pane { position: absolute; top: 0; left: calc(100% + 16px); width: 100%; height: 460px;
        overflow: hidden; z-index: 60; pointer-events: none; }
    /* Mobil/tablette hover paneli tamamen gizli (pinch kullanılır) */
    @media (max-width: 991px) { .masq-zoom-pane { display: none !important; } }
    /* MAS-91: Mobilde portre ürün görselleri "ince ve uzun" çıkıyordu (max-height kaynaklı
       genişlik daralması). Çözüm: görseli GENİŞLİĞE göre ölçekle (edge-to-edge), doğal en-boy
       oranını koru; Swiper autoHeight slide yüksekliğini görsele uydurur. */
    @media (max-width: 991px) {
        .masq-gallery-top .swiper-slide { height: auto !important; }
        .masq-gallery-top .swiper-zoom-container { height: auto !important; width: 100% !important; }
        .masq-gallery-top img { width: 100% !important; height: auto !important; max-height: 80vh !important; }
    }
</style>

<div class="masq-gallery">
    <!-- Ana görsel -->
    <div class="swiper-container masq-gallery-top">
        <div class="swiper-wrapper">
            <?php foreach ($galImgs as $img): $src = $basePath . 'admin/resimler/' . $img; ?>
            <div class="swiper-slide">
                <div class="swiper-zoom-container">
                    <img class="masq-main-img" src="<?= htmlspecialchars($src) ?>" data-zoom="<?= htmlspecialchars($src) ?>" alt="">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Thumbnail slider -->
    <?php if (count($galImgs) > 1): ?>
    <div class="swiper-container masq-gallery-thumbs">
        <div class="swiper-wrapper">
            <?php foreach ($galImgs as $img): ?>
            <div class="swiper-slide"><img src="<?= htmlspecialchars($basePath . 'admin/resimler/' . $img) ?>" alt=""></div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Masaüstü hover-zoom paneli -->
    <div class="masq-zoom-pane"></div>
</div>

<script>
(function () {
    function initGallery() {
        if (!window.Swiper) { return false; }
        var thumbsEl = document.querySelector('.masq-gallery-thumbs');
        var thumbs = thumbsEl ? new Swiper('.masq-gallery-thumbs', {
            spaceBetween: 10, slidesPerView: 4, freeMode: true,
            watchSlidesVisibility: true, watchSlidesProgress: true
        }) : null;

        new Swiper('.masq-gallery-top', {
            spaceBetween: 10,
            autoHeight: true, // MAS-91: slide yüksekliğini aktif görselin doğal oranına uydur (mobilde ince-uzun görsel fix)
            zoom: true, // mobil pinch + çift dokunuş
            navigation: { nextEl: '.masq-gallery .swiper-button-next', prevEl: '.masq-gallery .swiper-button-prev' },
            thumbs: thumbs ? { swiper: thumbs } : undefined
        });

        // Masaüstü hover-magnify (Drift) — sadece hover destekleyen cihazlarda
        if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
            var pane = document.querySelector('.masq-zoom-pane');
            var go = function () {
                if (!window.Drift || !pane) { return; }
                document.querySelectorAll('.masq-gallery-top .masq-main-img').forEach(function (img) {
                    new Drift(img, { paneContainer: pane, inlinePane: false, hoverBoundingBox: true, zoomFactor: 2.2 });
                });
            };
            if (window.Drift) { go(); }
            else {
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/drift-zoom@1.5.1/dist/Drift.min.js';
                s.onload = go;
                document.head.appendChild(s);
            }
        }
        return true;
    }
    // Swiper footer'da yükleniyor; sayfa tam yüklenince init et. Henüz hazır değilse kısa retry.
    window.addEventListener('load', function () {
        if (initGallery()) { return; }
        var tries = 0, t = setInterval(function () {
            if (initGallery() || ++tries > 20) { clearInterval(t); }
        }, 100);
    });
})();
</script>
