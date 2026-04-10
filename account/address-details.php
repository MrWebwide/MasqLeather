<?php
$basePath = '../';
require_once __DIR__ . '/../includes/init.php';

$pageTitle = 'Address Details - Masq Leather';
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
                        <h2>Saved Addresses</h2>
                        <ul class="d-flex justify-content-center">
                            <li><a href="../index.php">Home</a></li>
                            <li>></li>
                            <li><a>Saved Addresses</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>

    <?php
// Check if form is submitted
if(isset($_POST['kaydet'])) {
    // Retrieve posted values
    $addname = $_POST['addname'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

// İlk önce, veritabanında adsoyad ile eşleşen bir kayıt olup olmadığını kontrol edelim
$kontrol = $db->prepare("SELECT COUNT(*) FROM useraddress WHERE adsoyad = :adsoyad");
$kontrol->execute(array("adsoyad" => $adsoyad));
$sayi = $kontrol->fetchColumn();

if ($sayi > 0) {
    // Kayıt mevcutsa, güncelleme işlemi yap
    $ekle = $db->prepare("UPDATE useraddress SET addname=:addname, province=:province, city=:city, postal=:postal,userid=:userid, address=:address, email=:email, phone=:phone WHERE adsoyad=:adsoyad");
    $simdi = $ekle->execute(array(
        "addname" => $addname,
        "province" => $province,
        "city" => $city,
        "postal" => $postal,
        "address" => $address,
        "email" => $email,
        "phone" => $phone,
        "adsoyad" => $adsoyad,
        "userid" => $userId
    ));
} else {
    // Kayıt mevcut değilse, yeni kayıt ekle
    $ekle = $db->prepare("INSERT INTO useraddress SET addname=:addname, province=:province, city=:city, postal=:postal,userid=:userid, address=:address, email=:email, phone=:phone, adsoyad=:adsoyad");
    $simdi = $ekle->execute(array(
        "addname" => $addname,
        "province" => $province,
        "city" => $city,
        "postal" => $postal,
        "address" => $address,
        "email" => $email,
        "phone" => $phone,
        "adsoyad" => $adsoyad,
        "userid" => $userId
    ));
}

    
    // Check if update was successful
    if($simdi) {
        $mesaj = "<div class='alert alert-warning alert-dismissible fade show' id='del' role='alert'>
                      <strong>Address Updated Successfully!</strong> 
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";  
                 
    }



}

  // Fetch updated record from database
  $stmt_addr = $db->prepare("SELECT * FROM useraddress WHERE adsoyad = :adsoyad");
  $stmt_addr->execute([':adsoyad' => $adsoyad]);
  $guncelle = $stmt_addr->fetch(PDO::FETCH_ASSOC);
?>

 <div class="page-container">
          
                    
            <div>
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">Saved Addresses</h2>
                                    <div class="d-flex" >
                            <div class="buta">
                                    <a href="../index.php" class="oval-button" style="margin-right:0.3cm"><span>Home</span></a>
                                    <button class="oval-button" style="margin-right:0.3cm" onclick="silAddress('<?php echo $adsoyad; ?>')"><span>Delete Address</span></button>

                                    
                                    <script>
function silAddress(adsoyad) {
    // Kullanıcı onayladıysa, AJAX kullanarak veritabanından adresi silme işlemi gerçekleştirilecek
    $.ajax({
        type: 'POST',
        url: '../functions/delete_address.php',
        data: { adsoyad: adsoyad },
        success: function(response) {
            $('.alert').removeClass('d-none').addClass('d-flex');
            $('.alert strong').text('Address Deleted Successfully!');
            clearFormFields();
            clearupdateinfo();
        },
        error: function() {
            alert('There was a problem with deleting address.');
        }
    });
}

function clearFormFields() {
    $('input[name="addname"]').val('');
    $('input[name="province"]').val('');
    $('input[name="city"]').val('');
    $('input[name="postal"]').val('');
    $('input[name="address"]').val('');
    $('input[name="email"]').val('');
    $('input[name="phone"]').val('');
}

function clearupdateinfo() {
    var element = document.getElementById('del');
    element.classList.remove('d-flex');
    element.classList.add('d-none');
}

</script>

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
                                    
                           

                                    <form method="post" enctype="multipart/form-data" >

                                    <h4 style="color:black ">Address Details  </h4>      
                                    <?=$mesaj?>
                                    <div class='alert alert-warning alert-dismissible fade show d-none' role='alert'>
                      <strong>Address Deleted Successfully!</strong> 
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>

                                      
                                    <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Address Name</label>
                                        <input type="text" class="form-control" name="addname" value="<?=$guncelle['addname']?>" required>
                                   
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Province/State</label>
                                        <input type="text" class="form-control" name="province" value="<?=$guncelle['province']?>" required>
                                   
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">City</label>
                                        <input type="text" class="form-control" name="city" value="<?=$guncelle['city']?>" required>
                       
                                      </div>

                                      
                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Postal/Zip Code</label>
                                        <input type="text" class="form-control" name="postal" value="<?=$guncelle['postal']?>" required>
                                     
                                      </div>

                                      <div class="form-floating mb-3 col-6">
                                      <label for="floatingInput">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?=$guncelle['address']?>" required>
                                       
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">E-Mail</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?=$guncelle['email']?>" required>
                                     
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Phone</label>
                                        <input type="text" class="form-control" name="phone"  value="<?=$guncelle['phone']?>" required>
                                    
                                      </div>

                                     
                                        <input type="hidden"  name="userid" value="<?=$userId?>" required>
                                   
                                   

                                     



                                  
                                    
                               
                                       
<div id="queue"></div>
<div class="mb-3">
        <input type="submit" name="kaydet" class="btn btn-primary" value="Kaydet">
    </div>
                                      
                                      
                                      </div>
</form>         
                                      
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
