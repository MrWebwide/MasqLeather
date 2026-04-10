<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = 'Masq - Search Results';
$pageDescription = '';
$pageKeywords    = '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/functions/analytics.php'; ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>
<?php include __DIR__ . '/includes/head-css.php'; ?>
<?php include __DIR__ . '/includes/head-js.php'; ?>
    <style>
        #exzoom { width: 400px; }
        .main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }
    </style>
</head>
<body class="exclude-script">


    
    
     <!--offcanvas menu area start-->
     <div class="body_overlay">

</div>
<?php include("./layout/header-2.php");?>
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2>Shop</h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="index.html">Home</a></li>
                            <li>></li>
                            <li><a href="shop-left-sidebar.html">Masq Shop</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>

    <!-- shop page section satrt -->
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

foreach ($hizmetkategori as $hizmetka) {
    $adi = $hizmetka['adi'];
    $urun_sayisi = $hizmetka['urun_sayisi'];
    ?>        
                                    <li><a href="bagpurses-category.php?kategori=<?= urlencode($adi) ?>"><?= $adi ?>(<?= $urun_sayisi ?>)</a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                
                            </div>
                           
                            <div class="shop_widget_list categories">
                                <div class="shop_widget_title categories_title">
                                    <h3>Accessories </h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
                                    <?php
$hizmetkategori = $db->query("SELECT bk.adi, COUNT(b.id) AS urun_sayisi
                             FROM bolge_kategori AS bk
                             LEFT JOIN accessories AS b ON bk.adi = b.kategori
                             GROUP BY bk.adi");

foreach ($hizmetkategori as $hizmetka) {
    $adi = $hizmetka['adi'];
    $urun_sayisi = $hizmetka['urun_sayisi'];
    ?>         
                                    <li><a href="accessories-category.php?kategori=<?= urlencode($adi) ?>"><?= $adi ?>(<?= $urun_sayisi ?>)</a></li>
                                       
                                    <?php } ?>
                                    </ul>
                                </div>
                                
                            </div>

                            
                           
                           
                          
                        
                        </div>
                        <div class="shop_right_sidaber">
                           
                        <?php
// Veritabanı bağlantısını sağlamalısınız (bu kısmı kendi bağlantı fonksiyonunuzla değiştirmelisiniz)

// Sayfalama işlemi için kullanıcı tarafından belirlenecek sayfa numarası
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Sayfada gösterilecek ürün sayısı
$productsPerPage = 9;

// Ürünlerin başlangıç indeksi
$startIndex = ($page - 1) * $productsPerPage;

// Arama sorgusu
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Veritabanı sorgusu için LIMIT ve OFFSET değerleri ile sayfalama
$sql = "
    SELECT id, adi, resim, resim1, yazi1, 'urunler' as tablo FROM urunler
    WHERE adi LIKE :search_query
    UNION
    SELECT id, adi, resim, resim1, yazi1, 'accessories' as tablo FROM accessories
    WHERE adi LIKE :search_query
    LIMIT :startIndex, :productsPerPage
";

// Bu sorguyu veritabanınıza göre uyarlamalısınız.
$stmt = $db->prepare($sql);
$stmt->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
$stmt->bindValue(':startIndex', $startIndex, PDO::PARAM_INT);
$stmt->bindValue(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
$stmt->execute();

$urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($urunler) == 0) { ?>
<div class="text-center d-block mb-20">

    <p class="text-center" style="font-size:15px; color:rgb(147, 0, 0)" >There are no products that match your search.</p>
    </div>
<?php } ?>
                          
                            <div class="shop_gallery">
                                <div class="row">
                               

<?php foreach ($urunler as $urun) : ?>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <article class="single_product">
            <figure>
                <div class="product_thumb" onmouseover="showSecondImage(this)" onmouseout="hideSecondImage(this)">
                    <?php
                    $detailPage = '';
                    if ($urun['tablo'] == 'urunler') {
                        $detailPage = 'bagpurses-detail.php';
                    } elseif ($urun['tablo'] == 'accessories') {
                        $detailPage = 'accessories-detail.php';
                    }
                    ?>
                    <a href="<?= $detailPage ?>?id=<?= $urun['id'] ?>"><img src="admin/resimler/<?= $urun['resim'] ?>" alt="">
                    <?php if (!empty($urun['resim1'])): ?>
                        <img class="second_image" src="admin/resimler/<?=$urun['resim1']?>" alt="">
                    <?php endif; ?></a>
                    <div class="label_product">
                        <!-- Label content goes here -->
                    </div>
                </div>
                <figcaption class="product_content">
                    <h4><a href="<?= $detailPage ?>?id=<?= $urun['id'] ?>"><?= $urun['adi'] ?></a></h4>
                    <div class="price_box">
                        <span class="current_price">$<?= $urun['yazi1'] ?></span>
                    </div>
                </figcaption>
            </figure>
        </article>
    </div>
<?php endforeach; ?>

                                  
                                    
                               
                                   
                                
                                  
                                </div>
                            </div>
                            <div class="loding_bar">
    <ul class="d-flex justify-content-center">
        <?php
        // Toplam ürün sayısını hesaplayın (her iki tablodan)
        $totalProducts = $db->query("
            SELECT COUNT(*) as total
            FROM (
                SELECT id, adi, resim, yazi1, 'urunler' as tablo FROM urunler
                WHERE adi LIKE '%$search_query%'
                UNION
                SELECT id, adi, resim, yazi1, 'accessories' as tablo FROM accessories
                WHERE adi LIKE '%$search_query%'
            ) AS combined
        ")->fetchColumn();
        
        // Toplam sayfa sayısını hesaplayın
        $totalPages = ceil($totalProducts / $productsPerPage);

        // Sayfalama bağlantılarını oluşturun
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<li><a href="?page=' . $i . '&search_query=' . urlencode($search_query) . '">' . $i . '</a></li>';
        }
        ?>
<?php echo '<li><a href="?page=' . ($page + 1) . '&search_query=' . urlencode($search_query) . '"><i class="ion-ios-arrow-right"></i></a></li>'; ?>
    </ul>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop page section end -->



      <!-- footer section start -->
      <?php include("./layout/footer.php");?>
    <!-- footer section end -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>