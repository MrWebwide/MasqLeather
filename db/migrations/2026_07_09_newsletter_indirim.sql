-- MAS-110: Newsletter'a kayıt olana bir kerelik indirim maili.
-- Panelden yönetilir: indirim oranı, açık/kapalı, kupon kod öneki + mail metni (mail_sablon).

-- 1) İndirim ayarları (tek satır)
CREATE TABLE IF NOT EXISTS newsletter_indirim (
    id       INT PRIMARY KEY AUTO_INCREMENT,
    aktif    TINYINT(1)    NOT NULL DEFAULT 1,      -- 1: kayıt olana indirim maili gönder
    oran     DECIMAL(5,2)  NOT NULL DEFAULT 10.00,  -- yüzde indirim (cupon.fiyat ile aynı mantık)
    kod_onek VARCHAR(20)   NOT NULL DEFAULT 'WELCOME'
);

INSERT INTO newsletter_indirim (id, aktif, oran, kod_onek)
SELECT 1, 1, 10.00, 'WELCOME'
WHERE NOT EXISTS (SELECT 1 FROM newsletter_indirim WHERE id = 1);

-- 2) Mail şablonu (MAS-83 sistemine eklenir → admin > Mail Metinleri sayfasından da düzenlenebilir)
--    Değişkenler: {code} = kupon kodu, {oran} = indirim yüzdesi
INSERT INTO mail_sablon (mkey, baslik, konu, icerik, degiskenler)
SELECT 'newsletter_welcome',
       'Newsletter Hosgeldin Indirimi',
       'Welcome to Masq Leather - Your {oran}% Discount Inside',
       '<p>Thank you for subscribing to Masq Leather!</p><p>Here is your one-time <strong>{oran}%</strong> discount code:</p><p style="font-size:22px;font-weight:700;letter-spacing:2px;">{code}</p><p>Apply it at checkout. Enjoy your shopping!</p>',
       '{code}, {oran}'
WHERE NOT EXISTS (SELECT 1 FROM mail_sablon WHERE mkey = 'newsletter_welcome');
