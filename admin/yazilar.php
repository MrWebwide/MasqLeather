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
$yazi11 = $_POST['yazi11'];
$yazi12 = $_POST['yazi12'];
$yazi13 = $_POST['yazi13'];

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
	  
	  
	 $simdi = $db->prepare("update  yazilar set hizmetadi=:hizmetadi,hizmetyazi=:hizmetyazi,yorumadi=:yorumadi,yorumyazi=:yorumyazi,urunadi=:urunadi,urunyazi=:urunyazi,sssadi=:sssadi,sssyazi=:sssyazi,iletisimadi=:iletisimadi,iletisimyazi=:iletisimyazi,blogadi=:blogadi,blogyazi=:blogyazi,hizmetvideoadi=:hizmetvideoadi,hizmetvideoyazi=:hizmetvideoyazi,formadi=:formadi,ekipadi=:ekipadi,yazi1=:yazi1,yazi2=:yazi2,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,yazi11=:yazi11,yazi12=:yazi12,yazi13=:yazi13");
	$ekle = $simdi->execute(array("hizmetadi"=>$hizmetadi,"hizmetyazi"=>$hizmetyazi,"yorumadi"=>$yorumadi,"yorumyazi"=>$yorumyazi,"urunadi"=>$urunadi,"urunyazi"=>$urunyazi,"sssadi"=>$sssadi,"sssyazi"=>$sssyazi,"iletisimadi"=>$iletisimadi,"iletisimyazi"=>$iletisimyazi,"blogadi"=>$blogadi,"blogyazi"=>$blogyazi,"hizmetvideoadi"=>$hizmetvideoadi,"hizmetvideoyazi"=>$hizmetvideoyazi,"formadi"=>$formadi,"ekipadi"=>$ekipadi,"yazi1"=>$yazi1,"yazi2"=>$yazi2,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"yazi11"=>$yazi11,"yazi12"=>$yazi12,"yazi13"=>$yazi13));
	if($ekle){
		
	
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Yazılar Başarıyla Güncellendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}







	
	$guncelle = $db->query("select * from yazilar where id='1'")->fetch(PDO::FETCH_ASSOC);





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
                                        <!--   
                                    <h5>Footer Üstü</h5>    
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi9" placeholder="Button Name" value="<?=$guncelle['yazi9']?>">
                                        <label for="floatingInput">Button Name</label>
                                      </div>
                                   
                                   
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="ekipadi" placeholder="Buton Linki" value="<?=$guncelle['ekipadi']?>">
                                        <label for="floatingInput">Buton Linki</label>
                                      </div>
                                 
                                       <div class="mb-3">
                                 
                                 <textarea  class="ckeditor" name="hizmetyazi"  rows="10"><?=$guncelle['hizmetyazi']?></textarea>
                        </div>
                                 -->            
                                        
                                 <h5>SEO AREA (Main Page)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="blogadi" placeholder="Title" value="<?=$guncelle['blogadi']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="hizmetadi" placeholder="Descriptions" value="<?=$guncelle['hizmetadi']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="sssyazi" placeholder="Keywords" value="<?=$guncelle['sssyazi']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Bag & Purses)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="sssadi" placeholder="Title" value="<?=$guncelle['sssadi']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="urunyazi" placeholder="Descriptions" value="<?=$guncelle['urunyazi']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="ekipadi" placeholder="Keywords" value="<?=$guncelle['ekipadi']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Accessories)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi1" placeholder="Title" value="<?=$guncelle['yazi1']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="blogyazi" placeholder="Descriptions" value="<?=$guncelle['blogyazi']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi3" placeholder="Keywords" value="<?=$guncelle['yazi3']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>


<h5>SEO AREA (Masq-Leather - Blog)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi2" placeholder="Title" value="<?=$guncelle['yazi2']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="hizmetvideoyazi" placeholder="Descriptions" value="<?=$guncelle['hizmetvideoyazi']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yorumyazi" placeholder="Keywords" value="<?=$guncelle['yorumyazi']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Main Page - 2)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="urunadi" placeholder="Title" value="<?=$guncelle['urunadi']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi3" placeholder="Descriptions" value="<?=$guncelle['yazi3']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi4" placeholder="Keywords" value="<?=$guncelle['yazi4']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Homedecor)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi5" placeholder="Title" value="<?=$guncelle['yazi5']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi6" placeholder="Descriptions" value="<?=$guncelle['yazi6']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi7" placeholder="Keywords" value="<?=$guncelle['yazi7']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Jewelry)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi8" placeholder="Title" value="<?=$guncelle['yazi8']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi10" placeholder="Descriptions" value="<?=$guncelle['yazi10']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="formadi" placeholder="Keywords" value="<?=$guncelle['formadi']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

<h5>SEO AREA (Mercantile - Blog)</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi11" placeholder="Title" value="<?=$guncelle['yazi11']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi12" placeholder="Descriptions" value="<?=$guncelle['yazi12']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi13" placeholder="Keywords" value="<?=$guncelle['yazi13']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>
             
                             
                             

                                       
                                   
                                   
                                      
                                           

                                 

                                      
                                      <!--  
                                      
                                   
                                   
                                     
                                         
                                      
                                  
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