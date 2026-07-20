-- MAS-86(a): Grup landing sayfaları (Bags & Purses / Accessories / Home Decor / Jewelry)
-- için opsiyonel başlık arka plan görseli. gkey = kategori tablosu adı (grup anahtarı).
CREATE TABLE IF NOT EXISTS grup_banner (
    gkey  VARCHAR(32)  NOT NULL PRIMARY KEY,
    resim VARCHAR(255) NOT NULL DEFAULT 'resim-yok'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO grup_banner (gkey, resim) VALUES
  ('urun_kategori',  'resim-yok'),
  ('bolge_kategori', 'resim-yok'),
  ('mer_kategori',   'resim-yok'),
  ('jewe_kategori',  'resim-yok');
