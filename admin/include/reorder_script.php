<?php
/**
 * reorder_script.php — Sürükle-bırak sıralama (tüm panel için ortak).
 *
 * Kullanım: liste sayfasında, satırlara data-id + data-oldorder ver, listeyi
 * "ORDER BY sira ASC" çek, sonra </body>'den önce:
 *
 *   <?php $reorderTable = 'bloglar'; $reorderOffset = 0; include 'include/reorder_script.php'; ?>
 *
 * - $reorderTable : update_order.php whitelist'indeki tablo adı (zorunlu)
 * - $reorderOffset: sayfalama varsa (page-1)*perPage; yoksa 0 (opsiyonel)
 *
 * Tüm <tbody> içindeki "tr[data-id]" satırlarını otomatik sürüklenebilir yapar.
 */
if (empty($reorderTable)) { return; }
$reorderOffset = isset($reorderOffset) ? (int) $reorderOffset : 0;
?>
<style>
    tbody tr[data-id] { cursor: move; }
    tbody tr.selected-row { background: #fff3cd !important; }
    .drag-handle { cursor: grab; color: #c0c0c0; padding-right: 6px; }
    .reorder-hint { font-size: 12px; color: #888; margin: 4px 0 10px; }
</style>
<p class="reorder-hint"><i class="fa fa-arrows"></i> Sıralamak için satırları sürükleyip bırakın — otomatik kaydedilir.</p>
<script>
(function () {
    var endpoint = 'update_order.php?table=<?= urlencode($reorderTable) ?>';
    var offset = <?= $reorderOffset ?>;
    var dragged = null;

    function onStart(e) {
        dragged = e.target.closest('tr');
        if (!dragged) return;
        dragged.classList.add('selected-row');
        if (e.dataTransfer) { e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setDragImage(new Image(), 0, 0); }
    }
    function onOver(e) {
        e.preventDefault();
        var target = e.target.closest('tr');
        if (!target || target === dragged || !target.hasAttribute('data-id')) return;
        var kids = Array.from(target.parentNode.children);
        if (kids.indexOf(target) > kids.indexOf(dragged)) target.after(dragged);
        else target.before(dragged);
    }
    function onEnd() {
        if (dragged) dragged.classList.remove('selected-row');
        var payload = [];
        document.querySelectorAll('tbody tr[data-id]').forEach(function (r, i) {
            payload.push({
                oldorder: r.getAttribute('data-oldorder'),
                order: offset + i + 1,
                id: r.getAttribute('data-id')
            });
        });
        var xhr = new XMLHttpRequest();
        xhr.open('POST', endpoint, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(payload));
    }

    document.querySelectorAll('tbody tr[data-id]').forEach(function (r) {
        r.setAttribute('draggable', 'true');
        r.addEventListener('dragstart', onStart);
        r.addEventListener('dragover', onOver);
        r.addEventListener('dragend', onEnd);
    });
})();
</script>
