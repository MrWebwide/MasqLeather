<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = $hizmet['yazi3'] ?? 'Blog';
$pageDescription = $hizmet['yazi4'] ?? '';
$pageKeywords    = $hizmet['yazi5'] ?? '';
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
    
    <!--blog body area start-->
    <section class="blog_details_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="blog__sticky">
                        <div class="blog_sticky_thumb">
                            <img src="admin/resimler/<?=$hizmet['resim']?>" alt="">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog_details_content">
                        <div class="blog_details_title">
                            <h2><?=$hizmet['yazi2']?></h2>
                        </div>
                      
                        <div class="blog_details_desc">
                           <p><?=$hizmet['aciklama']?></p>
                         
                        </div>
                        
                       
                        
                        
                          
                       
                                </div>  
                            </div>   
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </section>
    <!--blog section area end-->

   <!-- footer section start -->
   <?php include("./layout/footer-mer.php");?>
<!-- footer section end -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>