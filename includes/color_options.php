<?php
/**
 * color_options.php — Ürün detayında renk varyantlarını render eder. (MAS-28)
 *
 * Eski sistem: varyant görseli ayrı kolonlara (yazi15..19) KOPYALANIYORDU; varyant
 * ürünün asıl fotoğrafı değişince bu kopya bayatlıyordu (bug). Ayrıca durum kontrolü
 * her varyant için ayrı sorguyla (N+1) ve yanlış tabloda (hep 'urunler') yapılıyordu.
 *
 * Yeni: varyant ID'leri yazi10..19'da (MAS-111: 5 → 10 slot). Görsel + durum, varyant
 * ürünün KENDİ tablosundan TEK sorguda CANLI çekilir → her zaman güncel, N+1 yok, doğru tablo.
 *
 * @param PDO    $db
 * @param string $table       Varyant tablosu (urunler/accessories/jewe/homedecor)
 * @param string $detailPage  Varyant linki için detay sayfası (örn. 'bagpurses-detail.php')
 * @param array  $row         Mevcut ürün satırı (yazi10..yazi19 = varyant ürün ID'leri)
 * @param string $basePath    Görsel/link prefix (varsayılan './')
 */
function masq_render_color_options(PDO $db, string $table, string $detailPage, array $row, string $basePath = './'): void
{
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

    // Varyant ID'lerini sıralı + tekilleştirilmiş topla.
    // MAS-111: yazi15..19 eskiden görsel DOSYA ADI tutuyordu (ör. "183-towel.png"). Bu
    // slotlar artık varyant ID'si için kullanılıyor; eski/bayat dosya-adı değerleri (int)
    // cast edilince sahte varyant üretmesin diye YALNIZCA tam sayı olanları kabul ediyoruz.
    $ids = [];
    foreach (['yazi10', 'yazi11', 'yazi12', 'yazi13', 'yazi14',
              'yazi15', 'yazi16', 'yazi17', 'yazi18', 'yazi19'] as $slot) {
        $val = isset($row[$slot]) ? trim((string) $row[$slot]) : '';
        if ($val === '' || !ctype_digit($val)) { continue; } // boş ya da eski dosya adı → atla
        $vid = (int) $val;
        if ($vid > 0 && !in_array($vid, $ids, true)) {
            $ids[] = $vid;
        }
    }
    if (!$ids) {
        return;
    }

    // Tek sorgu: aktif varyantların CANLI görseli (tek kaynak → bayatlamaz).
    // MAS-96: "Color Options" = aynı ürünün renk varyantı → yalnızca AYNI kategorideki
    // varyantlar gösterilir (admin yanlışlıkla farklı kategoriden ürün bağlarsa görünmez).
    $place  = implode(',', array_fill(0, count($ids), '?'));
    $params = $ids;
    $catFilter = '';
    if (!empty($row['kategori'])) {
        $catFilter = ' AND kategori = ?';
        $params[]  = $row['kategori'];
    }
    $stmt = $db->prepare("SELECT id, resim FROM {$table} WHERE id IN ({$place}) AND durum = 'on'{$catFilter}");
    $stmt->execute($params);
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
