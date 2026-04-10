<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = $yazi['yazi8'] ?? 'Jewelry';
$pageDescription = $urunler['yazi21'] ?? '';
$pageKeywords    = $urunler['yazi22'] ?? '';
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
<body>


<style>
    .offcanvas_main_menu li a {
        color:white !important;
    }
</style>
    
     <!--offcanvas menu area start-->
     <div class="body_overlay">

</div>
<?php include("./layout/header-mer2.php");?>

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2><?=$urunler['adi']?></h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="index-2.php">Home</a></li>
                            <li>></li>
                            <li><a href="#"><?=$urunler['kategori']?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="product-section" style="padding-left: 15vw;">
        <!-- product gallery section start -->
        <div class="col-lg-6">
        <div class="producter">
                <div class="product-details-tab">
                    <div class="pro-dec-big-img-slider">
                        <?php foreach ($resimler as $resim): ?>
                        <div class="easyzoom-style">
                            <img src="admin/resimler/<?= $resim['img'] ?>" style="display:inline;" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="product-dec-slider-small product-dec-small-style1">
                 
                        <?php foreach ($resimler as $resim): ?>
                            
                        <div class="product-dec-small">
                     
                            <img src="admin/resimler/<?= $resim['img'] ?>" />
                        </div>
                        <?php endforeach; ?>
                   
                    </div>

                </div>
            </div>
        </div>

      <!-- product gallery section end -->
      <?php
$haberg = $db->query("SELECT * FROM bloggelen WHERE durum = 'on' AND yorumid = $id AND tur = 'jewe' ORDER BY id DESC");
// Yorum sayısını varsayılan olarak 0 olarak tanımla
$yorumSayisi = 0;

if ($haberg) {
    // Yorumlar varsa sayısını hesapla
    $yorumSayisi = $haberg->rowCount();
}

