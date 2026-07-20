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
// MAS-109: Çoklu adres desteği. Adresler artık `id` ile yönetilir (userid'e bağlı),
// eskiden `adsoyad` ile tek satır tutuluyordu → kullanıcı yalnızca 1 adres kaydedebiliyordu.
$mesaj = '';
if(isset($_POST['kaydet'])) {
    // Retrieve posted values
    $editId  = isset($_POST['edit_id']) && $_POST['edit_id'] !== '' ? intval($_POST['edit_id']) : 0;
    $addname = $_POST['addname'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // MAS-97: isim/soyisim/ülke de kaydedilir
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $country = $_POST['country'] ?? '';

    if ($editId > 0) {
        // MAS-109: mevcut adresi güncelle — yalnızca bu kullanıcının kaydı (güvenlik: userid şartı)
        $ekle = $db->prepare("UPDATE useraddress SET addname=:addname, name=:name, surname=:surname, country=:country, province=:province, city=:city, postal=:postal, address=:address, email=:email, phone=:phone WHERE id=:id AND userid=:userid");
        $simdi = $ekle->execute(array(
            "addname" => $addname, "name" => $name, "surname" => $surname, "country" => $country,
            "province" => $province, "city" => $city, "postal" => $postal, "address" => $address,
            "email" => $email, "phone" => $phone, "id" => $editId, "userid" => $userId
        ));
        $mesajText = 'Address Updated Successfully!';
    } else {
        // MAS-109: her zaman YENİ adres ekle (artık üzerine yazmıyor)
        $ekle = $db->prepare("INSERT INTO useraddress SET addname=:addname, name=:name, surname=:surname, country=:country, province=:province, city=:city, postal=:postal, userid=:userid, address=:address, email=:email, phone=:phone, adsoyad=:adsoyad, eklenme_tarihi=:tarih");
        $simdi = $ekle->execute(array(
            "addname" => $addname, "name" => $name, "surname" => $surname, "country" => $country,
            "province" => $province, "city" => $city, "postal" => $postal, "address" => $address,
            "email" => $email, "phone" => $phone, "userid" => $userId, "adsoyad" => $adsoyad,
            "tarih" => date('Y-m-d H:i:s')
        ));
        $mesajText = 'Address Added Successfully!';
    }

    if($simdi) {
        $mesaj = "<div class='alert alert-warning alert-dismissible fade show' id='del' role='alert'>
                      <strong>" . $mesajText . "</strong>
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    }
}

// MAS-109: Kullanıcının TÜM kayıtlı adresleri
$addrListStmt = $db->prepare("SELECT * FROM useraddress WHERE userid = :userid ORDER BY id DESC");
$addrListStmt->execute([':userid' => $userId]);
$savedAddresses = $addrListStmt->fetchAll(PDO::FETCH_ASSOC);

// Düzenleme modu: ?edit=<id> geldiyse o adresi forma yükle; yoksa form BOŞ (yeni adres ekleme)
$editId = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$guncelle = [];
if ($editId > 0) {
    foreach ($savedAddresses as $a) {
        if ((int)$a['id'] === $editId) { $guncelle = $a; break; }
    }
    if (empty($guncelle)) { $editId = 0; } // başkasının/olmayan id → yeni ekleme moduna düş
}
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
                                    <!-- MAS-109: yeni adres ekleme formunu temizler (edit modundan çıkar) -->
                                    <a href="address-details.php" class="oval-button" style="margin-right:0.3cm"><span>+ Add New Address</span></a>

                                    <script>
function silAddress(id) {
    if (!confirm('Delete this address?')) { return; }
    // MAS-109: adres artık id ile silinir (kullanıcının birden çok adresi olabilir)
    $.ajax({
        type: 'POST',
        url: '../functions/delete_address.php',
        data: { id: id },
        success: function(response) {
            // Listeyi tazelemek için sayfayı yenile
            window.location.href = 'address-details.php';
        },
        error: function() {
            alert('There was a problem with deleting address.');
        }
    });
}

function clearupdateinfo() {
    var element = document.getElementById('del');
    if (element) { element.classList.remove('d-flex'); element.classList.add('d-none'); }
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
/* MAS-109: kayıtlı adres listesi kartları */
.addr-list { display:flex; flex-wrap:wrap; gap:14px; margin-bottom:26px; }
.addr-card { border:1px solid #e2d6c8; border-radius:10px; padding:14px 16px; min-width:230px; max-width:300px; background:#fbf8f4; }
.addr-card.active { border-color:#AB6E35; box-shadow:0 0 0 2px rgba(171,110,53,.15); }
.addr-card h5 { margin:0 0 6px; font-size:15px; font-weight:700; color:#3d2b1a; }
.addr-card p { margin:0 0 4px; font-size:13px; color:#5b5b5b; line-height:1.4; }
.addr-card .addr-actions { margin-top:10px; display:flex; gap:8px; }
.addr-card .addr-actions a, .addr-card .addr-actions button {
    font-size:12px; font-weight:600; padding:5px 12px; border-radius:50px;
    border:none; cursor:pointer; text-decoration:none;
}
.addr-edit { background:#AB6E35; color:#fff !important; }
.addr-del  { background:#c0392b; color:#fff !important; }
                                   </style>


                                    <!-- MAS-109: kullanıcının tüm kayıtlı adresleri -->
                                    <?php if (!empty($savedAddresses)): ?>
                                    <div class="addr-list">
                                        <?php foreach ($savedAddresses as $a):
                                            $isActive = ($editId > 0 && (int)$a['id'] === $editId);
                                            $countryLabel = ($a['country']=='2') ? 'Canada' : (($a['country']=='3') ? 'United States' : '');
                                        ?>
                                        <div class="addr-card <?= $isActive ? 'active' : '' ?>">
                                            <h5><?= htmlspecialchars($a['addname'] ?: 'Address') ?></h5>
                                            <p><?= htmlspecialchars(trim(($a['name'] ?? '') . ' ' . ($a['surname'] ?? ''))) ?></p>
                                            <p><?= htmlspecialchars($a['address'] ?? '') ?></p>
                                            <p><?= htmlspecialchars(trim(($a['city'] ?? '') . ' ' . ($a['province'] ?? '') . ' ' . ($a['postal'] ?? ''))) ?></p>
                                            <p><?= htmlspecialchars($countryLabel) ?></p>
                                            <div class="addr-actions">
                                                <a class="addr-edit" href="address-details.php?edit=<?= (int)$a['id'] ?>">Edit</a>
                                                <button type="button" class="addr-del" onclick="silAddress(<?= (int)$a['id'] ?>)">Delete</button>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <form method="post" enctype="multipart/form-data" >
                                    <!-- MAS-109: düzenleme modunda id taşınır; boşsa yeni adres eklenir -->
                                    <input type="hidden" name="edit_id" value="<?= $editId > 0 ? (int)$editId : '' ?>">

                                    <h4 style="color:black "><?= $editId > 0 ? 'Edit Address' : 'Add New Address' ?></h4>
                                    <?=$mesaj?>

                                      
                                    <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Address Name</label>
                                        <input type="text" class="form-control" name="addname" value="<?=$guncelle['addname'] ?? ''?>" required>

                                      </div>

                                      <!-- MAS-97: isim/soyisim/ülke de kaydedilir → checkout'ta saved address seçilince otomatik dolar -->
                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">First Name</label>
                                        <input type="text" class="form-control" name="name" value="<?=$guncelle['name'] ?? ''?>">
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Last Name</label>
                                        <input type="text" class="form-control" name="surname" value="<?=$guncelle['surname'] ?? ''?>">
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput">Country</label>
                                        <select class="form-control" name="country" id="addr-country">
                                            <option value="1" <?= (!isset($guncelle['country']) || $guncelle['country']==='' || $guncelle['country']=='1') ? 'selected' : '' ?>>Select Country</option>
                                            <option value="2" <?= (($guncelle['country'] ?? '')=='2') ? 'selected' : '' ?>>Canada</option>
                                            <option value="3" <?= (($guncelle['country'] ?? '')=='3') ? 'selected' : '' ?>>United States</option>
                                        </select>
                                      </div>

                                      <!-- MAS-107: province artık checkout ile aynı dropdown (Kanada illeri).
                                           ABD seçilince gizlenir, "USA" sentinel'i yazılır (checkout davranışı). -->
                                      <div class="form-floating mb-3 col-3" id="addr-province-wrap">
                                      <label for="floatingInput">Province</label>
                                        <select class="form-control" name="province" id="addr-province">
                                            <?php
                                            $provSaved = $guncelle['province'] ?? '';
                                            $caProvinces = array(
                                                'AB'=>'Alberta','BC'=>'British Columbia','MB'=>'Manitoba','NB'=>'New Brunswick',
                                                'NL'=>'Newfoundland and Labrador','NS'=>'Nova Scotia','ON'=>'Ontario',
                                                'PE'=>'Prince Edward Island','QC'=>'Quebec','SK'=>'Saskatchewan',
                                                'NT'=>'Northwest Territories','NU'=>'Nunavut','YT'=>'Yukon'
                                            );
                                            echo '<option value="USA"' . (($provSaved==='' || $provSaved==='USA') ? ' selected' : '') . '>Select Province</option>';
                                            foreach ($caProvinces as $pc => $pn) {
                                                echo '<option value="' . $pc . '"' . ($provSaved===$pc ? ' selected' : '') . '>' . $pn . '</option>';
                                            }
                                            // Eski kayıtlar serbest metin olabilir (örn. "Ontario") — listede yoksa koru
                                            if ($provSaved !== '' && $provSaved !== 'USA' && !isset($caProvinces[$provSaved])) {
                                                echo '<option value="' . htmlspecialchars($provSaved) . '" selected>' . htmlspecialchars($provSaved) . '</option>';
                                            }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                      <label for="floatingInput" id="addr-city-label">City</label>
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

<script>
// MAS-107: checkout ile aynı country/province davranışı
$(function () {
    var $country  = $('#addr-country');
    var $provWrap = $('#addr-province-wrap');
    var $prov     = $('#addr-province');
    var $cityLbl  = $('#addr-city-label');

    function applyCountry() {
        var c = $country.val();
        if (c === '3') { // ABD: province seçilmez, state şehirle birlikte yazılır
            $provWrap.hide();
            $prov.val('USA');
            $cityLbl.text('State and City');
        } else {
            $provWrap.show();
            $cityLbl.text('City');
        }
    }
    $country.on('change', function () {
        $country[0].setCustomValidity('');
        $prov[0].setCustomValidity('');
        applyCountry();
    });
    $prov.on('change', function () { $prov[0].setCustomValidity(''); });
    applyCountry();

    $country.closest('form').on('submit', function (e) {
        var c = $country.val();
        if (c === '1' || !c) {
            e.preventDefault();
            $country[0].setCustomValidity('Please select a country.');
            $country[0].reportValidity();
            return false;
        }
        $country[0].setCustomValidity('');
        if (c === '2' && ($prov.val() === 'USA' || !$prov.val())) {
            e.preventDefault();
            $prov[0].setCustomValidity('Please select a province.');
            $prov[0].reportValidity();
            return false;
        }
        $prov[0].setCustomValidity('');
    });
});
</script>         
                                      
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
