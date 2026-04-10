<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = $yazi['yazi11'] ?? 'Mercantile Blog';
$pageDescription = $yazi['yazi12'] ?? '';
$pageKeywords    = $yazi['yazi13'] ?? '';
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

    
    <!--offcanvas menu area start-->
    <div class="body_overlay">
                
    </div>
    <?php include("./layout/header-mer2.php");?>

    <div class="breadcrumbs_area breadcrumbs__bg">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2>Our Blog</h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="index.html">Home</a></li>
                            <li>></li>
                            <li><a href="blog.html">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>

    <!-- blog page section start -->
    <section class="blog_page_section">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-12">
                <?php
$hizmett = $db->query("SELECT * FROM bloglarmer");
$count = 0;

foreach ($hizmett as $hizmet) {
    // Belirli bir sıra için sınıf seçimi
    $class_order = ($count % 2 == 0) ? 'left' : 'right';
    $count++;
?>
    <div class="blog_list <?= ($class_order == 'left') ? 'blog_list_bg' : '' ?>">
        <div class="single_blog_page d-flex align-items-center justify-content-between">
            <?php if ($class_order == 'left') { ?>
                <div class="blog_page_thumb">
                    <img src="admin/resimler/<?= $hizmet['resim'] ?>" alt="">
                </div>
                <div class="blog_page_content left">
            <?php } else { ?>
                <div class="blog_page_content right">
            <?php } ?>
                <span class="wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s"><?= $hizmet['eklenme_tarihi'] ?></span>
                <h3 class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1.2s"><a href="blogmercantile-details.php?id=<?= $hizmet['id'] ?>"><?= $hizmet['adi'] ?></a></h3>
                <p class="wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s"><?= $hizmet['onaciklama'] ?></p>
                <a class="btn btn-link wow fadeInUp" href="blogmercantile-details.php?id=<?= $hizmet['id'] ?>" data-wow-delay="0.4s" data-wow-duration="1.4s">Read more</a>
            </div>
            <?php if ($class_order == 'right') { ?>
                <div class="blog_page_thumb">
                    <img src="admin/resimler/<?= $hizmet['resim'] ?>" alt="">
                </div>
            <?php } ?>
        </div>
    </div>
<?php
}
?>





                   
               
                </div>
            </div>
        </div>
    </section>
    <!-- blog page section end -->
    
<!-- footer section start -->
<?php include("./layout/footer-mer.php");?>
<!-- footer section end -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>