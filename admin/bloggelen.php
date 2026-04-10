<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();



$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$messagee = $_POST['messagee'];
$durum = $_POST['durum'];
$tur = $_POST['tur'];

$id = $_GET['id'];





if($_POST['kaydet'] and $_GET['islem']=='duzenle'){
	
	 $simdi1 = $db->prepare("update bloggelen set durum=:durum where id=:id");
	$ekle1 = $simdi1->execute(array("durum"=>$durum,"id"=>$id));
	if($ekle1){
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Product Reviews Başarıyla Güncellendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
}


if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from bloggelen where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
        <title>Product Reviews Listing | <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">Product Reviews Listing</h5>
                                    	<a href="index.php#hbrfrm"  style="border-radius: 10px;" class="btn btn-primary m-b-md">Messages</a>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                         	
		                             <div class="mb-3">
                                              	<div class="form-check form-switch">
                                       			  <input class="form-check-input" name="durum" type="checkbox" id="flexSwitchCheckChecked" 
                                       			  	<?php 
                                       			  	if($_GET['islem']=='duzenle'){
                                       			  		if($guncelle['durum']=='on'){ ?> checked <?php } } ?> >
                                        		  <label class="form-check-label" for="flexSwitchCheckChecked">YORUM DURUM</label>
                                      			</div>
                                      </div>      	 
                                       
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['yorumid']?>" disabled>
                                        <label for="floatingInput">Reviews Id</label>
                                      </div>
                                      
                                     
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['name']?>" disabled>
                                        <label for="floatingInput"> Name & Surname </label>
                                      </div>
                                      
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['email']?>" disabled>
                                        <label for="floatingInput">Email</label>
                                      </div>

                                     
                                      
                                       <div class="form-floating mb-3">
                                        <input type="text" class="form-control"  value="<?=$guncelle['tur']?>" disabled>
                                        <label for="floatingInput">Category</label>
                                      </div>
                                      
                                      
                                      
                                       <div class=" mb-3">
                                            <label for="floatingInput"> Mesaj</label>
                                          <textarea class="form-control"  rows="2" cols="20" disabled><?=$guncelle['messagee']?></textarea>
                                        
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
        
        
	
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>