?>
        <!-- product details css here -->
        <div class="detail col-lg-6">
            <div class="product_details_section">
                <div class="detailer container">
                    <div class="right" style="display: block; padding-top: 1cm;">
                        <div class="product-writing col-lg-8">
                            <div class="product_details_left">
                                <form action="#">
                                    <div class="product_ratting_stock d-flex">
                                        <div class=" product_ratting">
                                            <ul class="d-flex">

                                                <li class="review"><span>
                                                        <?=$yorumSayisi?> Reviews
                                                    </span></li>
                                            </ul>
                                        </div>
                                        <?php 

                                            if ($stock >0) {
                                        
                                        ?>
                                        <div class="in_stock">
                                            <span class="stock-status"><img src="assets/img/icon/check.png" alt=""> in Stock</span>
                                        </div>

                                     <?php } else { ?>

                                        <div class="in_stock">
                                            <span class="stock-status"><img src="assets/img/icon/check.png" alt=""> Out of Stock</span>
                                        </div>

                                        <?php }?>

                                    </div>
                                    <div class="product_details_title">
                                        <h3>
                                            <?=$urunler['adi']?>
                                        </h3>
                                    </div>
                                    <div class="product_price_box">
                                        <span class="current_price">
                                        <?php if ($urunler['kampanya']) { ?>
                                            $
                                            <?=$urunler['yazi1'] - ($urunler['yazi1'] * $urunler['kampanya'] / 100)?> CAD
                                            <?php } else { ?>
                                            $
                                            <?=$urunler['yazi1']?> CAD
                                            <?php } ?>
                                        </span>
                                    </div>
                                    <div class="product_desc">
                                        <p>
                                            <?=$urunler['yazi3']?>
                                        </p>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="product_details_right">
                                <div class="product_d_meta">
                                    <span>


                                        Product ID: 274</span>
                                </div>
                                <form method="POST" action="" id="addToCartForm">
                                    <input type="hidden" name="productId" value="<?=$urunler['id']?>">
                                    <input type="hidden" name="productName" value="<?=$urunler['adi']?>">
                                    <input type="hidden" name="productPrice"
                                        value="<?php echo $urunler['kampanya'] ? $urunler['yazi1'] - ($urunler['yazi1'] * $urunler['kampanya'] / 100) : $urunler['yazi1']; ?>">
                                    <input type="hidden" name="productImage" value="<?=$urunler['resim']?>">
                                    <input type="hidden" name="productCategory" value="<?=$urunler['kategori']?>">
                                    <input type="hidden" name="productCargo" value="<?=$urunler['cargo']?>">
                                    <input type="hidden" name="productCargos" value="<?=$urunler['cargo_us']?>">
                                    <input type="hidden" name="producttur" value="<?=$urunler['tur']?>">



                                    <div class="product_variant_quantity d-flex align-items-center">
                                        <div class="pro-qty border">
                                            <input min="1" max="100" type="number" name="productQuantity" value="1"
                                                class="no-spin">
                                        </div>


                                        <div class="btn-wrapper">
    <?php 
        if ($stock > 0) { 

         if (isset($_SESSION['id'])) { // Stok varsa
    ?>
                <div class="btn-wrapper">
                    <button class="add-to-cart" type="submit" name="addToCart">
                        <span class="btn-text">Add to cart</span>
                    </button>

                    <svg class="icon-loader-check" x="0px" y="0px" width="471.197px" height="471.197px"
                        viewBox="0 0 510 510" overflow="inherit" preserveAspectRatio="xMidYMid meet">
                        <g id="loader">
                            <circle class="circle" fill="transparent" stroke="#41BD59" stroke-width="48"
                                stroke-linecap="round" stroke-miterlimit="10" cx="250" cy="250" r="212.599" />
                            <polyline class="check" fill="none" stroke="#41BD59" stroke-width="32"
                                stroke-linecap="round" stroke-linejoin="round" points="
                                        227.599,322.099 290.599,259.099 180.599,149.099 " />
                        </g>
                    </svg>
                </div>
    <?php 
            } else { // Stok yoksa
    ?>

<div class="btn-wrapper">
                    <button class="add-to-cart" type="submit" name="addToCart">
                        <span class="btn-text">Add to cart</span>
                    </button>

                    <svg class="icon-loader-check" x="0px" y="0px" width="471.197px" height="471.197px"
                        viewBox="0 0 510 510" overflow="inherit" preserveAspectRatio="xMidYMid meet">
                        <g id="loader">
                            <circle class="circle" fill="transparent" stroke="#41BD59" stroke-width="48"
                                stroke-linecap="round" stroke-miterlimit="10" cx="250" cy="250" r="212.599" />
                            <polyline class="check" fill="none" stroke="#41BD59" stroke-width="32"
                                stroke-linecap="round" stroke-linejoin="round" points="
                                        227.599,322.099 290.599,259.099 180.599,149.099 " />
                        </g>
                    </svg>
                </div>
               
    <?php 
            } 
        } else { // Oturum açılmamışsa
    ?>
          
          <button class="add-to-cart" type="button" disabled>
                    <span class="btn-text">Out of Stock</span>
                </button>
    <?php 
        } 
    ?>
</div>
                                    </div>
                                </form>



                            </div>

                        </div>
                        <div class="product_details_title" style="<?php echo (empty($urunler['yazi10']) && empty($urunler['yazi11']) && empty($urunler['yazi12']) && empty($urunler['yazi13']) && empty($urunler['yazi14'])) ? 'display: none;' : ''; ?>">
    <h3>
        Color Options
    </h3>

    <?php
// Ürün durumunu kontrol eden fonksiyon
function getDurumById($urun_id) {
    global $db; // Veritabanı bağlantısı
    $stmt = $db->prepare("SELECT durum FROM jewe WHERE id = ?");
    $stmt->execute([$urun_id]);
    $result = $stmt->fetch();
    return $result ? $result['durum'] : null;
}
?>

