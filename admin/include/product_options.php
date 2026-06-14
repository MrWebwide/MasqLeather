<?php
/**
 * product_options.php — Ürünlere admin-tanımlı yapılandırılabilir seçenekler (MAS-46).
 *
 * 4 ürün dosyası da (urun/jewe/accessories/homedecor -ekle.php) bunu kullanır:
 *   - masq_save_product_options()      : POST'taki options[] yapısını DB'ye yazar (ekle+düzenle ortak)
 *   - masq_get_product_options()       : (urun_id, tur) için seçenekleri + değerlerini getirir
 *   - masq_render_options_repeater()   : admin formundaki repeater UI'ı (mevcutları prefill ederek) basar
 *
 * Veri: product_options (urun_id, tur, baslik, zorunlu, sira) + product_option_values (option_id, deger, sira).
 */

if (!function_exists('masq_save_product_options')) {

    /**
     * Bir ürünün tüm seçeneklerini POST'tan (yeniden) yazar.
     * Önce (urun_id, tur) için mevcutları siler (FK CASCADE değerleri de siler), sonra ekler.
     */
    function masq_save_product_options(PDO $db, int $urunId, string $tur, $optionsPost): void
    {
        $del = $db->prepare("DELETE FROM product_options WHERE urun_id = ? AND tur = ?");
        $del->execute([$urunId, $tur]);

        if (!is_array($optionsPost)) {
            return;
        }

        $insOpt = $db->prepare("INSERT INTO product_options (urun_id, tur, baslik, zorunlu, sira) VALUES (?,?,?,?,?)");
        $insVal = $db->prepare("INSERT INTO product_option_values (option_id, deger, sira) VALUES (?,?,?)");

        $optSira = 0;
        foreach ($optionsPost as $opt) {
            if (!is_array($opt)) {
                continue;
            }
            $baslik = trim((string) ($opt['baslik'] ?? ''));
            if ($baslik === '') {
                continue;
            }
            // Boş olmayan değerleri topla
            $clean = [];
            if (isset($opt['values']) && is_array($opt['values'])) {
                foreach ($opt['values'] as $v) {
                    $v = trim((string) $v);
                    if ($v !== '') {
                        $clean[] = $v;
                    }
                }
            }
            if (empty($clean)) {
                continue; // değeri olmayan selector kaydedilmez
            }
            $zorunlu = !empty($opt['zorunlu']) ? 1 : 0;
            $insOpt->execute([$urunId, $tur, $baslik, $zorunlu, $optSira++]);
            $optionId = (int) $db->lastInsertId();
            $valSira = 0;
            foreach ($clean as $v) {
                $insVal->execute([$optionId, $v, $valSira++]);
            }
        }
    }

    /**
     * (urun_id, tur) için seçenekleri değerleriyle birlikte döndürür.
     * @return array [ ['id','baslik','zorunlu','sira','values'=>[['id','deger','fiyat_farki','sira'],...]], ... ]
     */
    function masq_get_product_options(PDO $db, int $urunId, string $tur): array
    {
        $stmt = $db->prepare("SELECT id, baslik, zorunlu, sira FROM product_options WHERE urun_id = ? AND tur = ? ORDER BY sira, id");
        $stmt->execute([$urunId, $tur]);
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$options) {
            return [];
        }
        $valStmt = $db->prepare("SELECT id, deger, fiyat_farki, sira FROM product_option_values WHERE option_id = ? ORDER BY sira, id");
        foreach ($options as &$o) {
            $valStmt->execute([$o['id']]);
            $o['values'] = $valStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        unset($o);
        return $options;
    }

    /** Tek bir değer input'unun HTML'i (idx yer tutucu __I__). */
    function masq_option_value_row(string $idx, string $deger = ''): string
    {
        $v = htmlspecialchars($deger, ENT_QUOTES);
        return '<span class="value-row" style="display:inline-flex;align-items:center;gap:4px;margin:0 6px 6px 0;">'
            . '<input type="text" class="form-control form-control-sm value-input" name="options[' . $idx . '][values][]" placeholder="Seçenek (ör. Medium)" value="' . $v . '" style="width:auto;min-width:160px;">'
            . '<button type="button" class="btn btn-sm btn-link text-danger p-0 remove-value" title="Sil" style="text-decoration:none;font-size:18px;line-height:1;">&times;</button>'
            . '</span>';
    }

    /** Tek bir selector (option) bloğunun HTML'i. */
    function masq_option_block(string $idx, string $baslik = '', bool $zorunlu = true, array $values = []): string
    {
        $b = htmlspecialchars($baslik, ENT_QUOTES);
        $checked = $zorunlu ? 'checked' : '';
        $valuesHtml = '';
        if ($values) {
            foreach ($values as $val) {
                $valuesHtml .= masq_option_value_row($idx, (string) ($val['deger'] ?? ''));
            }
        } else {
            $valuesHtml = masq_option_value_row($idx, '');
        }
        return '<div class="option-block card p-3 mb-2" data-idx="' . $idx . '" style="background:#f8f9fa;">'
            . '<div class="d-flex align-items-center mb-2" style="gap:10px;">'
            . '<input type="text" class="form-control" name="options[' . $idx . '][baslik]" placeholder="Selector başlığı (ör. Kayış Boyu)" value="' . $b . '" style="max-width:340px;">'
            . '<label class="text-nowrap mb-0"><input type="checkbox" name="options[' . $idx . '][zorunlu]" value="1" ' . $checked . '> Zorunlu</label>'
            . '<button type="button" class="btn btn-danger btn-sm remove-option ms-auto">Selector\'ı Sil</button>'
            . '</div>'
            . '<div class="values" style="display:flex;flex-wrap:wrap;align-items:center;">' . $valuesHtml . '</div>'
            . '<div><button type="button" class="btn btn-outline-secondary btn-sm mt-2 add-value">+ Seçenek Ekle</button></div>'
            . '</div>';
    }

    /**
     * Admin formundaki "Product Options" repeater bölümünü basar (mevcutları prefill ederek).
     */
    function masq_render_options_repeater(array $options): string
    {
        $existing = '';
        $i = 0;
        foreach ($options as $o) {
            $existing .= masq_option_block(
                (string) $i,
                (string) ($o['baslik'] ?? ''),
                !empty($o['zorunlu']),
                $o['values'] ?? []
            );
            $i++;
        }
        $startIdx = $i; // yeni eklenenler buradan devam eder

        // JS şablonları için boş bir blok ve değer satırı (yer tutucu __I__)
        $blockTpl = masq_option_block('__I__', '', true, []);
        $valueTpl = masq_option_value_row('__I__', '');

        ob_start(); ?>
        <div class="mb-4" id="productOptionsSection">
            <h5>Product Options (Selectors)</h5>
            <p class="text-muted" style="margin-bottom:10px;">
                Müşterinin bu üründe seçeceği dropdown'lar. Her selector için başlık + seçenekleri girin;
                istediğiniz kadar selector ve seçenek ekleyebilirsiniz. (Boş bırakılanlar kaydedilmez.)
            </p>
            <div id="optionsRepeater"><?php echo $existing; ?></div>
            <button type="button" class="btn btn-primary btn-sm" id="addOptionBtn">+ Selector Ekle</button>

            <template id="optionBlockTpl"><?php echo $blockTpl; ?></template>
            <template id="valueInputTpl"><?php echo $valueTpl; ?></template>
        </div>
        <script>
        (function () {
            var repeater = document.getElementById('optionsRepeater');
            var blockTpl = document.getElementById('optionBlockTpl').innerHTML;
            var valueTpl = document.getElementById('valueInputTpl').innerHTML;
            var nextIdx = <?php echo (int) $startIdx; ?>;

            document.getElementById('addOptionBtn').addEventListener('click', function () {
                var html = blockTpl.split('__I__').join(String(nextIdx++));
                var wrap = document.createElement('div');
                wrap.innerHTML = html.trim();
                repeater.appendChild(wrap.firstChild);
            });

            // Delegasyon: değer ekle / selector sil / değer sil
            repeater.addEventListener('click', function (e) {
                var block = e.target.closest('.option-block');
                if (e.target.classList.contains('add-value') && block) {
                    var idx = block.getAttribute('data-idx');
                    var html = valueTpl.split('__I__').join(idx);
                    var wrap = document.createElement('div');
                    wrap.innerHTML = html.trim();
                    block.querySelector('.values').appendChild(wrap.firstChild);
                } else if (e.target.classList.contains('remove-option') && block) {
                    block.remove();
                } else if (e.target.classList.contains('remove-value')) {
                    var row = e.target.closest('.value-row');
                    if (row) row.remove();
                }
            });
        })();
        </script>
        <?php
        return ob_get_clean();
    }
}
