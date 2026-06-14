<?php
/**
 * color_variants_form.php — Ürün ekle/düzenle formunda renk varyantı seçicileri. (MAS-28/MAS-29)
 *
 * Eski sistem: 5 ayrı select, her biri TÜM ürünleri AYRI sorguyla çekiyordu (5× tam tablo),
 * ve seçilen ürünün görselini JS ile gizli yazi15..19 kolonlarına KOPYALIYORDU (bayatlama bug'ı).
 *
 * Yeni: ürünler TEK sorguda çekilir (MAS-29), 5 select bu listeyi paylaşır, select2 ile
 * aranabilir. Görsel KOPYALANMAZ — detail sayfası varyantın canlı resim'ini gösterir (MAS-28).
 *
 * Beklenen değişkenler:
 *   $db        (PDO)
 *   $cvTable   (string)  varyant tablosu, ör. 'urunler'
 *   $guncelle  (array)   düzenlenen ürün satırı (yoksa boş array)
 */

$cvSlots    = ['yazi10', 'yazi11', 'yazi12', 'yazi13', 'yazi14'];
$cvTableSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $cvTable);
$cvProducts = $db->query("SELECT id, adi FROM {$cvTableSafe} ORDER BY adi ASC", PDO::FETCH_ASSOC)->fetchAll();
$cvCurrentId = isset($guncelle['id']) ? (int) $guncelle['id'] : 0;
?>
<div class="mb-3">
    <h5>Color Variants</h5>
    <p>Link other color versions of this product. The variant's image is taken automatically
       from that product, so it always stays up to date. Leave empty if none.</p>

    <?php foreach ($cvSlots as $slot):
        $current = isset($guncelle[$slot]) ? (string) $guncelle[$slot] : '';
    ?>
    <select class="form-select cv-select mb-2" name="<?= $slot ?>">
        <option value="">Choose One</option>
        <?php foreach ($cvProducts as $p):
            if ((int) $p['id'] === $cvCurrentId) { continue; } // ürün kendini varyant seçemesin
        ?>
        <option value="<?= $p['id'] ?>" <?= ($current !== '' && $current === (string) $p['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['adi']) ?> (#<?= $p['id'] ?>)
        </option>
        <?php endforeach; ?>
    </select>
    <?php endforeach; ?>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script>
// select2 jQuery'den SONRA yüklenmeli; ekle sayfasında jQuery genelde en altta.
// Bu yüzden sayfa tam yüklenince (jQuery hazırken) select2'yi dinamik yükleyip başlatıyoruz.
// jQuery yoksa select'ler normal dropdown olarak çalışmaya devam eder (graceful fallback).
window.addEventListener('load', function () {
    if (!window.jQuery) { return; }
    function initCv() {
        jQuery('.cv-select').select2({ width: '100%', placeholder: 'Choose One', allowClear: true });
    }
    if (jQuery.fn && jQuery.fn.select2) { initCv(); return; }
    var s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
    s.onload = initCv;
    document.head.appendChild(s);
});
</script>
