<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();




$userid = $_POST['userid'];
$gid = $_GET['id'];
$id = $_GET['id'];
$guncelle = $db->query("select * from mailgelen where id='$gid'")->fetch(PDO::FETCH_ASSOC);








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

<!DOCTYPE html>
<html lang="tr">
    
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?=$ayar['site_description']?>">
        <meta name="keywords" content="<?=$ayar['site_keyword']?>">
        <meta name="author" content="<?=$ayar['site_author']?>">
        <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
        <title>Sold Product | <?=$ayar['site_title']?></title>




        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

   
        <link href="assets/css/main.min.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">

       
    </head>
    <body>
     

        <div class="page-container">
          <div class="page-header">
            <?php include("include/header.php");?>
        </div>
                     <?php include("include/menu.php");?>
            <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Sale Details</h5>
                                    <a href="index.php#hbrfrm"  style="border-radius: 10px;" class="btn btn-primary m-b-md">Home</a>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                        <div id="shipped">
                                    <h5>Tracking ID</h5>
<div class="form-floating d-flex mb-3 col-3">
    <input type="text" class="form-control" name="trackingid" id="trackingid" value="<?=$guncelle['trackingid']?>" >
    <label for="floatingInput">Tracking ID</label>
</div>
</div>

<div class="mb-3 col-2">
    <h5>Order Status</h5>
    <select class="form-select" name="orderstatus" id="orderstatus">
        <?php if(empty($guncelle['orderstatus'])): ?>
            <option value="" selected>Select One</option>
        <?php else: ?>
            <option style="display:none;" value="<?=$guncelle['orderstatus']?>"><?=$guncelle['orderstatus']?></option>
            <option value="">Select One</option>
        <?php endif; ?>
        <option value="Shipped">Shipped</option>
        <option value="Order Cancelled">Order Cancelled</option>
        <option value="Order Completed">Order Completed</option>
    </select>
