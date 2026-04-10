<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = 'Masq Leather - About';
$pageDescription = 'Handcrafted leather goods';
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
<body>
    
    
   <!--offcanvas menu area start-->
   <div class="body_overlay">

</div>
<?php include("./layout/header-2.php");?>


<style>
    .contact_page_details p{
font-size:20px;


    }
</style>

    <!-- contact section start -->
    <section class="contact_page_section">
   
        <div class="contact_page_details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact_info">
                            <div class="contact_info_title text-center">
                                <h3 class="wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s"><?=$sayac2['sayi1']?></h3>
                            </div>
                           
                        </div>
                    </div>
                    <div class="cen text-center" style="display:flex;" >
                    <div class="col-lg-4 about-thumb">
                        <img src="admin/resimler/<?=$sayac2['resim1']?>" alt="" class="img-fluid" >
                    </div>
                    <div class="col-lg-8 abot" >
                        <div class="contact_form wow fadeInUp " data-wow-delay="0.1s" data-wow-duration="1.1s"> 
                                <p>	
                                    
                                
                                <?=$sayac2['yazi1']?>      


</p>
                        </div>
                    </div>
                    </div>
                </div>
                
               
            </div>
        </div>
    </section>
    <!-- contact section end -->

 <!-- footer section start -->
 <?php include("./layout/footer.php");?>
    <!-- footer section end -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>