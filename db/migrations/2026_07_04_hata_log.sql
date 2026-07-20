-- MAS-8 / INF-4: Panel içi hata izleme (Sentry yerine, self-hosted).
-- Backend PHP + frontend JS hataları burada toplanır; aynı hata tek satırda
-- gruplanır (hash UNIQUE + adet sayacı) → mail/Slack yok, spam yok.
-- Natro (prod) üzerinde phpMyAdmin'den bir kez çalıştırılacak.

CREATE TABLE IF NOT EXISTS `hata_log` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `hash` CHAR(32) NOT NULL UNIQUE,          -- dedupe: tur+dosya+satir+mesaj
  `tur` VARCHAR(24) NOT NULL,               -- php_exception | php_fatal | php_error | js | js_promise
  `seviye` VARCHAR(24) DEFAULT '',          -- E_WARNING, FATAL, error vb.
  `mesaj` TEXT NOT NULL,
  `dosya` VARCHAR(500) DEFAULT '',
  `satir` INT DEFAULT 0,
  `iz` MEDIUMTEXT,                          -- stack trace
  `url` VARCHAR(1000) DEFAULT '',
  `kullanici` VARCHAR(255) DEFAULT '',
  `ip` VARCHAR(64) DEFAULT '',
  `tarayici` VARCHAR(500) DEFAULT '',       -- user agent
  `adet` INT DEFAULT 1,                      -- kaç kez oldu
  `cozuldu` TINYINT DEFAULT 0,              -- panelden "çözüldü" işareti
  `ilk_gorulme` DATETIME DEFAULT NULL,
  `son_gorulme` DATETIME DEFAULT NULL,
  INDEX `idx_cozuldu` (`cozuldu`),
  INDEX `idx_son` (`son_gorulme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
