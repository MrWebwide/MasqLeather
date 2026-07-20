<?php
/**
 * cat_counts.php — Kategori + ürün sayısı sorgusu için request-içi memoization. (MAS-21)
 *
 * Header (desktop + mobil menü) aynı COUNT sorgusunu request başına birden çok kez
 * çalıştırıyordu. Bu helper sonucu static cache'te tutar → request başına tek sorgu.
 */
function masq_category_counts(PDO $db, string $catTable, string $prodTable): array
{
    static $cache = [];
    $catTable  = preg_replace('/[^a-zA-Z0-9_]/', '', $catTable);
    $prodTable = preg_replace('/[^a-zA-Z0-9_]/', '', $prodTable);
    $key = $catTable . '|' . $prodTable;
    if (isset($cache[$key])) { return $cache[$key]; }

    // MAS-102: yalnızca yayında (durum='on') ürünler sayılır — eskiden gizli/taslak ürünler de
    // sayılıyordu (ör. "Laptop Bags(2)" ama kategori sayfasında 0 aktif ürün görünüyordu).
    $rows = $db->query(
        "SELECT bk.adi, bk.sira, COUNT(b.id) AS urun_sayisi
           FROM {$catTable} AS bk
           LEFT JOIN {$prodTable} AS b ON bk.adi = b.kategori AND b.durum = 'on'
          GROUP BY bk.adi, bk.sira
          ORDER BY bk.sira ASC, bk.adi ASC"
    )->fetchAll(PDO::FETCH_ASSOC);

    return $cache[$key] = $rows;
}
