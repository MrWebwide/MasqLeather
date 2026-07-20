-- MAS-83: Müşteri mail metinlerini panelden editlenebilir yapmak için şablon tablosu.
-- Natro (prod) üzerinde phpMyAdmin'den bir kez çalıştırılacak.

CREATE TABLE IF NOT EXISTS `mail_sablon` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mkey` VARCHAR(64) NOT NULL UNIQUE,
  `baslik` VARCHAR(255) NOT NULL,
  `konu` VARCHAR(255) NOT NULL,
  `icerik` TEXT NOT NULL,
  `degiskenler` VARCHAR(500) DEFAULT '',
  `guncelleme` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mevcut metinlerle seed (davranış birebir korunur; admin panelden düzenleyebilir).
INSERT INTO `mail_sablon` (`mkey`, `baslik`, `konu`, `icerik`, `degiskenler`) VALUES
('order_confirmation', 'Sipariş Onay (müşteri)', 'Order Confirmation',
 'Dear {name} {surname}, <br><br>We are pleased to inform you that your order has been confirmed. Your order number is <strong>{order_no}</strong>. We sincerely appreciate your business and thank you for choosing Masq Leather. If you have any further inquiries, please do not hesitate to contact us.<br><br>Best regards,<br><strong>Masq Leather</strong>',
 '{name} {surname} {order_no}'),
('order_admin_alert', 'Yeni Sipariş Uyarı (admin)', 'New Order Alert!',
 'A new order (<strong>{order_no}</strong>) has been placed on your website. Please review the order details on the administration panel.<br><br><strong>Masq Leather</strong>',
 '{order_no}'),
('order_completed', 'Sipariş Teslim Edildi (müşteri)', 'Order Completed',
 'Dear <strong>{name} {surname}</strong>, <br><br>We''re delighted to inform you that your order with the order number <strong>{order_no}</strong> has been successfully delivered to your doorstep. We hope you''re excited to receive your purchase and that it meets your expectations.<br><br>You can make your comments about the product in the comment section on our website.<br><br>Best regards,<br><strong> Masq Leather <br>info@masqleather.com </strong>',
 '{name} {surname} {order_no}'),
('order_cancelled', 'Sipariş İptal (müşteri)', 'Order Cancelled',
 'Dear <strong>{name} {surname}</strong>, <br><br>Sadly your order with order number of <strong>{order_no}</strong> has been cancelled.<br><br><strong> Order cancellation reason is :</strong><br><br> <strong> {reason} </strong> <br><br>Best regards,<br><strong> Masq Leather </strong>',
 '{name} {surname} {order_no} {reason}'),
('order_shipment', 'Sipariş Kargolandı (müşteri)', 'Order Shipment',
 'Dear <strong>{name} {surname}</strong>, <br><br>Your products with order number <strong>{order_no}</strong> has been shipped. This is your tracking number : <strong>{tracking_no}</strong>. <br><br>Best regards,<br><strong> Masq Leather </strong>',
 '{name} {surname} {order_no} {tracking_no}');
