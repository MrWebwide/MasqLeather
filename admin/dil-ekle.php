<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");



ob_start();
session_start();
oturumkontrolana();


$title = $_POST['title'];
$kodu = $_POST['kodu'];
$height = $_POST['height'];
$width = $_POST['width'];
$alt = $_POST['alt'];


$id = $_GET['id'];



if($_POST['kaydet'] and $_GET['islem']==''){
	
	
	
$klasord="../resimler/";
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
	
      
	  
	  
	  
	 $simdi = $db->prepare("insert into dil set title=:title,kodu=:kodu,resim=:resim,height=:height,width=:width,alt=:alt");
	$ekle = $simdi->execute(array("title"=>$title,"kodu"=>$kodu,"resim"=>$resim,"height"=>$height,"width"=>$width,"alt"=>$alt));
	if($ekle){
		
		
		
		  
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Dil Başarıyla Eklendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}

if($_POST['kaydet'] and $_GET['islem']=='duzenle'){
	
		
		
		
		
			$klasor="../resimler/";
	
	$resim_tmp = $_FILES['resim']['tmp_name'];
	
	if(empty($resim_tmp))
	{
		$duzenlenecek_id = $_GET['id'];
		$ayar_kaydi = $db->query("SELECT * FROM bolge_kategori WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim = $ayar_kaydi['resim'];
	}
	else
	{
		if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png"|| $_FILES["resim"]["type"] =="image/jpg"|| $_FILES["resim"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM bolge_kategori WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim']!="resim-yok")
			{
			  unlink("../resimler/".$ayar_kaydi['resim']);	  
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
	
		

	

		
		
		
	 $simdi1 = $db->prepare("update dil set title=:title,kodu=:kodu,resim=:resim,height=:height,width=:width,alt=:alt where id=:id");
	$ekle1 = $simdi1->execute(array("title"=>$title,"kodu"=>$kodu,"resim"=>$resim,"height"=>$height,"width"=>$width,"alt"=>$alt,"id"=>$id));
	if($ekle1){
		
		
		
		
		
		
		
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Dil Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
	
	
}





if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from dil where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <link rel="icon" type="image/png" href="../resimler/<?=$ayar['favicon']?>">
        <title>Dil Ekle | <?=$ayar['site_title']?></title>

        


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
                                    <h5 class="card-title">Dil  Ekle</h5>
                                      <a href="dil-listele.php"  class="btn btn-primary m-b-md">Dil Listele</a>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                   
                                      
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="title" placeholder="Dil Adı" value="<?=$guncelle['title']?>">
                                        <label for="floatingInput">Dil Adı</label>
                                      </div>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="kodu" placeholder="Dil Kodu" value="<?=$guncelle['kodu']?>">
                                        <label for="floatingInput">Dil Kodu</label>
                                      </div>
                                      
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Dil Resmi</label>
                                        <input class="form-control" type="file" name="resim" id="formFile">
                                        
                                         <img src="../resimler/<?=$guncelle['resim']?>" width="200">
                                      </div>
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="height" placeholder="Dil Resim Yükseklik" value="<?=$guncelle['height']?>">
                                        <label for="floatingInput">Dil Resim Yükseklik</label>
                                      </div>
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="width" placeholder="Dil Resim En" value="<?=$guncelle['width']?>">
                                        <label for="floatingInput">Dil Resim En</label>
                                      </div>
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="alt" placeholder="Dil Alt Etiketi" value="<?=$guncelle['alt']?>">
                                        <label for="floatingInput">Dil Alt Etiketi</label>
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