<?php
/**
 * newsletter_discount.php — MAS-110
 * Newsletter'a kayıt olan kullanıcıya bir kerelik indirim kuponu üretir ve e-posta ile gönderir.
 *
 * masq_send_newsletter_discount(PDO $db, string $email): bool
 *   - newsletter_indirim ayarını okur (aktif / oran / kod_onek). Kapalıysa hiçbir şey yapmaz.
 *   - `cupon` tablosuna benzersiz kod ekler (fiyat=oran, durum=0 → checkout'ta bir kez kullanılır).
 *   - mail_sablon 'newsletter_welcome' şablonunu {code}/{oran} ile doldurup gönderir.
 *   - Best-effort: mail/kupon hata verse bile abonelik akışını BOZMAZ (false döner, exception yutulur).
 *
 * Not: Tablo yoksa (SQL prod'a uygulanmadıysa) sessizce false döner; abonelik yine başarılı olur.
 */

if (!function_exists('masq_send_newsletter_discount')) {

function masq_send_newsletter_discount(PDO $db, string $email): bool
{
    try {
        // 1) Ayarları oku
        $st = $db->query("SELECT aktif, oran, kod_onek FROM newsletter_indirim WHERE id = 1 LIMIT 1");
        $cfg = $st ? $st->fetch(PDO::FETCH_ASSOC) : null;
        if (!$cfg || (int) $cfg['aktif'] !== 1) {
            return false; // özellik kapalı ya da tablo/satır yok
        }

        $oran   = (float) $cfg['oran'];
        $onek   = preg_replace('/[^A-Z0-9]/', '', strtoupper($cfg['kod_onek'] ?: 'WELCOME'));
        if ($onek === '') { $onek = 'WELCOME'; }
        if ($oran <= 0)   { return false; }

        // 2) Benzersiz kupon kodu üret (çakışma olursa birkaç kez dene)
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $candidate = $onek . '-' . strtoupper(bin2hex(random_bytes(3))); // ör. WELCOME-1A2B3C
            $chk = $db->prepare("SELECT COUNT(*) FROM cupon WHERE adi = :adi");
            $chk->execute([':adi' => $candidate]);
            if ((int) $chk->fetchColumn() === 0) { $code = $candidate; break; }
        }
        if ($code === '') { return false; }

        // 3) Kuponu ekle (fiyat = yüzde indirim; checkout mevcut kupon sistemiyle uygular)
        $ins = $db->prepare(
            "INSERT INTO cupon (adi, sira, resim, durum, fiyat, seo, tur, eklenme_tarihi)
             VALUES (:adi, '0', 'resim-yok', '0', :fiyat, :seo, 'cupon', :tarih)"
        );
        $ins->execute([
            ':adi'   => $code,
            ':fiyat' => (string) $oran,
            ':seo'   => strtolower($code),
            ':tarih' => date('d.m.Y'),
        ]);

        // 4) Mail şablonunu doldur (panelden düzenlenebilir — MAS-83 sistemi)
        require_once __DIR__ . '/mail_templates.php';
        $tpl = masq_mail_template($db, 'newsletter_welcome', [
            'code' => $code,
            'oran' => rtrim(rtrim(number_format($oran, 2, '.', ''), '0'), '.'), // 10.00 -> 10
        ], [
            'konu'   => 'Welcome to Masq Leather - Your Discount Inside',
            'icerik' => '<p>Thank you for subscribing!</p><p>Use code <strong>{code}</strong> for <strong>{oran}%</strong> off your first order.</p>',
        ]);

        // 5) Gönder (PHPMailer + SMTP). MAIL_FROM_ADDRESS boşsa (lokal) sessizce başarısız olur.
        if (!defined('MAIL_FROM_ADDRESS') || MAIL_FROM_ADDRESS === '') {
            return false; // SMTP yapılandırılmamış (ör. lokal) → kupon üretildi ama mail atlanır
        }

        require_once __DIR__ . '/../PHPMailer/src/Exception.php';
        require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        configureMailer($mail);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $tpl['konu'];
        $mail->Body    = $tpl['icerik'];
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '</p>'], "\n", $tpl['icerik']));
        $mail->send();

        return true;
    } catch (\Throwable $e) {
        error_log('newsletter discount error: ' . $e->getMessage());
        return false;
    }
}

}
