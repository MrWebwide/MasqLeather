<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();



if($_POST['kaydet'] ){

$yorumadi = $_POST['yorumadi'];
$yorumyazi = $_POST['yorumyazi'];
$hizmetadi = $_POST['hizmetadi'];
$hizmetyazi = $_POST['hizmetyazi'];
$sssadi = $_POST['sssadi'];
$sssyazi = $_POST['sssyazi'];
$iletisimadi = $_POST['iletisimadi'];
$iletisimyazi = $_POST['iletisimyazi'];
$blogadi = $_POST['blogadi'];
$blogyazi = $_POST['blogyazi'];
$hizmetvideoadi = $_POST['hizmetvideoadi'];
$hizmetvideoyazi = $_POST['hizmetvideoyazi'];
$urunadi = $_POST['urunadi'];
$urunyazi = $_POST['urunyazi'];
$formadi = $_POST['formadi'];
$ekipadi = $_POST['ekipadi'];
$id = 1;
	
if($_POST['kaydet'] and $_GET['islem']==''){
	
	
	
$klasord="resimler/";
	$resim_tmpd = $_FILES['iletisimadi']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$iletisimadi = "resim-yok";
	}
	else
	{
		
		if ($_FILES["iletisimadi"]["type"] =="image/gif" || $_FILES["iletisimadi"]["type"] =="image/png"|| $_FILES["iletisimadi"]["type"] =="image/jpg"|| $_FILES["iletisimadi"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$iletisimadi = $random."-".$seo.".".substr($_FILES['iletisimadi']['name'], -3);
			
			move_uploaded_file($_FILES['iletisimadi']['tmp_name'],$klasord."/".$iletisimadi);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
}
	  
	  
	 $simdi = $db->prepare("update  contactform set hizmetadi=:hizmetadi,hizmetyazi=:hizmetyazi,yorumadi=:yorumadi,yorumyazi=:yorumyazi,urunadi=:urunadi,urunyazi=:urunyazi,sssadi=:sssadi,sssyazi=:sssyazi,iletisimadi=:iletisimadi,iletisimyazi=:iletisimyazi,blogadi=:blogadi,blogyazi=:blogyazi,hizmetvideoadi=:hizmetvideoadi,hizmetvideoyazi=:hizmetvideoyazi,formadi=:formadi,ekipadi=:ekipadi");
	$ekle = $simdi->execute(array("hizmetadi"=>$hizmetadi,"hizmetyazi"=>$hizmetyazi,"yorumadi"=>$yorumadi,"yorumyazi"=>$yorumyazi,"urunadi"=>$urunadi,"urunyazi"=>$urunyazi,"sssadi"=>$sssadi,"sssyazi"=>$sssyazi,"iletisimadi"=>$iletisimadi,"iletisimyazi"=>$iletisimyazi,"blogadi"=>$blogadi,"blogyazi"=>$blogyazi,"hizmetvideoadi"=>$hizmetvideoadi,"hizmetvideoyazi"=>$hizmetvideoyazi,"formadi"=>$formadi,"ekipadi"=>$ekipadi));
	if($ekle){
		
	
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Yazılar Başarıyla Güncellendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}







	
	$guncelle = $db->query("select * from contactform where id='1'")->fetch(PDO::FETCH_ASSOC);





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
        <title>Yazılar | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Yazılar</h5>
                                    
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                        
                                         <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="hizmetadi" placeholder="İletişim Başlık" value="<?=$guncelle['hizmetadi']?>">
                                        <label for="floatingInput">İletişim Başlık</label>
                                      </div>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="ekipadi" placeholder="Button Name" value="<?=$guncelle['ekipadi']?>">
                                        <label for="floatingInput">Button Name</label>
                                      </div>

                                       <div class="mb-3">
                                 
                                 <textarea  class="ckeditor" name="hizmetyazi"  rows="10"><?=$guncelle['hizmetyazi']?></textarea>
                        </div>
                                        
                                        
                                      <!--
                                         <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yorumadi" placeholder="Yorum Başlık" value="<?=$guncelle['yorumadi']?>">
                                        <label for="floatingInput">İletişim Yazı</label>
                                      </div>
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="blogadi" placeholder="Blog Başlık" value="<?=$guncelle['blogadi']?>">
                                        <label for="floatingInput">Blog Başlık</label>
                                      </div> 
                                      
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="blogyazi" placeholder="Blog Açıklama" value="<?=$guncelle['blogyazi']?>">
                                        <label for="floatingInput">Blog Açıklama</label>
                                      </div> 
                                     
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sssyazi" placeholder="Hakkımızda Başlık" value="<?=$guncelle['sssyazi']?>">
                                        <label for="floatingInput">Hakkımızda Başlık</label>
                                      </div> 
                                       
                                          <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sssadi" placeholder="Hakkımızda Yazı" value="<?=$guncelle['sssadi']?>">
                                        <label for="floatingInput">Hakkımızda Yazı</label>
                                      </div>
                                       
                                        
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="hizmetvideoyazi" placeholder="Galeri Yazı" value="<?=$guncelle['hizmetvideoyazi']?>">
                                        <label for="floatingInput">Galeri Yazı</label>
                                      </div>
                                             
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Sayfa Resmi</label>
                                        <input class="form-control" type="file" name="iletisimadi" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['iletisimadi']?>" width="200">
                                      </div>
                                     
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="iletisimyazi" placeholder="İletişim Yazı" value="<?=$guncelle['iletisimyazi']?>">
                                        <label for="floatingInput">İletişim Yazı</label>
                                      </div>
                                   
                                     
                                             <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="hizmetadi" placeholder="Hizmet Başlık" value="<?=$guncelle['hizmetadi']?>">
                                        <label for="floatingInput">Hizmet Başlık</label>
                                      </div>
                                      
                                             <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="hizmetyazi" placeholder="Hizmet Açıklama" value="<?=$guncelle['hizmetyazi']?>">
                                        <label for="floatingInput">Hizmet Açıklama</label>
                                      </div>
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="urunadi" placeholder="Oda Başlık" value="<?=$guncelle['urunadi']?>">
                                        <label for="floatingInput">Oda Başlık</label>
                                      </div>
                                      
                                             <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="urunyazi" placeholder="Oda Açıklama" value="<?=$guncelle['urunyazi']?>">
                                        <label for="floatingInput">Oda Açıklama</label>
                                      </div>
                                        
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="ekipadi" placeholder="Ekip Başlık" value="<?=$guncelle['ekipadi']?>">
                                        <label for="floatingInput">Ekip Başlık</label>
                                      </div>
                                      
                                         <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yorumyazi" placeholder="Ekip Açıklama" value="<?=$guncelle['yorumyazi']?>">
                                        <label for="floatingInput">Ekip Açıklama</label>
                                      </div>
                                      
                                      
                                  
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="formadi" placeholder="Form Başlık" value="<?=$guncelle['formadi']?>">
                                        <label for="floatingInput">Form Başlık</label>
                                      </div> -->
                                   
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
        
        
	<link rel="stylesheet" href="assets/uploadfive/uploadifive.css" type="text/css">
    	<script src="assets/uploadfive/jquery.uploadifive.min.js" type="text/javascript"></script>
    	
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>