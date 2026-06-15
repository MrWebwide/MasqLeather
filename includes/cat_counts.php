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

    $rows = $db->query(
        "SELECT bk.adi, COUNT(b.id) AS urun_sayisi
           FROM {$catTable} AS bk
           LEFT JOIN {$prodTable} AS b ON bk.adi = b.kategori
          GROUP BY bk.adi"
    )->fetchAll(PDO::FETCH_ASSOC);

    return $cache[$key] = $rows;
}
