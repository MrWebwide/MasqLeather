<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();



if($_POST['kaydet'] ){

$adi = $_POST['adi'];
$aciklama = $_POST['aciklama'];
$buton = $_POST['buton'];
$linki = $_POST['linki'];
$resim4 = $_POST['resim4'];
$id = 1;
	
	
	
$klasor="../resimler/";
	

	
    	$resim_tmp3 = $_FILES['resim4']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM kazanc WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim4 = $ayar_kaydi['resim4'];
	}
	else
	{
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM kazanc WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
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
	
      
	  
	  
	 $simdi = $db->prepare("update kazanc set adi=:adi,aciklama=:aciklama,buton=:buton,linki=:linki,resim4=:resim4");
	$ekle = $simdi->execute(array("adi"=>$adi,"aciklama"=>$aciklama,"buton"=>$buton,"linki"=>$linki,"resim4"=>$resim4));
	if($ekle){
		
		$mesaj = "
		  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
       <strong>Alt Banner Alanı Başarıyla Güncellendi!</strong>
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>
		
		";
	}
}







	
	$guncelle = $db->query("select * from kazanc where id='1'")->fetch(PDO::FETCH_ASSOC);





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
        <title>Alt Banner Alanı | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Alt Banner Alanı</h5>
                                    
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                        <form method="post" enctype="multipart/form-data" >
                                        
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Adı" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Adı</label>
                                      </div> 
                                      
                                         <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="aciklama" placeholder="Açıklama" value="<?=$guncelle['aciklama']?>">
                                        <label for="floatingInput">Açıklama</label>
                                      </div> 
                                    
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="buton" placeholder="Buton" value="<?=$guncelle['buton']?>">
                                        <label for="floatingInput">Buton</label>
                                      </div> 
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="linki" placeholder="Linki" value="<?=$guncelle['linki']?>">
                                        <label for="floatingInput">Linki</label>
                                      </div> 
                                      
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Haber Resmi</label>
                                        <input class="form-control" type="file" name="resim4" id="formFile">
                                        
                                         <img src="../resimler/<?=$guncelle['resim4']?>" width="200">
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