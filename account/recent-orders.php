<?php
$basePath = '../';
require_once __DIR__ . '/../includes/init.php';

$pageTitle = 'Recent Orders - Masq Leather';
$noExzoom = true;
$pageCSS = [$basePath . 'admin/assets/css/main.min.css'];
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/../functions/analytics.php'; ?>
<?php include __DIR__ . '/../includes/head-meta.php'; ?>
<?php include __DIR__ . '/../includes/head-css.php'; ?>
<?php include __DIR__ . '/../includes/head-js.php'; ?>
    <style>
        .main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }
        a { color: unset; }
    </style>
    <script src="<?=$basePath?>assets/js/ajax.js"></script>
    <script src="<?=$basePath?>assets/js/handlewindowsize.js"></script>
</head>
<body class="exclude-script">


    <!--offcanvas menu area start-->
    <div class="body_overlay">

    </div>
  <?php $basePath = '../'; include('../layout/header-2.php'); ?>

    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h2>Recent Orders</h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="../index.php">Home</a></li>
                            <li>></li>
                            <li><a>Recent Orders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>

    <div>
                <div class="main-wrapper">
                  
                  
                
                
                
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body" style="overflow:scroll">
                             
                           
                               
                                         <table class="table invoice-table">
                                            <thead>
                                              <tr>
                                                <th scope="col">Most Recent Orders </th>
                                                <th scope="col">Order ID</th>
                                                
                                                <th scope="col">Order Total</th>
                                                <th scope="col">Date of Purchase</th>
                                                <th scope="col">Process</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$stmt_orders = $db->prepare("SELECT * FROM mailgelen WHERE adsoyad = :adsoyad ORDER BY id DESC");
$stmt_orders->execute([':adsoyad' => $adsoyad]);
$urunlistele = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
if ($urunlistele->rowCount()) {
    // Başlangıç değeri için bir numara değişkeni tanımlayalım
    $sira = 1;
    foreach ($urunlistele as $urungoster) {
?>
        <tr>
            <!-- Ürün sırasını yazdırmak için $sira değişkenini kullanalım -->
            <th scope="row"><?= $sira ?></th>
            <td><?= $urungoster['siparisid'] ?></td>
     
            <td>$<?= $urungoster['totalAmount'] ?> CAD</td>
            <td><span class="badge bg-primary"><?= $urungoster['eklenme_tarihi'] ?></span></td>
            <td>
             
                <a href="order-detail.php?islem=duzenle&id=<?= $urungoster['id'] ?>" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>
            </td>
        </tr>
<?php
        // Her bir ürün için sıra numarasını bir arttıralım
        $sira++;
    }
}
?>

                                       
                                              
                                            </tbody>
                                          </table>
                            </div>
                        </div>      
                    </div>
                </div>
                </div>
                </div>



     <!-- footer section start -->
     <footer class="footer_section footer_bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main_footer d-flex justify-content-between align-items-center">
                        <div class="footer_left">
                            <div class="footer_logo">
                                <a href="../index.html"><img src="../assets/img/logo/Artboard 1 copy 3.png" width="140px"
                                        alt=""></a>
                            </div>
                            <div class="footer_social">
                            <ul class="d-flex">
                                <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            </ul>
                            </div>
                        </div>
                        <div class="footer_sidebar d-flex">
                            <div class="footer_widget_list">
                                <div class="footer_widget_title">
                                    <h3>COMPANY</h3>
                                </div>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="../about.php">About Us</a></li>
                                        <li><a href="../contact.php">Contact</a></li>


                                        <li><a href="#">Site Map</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="footer_widget_list">
                                <div class="footer_widget_title">
                                    <h3>Help</h3>
                                </div>
                                <div class="footer_menu">
                                    <ul>
                                    <li><a href="../legal/terms.php">Terms and Services</a></li>
                                    <li><a href="../legal/refund.php">Refund Policy</a></li>
                                    <li><a href="../legal/shipping.php">Shipping Policy</a></li>
                                    <li><a href="../legal/privacy.php">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="footer_widget_list">
                                <div class="footer_widget_title">
                                    <h3>Latest Blogs</h3>
                                </div>
                                <div class="footer_menu">
                                <ul>
    <?php
    $sql = "SELECT adi, id FROM bloglar ORDER BY id DESC LIMIT 4";
    $stmt = $db->query($sql);

    if ($stmt) {
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li><a href="../blog-details.php?id=' . $row["id"] . '">' . $row["adi"] . '</a></li>';
            }
        } else {
            echo "No Blogs.";
        }
    } else {
        echo "Sorgu hatası: " . print_r($conn->errorInfo());
    }
    ?>
</ul>

</div>

                            </div>
                            <div class="footer_widget_list">
                                <div class="footer_widget_title">
                                    <h3>Sing up for newsletter</h3>
                                </div>
                                <div class="newsletter_subscribe">
                                    <form id="mc-form">
                                        <input id="mc-email" type="email" autocomplete="off"
                                            placeholder="Email address... ">
                                        <button id="mc-submit">Subscribe</button>
                                    </form>
                                    <!-- mailchimp-alerts Start -->
                                    <div class="mailchimp-alerts text-centre">
                                        <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                        <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                        <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                                    </div><!-- mailchimp-alerts end -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="footer_bottom">
                        <div class="copyright_right text-center">
                            <p>&copy; 2023 All rights reserved Made
                                by <a href="https://www.adwebture.com">Adwebture</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end -->
    

 <!-- Js 
    ========================= -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="../assets/js/swiper-bundle.min.js"></script>
    <script src="../assets/js/slick.min.js"></script>
    <script src="../assets/js/wow.min.js"></script>
    <script src="../assets/js/jquery.scrollup.min.js"></script>
    <script src="../assets/js/images-loaded.min.js"></script>
    <script src="../assets/js/jquery.nice-select.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/mailchimp-ajax.js"></script>
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <script src="../assets/js/jquery-waypoints.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/ajax-mail.js"></script>



    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>


    <script type="text/javascript">

        $('.container').imagesLoaded(function () {
            $("#exzoom").exzoom({
                autoPlay: false,
            });
            $("#exzoom").removeClass('hidden')
        });

    </script>


    <script>
        // Mesajın otomatik kapanması veya kaybolması için JavaScript kodu
        setTimeout(function () {
            var message = document.querySelector('.message');
            if (message) {
                message.style.display = 'none';
            }
        }, 6000); // Mesajın 3 saniye sonra kaybolmasını sağlar, istediğiniz süreyi buradan ayarlayabilirsiniz.
    </script>

  <script>
    $(document).ready(function () {
        function handleButtonClick(event) {
            event.stopPropagation();

            var $btnWrapper = $(this).closest('.btn-wrapper');
            $btnWrapper.addClass('add');

            setTimeout(function () {
                $btnWrapper.removeClass('add');
            }, 2200); // 2200 milisaniye (2.2 saniye) sonra animasyon sınıfını kaldır
        }

        $('.add-to-cart').on('click touchstart', handleButtonClick);
    });
</script>
</body>
</html>
