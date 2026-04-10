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
$sayi4 = $_POST['sayi4'];
$icon4 = $_POST['icon4'];
$resim4 = $_POST['resim4'];
$resim3 = $_POST['resim3'];
$resim2 = $_POST['resim2'];
$resim1 = $_POST['resim1'];
$yazi4 = $_POST['yazi4'];
$yazi5 = $_POST['yazi5'];
$yazi6 = $_POST['yazi6'];
$yazi7 = $_POST['yazi7'];
$yazi8 = $_POST['yazi8'];
$yazi9 = $_POST['yazi9'];


$id = 1;
	
	
	

      
	  
	  
	 $simdi = $db->prepare("update sayac4 set yazi1=:yazi1,sayi1=:sayi1,icon1=:icon1,yazi2=:yazi2,sayi2=:sayi2,icon2=:icon2,yazi3=:yazi3,sayi3=:sayi3,icon3=:icon3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,sayi4=:sayi4,icon4=:icon4,resim4=:resim4,resim3=:resim3,resim2=:resim2,resim1=:resim1");
	$ekle = $simdi->execute(array("yazi1"=>$yazi1,"sayi1"=>$sayi1,"icon1"=>$icon1,"yazi2"=>$yazi2,"sayi2"=>$sayi2,"icon2"=>$icon2,"yazi3"=>$yazi3,"sayi3"=>$sayi3,"icon3"=>$icon3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"sayi4"=>$sayi4,"icon4"=>$icon4,"resim4"=>$resim4,"resim3"=>$resim3,"resim2"=>$resim2,"resim1"=>$resim1));
	if($ekle){
		
		$mesaj = "
		  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
       <strong>Sayaç Alanı Başarıyla Güncellendi!</strong>
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>
		
		";
	}
}







	
	$guncelle = $db->query("select * from sayac4 where id='1'")->fetch(PDO::FETCH_ASSOC);





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
        <title>Header Alanı | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Privacy Section </h5>
                                    
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                        <form method="post" enctype="multipart/form-data" >
                                        
                                    
                                     
                                     <!--  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> -->
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi1" placeholder="Başlık" value="<?=$guncelle['sayi1']?>">
                                        <label for="floatingInput">Header</label>
                                      </div> 
                                      
                                      <div class="mb-3">
                                 
                                 <textarea  class="ckeditor" name="yazi1"  rows="10"><?=$guncelle['yazi1']?></textarea>
                            </div>

                                    
                                      
                                     <!--   <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim4" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim4']?>" width="200">
                                      </div>

                                            <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> 
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi2" placeholder="Başlık" value="<?=$guncelle['sayi2']?>">
                                        <label for="floatingInput">Başlık</label>
                                      </div> 
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Yazı 2" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">İçerik</label>
                                      </div> 
                                      
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim3" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim3']?>" width="200">
                                      </div>
                                             <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> 
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi3" placeholder="Sayı 3" value="<?=$guncelle['sayi3']?>">
                                        <label for="floatingInput">Çalışma Saati</label>
                                      </div> 

                                      <h5>Menü Adı</h5>

                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi3" placeholder="Anasayfa" value="<?=$guncelle['yazi3']?>">
                                        <label for="floatingInput">Anasayfa</label>
                                      </div> 

                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi4" placeholder="Hakkımızda" value="<?=$guncelle['sayi4']?>">
                                        <label for="floatingInput">Hakkımızda</label>
                                      </div> 
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Rezervasyon" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Rezervasyon</label>
                                      </div> 

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi5" placeholder="Menü" value="<?=$guncelle['yazi5']?>">
                                        <label for="floatingInput">Menü</label>
                                      </div> 

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi6" placeholder="Galeri" value="<?=$guncelle['yazi6']?>">
                                        <label for="floatingInput">Galeri</label>
                                      </div> 

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi7" placeholder="Blog" value="<?=$guncelle['yazi7']?>">
                                        <label for="floatingInput">Blog</label>
                                      </div> 

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi8" placeholder="Tarif" value="<?=$guncelle['yazi8']?>">
                                        <label for="floatingInput">Tarif</label>
                                      </div> 

                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi9" placeholder="İletişim" value="<?=$guncelle['yazi9']?>">
                                        <label for="floatingInput">İletişim</label>
                                      </div> 



                                      
                                      
                                      
                                       <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim2" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim2']?>" width="200">
                                      </div>

                                         
                                      
                                      
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
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