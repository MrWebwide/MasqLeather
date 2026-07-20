<?php
/**
 * error_handler.php — Panel içi hata izleme (MAS-8 / INF-4).
 *
 * Backend PHP hatalarını (uncaught exception, fatal, warning/error) hata_log
 * tablosuna yazar. Aynı hata (tur+dosya+satir+mesaj hash'i) tekrar gelirse yeni
 * satır AÇMAZ, sadece adet sayacını artırır → mail/Slack yok, spam yok.
 *
 * baglan.php sonunda ($db oluştuktan sonra) require edilir → tüm sayfalarda aktif.
 * JS hataları functions/js_error.php üzerinden yine masq_log_error() ile yazılır.
 *
 * Güvenli: hata_log tablosu yoksa / DB yoksa sessizce error_log'a düşer, uygulamayı
 * asla çökertmez. Kendi hatasında sonsuz döngüye girmez (recursion guard).
 */

if (!function_exists('masq_log_error')) {

    function masq_log_error(string $tur, string $mesaj, string $dosya = '', int $satir = 0, string $iz = '', string $seviye = ''): void
    {
        static $guard = false;
        if ($guard) { return; }               // kendi hatasında tekrar loglama
        $guard = true;

        global $db;
        try {
            if (!($db instanceof PDO)) { $guard = false; return; }

            $mesaj = trim($mesaj);
            if ($mesaj === '') { $guard = false; return; }
            $mesaj = mb_substr($mesaj, 0, 2000);
            $iz    = mb_substr($iz, 0, 20000);

            $url = $_SERVER['REQUEST_URI'] ?? ($_SERVER['SCRIPT_NAME'] ?? 'cli');
            $ip  = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? ($_SERVER['REMOTE_ADDR'] ?? '');
            $ua  = mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
            $kullanici = (string) ($_SESSION['eposta'] ?? ($_SESSION['adsoyad'] ?? ($_SESSION['id'] ?? '')));

            $hash = md5($tur . '|' . $dosya . '|' . $satir . '|' . mb_substr($mesaj, 0, 200));

            $sql = "INSERT INTO hata_log
                    (hash, tur, seviye, mesaj, dosya, satir, iz, url, kullanici, ip, tarayici, adet, cozuldu, ilk_gorulme, son_gorulme)
                    VALUES (:hash,:tur,:seviye,:mesaj,:dosya,:satir,:iz,:url,:kullanici,:ip,:ua,1,0,NOW(),NOW())
                    ON DUPLICATE KEY UPDATE
                        adet = adet + 1, son_gorulme = NOW(), cozuldu = 0,
                        mesaj = VALUES(mesaj), iz = VALUES(iz), url = VALUES(url),
                        kullanici = VALUES(kullanici), ip = VALUES(ip), tarayici = VALUES(tarayici)";
            $st = $db->prepare($sql);
            $st->execute([
                ':hash' => $hash, ':tur' => $tur, ':seviye' => $seviye, ':mesaj' => $mesaj,
                ':dosya' => mb_substr($dosya, 0, 500), ':satir' => $satir, ':iz' => $iz,
                ':url' => mb_substr($url, 0, 1000), ':kullanici' => mb_substr($kullanici, 0, 255),
                ':ip' => mb_substr($ip, 0, 64), ':ua' => $ua,
            ]);
        } catch (\Throwable $e) {
            @error_log('[hata_log] yazilamadi: ' . $e->getMessage());
        }
        $guard = false;
    }

    /**
     * Handler'ları bir kez kaydet. (Mevcut try/catch'leri ETKİLEMEZ: sadece
     * yakalanmayan exception, fatal ve önemli error'ları loglar; error handler
     * false döner → PHP'nin normal davranışı korunur.)
     */
    function masq_register_error_handlers(): void
    {
        // Yakalanmayan exception → white screen / 500'ün ana sebebi
        set_exception_handler(function (\Throwable $e): void {
            masq_log_error('php_exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString(), get_class($e));
        });

        // PHP error'ları — gürültüyü azaltmak için NOTICE/DEPRECATED/STRICT loglanmaz.
        set_error_handler(function (int $no, string $str, string $file = '', int $line = 0): bool {
            $onemli = E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR;
            if ($no & $onemli) {
                $adi = [
                    E_ERROR => 'E_ERROR', E_WARNING => 'E_WARNING', E_PARSE => 'E_PARSE',
                    E_USER_ERROR => 'E_USER_ERROR', E_USER_WARNING => 'E_USER_WARNING',
                    E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR', E_CORE_ERROR => 'E_CORE_ERROR',
                    E_COMPILE_ERROR => 'E_COMPILE_ERROR',
                ][$no] ?? (string) $no;
                masq_log_error('php_error', $str, $file, $line, '', $adi);
            }
            return false; // PHP'nin kendi hata işleyişi (log_errors vb.) devam etsin
        });

        // Fatal / parse hataları (script'i öldüren) → shutdown'da yakalanır
        register_shutdown_function(function (): void {
            $e = error_get_last();
            if ($e && ($e['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR))) {
                masq_log_error('php_fatal', $e['message'], $e['file'] ?? '', (int) ($e['line'] ?? 0), '', 'FATAL');
            }
        });
    }
}
