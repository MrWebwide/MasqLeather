<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();



$adi = $_POST['adi'];
$sira=$_POST['sira'];
$aciklama = $_POST['aciklama'];
$onaciklama = $_POST['onaciklama'];
$durum = $_POST['durum'];
$kategori = $_POST['kategori'];
$yazi2 = $_POST['yazi2'];
$yazi1 = $_POST['yazi1'];
$yazi3 = $_POST['yazi3'];
$yazi4 = $_POST['yazi4'];
$yazi5 = $_POST['yazi5'];
$yazi6 = $_POST['yazi6'];
$yazi7 = $_POST['yazi7'];
$yazi8 = $_POST['yazi8'];
$yazi9 = $_POST['yazi9'];
$yazi10 = $_POST['yazi10'];
$yazi11= $_POST['yazi11'];
$yazi12 = $_POST['yazi12'];
$yazi13= $_POST['yazi13'];
$yazi15= $_POST['yazi15'];




function seflink($string){
$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
$string = strtolower(str_replace($find, $replace, $string));
$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
$string = trim(preg_replace('/\s+/', ' ', $string));
$string = str_replace(' ', '-', $string);
return $string;
}

$seo= seflink($adi);


$tur = "sayfalar";

$id = $_GET['id'];






	  
 




if($_POST['kaydet'] and $_GET['islem']==''){
	
	
	
$klasord="resimler/";
	$resim_tmpd = $_FILES['resim']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png"|| $_FILES["resim"]["type"] =="image/jpg"|| $_FILES["resim"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim = $random."-".$seo.".".substr($_FILES['resim']['name'], -3);
			
			move_uploaded_file($_FILES['resim']['tmp_name'],$klasord."/".$resim);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	$resim_tmpd = $_FILES['resim1']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim1 = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png"|| $_FILES["resim1"]["type"] =="image/jpg"|| $_FILES["resim1"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim1 = $random."-".$seo.".".substr($_FILES['resim1']['name'], -3);
			
			move_uploaded_file($_FILES['resim1']['tmp_name'],$klasord."/".$resim1);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}


	$resim_tmpd = $_FILES['resim2']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim2 = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim2"]["type"] =="image/gif" || $_FILES["resim2"]["type"] =="image/png"|| $_FILES["resim2"]["type"] =="image/jpg"|| $_FILES["resim2"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim2 = $random."-".$seo.".".substr($_FILES['resim2']['name'], -3);
			
			move_uploaded_file($_FILES['resim2']['tmp_name'],$klasord."/".$resim2);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	$resim_tmpd = $_FILES['resim3']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim3 = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim3"]["type"] =="image/gif" || $_FILES["resim3"]["type"] =="image/png"|| $_FILES["resim3"]["type"] =="image/jpg"|| $_FILES["resim3"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim3 = $random."-".$seo.".".substr($_FILES['resim3']['name'], -3);
			
			move_uploaded_file($_FILES['resim3']['tmp_name'],$klasord."/".$resim3);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	$resim_tmpd = $_FILES['resim4']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim4 = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim4 = $random."-".$seo.".".substr($_FILES['resim4']['name'], -3);
			
			move_uploaded_file($_FILES['resim4']['tmp_name'],$klasord."/".$resim4);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	$resim_tmpd = $_FILES['resim5']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$resim5 = "resim-yok";
	}
	else
	{
		
		if ($_FILES["resim5"]["type"] =="image/gif" || $_FILES["resim5"]["type"] =="image/png"|| $_FILES["resim5"]["type"] =="image/jpg"|| $_FILES["resim5"]["type"] =="image/jpeg") 
		{
			$random = rand(0,999);
			
			$resim5 = $random."-".$seo.".".substr($_FILES['resim5']['name'], -3);
			
			move_uploaded_file($_FILES['resim5']['tmp_name'],$klasord."/".$resim5);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}
	
      
	  
	  
	  
	 $simdi = $db->prepare("insert into sayfalar set adi=:adi,sira=:sira,resim=:resim,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,aciklama=:aciklama,seo=:seo,tur=:tur,yazi2=:yazi2,yazi1=:yazi1,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,yazi11=:yazi11,yazi12=:yazi12,yazi13=:yazi13,yazi14=:yazi14,yazi15=:yazi15,resim1=:resim1,resim2=:resim2,resim3=:resim3,resim4=:resim4,resim5=:resim5,eklenme_tarihi=:eklenme_tarihi");
	$ekle = $simdi->execute(array("adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"kategori"=>$kategori,"aciklama"=>$aciklama,"seo"=>$seo,"tur"=>$tur,"onaciklama"=>$onaciklama,"durum"=>$durum,"yazi2"=>$yazi2,"yazi1"=>$yazi1,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"yazi11"=>$yazi11,"yazi12"=>$yazi12,"yazi13"=>$yazi13,"yazi14"=>$yazi14,"yazi15"=>$yazi15,"resim1"=>$resim1,"resim2"=>$resim2,"resim3"=>$resim3,"resim4"=>$resim4,"resim5"=>$resim5,"eklenme_tarihi"=>$tarih));
	if($ekle){
		
		
		
		  $sonid=$db->query("select * from sayfalar order by id desc")->fetch(PDO::FETCH_ASSOC);
				
$yeni =$sonid['id'];
    if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
    		$islem = $db->prepare("INSERT INTO urun_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($yeni,$img,$tur));
    	}}
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Sayfa  Başarıyla Eklendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}

if($_POST['kaydet'] and $_GET['islem']=='duzenle'){
	
		
		
		
		
		
			$klasor="resimler/";
	
	$resim_tmp = $_FILES['resim']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim = $ayar_kaydi['resim'];
	}
	else
	{
		if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png"|| $_FILES["resim"]["type"] =="image/jpg"|| $_FILES["resim"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim']);	  
			}
			
			$random = rand(0,999);
			
			$resim = $random."-".$adii.".".substr($_FILES['resim']['name'], -3);
			
			move_uploaded_file($_FILES['resim']['tmp_name'],$klasor."/".$resim);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	$resim_tmp = $_FILES['resim1']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim1 = $ayar_kaydi['resim1'];
	}
	else
	{
		if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png"|| $_FILES["resim1"]["type"] =="image/jpg"|| $_FILES["resim1"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim1']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim1']);	  
			}
			
			$random = rand(0,999);
			
			$resim1 = $random."-".$adii.".".substr($_FILES['resim1']['name'], -3);
			
			move_uploaded_file($_FILES['resim1']['tmp_name'],$klasor."/".$resim1);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	$resim_tmp = $_FILES['resim2']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim2 = $ayar_kaydi['resim2'];
	}
	else
	{
		if ($_FILES["resim2"]["type"] =="image/gif" || $_FILES["resim2"]["type"] =="image/png"|| $_FILES["resim2"]["type"] =="image/jpg"|| $_FILES["resim2"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim2']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim2']);	  
			}
			
			$random = rand(0,999);
			
			$resim2 = $random."-".$adii.".".substr($_FILES['resim2']['name'], -3);
			
			move_uploaded_file($_FILES['resim2']['tmp_name'],$klasor."/".$resim2);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	$resim_tmp = $_FILES['resim3']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim3 = $ayar_kaydi['resim3'];
	}
	else
	{
		if ($_FILES["resim3"]["type"] =="image/gif" || $_FILES["resim3"]["type"] =="image/png"|| $_FILES["resim3"]["type"] =="image/jpg"|| $_FILES["resim3"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim3']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim3']);	  
			}
			
			$random = rand(0,999);
			
			$resim3 = $random."-".$adii.".".substr($_FILES['resim3']['name'], -3);
			
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

	$resim_tmp = $_FILES['resim4']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim4 = $ayar_kaydi['resim4'];
	}
	else
	{
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim4']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim4']);	  
			}
			
			$random = rand(0,999);
			
			$resim4 = $random."-".$adii.".".substr($_FILES['resim4']['name'], -3);
			
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

	$resim_tmp = $_FILES['resim5']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim5 = $ayar_kaydi['resim5'];
	}
	else
	{
		if ($_FILES["resim5"]["type"] =="image/gif" || $_FILES["resim5"]["type"] =="image/png"|| $_FILES["resim5"]["type"] =="image/jpg"|| $_FILES["resim5"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sayfalar WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim5']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim5']);	  
			}
			
			$random = rand(0,999);
			
			$resim5 = $random."-".$adii.".".substr($_FILES['resim5']['name'], -3);
			
			move_uploaded_file($_FILES['resim5']['tmp_name'],$klasor."/".$resim5);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	}

	
	
		
	
	
	$deleteee = $db->exec("DELETE FROM urun_img WHERE urun_id = '$id' ");
        
	if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
			
	
    		$islem = $db->prepare("INSERT INTO urun_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($id,$img,$tur));
    	}
    }
	

		
		
		
	 $simdi1 = $db->prepare("update sayfalar set adi=:adi,sira=:sira,resim=:resim,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,aciklama=:aciklama,seo=:seo,yazi2=:yazi2,yazi1=:yazi1,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,yazi11=:yazi11,yazi12=:yazi12,yazi13=:yazi13,yazi14=:yazi14,yazi15=:yazi15,resim1=:resim1,resim2=:resim2,resim3=:resim3,resim4=:resim4,resim5=:resim5,tur=:tur,guncelleme_tarihi=:guncelleme_tarihi where id=:id");
	$ekle1 = $simdi1->execute(array("adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"kategori"=>$kategori,"aciklama"=>$aciklama,"seo"=>$seo,"yazi2"=>$yazi2,"yazi1"=>$yazi1,"tur"=>$tur,"onaciklama"=>$onaciklama,"durum"=>$durum,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"yazi11"=>$yazi11,"yazi12"=>$yazi12,"yazi13"=>$yazi13,"yazi14"=>$yazi14,"yazi15"=>$yazi15,"resim1"=>$resim1,"resim2"=>$resim2,"resim3"=>$resim3,"resim4"=>$resim4,"resim5"=>$resim5,"guncelleme_tarihi"=>$tarih,"id"=>$id));
	if($ekle1){
		
		
		
		
		
		
		
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Sayfa Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
	
	
}





if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from sayfalar where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <link rel="icon" type="image/png" href="/resimler/<?=$ayar['favicon']?>">
        <title>Sayfa Ekle - <?=$ayar['site_title']?></title>



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
                                <div class="card-body table-responsive">
                                    <h5 class="card-title">Sayfa  Ekle</h5>
                                    <a href="sayfa-listele.php"  class="btn btn-primary m-b-md">Sayfa Listele</a>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sira" placeholder="Sayfa Sırası" value="<?=$guncelle['sira']?>">
                                        <label for="floatingInput">Sayfa sırası</label>
                                      </div>
                                      
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Sayfa Adı" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Sayfa Adı</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Alt Başlık" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">Başlık</label>
                                      </div>

									  
									  <div class="mb-3">
                                 
								 <textarea  class="ckeditor" name="aciklama"  rows="10"><?=$guncelle['aciklama']?></textarea>
						</div>

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Sayfa Resmi</label>
                                        <input class="form-control" type="file" name="resim" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim']?>" width="200">
                                      </div>

									
						
						
						
									
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi3" placeholder="Alt Başlık" value="<?=$guncelle['yazi3']?>">
                                        <label for="floatingInput">Başlık</label>
                                      </div>

									  <div class="mb-3">
                                 
								 <textarea  class="ckeditor" name="yazi6"  rows="10"><?=$guncelle['yazi6']?></textarea>
						</div>
									
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Kişinin Resmi</label>
                                        <input class="form-control" type="file" name="resim1" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim1']?>" width="200">
                                      </div>

									
                                   
									  <h5>Hakkımız Banner Yazı</h5>
									 
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi5" placeholder="Başlık" value="<?=$guncelle['yazi5']?>">
                                        <label for="floatingInput">Başlık</label>
                                      </div>

									
									
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi7" placeholder="Yazı" value="<?=$guncelle['yazi7']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>
									
								

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Resim</label>
                                        <input class="form-control" type="file" name="resim2" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim2']?>" width="200">
                                      </div>
										<!--
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi15" placeholder="Alt Başlık" value="<?=$guncelle['yazi15']?>">
                                        <label for="floatingInput"> Alt Başlık</label>
                                      </div>
									
									<div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder=" Başlık" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput"> Başlık</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Yazı" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>
									
									 

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi8" placeholder=" Başlık" value="<?=$guncelle['yazi8']?>">
                                        <label for="floatingInput"> Başlık</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi9" placeholder="Yazı" value="<?=$guncelle['yazi9']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>
									
									 

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi10" placeholder=" Başlık" value="<?=$guncelle['yazi10']?>">
                                        <label for="floatingInput"> Başlık</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi11" placeholder="Yazı" value="<?=$guncelle['yazi11']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>
									
									

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi12" placeholder=" Başlık" value="<?=$guncelle['yazi12']?>">
                                        <label for="floatingInput"> Başlık</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi13" placeholder="" value="<?=$guncelle['yazi13']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>
									
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">İcon Resmi</label>
                                        <input class="form-control" type="file" name="resim5" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim5']?>" width="200">
                                      </div>
                                      
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">İcon Resmi</label>
                                        <input class="form-control" type="file" name="resim4" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim4']?>" width="200">
                                      </div>
                                    
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">İcon Resmi</label>
                                        <input class="form-control" type="file" name="resim3" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim3']?>" width="200">
                                      </div>

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">İcon Resmi</label>
                                        <input class="form-control" type="file" name="resim2" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim2']?>" width="200">
                                      </div>
										-->
									  <div class="mb-3">
                                              	<div class="form-check form-switch">
                                       			  <input class="form-check-input" name="durum" type="checkbox" id="flexSwitchCheckChecked" 
                                       			  	<?php 
                                       			  	if($_GET['islem']=='duzenle'){
                                       			  		if($guncelle['durum']=='on'){ ?> checked <?php } }
                                       			  	else if($_GET['islem']==''){	?> checked <?php } ?> >
                                        		  <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                      			</div>
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
    		<script type="text/javascript">
	    $(document).ready(function(){

	      	var date = new Date();
	        var date_time = date.getTime();
	        $('.upload .icon span').uploadifive({
	            'auto'             : true,
	            'queueID'  : 'queue',
	            'fileSizeLimit' : '15360KB',
	            'fileExt'     : '*.jpg;*.jpeg;*.JPG;*.JPEG;*.png;*.PNG;*.svg;*.gif',
	            'width' : 25,
	            'buttonText' : " ",
	            'formData'         : {'timestamp' : date_time,'token' : 'sayim'+date_time+'sayim'},
	            'uploadScript'     : 'assets/uploadfive/uploadifive.php',
	            'removeCompleted' : true,
	            'onUploadComplete' : function(file, data) {
	                if(data == '2'){
	                    alert('Lütfen Geçerli Fortmatta Yükleme Yapınız.');
	                }else if(data == '3'){
	                    alert('Process Başarısız.(Dosya Boyutu İle Alakalı Olabilir.)');
	                }else{
	                    var id = $(this).attr('data-id');
	                    $('input[name="img'+id+'"]').val(data);
	                    $('#url').val('<?php echo $site; ?>resimler/'+data);
	                    $('.uploaddis[data-id="'+id+'"] .yuklendi img').attr('src','../resimler/'+data);
	                    $('.uploaddis[data-id="'+id+'"]').removeClass('aktif');
	                    $('.uploaddis[data-id="'+id+'"]').addClass('pasif');
	                }
	            }
	        });

	        $('.upload1 .icon span').uploadifive({
	            'auto'             : true,
	            'queueID'  : 'queue',
	            'fileSizeLimit' : '15360KB',
	            'fileExt'     : '*.jpg;*.jpeg;*.JPG;*.JPEG;*.png;*.PNG;*.svg;*.gif',
	            'width' : 25,
	            'buttonText' : " ",
	            'formData'         : {'timestamp' : date_time,'token' : 'sayim'+date_time+'sayim'},
	            'uploadScript'     : 'assets/uploadfive/uploadifive.php',
	            'removeCompleted' : true,
	            'onUploadComplete' : function(file, data) {
	                if(data == '2'){
	                    alert('Lütfen Geçerli Fortmatta Yükleme Yapınız.');
	                }else if(data == '3'){
	                    alert('Process Başarısız.(Dosya Boyutu İle Alakalı Olabilir.)');
	                }else{
	                    var say = $('#resimler .col-md-3').length;
	                    $('#resimler').append('\
	                    	<div class="col-md-3" data-resim-dis-id="'+say+'">\
				                    <div class="uploaddis pasif" style="float:left;">\
				        			  <div class="yuklendi">\
				        				  <img src="../resimler/'+data+'" width="100%">\
				        				  <div class="icon" data-resim-sil-id="'+say+'"><span class="fa fa-trash"></span></div>\
				        				  <input type="hidden" name="img[]" value="'+data+'" required="">\
				        			  </div>\
				        			</div>\
				                </div>\
				        ');

	                }
	            }
	        });
	        $(document).on('click','[data-resim-sil-id]', function(){
	        	$('[data-resim-dis-id="'+$(this).attr('data-resim-sil-id')+'"]').remove();
	        });

	        $('.yuklendi .icon').click(function(){
	            var id = $(this).attr('data-id');
	            $('.uploaddis[data-id="'+id+'"]').removeClass('pasif');
	            $('.uploaddis[data-id="'+id+'"]').addClass('aktif');
	            $('input[name="img'+id+'"]').val('');
	            $('.uploaddis[data-id="'+id+'"] .yuklendi img').attr('src','');
	        });
	      });
	    </script>
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>