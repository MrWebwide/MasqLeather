-- ============================================================
-- Migration: create product_options + product_option_values, add siparis.secimler
-- Date:      2026-06-14
-- Issue:     MAS-46 — Ürünlere admin-tanımlı yapılandırılabilir seçenekler
-- ------------------------------------------------------------
-- Admin, ürün başına SINIRSIZ "selector" (dropdown) tanımlar; her selector'ın
-- başlığı (product_options.baslik) + SINIRSIZ değeri (product_option_values)
-- olur. Ürünler 4 ayrı tabloda (urunler/jewe/accessories/homedecor) ve id'ler
-- çakıştığı için seçenekler (urun_id, tur) ile ürüne bağlanır.
--
-- Müşterinin seçimi sipariş anında siparis.secimler içine JSON snapshot olarak
-- yazılır (option tanımı sonradan değişse bile sipariş ne seçildiğini korur).
--
-- NOT: Her ortamda (local / dev / prod-Natro) AYRI çalıştırılmalıdır.
-- ============================================================

CREATE TABLE IF NOT EXISTS product_options (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    urun_id     INT          NOT NULL,                    -- ürün PK (id) — tur ile birlikte ürünü tekilleştirir
    tur         VARCHAR(32)  NOT NULL,                    -- bagpurses / jewelry / accessories / homedecor
    baslik      VARCHAR(255) NOT NULL,                    -- selector başlığı (ör. "Kayış Boyu")
    tip         VARCHAR(16)  NOT NULL DEFAULT 'select',   -- ileride radio/text için
    zorunlu     TINYINT(1)   NOT NULL DEFAULT 1,          -- müşteri seçmek zorunda mı
    sira        INT          NOT NULL DEFAULT 0,          -- gösterim sırası
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_product (tur, urun_id),
    KEY idx_sira (sira)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS product_option_values (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    option_id   INT           NOT NULL,                   -- FK -> product_options.id
    deger       VARCHAR(255)  NOT NULL,                   -- seçenek değeri (ör. "Medium")
    fiyat_farki DECIMAL(10,2) NOT NULL DEFAULT 0.00,      -- ops. upcharge; şimdilik 0 (fiyatı etkilemez)
    sira        INT           NOT NULL DEFAULT 0,
    KEY idx_option (option_id),
    CONSTRAINT fk_option_values_option
        FOREIGN KEY (option_id) REFERENCES product_options (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sipariş kalemine seçim snapshot'ı (JSON string). Eski siparişlerde NULL kalır.
-- (Bu ALTER bir kez çalıştırılır; kolon zaten varsa "Duplicate column" hatası normaldir.)
ALTER TABLE siparis ADD COLUMN secimler TEXT NULL DEFAULT NULL AFTER tur;
