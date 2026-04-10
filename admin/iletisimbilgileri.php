<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

if($_POST['kaydet']){
	
	$telefon1= $_POST['telefon1'];
	$telefon2=$_POST['telefon2'];
	$adres1= $_POST['adres1'];
	$adres2 = $_POST['adres2'];
	$email1 = $_POST['email1'];
	$email2 = $_POST['email2'];
	$calismasaat =$_POST['calismasaat'];
  $yazi1 = $_POST['yazi1'];
  $yazi2 = $_POST['yazi2'];
	$google_maps=$_POST['google_maps'];
	$id=1;
	
  
  $klasor="resimler/";

  $resim_tmp1 = $_FILES['footer_logo']['tmp_name'];
	
	if(empty($resim_tmp1))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM iletisimbilgileri WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$footer_logo = $ayar_kaydi['footer_logo'];
	}
	else
	{
		if ($_FILES["footer_logo"]["type"] =="image/gif" || $_FILES["footer_logo"]["type"] =="image/png"|| $_FILES["footer_logo"]["type"] =="image/jpg"|| $_FILES["footer_logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM iletisimbilgileri WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['footer_logo']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['footer_logo']);	  
			}
			
			$random = rand(0,995959999);
			
			$footer_logo = $random."-".$seo.".".substr($_FILES['footer_logo']['name'], -3);
			
			move_uploaded_file($_FILES['footer_logo']['tmp_name'],$klasor."/".$footer_logo);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	
  
  $simdi =$db->prepare("update iletisimbilgileri set whatsapp=:whatsapp,calismasaat=:calismasaat,google_maps=:google_maps,telefon1=:telefon1,telefon2=:telefon2,adres1=:adres1,adres2=:adres2,email1=:email1,email2=:email2,yazi1=:yazi1,yazi2=:yazi2,footer_logo=:footer_logo where id=:id");
	$hemen = $simdi->execute(array("whatsapp"=>$_POST['whatsapp'],"calismasaat"=>$_POST['calismasaat'],"google_maps"=>$google_maps,"telefon1"=>$telefon1,"telefon2"=>$telefon2,"adres1"=>$adres1,"adres2"=>$adres2,"email1"=>$email1,"email2"=>$email2,"yazi1"=>$yazi1,"yazi2"=>$yazi2,"footer_logo"=>$footer_logo,"id"=>$id));

}

$i = $db->query("select * from iletisimbilgileri where id='1'")->fetch(PDO::FETCH_ASSOC);
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
        <link rel="icon" type="image/png" href="../resimler/<?=$ayar['favicon']?>">
        <title>İletişim Bilgileri - <?=$ayar['site_title']?></title>


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
                                    <h5 class="card-title">İletişim Bilgileri</h5>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                              
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-map-marker"></i></span>
                                        <input type="text" class="form-control" name="yazi2" placeholder="Adres Başlığı" value="<?=$i['yazi2']?>" aria-label="Telefon 1" aria-describedby="basic-addon1">
                                      </div>
                                      
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-map-marker"></i></span>
                                        <input type="text" class="form-control" name="adres2" placeholder="Adres"  value="<?=$i['adres2']?>" aria-label="Adres 2" aria-describedby="basic-addon1">
                                      </div>
                                      
                                    
                                  
                                  
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="telefon1" placeholder="Telefon Başlığı" value="<?=$i['telefon1']?>" aria-label="Telefon 1" aria-describedby="basic-addon1">
                                      </div>
                                      
                                             <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="telefon2" placeholder="Telefon" aria-label="Telefon 2" value="<?=$i['telefon2']?>"  aria-describedby="basic-addon1">
                                      </div>
                                      
                                    
                                      
                                      
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="email2" placeholder="Telefon"  value="<?=$i['email2']?>" aria-label="Email 2" aria-describedby="basic-addon1">
                                      </div>
                                  
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="yazi1" placeholder="Telefon" value="<?=$i['yazi1']?>"  aria-label="Adres 1" aria-describedby="basic-addon1">
                                      </div>
                                    
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" name="email1" placeholder="E-Mail" value="<?=$i['email1']?>"  aria-label="Adres 1" aria-describedby="basic-addon1">
                                      </div>
                                      
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-map-marker"></i></span>
                                        <input type="text" class="form-control" name="calismasaat" placeholder="Sosyal Başlık"  value="<?=$i['calismasaat']?>" aria-label="Çalışma Saat " aria-describedby="basic-addon1">
                                      </div>
                                   
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" name="adres1" placeholder="Form Butonu" value="<?=$i['adres1']?>"  aria-label="Adres 1" aria-describedby="basic-addon1">
                                      </div>
                                     
                                    
                                    
                                    
                                      <div class="input-group">
                                        <span class="input-group-text">Google Maps</span>
                                        <textarea class="form-control" name="google_maps" aria-label="Google Maps"><?=$i['google_maps']?></textarea>
                                      </div>
                                   <br>
                                      
                                  
                                   
                                       <!--
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Footer Logo</label>
                                        <input class="form-control" type="file" name="footer_logo" id="formFile">
                                        
                                         <img src="resimler/<?=$i['footer_logo']?>" width="100">
                                      </div>
                                          -->   
                                        
                                      
                                      
                                      
                                      <!--
                                      
                                      
                                    
                                      
                                      
                                      
                                      <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="whatsapp" placeholder="Telefon" aria-label="Telefon 2" value="<?=$i['whatsapp']?>"  aria-describedby="basic-addon1">
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