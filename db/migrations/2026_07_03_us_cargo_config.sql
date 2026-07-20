-- MAS-85: US kargo config satırı (icecek id=2). Kanada = id=1.
-- US oranları Kanada'dan bağımsız; başlangıç için Kanada satırı kopyalanır, admin panelden düzenler.
-- (Panelden ilk "US" kaydında zaten otomatik oluşur; bu, hazır bir başlangıç satırı için opsiyoneldir.)
-- Natro'da phpMyAdmin'den bir kez çalıştırılabilir. Idempotent: id=2 varsa hiçbir şey yapmaz.

INSERT INTO `icecek`
    (`id`,`adi`,`sira`,`kategori`,`durum`,`durum1`,`durum2`,`onaciklama`,`yazi1`,`yazi2`,`yazi3`,`yazi4`,`yazi5`,`yazi6`,`yazi7`,`yazi8`,`yazi9`,`yazi10`,`tur`)
SELECT 2,`adi`,`sira`,`kategori`,`durum`,`durum1`,`durum2`,`onaciklama`,`yazi1`,`yazi2`,`yazi3`,`yazi4`,`yazi5`,`yazi6`,`yazi7`,`yazi8`,`yazi9`,`yazi10`,`tur`
FROM `icecek`
WHERE `id` = 1
  AND NOT EXISTS (SELECT 1 FROM (SELECT `id` FROM `icecek` WHERE `id` = 2) AS t);
