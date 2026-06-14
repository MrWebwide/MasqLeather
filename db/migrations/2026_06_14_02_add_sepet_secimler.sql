-- MAS-46 A3: sepete eklenen ürünle birlikte seçilen selector değerlerini (JSON snapshot) saklar.
-- Aynı ürün + farklı seçimler = ayrı sepet satırı; aynı ürün + aynı seçimler = miktar artar.
ALTER TABLE sepet ADD COLUMN secimler TEXT NULL DEFAULT NULL AFTER tur;
