/**
 * masq-crop.js — Admin tekli görsel yüklemeleri için Cropper.js editörü.
 * Bir görsel dosyası seçilince modal açılır; admin görseli sürükler/yakınlaştırır/döndürür,
 * istediği orana (serbest veya sabit) kırpar. "Uygula" deyince kırpılmış görsel aynı file
 * input'a yazılır → form normal şekilde kırpılmış görseli gönderir.
 *
 * - Vanilla JS (jQuery gerekmez). Cropper global'ini kullanır (cropper.min.js).
 * - Video input'ları ve data-no-crop olanları atlar.
 * - İnput'ta data-crop-ratio="W/H" varsa modal o sabit oranla açılır.
 */
(function () {
    'use strict';
    if (window.__masqCropInit) { return; }
    window.__masqCropInit = true;

    var S = { modal: null, cropper: null, input: null, img: null };

    function isImageInput(input) {
        if (!input || input.type !== 'file') { return false; }
        if (input.hasAttribute('data-no-crop')) { return false; }
        // ÇOKLU görsel (uploadifive) input'unu ATLA — kullanıcı isteği: yalnız tekli görseller.
        if (input.closest && input.closest('.uploadifive-button')) { return false; }
        // Çoklu seçim (multiple) input'larını da atla
        if (input.hasAttribute('multiple')) { return false; }
        var name = (input.getAttribute('name') || '').toLowerCase();
        if (name.indexOf('video') !== -1) { return false; }
        var accept = (input.getAttribute('accept') || '').toLowerCase();
        if (accept.indexOf('video') !== -1) { return false; }
        return true;
    }

    function buildModal() {
        var wrap = document.createElement('div');
        wrap.id = 'masq-crop-modal';
        wrap.innerHTML =
            '<div class="mc-backdrop"></div>' +
            '<div class="mc-dialog">' +
              '<div class="mc-head"><span>Görseli düzenle — sürükle / yakınlaştır / kırp</span><button type="button" class="mc-x" title="Kapat">&times;</button></div>' +
              '<div class="mc-body"><div class="mc-stage"><img id="mc-image" alt=""></div></div>' +
              '<div class="mc-tools">' +
                '<div class="mc-ratios">' +
                  '<span class="mc-lbl">Oran:</span>' +
                  '<button type="button" data-r="NaN" class="active">Serbest</button>' +
                  '<button type="button" data-r="3.2">Banner 16:5</button>' +
                  '<button type="button" data-r="1.7778">16:9</button>' +
                  '<button type="button" data-r="1.3333">4:3</button>' +
                  '<button type="button" data-r="0.75">3:4</button>' +
                  '<button type="button" data-r="1">Kare</button>' +
                '</div>' +
                '<div class="mc-acts">' +
                  '<button type="button" class="mc-btn" data-a="zoomin" title="Yakınlaştır">+</button>' +
                  '<button type="button" class="mc-btn" data-a="zoomout" title="Uzaklaştır">&minus;</button>' +
                  '<button type="button" class="mc-btn" data-a="rotl" title="Sola döndür">&#8634;</button>' +
                  '<button type="button" class="mc-btn" data-a="rotr" title="Sağa döndür">&#8635;</button>' +
                  '<button type="button" class="mc-btn" data-a="reset" title="Sıfırla">Sıfırla</button>' +
                '</div>' +
              '</div>' +
              '<div class="mc-foot">' +
                '<button type="button" class="mc-cancel">Vazgeç</button>' +
                '<button type="button" class="mc-apply">Uygula</button>' +
              '</div>' +
            '</div>';
        document.body.appendChild(wrap);
        S.modal = wrap;
        S.img = wrap.querySelector('#mc-image');

        wrap.querySelector('.mc-x').onclick = cancel;
        wrap.querySelector('.mc-cancel').onclick = cancel;
        wrap.querySelector('.mc-backdrop').onclick = cancel;
        wrap.querySelector('.mc-apply').onclick = apply;

        wrap.querySelectorAll('.mc-ratios button').forEach(function (b) {
            b.onclick = function () {
                wrap.querySelectorAll('.mc-ratios button').forEach(function (x) { x.classList.remove('active'); });
                b.classList.add('active');
                if (S.cropper) { S.cropper.setAspectRatio(parseFloat(b.getAttribute('data-r'))); }
            };
        });
        wrap.querySelectorAll('.mc-acts button').forEach(function (b) {
            b.onclick = function () {
                if (!S.cropper) { return; }
                var a = b.getAttribute('data-a');
                if (a === 'zoomin') { S.cropper.zoom(0.1); }
                else if (a === 'zoomout') { S.cropper.zoom(-0.1); }
                else if (a === 'rotl') { S.cropper.rotate(-90); }
                else if (a === 'rotr') { S.cropper.rotate(90); }
                else if (a === 'reset') { S.cropper.reset(); }
            };
        });
    }

    function openFor(input, dataUrl) {
        if (typeof Cropper === 'undefined') { return; } // lib yüklenmediyse dokunma
        if (!S.modal) { buildModal(); }
        S.input = input;

        var ratio = NaN;
        var fixed = input.getAttribute('data-crop-ratio');
        if (fixed && fixed.indexOf('/') !== -1) {
            var p = fixed.split('/');
            var r = parseFloat(p[0]) / parseFloat(p[1]);
            if (isFinite(r) && r > 0) { ratio = r; }
        }

        S.img.src = dataUrl;
        S.modal.classList.add('open');
        if (S.cropper) { S.cropper.destroy(); S.cropper = null; }
        S.cropper = new Cropper(S.img, {
            viewMode: 1, autoCropArea: 1, background: true,
            movable: true, zoomable: true, rotatable: true,
            aspectRatio: ratio, responsive: true, checkOrientation: true
        });

        var rbtns = S.modal.querySelectorAll('.mc-ratios button');
        rbtns.forEach(function (x) { x.classList.remove('active'); });
        rbtns[0].classList.add('active');
    }

    function cancel() {
        if (S.input) { S.input.value = ''; } // seçim iptal
        close();
    }

    function close() {
        if (S.cropper) { S.cropper.destroy(); S.cropper = null; }
        if (S.modal) { S.modal.classList.remove('open'); }
        S.input = null;
    }

    function apply() {
        if (!S.cropper || !S.input) { close(); return; }
        var input = S.input;
        var origName = (input.files && input.files[0] && input.files[0].name) || 'gorsel.jpg';
        var isPng = /\.png$/i.test(origName);
        var type = isPng ? 'image/png' : 'image/jpeg';

        var canvas = S.cropper.getCroppedCanvas({ maxWidth: 2400, maxHeight: 2400, imageSmoothingQuality: 'high' });
        if (!canvas) { close(); return; }

        canvas.toBlob(function (blob) {
            if (!blob) { close(); return; }
            try {
                var file = new File([blob], origName, { type: type });
                var dt = new DataTransfer();
                dt.items.add(file);
                input._masqApplied = true; // programatik atama: change'i tekrar açma
                input.files = dt.files;
                // sayfadaki mevcut önizleme <img>'ini de anında güncelle (varsa)
                updatePreview(input, canvas.toDataURL(type, 0.9));
            } catch (e) { /* eski tarayıcı → orijinal dosya kalır */ }
            close();
        }, type, 0.9);
    }

    // Aynı form-group içindeki önizleme img'ini bul ve güncelle (best-effort)
    function updatePreview(input, dataUrl) {
        var scope = input.closest('.mb-3, .form-group, .form-floating, form') || document;
        var img = scope.querySelector('img');
        if (img) { img.src = dataUrl; img.style.maxWidth = img.style.maxWidth || '200px'; }
    }

    function onChange(e) {
        var input = e.target;
        if (!input || input.tagName !== 'INPUT' || input.type !== 'file') { return; }
        if (input._masqApplied) { input._masqApplied = false; return; }
        if (!isImageInput(input)) { return; }
        var f = input.files && input.files[0];
        if (!f || !/^image\//.test(f.type)) { return; }
        var reader = new FileReader();
        reader.onload = function () { openFor(input, reader.result); };
        reader.readAsDataURL(f);
    }

    // Delegasyon: dinamik eklenen input'ları da yakalar
    document.addEventListener('change', onChange, true);
})();
