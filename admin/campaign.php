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
	$kategori = $_POST['kategori'];
	$yazi1 = $_POST['yazi1'];
	$yazi3 = $_POST['yazi3'];
	$yazi2 = $_POST['yazi2'];
	$yazi4 = $_POST['yazi4'];
	$yazi5 = $_POST['yazi5'];
	$yazi6 = $_POST['yazi6'];
	$yazi7 = $_POST['yazi7'];
	$yazi8 = $_POST['yazi8'];
	$yazi9 = $_POST['yazi9'];
	$yazi10 = $_POST['yazi10'];
	$yazi11 = $_POST['yazi11'];
	$yazi12 = $_POST['yazi12'];
	$yazi13 = $_POST['yazi13'];
	$yazi14 = $_POST['yazi14'];
	$yazi15 = $_POST['yazi15'];
	
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






	$klasor="resimler/";
	
	$resim_tmp = $_FILES['logo']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM campaign WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$logo = $ayar_kaydi['logo'];
	}
	else
	{
		if ($_FILES["logo"]["type"] =="image/gif" || $_FILES["logo"]["type"] =="image/png"|| $_FILES["logo"]["type"] =="image/jpg"|| $_FILES["logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM campaign WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['logo']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['logo']);	  
			}
			
			$random = rand(0,995959999);
			
			$logo = $random."-".$seo.".".substr($_FILES['logo']['name'], -3);
			
			move_uploaded_file($_FILES['logo']['tmp_name'],$klasor."/".$logo);
			
			
		




			
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	

	
	
	

	


	
	
	$ekle  = $db->prepare("update campaign set adi=:adi,sira=:sira,resim=:resim,logo=:logo,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,yazi1=:yazi1,yazi3=:yazi3,yazi2=:yazi2,yazi4=:yazi4 where id=:id");
	
	$simdi = $ekle->execute(array("adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"logo"=>$logo,"kategori"=>$kategori,"durum"=>$durum,"onaciklama"=>$onaciklama,"yazi1"=>$yazi1,"yazi3"=>$yazi3,"yazi2"=>$yazi2,"yazi4"=>$yazi4,"id"=>$id));
	
	if($simdi){
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ayarlar Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
}


$guncelle = $db->query("select * from campaign where id='1'")->fetch(PDO::FETCH_ASSOC);

// Veritabanından durum verisini çek
$query = $db->query("SELECT durum FROM campaign");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum = $result['durum'];


// Veritabanından durum verisini çek
$query = $db->query("SELECT yazi1 FROM campaign");
$result = $query->fetch(PDO::FETCH_ASSOC);
$yazi1 = $result['yazi1'];
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
        <title>Campaign Set-up - <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">Campaign Set-up</h5>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
									<div class="toggle">
  <input name="durum" type="checkbox" id="btn">
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Campaign Title" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Campaign Title</label>
                                      </div>
                                      
                                      
                                         
                                      
									  <h5>Campaign Description</h5>
									
									<div class=" mb-3">
												
												 <textarea class="form-control" name="onaciklama" rows="10" cols="100"><?=$guncelle['onaciklama']?></textarea>
											   
											 </div>
                                      
											 <div class="mb-3">
    <h5>Category Redirect</h5>
    <p>(By default the top category is always shown, you must re-select the category with each edit)</p>
    <select class="form-select"  name="yazi2">
        <option value="bagpurses.php" >Bags & Purses</option>
		<option value="accessories.php" >Accessories</option>
		<option value="homedecor.php" >Home Decor</option>
		<option value="jewelry.php" >Jewelry</option>
    
    </select>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum = "<?php echo $durum; ?>"; // PHP'den JavaScript'e durum verisini aktar

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
  var durum1 = "<?php echo $yazi1; ?>"; // PHP'den JavaScript'e durum verisini aktar

  var checkbox = document.getElementById("btn1");
  if (durum1 === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script>  
                                      
                                    
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Campaign İmage</label>
                                        <input class="form-control" type="file" name="logo" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['logo']?>" width="100">
                                      </div>

                                      <h5>Homepage Top Bar</h5>

                                      <div class="toggle">
  <input name="yazi1" type="checkbox" id="btn1">
  <label for="btn1">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="onaciklama" placeholder="Campaign Title" value="<?=$guncelle['onaciklama']?>">
                                        <label for="floatingInput">Top Bar Text</label>
                                      </div>
                                      
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