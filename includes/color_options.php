<?php
/**
 * color_options.php — Ürün detayında renk varyantlarını render eder. (MAS-28)
 *
 * Eski sistem: varyant görseli ayrı kolonlara (yazi15..19) KOPYALANIYORDU; varyant
 * ürünün asıl fotoğrafı değişince bu kopya bayatlıyordu (bug). Ayrıca durum kontrolü
 * her varyant için ayrı sorguyla (N+1) ve yanlış tabloda (hep 'urunler') yapılıyordu.
 *
 * Yeni: varyant ID'leri yazi10..14'te. Görsel + durum, varyant ürünün KENDİ tablosundan
 * TEK sorguda CANLI çekilir → her zaman güncel, N+1 yok, doğru tablo.
 *
 * @param PDO    $db
 * @param string $table       Varyant tablosu (urunler/accessories/jewe/homedecor)
 * @param string $detailPage  Varyant linki için detay sayfası (örn. 'bagpurses-detail.php')
 * @param array  $row         Mevcut ürün satırı (yazi10..yazi14 = varyant ürün ID'leri)
 * @param string $basePath    Görsel/link prefix (varsayılan './')
 */
function masq_render_color_options(PDO $db, string $table, string $detailPage, array $row, string $basePath = './'): void
{
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

    // Varyant ID'lerini sıralı + tekilleştirilmiş topla
    $ids = [];
    foreach (['yazi10', 'yazi11', 'yazi12', 'yazi13', 'yazi14'] as $slot) {
        if (!empty($row[$slot]) && !in_array((int) $row[$slot], $ids, true)) {
            $ids[] = (int) $row[$slot];
        }
    }
    if (!$ids) {
        return;
    }

    // Tek sorgu: aktif varyantların CANLI görseli (tek kaynak → bayatlamaz)
    $place = implode(',', array_fill(0, count($ids), '?'));
    $stmt  = $db->prepare("SELECT id, resim FROM {$table} WHERE id IN ({$place}) AND durum = 'on'");
    $stmt->execute($ids);
    $map = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
        $map[(int) $r['id']] = $r['resim'];
    }
    if (!$map) {
        return;
    }
    ?>
    <div class="product_details_title">
        <h3>Color Options</h3>
        <div class="coloropt d-flex">
            <?php foreach ($ids as $vid): ?>
                <?php if (!isset($map[$vid])) continue; ?>
                <a href="<?= $basePath . htmlspecialchars($detailPage) ?>?id=<?= $vid ?>" class="color_option">
                    <img src="<?= $basePath ?>admin/resimler/<?= htmlspecialchars($map[$vid]) ?>" alt="">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
