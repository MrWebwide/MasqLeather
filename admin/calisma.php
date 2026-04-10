<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();



if($_POST['kaydet'] ){

$adi = $_POST['adi'];
$aciklama = $_POST['aciklama'];
$yazi1 = $_POST['yazi1'];
$aciklama1 = $_POST['aciklama1'];
$yazi2 = $_POST['yazi2'];
$aciklama2 = $_POST['aciklama2'];
$yazi3 = $_POST['yazi3'];
$aciklama3 = $_POST['aciklama3'];
$yazi4 = $_POST['yazi4'];
$aciklama4 = $_POST['aciklama4'];


$id = 1;

	
$klasor="../resimler/";
	
	$resim_tmp = $_FILES['logo']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$logo = $ayar_kaydi['logo'];
	}
	else
	{
		if ($_FILES["logo"]["type"] =="image/gif" || $_FILES["logo"]["type"] =="image/png"|| $_FILES["logo"]["type"] =="image/jpg"|| $_FILES["logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
	
	
	$resim_tmp1 = $_FILES['footer_logo']['tmp_name'];
	
	if(empty($resim_tmp1))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$footer_logo = $ayar_kaydi['footer_logo'];
	}
	else
	{
		if ($_FILES["footer_logo"]["type"] =="image/gif" || $_FILES["footer_logo"]["type"] =="image/png"|| $_FILES["footer_logo"]["type"] =="image/jpg"|| $_FILES["footer_logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
	$resim_tmp2 = $_FILES['resim3']['tmp_name'];
	
	if(empty($resim_tmp2))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim3 = $ayar_kaydi['resim3'];
	}
	else
	{
		if ($_FILES["resim3"]["type"] =="image/gif" || $_FILES["resim3"]["type"] =="image/png"|| $_FILES["resim3"]["type"] =="image/jpg"|| $_FILES["resim3"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim3']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim3']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim3 = $random."-".$seo.".".substr($_FILES['resim3']['name'], -3);
			
			move_uploaded_file($_FILES['resim3']['tmp_name'],$klasor."/".$resim3);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	
	
    	$resim_tmp3 = $_FILES['resim4']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim4 = $ayar_kaydi['resim4'];
	}
	else
	{
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM calisma WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim4']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim4']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim4 = $random."-".$seo.".".substr($_FILES['resim4']['name'], -3);
			
			move_uploaded_file($_FILES['resim4']['tmp_name'],$klasor."/".$resim4);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 
	
      
	  
	  
	  
	 $simdi = $db->prepare("update  calisma set adi=:adi,aciklama=:aciklama,yazi1=:yazi1,aciklama1=:aciklama1,logo=:logo,footer_logo=:footer_logo,resim1=:resim1,yazi2=:yazi2,aciklama2=:aciklama2,resim2=:resim2,yazi3=:yazi3,aciklama3=:aciklama3,resim3=:resim3,
	 yazi4=:yazi4,aciklama4=:aciklama4,resim4=:resim4");
	$ekle = $simdi->execute(array("adi"=>$adi,"aciklama"=>$aciklama,"yazi1"=>$yazi1,"aciklama1"=>$aciklama1,"logo"=>$logo,"footer_logo"=>$footer_logo,"resim1"=>$resim1,"yazi2"=>$yazi2,"aciklama2"=>$aciklama2,"resim2"=>$resim2,"yazi3"=>$yazi3,"aciklama3"=>$aciklama3,"resim3"=>$resim3,
	"yazi4"=>$yazi4,"aciklama4"=>$aciklama4,"resim4"=>$resim4));
	if($ekle){
		
	
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ekstra Alan  Başarıyla Güncellendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}
	$guncelle = $db->query("select * from calisma where id='1'")->fetch(PDO::FETCH_ASSOC);
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
        <title>Ekstra Alan | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Footer Üstü </h5>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                      <label>Adı</label><br> 
                                    <div class="mb-3">
                                      <textarea  class="ckeditor" name="adi"  rows="2"><?=$guncelle['adi']?></textarea>
                                    </div>
                                      <label>Açıklama</label><br>
                                    <div class="mb-3">
                                      <textarea  class="ckeditor" name="aciklama"  rows="2"><?=$guncelle['aciklama']?></textarea>
                                    </div>
                                      
                                    <div class="mb-3">
                                     <label for="formFile" class="form-label">Resim</label>
                                     <input class="form-control" type="file" name="resim3" id="formFile">
                                     <img src="../resimler/<?=$guncelle['resim3']?>" width="200">
                                    </div>
                                      
                                      
                                      
                                      
                                      <hr>
                                      <h4>Sayılarla Biz</h4>
                                      <hr>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="Yazı 1" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput">Yazı 1</label>
                                      </div>
                                      
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="aciklama1" placeholder="Sayı 1" value="<?=$guncelle['aciklama1']?>">
                                        <label for="floatingInput">Sayı 1</label>
                                      </div>
                                      
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Yazı 2" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">Yazı 2</label>
                                      </div>
                                      
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="aciklama2" placeholder="Sayı 2" value="<?=$guncelle['aciklama2']?>">
                                        <label for="floatingInput">Sayı 2</label>
                                      </div>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi3" placeholder="Yazı 3" value="<?=$guncelle['yazi3']?>">
                                        <label for="floatingInput">Yazı 3</label>
                                      </div>
                                      
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="aciklama3" placeholder="Sayı 3" value="<?=$guncelle['aciklama3']?>">
                                        <label for="floatingInput">Sayı 3</label>
                                      </div>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Yazı 4" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Yazı 4</label>
                                      </div>
                                      
                                     <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="aciklama4" placeholder="Sayı 4" value="<?=$guncelle['aciklama4']?>">
                                        <label for="floatingInput">Sayı 4</label>
                                      </div>
                                      
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