<div class="coloropt d-flex">
    <?php if (!empty($urunler['yazi10']) && getDurumById($urunler['yazi10']) === 'on'): ?>
        <a href="./jewelry-detail.php?id=<?=$urunler['yazi10']?>" class="color_option"><img src="./admin/resimler/<?=$urunler['yazi15']?>" alt=""></a>
    <?php endif; ?>
    <?php if (!empty($urunler['yazi11']) && getDurumById($urunler['yazi11']) === 'on'): ?>
        <a href="./jewelry-detail.php?id=<?=$urunler['yazi11']?>" class="color_option"><img src="./admin/resimler/<?=$urunler['yazi16']?>" alt=""></a>
    <?php endif; ?>
    <?php if (!empty($urunler['yazi12']) && getDurumById($urunler['yazi12']) === 'on'): ?>
        <a href="./jewelry-detail.php?id=<?=$urunler['yazi12']?>" class="color_option"><img src="./admin/resimler/<?=$urunler['yazi17']?>" alt=""></a>
    <?php endif; ?>
    <?php if (!empty($urunler['yazi13']) && getDurumById($urunler['yazi13']) === 'on'): ?>
        <a href="./jewelry-detail.php?id=<?=$urunler['yazi13']?>" class="color_option"><img src="./admin/resimler/<?=$urunler['yazi18']?>" alt=""></a>
    <?php endif; ?>
    <?php if (!empty($urunler['yazi14']) && getDurumById($urunler['yazi14']) === 'on'): ?>
        <a href="./jewelry-detail.php?id=<?=$urunler['yazi14']?>" class="color_option"><img src="./admin/resimler/<?=$urunler['yazi19']?>" alt=""></a>
    <?php endif; ?>
</div>

