<?php
/**
 * Product Listing Template
 * 
 * Required variables (set before including this template):
 *   $productTable    — DB table name (urunler, accessories, homedecor, jewe)
 *   $categoryTable   — Category DB table (urun_kategori, bolge_kategori, mer_kategori, jewe_kategori)
 *   $detailPage      — Detail link prefix (bagpurses-detail, accessories-detail, etc.)
 *   $categoryPage    — Category link prefix (bagpurses-category, accessories-category, etc.)
 *   $headerFile      — Header include (header-2.php or header-mer2.php)
 *   $footerFile      — Footer include (footer.php or footer-mer.php)
 *   $homeLink        — Home page link (index.php or index-2.php)
 *   $sectionTitle    — Display title (Bags & Purses, Accessories, etc.)
 *   $pageTitle       — SEO title
 *   $pageDescription — SEO description
 *   $pageKeywords    — SEO keywords
 *   $bodyClass       — Optional body class (default: 'exclude-script')
 *   $extraStyles     — Optional extra CSS string
 */
if (!isset($bodyClass)) $bodyClass = 'exclude-script';
if (!isset($extraStyles)) $extraStyles = '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/../functions/analytics.php'; ?>
<?php include __DIR__ . '/../includes/head-meta.php'; ?>
<?php include __DIR__ . '/../includes/head-css.php'; ?>
<?php include __DIR__ . '/../includes/head-js.php'; ?>
    <style>
        #exzoom { width: 400px; }
        /* MAS-113: sol menu yok -> urun alani tam genislik */
        .shop_right_sidaber--full { width: 100%; }
        <?=$extraStyles?>
    </style>
</head>
<body class="<?=$bodyClass?>">

<div class="body_overlay"></div>
<?php include __DIR__ . "/../layout/$headerFile"; ?>

    <?php
    // MAS-86(a): grup landing sayfası (Bags & Purses / Accessories / Home Decor / Jewelry)
    // için opsiyonel başlık arka plan görseli. Panel → "Group Banners" ile yönetilir.
    // grup_banner tablosu yoksa (prod'a SQL uygulanmadıysa) sessizce eski görünüm kalır.
    $grupBannerImg = '';
    try {
        $gb = $db->prepare("SELECT resim FROM grup_banner WHERE gkey = ?");
        $gb->execute([$categoryTable]);
        $gbr = $gb->fetchColumn();
        if (!empty($gbr) && $gbr !== 'resim-yok') { $grupBannerImg = $gbr; }
    } catch (\Throwable $e) { $grupBannerImg = ''; }
    ?>
    <div class="breadcrumbs_area<?= $grupBannerImg ? ' has-cat-bg' : '' ?>"<?= $grupBannerImg ? ' style="background-image:url(admin/resimler/' . htmlspecialchars($grupBannerImg) . ')"' : '' ?>>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2><?=$sectionTitle?></h2>
                        <!-- breadcrumb navigasyonu kaldırıldı (sadece başlık kalsın) -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- shop page section start -->
    <div class="shop_page_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop_page_inner d-flex ">
                        <!-- MAS-113: sol kategori menusu kaldirildi (urunler tam genislik, satirda 3 buyuk foto).
                             Alt kategorilere ust menuden ulasiliyor. -->
                        <div class="shop_right_sidaber shop_right_sidaber--full">
                            <div class="shop_gallery">
                                <div class="row">
                                <?php
        // MAS-35: sayfa hesabı — page [1, totalPages] aralığına sıkıştırılır (boş sayfa olmasın)
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $productsPerPage = 9;

        $totalProducts = $db->prepare("SELECT COUNT(*) as total FROM $productTable WHERE durum = 'on'");
        $totalProducts->execute();
        $totalProductsCount = (int) $totalProducts->fetchColumn();
        $totalPages = max(1, (int) ceil($totalProductsCount / $productsPerPage));

        // İstenen sayfa toplam sayfadan büyükse son sayfaya çek (boş son sayfa bug'ı)
        if ($page > $totalPages) { $page = $totalPages; }
        $startIndex = ($page - 1) * $productsPerPage;

        $urunler = $db->query("SELECT * FROM $productTable WHERE durum = 'on' ORDER BY sira ASC LIMIT $startIndex, $productsPerPage");

foreach ($urunler as $urun) {
    $fiyat = $urun['kampanya'] ? ($urun['yazi1'] - ($urun['yazi1'] * $urun['kampanya'] / 100)) : $urun['yazi1'];
?>
<div class="col-lg-4 col-md-6 col-sm-6">
    <article class="single_product">
        <figure>
            <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                <a href="<?=$detailPage?>.php?id=<?= $urun['id'] ?>"><img src="admin/resimler/<?=$urun['resim']?>" loading="lazy" alt="">
                <?php if ($urun['resim1'] !== null): ?>
                    <img class="second_image" src="admin/resimler/<?=$urun['resim1']?>" loading="lazy" alt="">
                <?php endif; ?></a>
                <div class="label_product"></div>
            </div>
            <figcaption class="product_content">
                <h4><a href="<?=$detailPage?>.php?id=<?= $urun['id'] ?>"><?=$urun['adi']?></a></h4>
                <div class="price_box"> 
                    <?php if ($urun['kampanya']) { ?>
                        <span class="old_price">$<?=$urun['yazi1']?> CAD</span>
                        <span class="current_price">$<?=$fiyat?> CAD</span>
                    <?php } else { ?>
                        <span class="current_price">$<?=$urun['yazi1']?> CAD</span>
                    <?php } ?>
                </div>
            </figcaption>  
        </figure>
    </article>
</div>
<?php } ?>
                                </div>
                            </div>
                            <div class="loding_bar">
                                <ul class="d-flex justify-content-center">
                                <?php
    // MAS-35: $page yukarıda zaten [1, totalPages] aralığına sıkıştırıldı.
    $currentPage = $page;
    // Tek sayfa varsa pagination çubuğu gösterme.
    if ($totalPages > 1) {
        // Önceki
        if ($currentPage > 1) {
            echo '<li><a href="?page=' . ($currentPage - 1) . '"><i class="ion-ios-arrow-left"></i></a></li>';
        }
        // Sayfa numaraları
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            echo '<li><a class="' . $activeClass . '" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        // Sonraki (son sayfada gösterilmez; eski bozuk "x" ikonu kaldırıldı)
        if ($currentPage < $totalPages) {
            echo '<li><a href="?page=' . ($currentPage + 1) . '"><i class="ion-ios-arrow-right"></i></a></li>';
        }
    }
    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop page section end -->

    <?php include __DIR__ . "/../layout/$footerFile"; ?>

<?php include __DIR__ . '/../includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/../includes/product-listing-scripts.php'; ?>
</body>
</html>
