-- ============================================================
-- Migration: create pending_orders
-- Date:      2026-06-13
-- Issue:     MAS-10 — Stripe sipariş akışını webhook'a taşı
-- ------------------------------------------------------------
-- Checkout başlarken (stripe/checkout.php) siparişin tüm verisini
-- Stripe checkout session id ile burada saklarız. Webhook
-- (checkout.session.completed) bu satırı okuyup siparişi yazar.
-- Böylece sipariş kaydı tarayıcıdan (return.php) bağımsız olur.
--
-- status akışı: pending -> processing -> completed
--   webhook atomik olarak 'pending' -> 'processing' yapar;
--   sadece bu geçişi yapan istek siparişi işler (idempotency).
-- ============================================================

CREATE TABLE IF NOT EXISTS pending_orders (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    session_id    VARCHAR(255) NOT NULL,            -- Stripe checkout session id (cs_...)
    siparis_id    VARCHAR(100) NOT NULL,            -- iç sipariş no (mevcut siparisId)
    payload       LONGTEXT     NOT NULL,            -- JSON: adresler + sepetler + siparis + tutar + userId/misafir
    status        ENUM('pending','processing','completed') NOT NULL DEFAULT 'pending',
    created_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    processed_at  DATETIME     NULL DEFAULT NULL,
    UNIQUE KEY uq_session_id (session_id),
    KEY idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
