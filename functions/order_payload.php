<?php
/**
 * order_payload.php — Checkout payload yardımcıları. (MAS-10)
 *
 * Sipariş kalemlerini OTORİTER kaynaktan toplar (tur garantili):
 *   - Üye    : sepet tablosu (tur kolonu mevcut)
 *   - Misafir: noid session sepeti (item'larda tur var)
 *
 * Not: ürün id'leri tablolar arası çakıştığı için tur'u id'den TÜRETEMEYİZ;
 * mutlaka sepet kaynağından almak gerekir.
 */

/**
 * @return array<int,array{id:mixed,name:string,quantity:int,totalPrice:mixed,tur:string}>
 */
function masq_collect_order_items(PDO $db): array
{
    $items = [];

    if (isset($_SESSION['id'])) {
        // ÜYE — sepet tablosu
        $stmt = $db->prepare(
            "SELECT UrunID, UrunAdi, UrunMiktari, FiyatToplam, tur FROM sepet WHERE KullaniciID = ?"
        );
        $stmt->execute([$_SESSION['id']]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = [
                'id'         => $row['UrunID'],
                'name'       => $row['UrunAdi'],
                'quantity'   => (int) $row['UrunMiktari'],
                'totalPrice' => $row['FiyatToplam'],
                'tur'        => $row['tur'],
            ];
        }
        return $items;
    }

    // MİSAFİR — noid session sepetini güvenli şekilde oku (session değiştir → geri al)
    $cart = masq_read_noid_cart();
    foreach ($cart as $item) {
        $qty = (int) ($item['quantity'] ?? 0);
        $items[] = [
            'id'         => $item['id'] ?? null,
            'name'       => $item['name'] ?? '',
            'quantity'   => $qty,
            'totalPrice' => $item['totalPrice'] ?? (($item['price'] ?? 0) * $qty),
            'tur'        => $item['tur'] ?? '',
        ];
    }
    return $items;
}

/**
 * Misafirin 'noid' session sepetini, aktif (varsayılan) session'ı bozmadan okur.
 * Çağrıldığı anda varsayılan session açık olmalıdır; fonksiyon onu kapatıp
 * geri açar, böylece çağıran taraf kaldığı yerden devam eder.
 */
function masq_read_noid_cart(): array
{
    $defaultName = session_name();
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    session_name('noid');
    session_start();
    $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
    session_write_close();

    // Varsayılan session'a geri dön
    session_name($defaultName);
    session_start();

    return $cart;
}

/**
 * Misafirin 'noid' sepetini temizler (ödeme sonrası). Aktif session'ı korur.
 */
function masq_clear_noid_cart(): void
{
    $defaultName = session_name();
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    session_name('noid');
    session_start();
    unset($_SESSION['cart']);
    session_write_close();

    session_name($defaultName);
    session_start();
}
