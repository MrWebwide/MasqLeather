-- ============================================================
-- MAS-46 — TÜM SQL (tek dosya) | Ürünlere admin-tanımlı yapılandırılabilir seçenekler
-- Her ortamda (Natro DEV + PROD) bir kez çalıştır. utf8mb4 şart (Türkçe karakter).
-- Not: ALTER ... ADD COLUMN kolon zaten varsa "Duplicate column" hatası verir — normaldir, atlanabilir.
-- ============================================================

-- 1) Selector tanımları (ürün başına sınırsız selector)
CREATE TABLE IF NOT EXISTS product_options (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    urun_id     INT          NOT NULL,
    tur         VARCHAR(32)  NOT NULL,                    -- bagpurses / jewelry / accessories / homedecor
    baslik      VARCHAR(255) NOT NULL,
    tip         VARCHAR(16)  NOT NULL DEFAULT 'select',
    zorunlu     TINYINT(1)   NOT NULL DEFAULT 1,
    sira        INT          NOT NULL DEFAULT 0,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_product (tur, urun_id),
    KEY idx_sira (sira)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2) Selector değerleri (selector başına sınırsız değer; option silinince CASCADE siler)
CREATE TABLE IF NOT EXISTS product_option_values (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    option_id   INT           NOT NULL,
    deger       VARCHAR(255)  NOT NULL,
    fiyat_farki DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    sira        INT           NOT NULL DEFAULT 0,
    KEY idx_option (option_id),
    CONSTRAINT fk_option_values_option
        FOREIGN KEY (option_id) REFERENCES product_options (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Sepet satırına seçim snapshot'ı (JSON)
ALTER TABLE sepet   ADD COLUMN secimler TEXT NULL DEFAULT NULL AFTER tur;

-- 4) Sipariş kalemine seçim snapshot'ı (JSON)
ALTER TABLE siparis ADD COLUMN secimler TEXT NULL DEFAULT NULL AFTER tur;