</div>

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#ajax').click(function(){
            var trackingid = $('#trackingid').val();
            var orderstatus = $('#orderstatus').val();
            
            if (orderstatus == 'Shipped' && trackingid.trim() != '') {
                var name = $('#name').val();
                var surname = $('#surname').val();
                var email = $('#email').val();
                var siparisid = $('#siparisid').val();

                $.ajax({
                    type: 'POST',
                    url: '../functions/mailer/admin-order-mail.php',
                    data: {
                        trackingid: trackingid,
                        name: name,
                        surname: surname,
                        email: email,
                        siparisid: siparisid
                    },
                    success: function(response){
                        // Burada gerekirse başarılı olduğuna dair bir işlem yapabilirsiniz
                        console.log('Mail gönderildi: ' + response);
                    }
                });
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var orderStatusSelect = document.getElementById("orderstatus");
        var reasonTextarea = document.getElementById("reason1");

        orderStatusSelect.addEventListener("change", function() {
            if (this.value === "Order Cancelled") {
                reasonTextarea.style.display = "block";
            } else {
                reasonTextarea.style.display = "none";
            }
        });

        // Initial state
        if (orderStatusSelect.value === "Order Cancelled") {
            reasonTextarea.style.display = "block";
        } else {
            reasonTextarea.style.display = "none";
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        var orderStatusSelect = document.getElementById("orderstatus");
        var reasonTextarea = document.getElementById("shipped");

        orderStatusSelect.addEventListener("change", function() {
            if (this.value === "Shipped") {
                reasonTextarea.style.display = "block";
            } else {
                reasonTextarea.style.display = "none";
            }
        });

        // Initial state
        if (orderStatusSelect.value === "Shipped") {
            reasonTextarea.style.display = "block";
        } else {
            reasonTextarea.style.display = "none";
        }
    });

    $(document).ready(function(){
        $('#ajax').click(function(){
            var orderstatus = $('#orderstatus').val();
            var reason = $('#reason').val();

            if (orderstatus == 'Order Cancelled') {
                var name = $('#name').val();
                var surname = $('#surname').val();
                var email = $('#email').val();
                var siparisid = $('#siparisid').val();
                
                

                $.ajax({
                    type: 'POST',
                    url: '../functions/mailer/admin-order-cancelled.php',
                    data: {
                        name: name,
                        surname: surname,
                        email: email,
                        siparisid: siparisid,
                        reason: reason
                    },
                    success: function(response){
                        // Burada gerekirse başarılı olduğuna dair bir işlem yapabilirsiniz
                        console.log('Mail gönderildi: ' + response);
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        $('#ajax').click(function(){
            var orderstatus = $('#orderstatus').val();
            
            if (orderstatus == 'Order Completed') {
                var name = $('#name').val();
                var surname = $('#surname').val();
                var email = $('#email').val();
                var siparisid = $('#siparisid').val();
           

                $.ajax({
                    type: 'POST',
                    url: '../functions/mailer/admin-order-completed.php',
                    data: {
                        name: name,
                        surname: surname,
                        email: email,
                        siparisid: siparisid
                      
                    },
                    success: function(response){
                        // Burada gerekirse başarılı olduğuna dair bir işlem yapabilirsiniz
                        console.log('Mail gönderildi: ' + response);
                    }
                });
            }
        });
    });
</script>
<div id="reason1">
<div class="form-floating d-flex mb-3 col-3 " >
    <input type="text" class="form-control " name="reason" id="reason" value="<?=$guncelle['reason']?>" >
    <label for="floatingInput">Cancel Reason</label>
</div>
</div>
<div class="mb-3">
                                 
                                 <input type="submit" name="kaydet" class="btn btn-primary" id="ajax" value="Save" >
  </div>
                            </form>
                                    
                           

                                   
                                    <h1 style="color:black;">PRODUCT DETAILS</h1>
                                   
		                           
                          
                                    <?php 
$userId = $guncelle['userid'];
$siparisId = $guncelle['siparisid'];

$totalPrice = 0; // Toplam fiyatı başlat
$cargoPrice = 0; // Toplam fiyatı başlat


$stmt = $db->prepare("SELECT * FROM siparis WHERE userid = ? AND siparisid = ?");
$stmt->execute([$userId, $siparisId]);



?>






                                    

<?php foreach ($stmt as $item): ?>
    <?php $totalPrice += $item['total_price']; // Toplam fiyata siparişin fiyatını ekleyin
          $cargoPrice = $item['cargo'];  
    ?>
    <div class="product-info d-flex">
        <div class="form-floating d-flex mb-3 col-3">
            <input type="text" class="form-control" value="<?php echo $item['name']; ?>" disabled>
            <label for="floatingInput">Product Name</label>
        </div>

        <div class="form-floating d-flex mb-3 col-1">
            <input type="text" class="form-control" value="<?php echo $item['quantity']; ?>" disabled>
            <label for="floatingInput">Quantity</label>
        </div>
        <div class="form-floating d-flex mb-3 col-1">
            <input type="text" class="form-control" value="<?php echo $item['total_price']; ?>$" disabled>
            <label for="floatingInput">Sub Total</label>
        </div>
    </div>
<?php endforeach; ?>
<?php $totalPrice += $cargoPrice ?>
<div class="form-floating mb-3 col-2">
    <input type="text" class="form-control"  value="<?php echo $cargoPrice; ?>$" disabled>
    <label for="floatingInput">Cargo Price</label>
</div>
<div class="form-floating mb-3 col-2">
    <input type="text" class="form-control"  value="<?php echo $totalPrice; ?>$" disabled>
    <label for="floatingInput">Total Price(Cargo Included)</label>
</div>
<h6>The amount bellow shows the customer's payment after applying coupon and/or gift cards. </h6>
<div class="form-floating mb-3 col-2">
    <input type="text" class="form-control"  value="<?=$guncelle['totalAmount']?>$" disabled>
    <label for="floatingInput">Customer Payment</label>
</div>

                                    <h1 style="color:black; text-transform:uppercase; ">Customer Detaıls</h1>      
                                    <div class="form-floating mb-3 col-1">
                                        <input type="text" class="form-control"  value="<?=$guncelle['id']?>" disabled>
                                        <label for="floatingInput">Mesaj Id</label>
                                      </div>

                                      <div class="form-floating mb-3 col-2">
                                        <input type="text" class="form-control"  id="siparisid" value="<?=$guncelle['siparisid']?>" disabled>
                                        <label for="floatingInput">Order ID</label>
                                      </div>

                                      <div class="form-floating mb-3 col-1">
                                        <input type="text" class="form-control"  value="<?=$guncelle['userid']?>" disabled>
                                        <label for="floatingInput">Member Id</label>
                                      </div>

                                      <div class="form-floating mb-3 col-2">
                                        <input type="text" class="form-control"  value="<?=$guncelle['eklenme_tarihi']?>" disabled>
                                        <label for="floatingInput">Date</label>
                                      </div>
                                      
                                     
                                     
                                      
                                           <div class="form-floating mb-3 col-2">
                                        <input type="text" class="form-control" id="name"  value="<?=$guncelle['name']?>" disabled>
                                        <label for="floatingInput"> Adı </label>
                                      </div>
                                      
                                      <div class="form-floating mb-3 col-2">
                                        <input type="text" class="form-control" id="surname" value="<?=$guncelle['surname']?>" disabled>
                                        <label for="floatingInput">  Soyadı</label>
                                      </div>
                                    
                                      <div class="form-floating mb-3 col-3">
                                        <input type="text" class="form-control" id="email" value="<?=$guncelle['email']?>" disabled>
                                        <label for="floatingInput">E-Mail</label>
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['phone']?>" disabled>
                                        <label for="floatingInput">Phone</label>
                                      </div>

                                      <div class="form-floating mb-3 col-3">
    <input type="text" class="form-control" value="<?php echo ($guncelle['country'] == 2) ? 'Canada' : (($guncelle['country'] == 3) ? 'United States' : ''); ?>" disabled>
    <label for="floatingInput">Country</label>
</div>


                                      <div class="form-floating mb-3 col-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['province']?>" disabled>
                                        <label for="floatingInput">Province</label>
                                      </div>

                                      <div class="form-floating mb-3 col-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['city']?>" disabled>
                                        <label for="floatingInput">City</label>
                                      </div>

                                      
                                      <div class="form-floating mb-3 col-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['postal']?>" disabled>
                                        <label for="floatingInput">Postal</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['address']?>" disabled>
                                        <label for="floatingInput">Adres</label>
                                      </div>

                                      
                                    <h1 style="color:black; text-transform:uppercase; ">Bıllıng Address Detaıls</h1>
                                   <H3 style="color:grey; ">(The information under this heading appears as the billing address if the customer has chosen a different billing address than the delivery address.)</H3>   
                                    


                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['namebill']?>" disabled>
                                        <label for="floatingInput">NameBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['surnamebill']?>" disabled>
                                        <label for="floatingInput">SurnameBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['addressbill']?>" disabled>
                                        <label for="floatingInput">AdressBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['citybill']?>" disabled>
                                        <label for="floatingInput">CityBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['provincebill']?>" disabled>
                                        <label for="floatingInput">ProvinceBill</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['postalbill']?>" disabled>
                                        <label for="floatingInput">PostalBill</label>
                                      </div>
                                     

                                     



                                  
                                    
                                      
                                     <!--    <div class=" mb-3">
                                            <label for="floatingInput"> Mesaj</label>
                                          <textarea class="form-control"  rows="2" cols="20" disabled><?=$guncelle['message']?></textarea>
                                        
                                      </div>
                              
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['adres']?>" disabled>
                                        <label for="floatingInput">Hizmet</label>
                                      </div>
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['doktor']?>" disabled>
                                        <label for="floatingInput">Doktor</label>
                                      </div>
                                                -->
                                       
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

</style>
                    
                    


                </div>
                                  
                </div>
              
            </div>

            
         <script src="ckeditor-2/ckeditor.js"></script>
     
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        
        
	
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>