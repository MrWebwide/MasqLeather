<?php
$basePath = '../';
require_once __DIR__ . '/../includes/init.php';

$pageTitle = 'Order Detail - Masq Leather';
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

    <?php 
    $userid = $_POST['userid'];
    $gid = intval($_GET['id']);
    $id = $gid;
    $stmt_order = $db->prepare("SELECT * FROM mailgelen WHERE id = :id");
    $stmt_order->execute([':id' => $gid]);
    $guncelle = $stmt_order->fetch(PDO::FETCH_ASSOC);
    
    
    
    
    
    
    
    
    if($_POST['kaydet']){
        
        
        $trackingid = $_POST['trackingid'];
        $orderstatus = $_POST['orderstatus'];
        $reason = $_POST['reason'];
        
        function seflink($string){
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
    $string = strtolower(str_replace($find, $replace, $string));
    $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
    $string = trim(preg_replace('/\s+/', ' ', $string));
    $string = str_replace(' ', '-', $string);
    return $string;
    }
    
    $seo= seflink($site_title);
    
        
        
        $ekle  = $db->prepare("update mailgelen set trackingid=:trackingid, orderstatus=:orderstatus, reason=:reason where id=:id");
        
        $simdi = $ekle->execute(array("trackingid"=>$trackingid,"orderstatus"=>$orderstatus,"reason"=>$reason,"id"=>$id));
        
        if($simdi){
            
            $mesaj = "
            
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                              <strong>Ayarlar Başarıyla Güncellendi!</strong> 
                              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
            
            ";
        }
    
      header('Location: ./index.php');
    exit;
    
        
    }
    
     ?>

 <div class="page-container">
          
                    
            <div >
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">Order Details</h2>
                                    <div class="d-flex" >
                            <div class="buta">
                                    <a href="javascript:history.go(-1);" class="oval-button" style="margin-right:0.3cm"><span>All Orders</span></a>
                                    </div>

                                    <div class="buta">
                                    <a href="../contact.php" class="oval-button"><span>Issue a Refund</span></a>
                                    </div>
                                    </div>
                                    <style>
               .oval-button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 50px; /* Oval şeklini sağlamak için yarıçap */
    background-color: peru;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 150px; /* Tüm altındaki elementleri 1 cm aşağı it */
}
.buta{
margin-bottom:30px;    
}

.oval-button:hover {
    background-color: saddlebrown; /* Hover durumunda arka plan rengi değişimi */
}

.oval-button:hover span {
    color: white; /* Hover durumunda içindeki yazının rengini değiştirme */
}
              </style>      
                                    
                           

                                   
                                 
                                   
		                           
                          
                                    <?php 
$userId = $guncelle['userid'];
$siparisId = $guncelle['siparisid'];
$trackingId = $guncelle['trackingid'];

$totalPrice = 0; // Toplam fiyatı başlat
$cargoPrice = 0; // Toplam fiyatı başlat


$stmt = $db->prepare("SELECT * FROM siparis WHERE userid = ? AND siparisid = ?");
$stmt->execute([$userId, $siparisId]);

$cenk = $db->prepare("SELECT trackingid FROM mailgelen WHERE userid = ?");
$cenk->execute([$trackingId]);



?>




<div class="form-floating mb-3 col-2">
                                      <label for="floatingInput "><strong>Order Number</strong></label>
                                      <input type="text" class="form-control custom-input" id="siparisid" value="<?= $guncelle['siparisid'] ?>" disabled>

                                        
                                      </div>

                                      <div class="form-floating mb-3 col-3">
    <label for="floatingInput"><strong>Tracking Number</strong></label>

    <?php
    $trackingId = $guncelle['trackingid']; // $guncelle['trackingid'] değerini bir değişkene atayalım

    if ($trackingId !== null && $trackingId !== '') {
        // Eğer $trackingId değeri boş değilse, input değerini göster
        echo '<input type="text" class="form-control custom-input2" id="trackingid" value="' . $trackingId . '" disabled>';
    } else {
        // Eğer $trackingId boş ise, "Tracking Number not Available" mesajını göster
        echo '<input type="text" class="form-control custom-input2" id="trackingid" value=" Tracking Number not Available " disabled>';
    }
    ?>
</div>


                                    

<?php foreach ($stmt as $item): ?>
    <?php 
        $totalPrice += $item['total_price']; // Toplam fiyata siparişin fiyatını ekleyin
        $cargoPrice = $item['cargo'];  
    ?>
   <div class="product-info " style="display:flex;">
        <div class="mb-3 col-3">
            <label for="productName<?php echo $item['id']; ?>" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productName<?php echo $item['id']; ?>" value="<?php echo $item['name']; ?>" disabled>
        </div>

        <div class="mb-3 col-1">
            <label for="quantity<?php echo $item['id']; ?>" class="form-label">Quantity</label>
            <input type="text" class="form-control" id="quantity<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" disabled>
        </div>

        <div class="mb-3 col-1">
            <label for="subTotal<?php echo $item['id']; ?>" class="form-label">Sub Total</label>
            <input type="text" class="form-control" id="subTotal<?php echo $item['id']; ?>" value="<?php echo $item['total_price']; ?>$" disabled>
        </div>

        <div class="buta" style="margin-top:1cm">
                                    <a href="../<?=$item['tur'];?>-detail.php?id=<?=$item['urunid'];?>" class="oval-button"><span>Product Page</span></a>
                                    </div>
                                    
                            
    </div>
