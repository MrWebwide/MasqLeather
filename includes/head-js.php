<?php
/**
 * head-js.php — JavaScript files loaded in <head>.
 *
 * Consolidates jQuery to a SINGLE version (3.7.1).
 * Removes duplicate jQuery loads (1.9.1, 1.12.4, 3.4.1, vendor.min.js).
 *
 * Variable $basePath must be set before including.
 *   Root pages:   $basePath = '';
 *   Subdirectory: $basePath = '../';
 *
 * Optional:
 *   $noExzoom — set true to skip exzoom slider JS
 */

if (!isset($basePath)) {
    $basePath = '';
}
?>
    <!-- MAS-8: Frontend JS hata yakalama → panel içi hata_log (Slack/mail yok).
         Erken yüklenir; aynı hatayı sayfa başına bir kez, en fazla 10 çeşit gönderir. -->
    <script>
    (function () {
        var endpoint = '<?=$basePath?>functions/js_error.php';
        var sent = {}, count = 0, MAX = 10;
        function report(type, message, source, line, col, stack) {
            if (!message || count >= MAX) return;
            var key = type + '|' + source + '|' + line + '|' + String(message).slice(0, 120);
            if (sent[key]) return; sent[key] = 1; count++;
            var payload = JSON.stringify({ type: type, message: String(message), source: source || '', line: line || 0, col: col || 0, stack: stack || '' });
            try {
                if (navigator.sendBeacon) {
                    navigator.sendBeacon(endpoint, new Blob([payload], { type: 'application/json' }));
                } else {
                    fetch(endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: payload, keepalive: true, credentials: 'same-origin' });
                }
            } catch (e) {}
        }
        window.addEventListener('error', function (e) {
            report('error', (e && e.message) || (e && e.error && e.error.message) || 'Script error', e && e.filename, e && e.lineno, e && e.colno, e && e.error && e.error.stack);
        });
        window.addEventListener('unhandledrejection', function (e) {
            var r = (e && e.reason) || {};
            report('promise', (r && (r.message || (r.toString && r.toString()))) || 'Unhandled promise rejection', (r && r.fileName) || '', (r && r.lineNumber) || 0, 0, r && r.stack);
        });
    })();
    </script>

    <!-- jQuery 3.7.1 (single version for entire site) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Modernizr -->
    <script src="<?=$basePath?>assets/js/vendor/modernizr-3.7.1.min.js"></script>

    <!-- imagesLoaded: head'deki unpkg kopyası kaldırıldı (footer'da local images-loaded.min.js zaten yükleniyordu = çift). -->

    <!-- GSAP: defer — yalnızca tıklama animasyonunda kullanılıyor, ilk render'ı bloke etmesin (perf) -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>

    <!-- Exzoom Slider -->
<?php if (empty($noExzoom)): ?>
    <script src="<?=$basePath?>slider/jquery.exzoom.js"></script>
<?php endif; ?>

    <!-- Site utilities: defer — load/DOMContentLoaded dinleyicileri, render'ı bloke etmesin (perf) -->
    <script defer src="<?=$basePath?>assets/js/handlewindowsize.js"></script>
    <script defer src="<?=$basePath?>assets/js/loadingscreen.js"></script>
