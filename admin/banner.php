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
$sayi1 = $_POST['sayi1'];
$icon1 = $_POST['icon1'];
$yazi2 = $_POST['yazi2'];
$sayi2 = $_POST['sayi2'];
$icon2 = $_POST['icon2'];
$yazi3 = $_POST['yazi3'];
$sayi3 = $_POST['sayi3'];
$icon3 = $_POST['icon3'];
$yazi4 = $_POST['yazi4'];
$sayi4 = $_POST['sayi4'];
$icon4 = $_POST['icon4'];
$resim4 = $_POST['resim4'];
$resim3 = $_POST['resim3'];
$resim2 = $_POST['resim2'];
$resim1 = $_POST['resim1'];
$resim5 = $_POST['resim5'];
$resim6 = $_POST['resim6'];
$resim7 = $_POST['resim7'];
$resim8 = $_POST['resim8'];
$yazi6 = $_POST['yazi6'];
$yazi7 = $_POST['yazi7'];
$yazi8 = $_POST['yazi8'];
$yazi9 = $_POST['yazi9'];
$yazi10 = $_POST['yazi10'];


$id = 1;
	
	
	
$klasor="resimler/";
	

	
    	$resim_tmp3 = $_FILES['resim4']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim4 = $ayar_kaydi['resim4'];
	}
	else
	{
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
  $resim_tmp3 = $_FILES['resim3']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim3 = $ayar_kaydi['resim3'];
	}
	else
	{
		if ($_FILES["resim3"]["type"] =="image/gif" || $_FILES["resim3"]["type"] =="image/png"|| $_FILES["resim3"]["type"] =="image/jpg"|| $_FILES["resim3"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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

  $resim_tmp3 = $_FILES['resim2']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim2 = $ayar_kaydi['resim2'];
	}
	else
	{
		if ($_FILES["resim2"]["type"] =="image/gif" || $_FILES["resim2"]["type"] =="image/png"|| $_FILES["resim2"]["type"] =="image/jpg"|| $_FILES["resim2"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim2']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim2']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim2 = $random."-".$seo.".".substr($_FILES['resim2']['name'], -3);
			
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

  $resim_tmp3 = $_FILES['resim1']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim1 = $ayar_kaydi['resim1'];
	}
	else
	{
		if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png"|| $_FILES["resim1"]["type"] =="image/jpg"|| $_FILES["resim1"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim1']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim1']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim1 = $random."-".$seo.".".substr($_FILES['resim1']['name'], -3);
			
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

  $resim_tmp3 = $_FILES['resim5']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim5 = $ayar_kaydi['resim5'];
	}
	else
	{
		if ($_FILES["resim5"]["type"] =="image/gif" || $_FILES["resim5"]["type"] =="image/png"|| $_FILES["resim5"]["type"] =="image/jpg"|| $_FILES["resim5"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim5']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim5']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim5 = $random."-".$seo.".".substr($_FILES['resim5']['name'], -3);
			
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

  $resim_tmp3 = $_FILES['resim6']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim6 = $ayar_kaydi['resim6'];
	}
	else
	{
		if ($_FILES["resim6"]["type"] =="image/gif" || $_FILES["resim6"]["type"] =="image/png"|| $_FILES["resim6"]["type"] =="image/jpg"|| $_FILES["resim6"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim6']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim6']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim6 = $random."-".$seo.".".substr($_FILES['resim6']['name'], -3);
			
			move_uploaded_file($_FILES['resim6']['tmp_name'],$klasor."/".$resim6);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 
  $resim_tmp3 = $_FILES['resim7']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim7 = $ayar_kaydi['resim7'];
	}
	else
	{
		if ($_FILES["resim7"]["type"] =="image/gif" || $_FILES["resim7"]["type"] =="image/png"|| $_FILES["resim7"]["type"] =="image/jpg"|| $_FILES["resim7"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim7']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim7']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim7 = $random."-".$seo.".".substr($_FILES['resim7']['name'], -3);
			
			move_uploaded_file($_FILES['resim7']['tmp_name'],$klasor."/".$resim7);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 

  $resim_tmp3 = $_FILES['resim8']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim8 = $ayar_kaydi['resim8'];
	}
	else
	{
		if ($_FILES["resim8"]["type"] =="image/gif" || $_FILES["resim8"]["type"] =="image/png"|| $_FILES["resim8"]["type"] =="image/jpg"|| $_FILES["resim8"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim8']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim8']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim8 = $random."-".$seo.".".substr($_FILES['resim8']['name'], -3);
			
			move_uploaded_file($_FILES['resim8']['tmp_name'],$klasor."/".$resim8);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 

  $resim_tmp3 = $_FILES['icon4']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$icon4 = $ayar_kaydi['icon4'];
	}
	else
	{
		if ($_FILES["icon4"]["type"] =="image/gif" || $_FILES["icon4"]["type"] =="image/png"|| $_FILES["icon4"]["type"] =="image/jpg"|| $_FILES["icon4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM banner WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['icon4']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['icon4']);	  
			}
			
			$random = rand(0,995959999);
			
			$icon4 = $random."-".$seo.".".substr($_FILES['icon4']['name'], -3);
			
			move_uploaded_file($_FILES['icon4']['tmp_name'],$klasor."/".$icon4);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 
	  
	  
	 $simdi = $db->prepare("update banner set yazi1=:yazi1,sayi1=:sayi1,icon1=:icon1,yazi2=:yazi2,sayi2=:sayi2,icon2=:icon2,yazi3=:yazi3,sayi3=:sayi3,icon3=:icon3,yazi4=:yazi4,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,sayi4=:sayi4,icon4=:icon4,resim8=:resim8,resim7=:resim7,resim6=:resim6,resim5=:resim5,resim4=:resim4,resim3=:resim3,resim2=:resim2,resim1=:resim1");
	$ekle = $simdi->execute(array("yazi1"=>$yazi1,"sayi1"=>$sayi1,"icon1"=>$icon1,"yazi2"=>$yazi2,"sayi2"=>$sayi2,"icon2"=>$icon2,"yazi3"=>$yazi3,"sayi3"=>$sayi3,"icon3"=>$icon3,"yazi4"=>$yazi4,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"sayi4"=>$sayi4,"icon4"=>$icon4,"resim8"=>$resim8,"resim7"=>$resim7,"resim6"=>$resim6,"resim5"=>$resim5,"resim4"=>$resim4,"resim3"=>$resim3,"resim2"=>$resim2,"resim1"=>$resim1));
	if($ekle){
		
		$mesaj = "
		  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
       <strong>Sayaç Alanı Başarıyla Güncellendi!</strong>
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>
		
		";
	}
}







	
	$guncelle = $db->query("select * from banner where id='1'")->fetch(PDO::FETCH_ASSOC);





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
        <title>Banner Alanı | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Banner Alanı</h5>
                                    
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                        <form method="post" enctype="multipart/form-data" >
                                        
                                    
                                     
                                     <!--  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> -->
                                      
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi1" placeholder="Hakkımızda Başlık" value="<?=$guncelle['sayi1']?>">
                                        <label for="floatingInput">Hakkımızda Başlık </label>
                                      </div> 
                                      
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi4" placeholder="Yazı" value="<?=$guncelle['sayi4']?>">
                                        <label for="floatingInput"> Yazı</label>
                                      </div> 
                                     
									 
									 
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Hakkımızda Banner</label>
                                        <input class="form-control" type="file" name="resim6" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim6']?>" width="200">
                                      </div>


									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="Rezervasyon Başlık" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput"> Rezervasyon Başlık</label>
                                      </div> 
                                      
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi3" placeholder="Yazı" value="<?=$guncelle['sayi3']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div>  
									
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Rezervasyon  Banner</label>
                                        <input class="form-control" type="file" name="resim4" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim4']?>" width="200">
                                      </div>

                                     
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi3" placeholder=" Menü Başlık" value="<?=$guncelle['yazi3']?>">
                                        <label for="floatingInput"> Menü Başlık</label>
                                      </div> 
									  
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Yazı" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div> 

									 
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Menü  Banner</label>
                                        <input class="form-control" type="file" name="resim3" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim3']?>" width="200">
                                      </div>

									  
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Galeri Başlık" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Galeri Başlık</label>
                                      </div> 
                                       
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Yazı " value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput"> Yazı</label>
                                      </div> 
                                     

                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Galeri Banner</label>
                                        <input class="form-control" type="file" name="resim5" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim5']?>" width="200">
                                      </div>
									
									
									
									 <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon3" placeholder="Blog Başlık" value="<?=$guncelle['icon3']?>">
                                        <label for="floatingInput">Blog Başlık</label>
                                      </div> 

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi6" placeholder="Blog Başlık" value="<?=$guncelle['yazi6']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div> 

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Blog Banner</label>
                                        <input class="form-control" type="file" name="resim8" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim8']?>" width="200">
                                      </div>  
									 
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi7" placeholder="Blog Başlık" value="<?=$guncelle['yazi7']?>">
                                        <label for="floatingInput">Tarif Başlık</label>
                                      </div> 

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi8" placeholder="Yazı" value="<?=$guncelle['yazi8']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div> 
                                      
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Tarif Banner</label>
                                        <input class="form-control" type="file" name="resim1" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim1']?>" width="200">
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi9" placeholder="Blog Başlık" value="<?=$guncelle['yazi9']?>">
                                        <label for="floatingInput">İletişim Başlık</label>
                                      </div> 

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi10" placeholder="Yazı" value="<?=$guncelle['yazi10']?>">
                                        <label for="floatingInput">Yazı</label>
                                      </div> 
									 
                                      
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">İletişim Banner</label>
                                        <input class="form-control" type="file" name="icon4" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['icon4']?>" width="200">
                                      </div>
									
									
                                      
                                     
                                       
                                      <!--  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> -->
                                      
                                       

                                     

									

									 
									
									
                                      
									  

                                              <!--  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> 
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi4" placeholder="Ürünler Başlık" value="<?=$guncelle['sayi4']?>">
                                        <label for="floatingInput">Ürünler Başlık</label>
                                      </div> 
                                      
                                   

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi2" placeholder="Fiyatlar Başlık" value="<?=$guncelle['sayi2']?>">
                                        <label for="floatingInput">Fiyatlar Başlık</label>
                                      </div> 
                                      
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Fiyatlar Banner</label>
                                        <input class="form-control" type="file" name="resim2" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim2']?>" width="200">
                                      </div>
                                     
                                     -->
                                    
                                      
                                    
                                       
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