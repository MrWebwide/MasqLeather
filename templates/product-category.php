<?php
/**
 * Product Category Template
 * 
 * Required variables (set before including this template):
 *   $productTable    — DB table name (urunler, accessories, homedecor, jewe)
 *   $categoryTable   — Category DB table
 *   $detailPage      — Detail link prefix
 *   $categoryPage    — Category link prefix
 *   $headerFile      — Header include file
 *   $footerFile      — Footer include file
 *   $homeLink        — Home page href
 *   $sectionTitle    — Section display title
 *   $pageTitle, $pageDescription, $pageKeywords — SEO
 *   $bodyClass       — Optional body class
 *   $extraStyles     — Optional extra CSS
 */
if (!isset($bodyClass)) $bodyClass = 'exclude-script';
if (!isset($extraStyles)) $extraStyles = '';

// Get category from URL
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$statement = $db->prepare("SELECT adi FROM $categoryTable WHERE adi = :kategori");
$statement->bindParam(':kategori', $kategori, PDO::PARAM_STR);
$statement->execute();
$kategoriisim = $statement->fetchColumn();
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
        <?=$extraStyles?>
    </style>
</head>
<body class="<?=$bodyClass?>">

<div class="body_overlay"></div>
<?php include __DIR__ . "/../layout/$headerFile"; ?>

    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2><?= htmlspecialchars($kategoriisim) ?></h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="<?=$homeLink?>">Home</a></li>
                            <li>></li>
                            <li><a><?=$sectionTitle?></a></li>
                        </ul>
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
                        <div class="shop_sidebar_widget">
                            
                            <div class="shop_widget_list categories">
                                <div class="shop_widget_title categories_title">
                                    <h3>Bags & Purses</h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
                                    <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                             FROM urun_kategori AS bk
                             LEFT JOIN urunler AS b ON bk.adi = b.kategori
                             GROUP BY bk.adi");
foreach ($hizmetkategori as $hizmetka) { ?>
                                    <li><a href="bagpurses-category.php?kategori=<?= urlencode($hizmetka['adi']) ?>"><?= $hizmetka['adi'] ?>(<?= $hizmetka['urun_sayisi'] ?>)</a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                           
                            <div class="shop_widget_list categories">
                                <div class="shop_widget_title categories_title">
                                    <h3>Accessories</h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
                                    <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                             FROM bolge_kategori AS bk
                             LEFT JOIN accessories AS b ON bk.adi = b.kategori
                             GROUP BY bk.adi");
foreach ($hizmetkategori as $hizmetka) { ?>
                                    <li><a href="accessories-category.php?kategori=<?= urlencode($hizmetka['adi']) ?>"><?= $hizmetka['adi'] ?>(<?= $hizmetka['urun_sayisi'] ?>)</a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        
                        </div>
                        <div class="shop_right_sidaber">
                            <div class="shop_gallery">
                                <div class="row">
                                <?php
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $productsPerPage = 9;
        $startIndex = ($page - 1) * $productsPerPage;

        $totalProducts = $db->prepare("SELECT COUNT(*) as total FROM $productTable WHERE kategori = :kategori AND durum = 'on'");
        $totalProducts->bindParam(':kategori', $kategori);
        $totalProducts->execute();
        $totalProductsCount = $totalProducts->fetchColumn();
        $totalPages = ceil($totalProductsCount / $productsPerPage);

        $stmt = $db->prepare("SELECT * FROM $productTable WHERE durum = 'on' AND kategori = :kategori ORDER BY sira ASC LIMIT $startIndex, $productsPerPage");
        $stmt->bindParam(':kategori', $kategori);
        $stmt->execute();
        $urunler = $stmt->fetchAll();

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
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $encodedKategori = str_replace('&', '%26', $kategori);
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'active' : '';
        echo '<li><a class="' . $activeClass . '" href="?kategori=' . $encodedKategori . '&page=' . $i . '">' . $i . '</a></li>';
    }
    $nextPage = $currentPage + 1;
    if ($currentPage >= $totalPages) {
        echo '<li><a style="border:initial !important; font-size:xxx-large; padding-top: 4px;" href="#"><i class="ion-ios-close-outline"></i></a></li>';
    } else {
        echo '<li><a href="?kategori=' . $encodedKategori . '&page=' . $nextPage . '"><i class="ion-ios-arrow-right"></i></a></li>';
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