<?php endforeach; ?>

<?php $totalPrice += $cargoPrice ?>
<div class="form-floating mb-3 col-2">
<label for="floatingInput">Cargo Price</label>
    <input type="text" class="form-control"  value="<?php echo $cargoPrice; ?>$" disabled>
   
</div>
<label for="floatingInput">Total Price(Cargo Included)</label>
<div class="form-floating mb-3 col-2">
    <input type="text" class="form-control"  value="<?php echo $totalPrice; ?>$" disabled>

</div>
<label for="floatingInput">Payment Amount</label>
<div class="form-floating mb-3 col-2">
    <input type="text" class="form-control"  value="<?=$guncelle['totalAmount']?>$" disabled>

</div>

                                    <h4 style="color:black ">Address Detaıls</h4>      
                                    

                                      


                                      <div class="form-floating mb-3 col-2">
                                      <label for="floatingInput">Date</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['eklenme_tarihi']?>" disabled>
                                    
                                      </div>
                                      
                                     
                                     
                                      
                                           <div class="form-floating mb-3 col-2">
                                           <label for="floatingInput"> Name </label>
                                        <input type="text" class="form-control" id="name"  value="<?=$guncelle['name']?>" disabled>
                                    
                                      </div>
                                      
                                      <div class="form-floating mb-3 col-2">
                                      <label for="floatingInput"> Surname</label>
                                        <input type="text" class="form-control" id="surname" value="<?=$guncelle['surname']?>" disabled>
                                    
                                      </div>
                                    
                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">E-Mail</label>
                                        <input type="text" class="form-control" id="email" value="<?=$guncelle['email']?>" disabled>
                                   
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Phone</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['phone']?>" disabled>
                               
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Country</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['country']?>" disabled>
                                      
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Province</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['province']?>" disabled>
                                   
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">City</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['city']?>" disabled>
                       
                                      </div>

                                      
                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Postal</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['postal']?>" disabled>
                                     
                                      </div>

                                      <div class="form-floating mb-3 col-6">
                                      <label for="floatingInput">Adres</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['address']?>" disabled>
                                       
                                      </div>

                                      <div id="bill">
                                    <h2 style="color:black; text-transform:uppercase; ">Bıllıng Address Detaıls</h2>
                                     
                                    


                                      <div class="form-floating mb-3">
                                      <label for="floatingInput">NameBill</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['namebill']?>" disabled>
                                      
                                      </div>

                                      <div class="form-floating mb-3">
                                      <label for="floatingInput">SurnameBill</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['surnamebill']?>" disabled>
                                       
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['addressbill']?>" disabled>
                                        <label for="floatingInput">AdressBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                      <label for="floatingInput">CityBill</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['citybill']?>" disabled>
                                  
                                      </div>

                                      <div class="form-floating mb-3">
                                      <label for="floatingInput">ProvinceBill</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['provincebill']?>" disabled>
                                     
                                      </div>

                                      <div class="form-floating mb-3">
                                      <label for="floatingInput">PostalBill</label>
                                        <input type="text" class="form-control"  value="<?=$guncelle['postalbill']?>" disabled>
                                   
                                      </div>
                                      </div>

                                     
<script>
    // 'bill' id'sine sahip div'i seçme
const billDiv = document.getElementById('bill');

// Tüm input alanlarını seçme
const inputFields = billDiv.querySelectorAll('input');

// Değerleri kontrol etmek için bir dizi oluşturma
const values = Array.from(inputFields).map(input => input.value.trim());

// Tüm değerlerin boş olup olmadığını kontrol etme
const allEmpty = values.every(value => value === '');

// Eğer tüm input değerleri boş ise
if (allEmpty) {
    // 'bill' id'sine sahip div'i gizle (display: none)
    billDiv.style.display = 'none';
}

</script>


                                  
                                    
                               
                                       
<div id="queue"></div>
                                      
                                      
                                      
                                      </div>
                                        
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  
                    
                    
                    <style>

.product-info > div {
    margin-right: 20px; /* 20px sağ boşluk */
}

.product-info > div:last-child {
    margin-right: 0; /* Son öğe için sağ boşluğu sıfırla */
}

.custom-input {
    color: red; /* Input metin rengini kırmızı olarak ayarlar */
    font-weight: bold; /* Input metnini kalın olarak ayarlar */
    border: 2px solid peru; /* Input kenarlık rengini mavi olarak ayarlar */
    /* Diğer istediğiniz CSS stilleri */
}

.custom-input2 {
    color: black; /* Input metin rengini kırmızı olarak ayarlar */
    font-weight: bold; /* Input metnini kalın olarak ayarlar */
    border: 2px solid black; /* Input kenarlık rengini mavi olarak ayarlar */
    /* Diğer istediğiniz CSS stilleri */
}


</style>
                    
                    


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
