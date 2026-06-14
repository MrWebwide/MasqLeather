-- MAS-25: Province (eyalet) vergi oranlarını panelden yönetilebilir yap.
-- Eskiden oranlar checkout.php içinde hardcoded bir PHP array'di ($taxRates) ve
-- yalnızca ekranda gösterim içindi; gerçek tahsilatta Stripe automatic_tax 0 çekiyordu.
-- Artık oranlar bu tablodan okunur; checkout ekranı + Stripe ödeme satırı buradan beslenir.

CREATE TABLE IF NOT EXISTS province_tax (
  id    INT(11)      NOT NULL AUTO_INCREMENT,
  code  VARCHAR(5)   NOT NULL,                  -- AB, BC, ON, QC ...
  name  VARCHAR(100) NOT NULL,                  -- Alberta, Ontario ...
  rate  DECIMAL(5,2) NOT NULL DEFAULT 0.00,     -- yüzde (ör. 13.00)
  PRIMARY KEY (id),
  UNIQUE KEY uniq_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mevcut hardcoded oranlarla seed (checkout.php $taxRates ile birebir):
INSERT INTO province_tax (code, name, rate) VALUES
  ('AB', 'Alberta', 5.00),
  ('BC', 'British Columbia', 5.00),
  ('MB', 'Manitoba', 5.00),
  ('NB', 'New Brunswick', 15.00),
  ('NL', 'Newfoundland and Labrador', 15.00),
  ('NS', 'Nova Scotia', 15.00),
  ('ON', 'Ontario', 13.00),
  ('PE', 'Prince Edward Island', 15.00),
  ('QC', 'Quebec', 5.00),
  ('SK', 'Saskatchewan', 5.00),
  ('NT', 'Northwest Territories', 5.00),
  ('NU', 'Nunavut', 5.00),
  ('YT', 'Yukon', 5.00)
ON DUPLICATE KEY UPDATE name = VALUES(name);
