<?php
/**
 * mail_templates.php — Panelden düzenlenebilir müşteri mail metinleri. (MAS-83)
 *
 * masq_mail_template($db, $key, $vars, $default):
 *   - mail_sablon tablosundan $key'li şablonu çeker, {degisken} yerlerini $vars ile doldurur.
 *   - Tablo/satır yoksa veya boşsa $default (koddaki mevcut metin) kullanılır → HİÇBİR ŞEY BOZULMAZ.
 *     (SQL prod'a uygulanmadan da site aynen çalışmaya devam eder.)
 *
 * @param PDO    $db
 * @param string $key      Şablon anahtarı (ör. 'order_completed')
 * @param array  $vars     ['name'=>..., 'order_no'=>...] → {name}, {order_no} yerine geçer
 * @param array  $default  ['konu'=>..., 'icerik'=>...] koddaki mevcut metin (fallback)
 * @return array ['konu'=>..., 'icerik'=>...]  (değişkenler yerleştirilmiş)
 */
function masq_mail_template(PDO $db, string $key, array $vars, array $default): array
{
    $konu   = $default['konu']   ?? '';
    $icerik = $default['icerik'] ?? '';

    try {
        $st = $db->prepare("SELECT konu, icerik FROM mail_sablon WHERE mkey = ? LIMIT 1");
        $st->execute([$key]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if ($row && trim((string) $row['icerik']) !== '') {
            if (trim((string) $row['konu']) !== '') { $konu = $row['konu']; }
            $icerik = $row['icerik'];
        }
    } catch (\Throwable $e) {
        // mail_sablon tablosu yoksa (SQL henüz uygulanmadıysa) sessizce default kullan.
    }

    $repl = [];
    foreach ($vars as $k => $v) {
        $repl['{' . $k . '}'] = (string) $v;
    }

    return [
        'konu'   => strtr($konu, $repl),
        'icerik' => strtr($icerik, $repl),
    ];
}
