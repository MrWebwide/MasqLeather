<?php
/**
 * head-meta.php — Common <meta>, favicon, and canonical tags.
 *
 * Set these variables before including:
 *   $pageTitle       — <title> text
 *   $pageDescription — meta description
 *   $pageKeywords    — meta keywords
 *   $basePath        — '' for root, '../' for subdirectory
 *
 * Optional:
 *   $ogImage — Open Graph image URL (defaults to site logo)
 */

if (!isset($basePath)) $basePath = '';
if (!isset($pageTitle)) $pageTitle = $yazi['blogadi'] ?? 'Masq Leather';
if (!isset($pageDescription)) $pageDescription = '';
if (!isset($pageKeywords)) $pageKeywords = '';
if (!isset($ogImage)) $ogImage = 'https://www.masqleather.com/assets/img/logo/Artboard%201%20copy%203.png';
?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=htmlspecialchars($pageTitle)?></title>
    <meta name="description" content="<?=htmlspecialchars($pageDescription)?>" />
    <meta name="keywords" content="<?=htmlspecialchars($pageKeywords)?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Canonical -->
    <link rel="canonical" href="<?php echo 'https://' . ($_SERVER['HTTP_HOST'] ?? 'www.masqleather.com') . ($_SERVER['REQUEST_URI'] ?? '/'); ?>" />

    <!-- Favicon -->
    <link rel="icon" href="<?=$basePath?>masqicon.ico" sizes="96x96" />
<?php if (!empty($ayarlar['favicon'])): ?>
    <link rel="apple-touch-icon" href="https://www.masqleather.com/admin/resimler/<?=$ayarlar['favicon']?>" />
<?php endif; ?>

    <!-- Robots -->
    <meta name="robots" content="index, follow" />
    <meta name="author" content="www.masqleather.com">
    <meta name="language" content="en">

    <!-- Open Graph -->
    <meta property="og:title" content="<?=htmlspecialchars($pageTitle)?>" />
    <meta property="og:description" content="<?=htmlspecialchars($pageDescription)?>" />
    <meta property="og:image" content="<?=$ogImage?>" />
    <meta property="og:url" content="https://www.masqleather.com<?=$_SERVER['REQUEST_URI'] ?? '/'?>" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?=htmlspecialchars($pageTitle)?>" />
    <meta name="twitter:description" content="<?=htmlspecialchars($pageDescription)?>" />
    <meta name="twitter:image" content="<?=$ogImage?>" />