</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product details css end -->
    </div>
    </div>
 
  
  
      <!--product info start-->
      <div class="product_d_info">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist" id="nav-tab">
                            <li>
                                <a class="active" id="sheet-tab" data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="true">Additional Information</a>
                            </li>
                            <li>
                                <a id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Product Video</a>
                            </li>
                            <li>
                                <a id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Product Detailed Image</a>
                            </li>
                            <li>
                                <a id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews (<?=$yorumSayisi?>)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="sheet" role="tabpanel" aria-labelledby="sheet-tab">
                            <!-- Additional Information Content -->
                            <?php if (!empty($urunler['yazi7']) || !empty($urunler['yazi4']) || !empty($urunler['yazi8']) || !empty($urunler['yazi5']) || !empty($urunler['yazi9']) || !empty($urunler['yazi6'])): ?>
                                <div class="product_d_table">
                                    <form action="#">
                                        <table>
                                            <tbody>
                                                <?php if (!empty($urunler['yazi7'])): ?>
                                                    <tr>
                                                        <td class="first_child"><?= $urunler['yazi7'] ?></td>
                                                        <td><?= $urunler['yazi4'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (!empty($urunler['yazi8'])): ?>
                                                    <tr>
                                                        <td class="first_child"><?= $urunler['yazi8'] ?></td>
                                                        <td><?= $urunler['yazi5'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (!empty($urunler['yazi9'])): ?>
                                                    <tr>
                                                        <td class="first_child"><?= $urunler['yazi9'] ?></td>
                                                        <td><?= $urunler['yazi6'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <div class="product_info_content">
                                <?=$urunler['aciklama']?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                            <!-- Video Content -->
                            <div class="text-center mb-5">
                                <?php if ($urunler['video'] == null): ?>
                                    <h2>There is no video for this product.</h2>
                                <?php else: ?>
                                    <video controls src="admin/videolar/<?=$urunler['video']?>"></video>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <!-- Detailed Image Content -->
                            <div class="product-info-button" style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="product-hover">
                                    <div class="hover-content">
                                        <p>You can hover your mouse on the image to get a detailed look.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="product_info__flex d-flex">
                                <div class="product-slider">
                                    <div class="exzoom hidden" id="exzoom">
                                        <div class="exzoom_img_box">
                                            <ul class='exzoom_img_ul'>
                                                <?php foreach ($resimler as $resim): ?>
                                                    <li><img src="admin/resimler/<?= $resim['img'] ?>" /></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="exzoom_nav"></div>
                                        <p class="exzoom_btn">
                                            <a href="javascript:void(0);" class="exzoom_prev_btn"><</a>
                                            <a href="javascript:void(0);" class="exzoom_next_btn">></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="memo"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <!-- Reviews Content -->
                            <div class="reviews_wrapper">
                                <?php foreach ($haberg as $haber): ?>
                                    <div class="reviews_comment_box">
                                        <div class="comment_thmb">
                                            <img src="assets/img/blog/comment2.jpg" alt="">
                                        </div>
                                        <div class="comment_text">
                                            <div class="reviews_meta">
                                                <p><strong><?=$haber['name']?></strong> <?=$haber['eklenme_tarihi']?></p>
                                                <span><?=$haber['messagee']?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="addreview">
                                <div class="comment_title">
                                    <h2>Add a review</h2>
                                    <p>Your email address will not be published. Required fields are marked</p>
                                </div>
                                <div class="product_review_form">
                                    <form method="post" action="" id="comment-form4" data-tur="jewe" novalidate>
                                        <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="author">Name</label>
                                                <input id="author" type="text" name="author" value="<?php echo $_SESSION['adsoyad']; ?>" required>
                                            </div>
                                            <input type="hidden" id="yorumid" value="<?php echo $id; ?>">
                                            <div class="col-lg-6 col-md-6">
                                            <label for="email">E-mail (your email will not be published)</label>
                                                <input id="email" type="text" name="email" value="<?php echo $_SESSION['email']; ?>" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="review_comment">Your review</label>
                                                <textarea name="comment" id="review_comment" required></textarea>
                                            </div>
                                           
                                        </div>
                                        <button class="button" type="submit" id="submit-button">
                                            <span class="default">Send a Review</span>
                                            <span class="success">Sent</span>
                                            <div class="left"></div>
                                            <div class="right"></div>
                                        </button>
                                    </form>
                                    <div id="message-container">
                                        <!-- AJAX ile güncellenecek alan -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <!--product info end-->

    <!-- product section start -->
    <section class="related_product_section" id="related_products_section">
    <div class="container">
        <div class="product__title text-center">
            <h2>Related Products</h2>
        </div>
        <div class="related_product_inner">
            <div class="row">
                <?php
                $id = $_GET['id'];

                // Veritabanından ilgili id'ye sahip ürünün verilerini çek
                $stmt = $db->prepare("SELECT * FROM jewe WHERE id = ?");
                $stmt->execute([$id]);
                $urun = $stmt->fetch();

                // Ürünün kategorisini al
                $kategori = $urun['kategori'];

                // İlgili kategorideki diğer ürünleri al
                $hizmett = $db->prepare("SELECT * FROM jewe WHERE kategori = ? AND id != ? ORDER BY RAND() LIMIT 4");
                $hizmett->execute([$kategori, $id]);
                $relatedProducts = $hizmett->fetchAll();

                // Eğer ilgili kategoride başka ürün yoksa section'ı gizle
                if (empty($relatedProducts)) {
                    echo '<style>#related_products_section { display: none; }</style>';
                } else {
                    foreach ($relatedProducts as $hizmet) {
                ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>"><img
                                                src="admin/resimler/<?=$hizmet['resim']?>" alt=""></a>

                                    </div>
                                    <figcaption class="product_content">
                                        <h4><a href="jewelry-detail.php?id=<?= $hizmet['id'] ?>">
                                                <?=$hizmet['adi']?>
                                            </a></h4>
                                        <div class="price_box">
                                            <span class="current_price">$
                                                <?=$hizmet['yazi1']?> CAD
                                            </span>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
    <!-- product section end -->
   


     <!-- footer section start -->
     <?php include("./layout/footer-mer.php");?>
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>