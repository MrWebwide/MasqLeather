<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");




ob_start();
session_start();
oturumkontrolana();

if($_POST['kaydet']){
	
	$id = 1;
	$adi = $_POST['adi'];
	$sira=$_POST['sira'];
	$aciklama = $_POST['aciklama'];
	$onaciklama = $_POST['onaciklama'];
	$durum = $_POST['durum'];
  $durum1 = $_POST['durum1'];
  $durum2 = $_POST['durum2'];

	$kategori = $_POST['kategori'];
	$seo = $_POST['seo'];
  $tur = $_POST['tur'];
  $yazi1 = $_POST['yazi1'];
	$yazi2 = $_POST['yazi2'];
  $yazi3 = $_POST['yazi3'];
  $yazi4 = $_POST['yazi4'];
	$yazi5 = $_POST['yazi5'];
	$yazi6 = $_POST['yazi6'];
	$yazi7 = $_POST['yazi7'];
	$yazi8 = $_POST['yazi8'];
	$yazi9 = $_POST['yazi9'];
	$yazi10 = $_POST['yazi10'];


	
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


	$ekle  = $db->prepare("update icecek set adi=:adi,sira=:sira,kategori=:kategori,durum=:durum,durum1=:durum1,durum2=:durum2,onaciklama=:onaciklama,yazi1=:yazi1,yazi2=:yazi2,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,tur=:tur where id=:id");
	
	$simdi = $ekle->execute(array("adi"=>$adi,"sira"=>$sira,"kategori"=>$kategori,"durum"=>$durum,"durum1"=>$durum1,"durum2"=>$durum2,"onaciklama"=>$onaciklama,"yazi1"=>$yazi1,"yazi2"=>$yazi2,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"tur"=>$tur,"id"=>$id));
	
	if($simdi){
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ayarlar Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
}

$guncelle = $db->query("select * from icecek where id='1'")->fetch(PDO::FETCH_ASSOC);





// Veritabanından durum verisini çek
$query = $db->query("SELECT durum FROM icecek");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum = $result['durum'];

// Veritabanından durum verisini çek
$query = $db->query("SELECT durum1 FROM icecek");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum1 = $result['durum1'];

// Veritabanından durum verisini çek
$query = $db->query("SELECT durum2 FROM icecek");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum2 = $result['durum2'];



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
        <title>Cargo Range - <?=$ayar['site_title']?></title>




        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

   
        <link href="assets/css/main.min.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">

       
    </head>
    <body>

    <style>
      .card-title{
        margin-bottom:0 !important;
      }

      

      
    </style>
  

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
                                    <h2 class="">Cargo Range</h2>
                                    <h6 class="card-title" style="color:red">Important Notice !!!</h6>
                                    <h7 class="card-2" style="color:red">(Read before filling in)</h7>
                                    <p class="card-description" style="color:red; padding-top:0.5cm;">The "Price Range 1 for Shipping Fee" and "Free Cargo Price Limit" must be filled in.If you want to give more detailed shipping fee ranges, you can use the other price ranges by opening them from the buttons above them. You can close the ones you do not need when you no longer need them.</p>
                                    <p class="card-description" style="color:red">(Please do not leave a price gap when determining the shipping price ranges up to the "Free Cargo Price Limit", otherwise orders placed within the range that you are not included in the fee will be given with $0 shipping.)</p>
                                   
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
								
<h6>Free Cargo Price Limit(Subtotals that exceed this limit will have free cargo)</h6>
                                    <div class="form-group form-floating mb-3 col-3  dolar-isareti1">
                                        <input type="text" class="form-control" id="floatingInput" name="adi"  value="<?=$guncelle['adi']?>">
                                     
                                      </div>

                 

<h3 style="color:rgb(207, 0, 0)">Price Range 1 for Shipping Fee</h3>
<div class="d-flex">

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Bottom Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi1" value="<?=$guncelle['yazi1']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Top Price</h7>
        <input type="text" class="form-control " id="floatingInput" name="yazi2" value="<?=$guncelle['yazi2']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Cargo Fee for the Range</h7>
        <input type="text" class="form-control" id="floatingInput" name="onaciklama" value="<?=$guncelle['onaciklama']?>">
    </div>
</div>




<div class="togdiv d-flex">

<h3>Price Range 2 for Shipping Fee (Optional)</h3>
<div class="toggle" style="margin-left:0.5cm; margin-top:3px">
  <input name="durum" type="checkbox" id="btn">
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>

</div>
<div class="d-flex">

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Bottom Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi3" value="<?=$guncelle['yazi3']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Top Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi4" value="<?=$guncelle['yazi4']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Cargo Fee for the Range</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi5" value="<?=$guncelle['yazi5']?>">
    </div>
</div>

<div class="togdiv d-flex">

<h3>Price Range 2 for Shipping Fee (Optional)</h3>
<div class="toggle" style="margin-left:0.5cm; margin-top:3px">
  <input name="durum1" type="checkbox" id="btn1">
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>

</div>
<div class="d-flex">

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Bottom Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi6" value="<?=$guncelle['yazi6']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Top Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi7" value="<?=$guncelle['yazi7']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Cargo Fee for the Range</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi8" value="<?=$guncelle['yazi8']?>">
    </div>
</div>

<div class="togdiv d-flex">

<h3>Price Range 2 for Shipping Fee (Optional)</h3>
<div class="toggle" style="margin-left:0.5cm; margin-top:3px">
  <input name="durum2" type="checkbox" id="btn2">
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>

</div>
<div class="d-flex">

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Bottom Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi9" value="<?=$guncelle['yazi9']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Top Price</h7>
        <input type="text" class="form-control" id="floatingInput" name="yazi10" value="<?=$guncelle['yazi10']?>">
    </div>

    <div class="form-group form-floating mb-3 col-2 dolar-isareti">
        <h7>Cargo Fee for the Range</h7>
        <input type="text" class="form-control" id="floatingInput" name="kategori" value="<?=$guncelle['kategori']?>">
    </div>
</div>

                                      
                                      
									
                                      
										


<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum = "<?php echo $durum; ?>"; 

  var checkbox = document.getElementById("btn");
  if (durum === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script>   

<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum1 = "<?php echo $durum1; ?>"; 

  var checkbox = document.getElementById("btn1");
  if (durum1 === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script> 

<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum2 = "<?php echo $durum2; ?>"; 

  var checkbox = document.getElementById("btn2");
  if (durum2 === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script> 
                                      
                                    <!--
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Logo</label>
                                        <input class="form-control" type="file" name="logo" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['']?>" width="100">
                                      </div>
-->
									
                                     
                                      
                                        <div class="mb-3">
                                 
                                           <input type="submit" name="kaydet" class="btn btn-primary" value="Kaydet">
                                      </div>
                                      </div>
                                        
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  
                    
                    
                   
                    
                    


                </div>
                                  
                </div>
              
            </div>
         <script src="ckeditor-2/ckeditor.js"></script>
        <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        
        
	
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>