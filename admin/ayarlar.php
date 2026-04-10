<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

if($_POST['kaydet']){
	
	
	$site_title = $_POST['site_title'];
	$site_meta = $_POST['site_meta'];
	$site_keyword= $_POST['site_keyword'];
	$site_description = $_POST['site_description'];
	$site_author = $_POST['site_author'];
	$renk = $_POST['renk'];
	$renk2 = $_POST['renk2'];
	$id = 1;
	
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
		$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$logo = $ayar_kaydi['logo'];
	}
	else
	{
		if ($_FILES["logo"]["type"] =="image/gif" || $_FILES["logo"]["type"] =="image/png"|| $_FILES["logo"]["type"] =="image/jpg"|| $_FILES["logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
		$resim_tmp5 = $_FILES['stok']['tmp_name'];
	
	if(empty($resim_tmp5))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$stok = $ayar_kaydi['stok'];
	}
	else
	{
		if ($_FILES["stok"]["type"] =="image/gif" || $_FILES["stok"]["type"] =="image/png"|| $_FILES["stok"]["type"] =="image/jpg"|| $_FILES["stok"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['stok']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['stok']);	  
			}
			
			$random = rand(0,995959999);
			
			$stok = $random."-".$seo.".".substr($_FILES['stok']['name'], -3);
			
			move_uploaded_file($_FILES['stok']['tmp_name'],$klasor."/".$stok);
			
			
		




			
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
		$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$footer_logo = $ayar_kaydi['footer_logo'];
	}
	else
	{
		if ($_FILES["footer_logo"]["type"] =="image/gif" || $_FILES["footer_logo"]["type"] =="image/png"|| $_FILES["footer_logo"]["type"] =="image/jpg"|| $_FILES["footer_logo"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
	
	
$resim_tmp2 = $_FILES['favicon']['tmp_name'];

if (empty($resim_tmp2)) {
    $duzenlenecek_id = 1;
    $ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
    $favicon = $ayar_kaydi['favicon'];
} else {
    $allowed_types = ['image/x-icon', 'image/png', 'image/jpeg'];
    $file_type = $_FILES["favicon"]["type"];
    
    // Dosya türünü kontrol et
    if (in_array($file_type, $allowed_types)) {
        $ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
        if ($ayar_kaydi['favicon'] != "resim-yok") {
            unlink("resimler/" . $ayar_kaydi['favicon']);
        }
        
        $random = rand(0, 995959999);
        $file_info = pathinfo($_FILES['favicon']['name']);
        $extension = $file_info['extension']; // Dosya uzantısını al
        $favicon = $random . "-" . $seo . "." . $extension;
        
        move_uploaded_file($_FILES['favicon']['tmp_name'], $klasor . "/" . $favicon);
    } else {
        $bilgi = '<div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Hata !</strong> Lütfen uygun formattaki bir resim dosyası seçiniz (.jpg, .png, .ico).
                </div>';
    }
}


	$resim_tmp2 = $_FILES['resim1']['tmp_name'];
	
	if(empty($resim_tmp2))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim1 = $ayar_kaydi['resim1'];
	}
	else
	{
		if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png"|| $_FILES["resim1"]["type"] =="image/jpg"|| $_FILES["resim1"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM ayarlar WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
	
	$footer_copyright=$_POST['footer_copyright'];
	
	
	$ekle  = $db->prepare("update ayarlar set stok=:stok,renk2=:renk2,resim1=:resim1,renk=:renk,footer_copyright=:footer_copyright,site_title=:site_title,site_description=:site_description,site_author=:site_author,site_meta=:site_meta,site_keyword=:site_keyword,logo=:logo,favicon=:favicon,footer_logo=:footer_logo where id=:id");
	
	$simdi = $ekle->execute(array("stok"=>$stok,"renk2"=>$renk2,"resim1"=>$resim1,"renk"=>$renk,"footer_copyright"=>$footer_copyright,"site_title"=>$site_title,"site_meta"=>$site_meta,"site_description"=>$site_description,"site_author"=>$site_author,"site_keyword"=>$site_keyword,"logo"=>$logo,"footer_logo"=>$footer_logo,"favicon"=>$favicon,"id"=>$id));
	
	if($simdi){
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ayarlar Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
}


$guncelle = $db->query("select * from ayarlar where id='1'")->fetch(PDO::FETCH_ASSOC);



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
        <title>Ayarlar - <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">Ayarlar</h5>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="site_title" placeholder="Site Başlık" value="<?=$guncelle['site_title']?>">
                                        <label for="floatingInput">Site Title</label>
                                      </div>
                                      
                                      
                                          <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="site_description" placeholder="Site Description" value="<?=$guncelle['site_description']?>">
                                        <label for="floatingInput">Site Description</label>
                                      </div>
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="site_keyword" placeholder="Site keyword" value="<?=$guncelle['site_keyword']?>">
                                        <label for="floatingInput">Site Keyword</label>
                                      </div>
                                      
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="site_meta" placeholder="Site Meta" value="<?=$guncelle['site_meta']?>">
                                        <label for="floatingInput">Site Meta açıklama</label>
                                      </div>
                                      
                                          <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="site_author" placeholder="Site Author" value="<?=$guncelle['site_author']?>">
                                        <label for="floatingInput">Site Author </label>
                                      </div>
                                      
                                      
                                      
                                      
                                    
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Logo</label>
                                        <input class="form-control" type="file" name="logo" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['logo']?>" width="100">
                                      </div>

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Yan Logo</label>
                                        <input class="form-control" type="file" name="resim1" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim1']?>" width="100">
                                      </div>
                                      
                                       <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Footer Logo</label>
                                        <input class="form-control" type="file" name="footer_logo" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['footer_logo']?>" width="100">
                                      </div>
                                      
                                      
                                       <div class="mb-3">
                                        <label for="formFile" class="form-label">Site Favicon</label>
                                        <input class="form-control" type="file" name="favicon" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['favicon']?>" width="100">
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