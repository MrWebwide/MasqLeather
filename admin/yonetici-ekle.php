<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();


$ad_soyad = $_POST['ad_soyad'];
$eposta = $_POST['eposta'];
$sifre_raw = $_POST['sifre'];
$admin = $_POST['admin'];

	$id = intval($_GET['id']);
if($_POST['kaydet'] and $_GET['islem']==''){
		$sifre = password_hash($sifre_raw, PASSWORD_BCRYPT);
		$ekle = $db->prepare("insert into yonetici set ad_soyad=:ad_soyad,eposta=:eposta,sifre=:sifre,admin=:admin,normalsifre=''");
		$simdi = $ekle->execute(array("ad_soyad"=>$ad_soyad,"eposta"=>$eposta,"sifre"=>$sifre,"admin"=>$admin));
}

if($_POST['kaydet'] and $_GET['islem']=='duzenle'){
	if(!empty($sifre_raw)){
		$sifre = password_hash($sifre_raw, PASSWORD_BCRYPT);
		$guncelle = $db->prepare("update yonetici set ad_soyad=:ad_soyad,eposta=:eposta,sifre=:sifre,normalsifre='',admin=:admin where id=:id");
		$hemen = $guncelle->execute(array("ad_soyad"=>$ad_soyad,"eposta"=>$eposta,"sifre"=>$sifre,"admin"=>$admin,"id"=>$id));
	} else {
		$guncelle = $db->prepare("update yonetici set ad_soyad=:ad_soyad,eposta=:eposta,admin=:admin where id=:id");
		$hemen = $guncelle->execute(array("ad_soyad"=>$ad_soyad,"eposta"=>$eposta,"admin"=>$admin,"id"=>$id));
	}
	if($hemen){
	 	$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Kullanıcı Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
		
}
 

if($_GET['islem']=='duzenle'){

$hesap = $db->query("select * from yonetici where  id='$id'")->fetch(PDO::FETCH_ASSOC);	
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
        <title>Yönetici Ekle - <?=$ayar['site_title']?></title>
    



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
                                      <h5 class="card-title">Yönetici Ekle</h5> 
                                     <a href="yonetici-listele.php"  class="btn btn-primary m-b-md">Yönetici Listele</a>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    
                                         <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="ad_soyad" placeholder="Site Mail" value="<?=$hesap['ad_soyad']?>">
                                        <label for="floatingInput">Ad Soyad </label>
                                      </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="eposta" placeholder="Site Mail" value="<?=$hesap['eposta']?>">
                                        <label for="floatingInput">Kullanıcı Eposta</label>
                                      </div>
                                      
                                      
                                          <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="floatingInput" name="sifre" placeholder="Yeni Şifre">
                                        <label for="floatingInput">Kullanıcı Şifre</label>
                                      </div>
                                      
                                        
                                         <div class="mb-3">
                                             <label for="floatingInput">Yetki</label>
                                                 <select class="form-select" name="admin" >
                                                 <?php if($hesap['admin'] != 'kullanici') { ?>  <option selected disabled>Yetkili Seçiniz </option> <?php } ?>
                                                    <?php if($hesap['admin']== 'admin' || $yetkiliogren['admin']== 'admin'){?> <option value="admin" <?php if($hesap['admin']== 'admin'){?> selected <?php }?>>Admin</option><option value="yetkili">Yetkili</option><option value="kullanici">Kullanıcı</option><?php }
                                                    else if($hesap['admin']== 'yetkili' || $yetkiliogren['admin']== 'yetkili'){ ?> <option value="yetkili" <?php if($hesap['admin']== 'yetkili'){?> selected <?php }?>>Yetkili</option>
                                                 <option value="kullanici" <?php if($hesap['admin']== 'kullanici'){?> selected <?php }?>>Kullanıcı</option><?php } 
                                                 else if($hesap['admin'] == 'kullanici') { ?> <option value="kullanici" <?php if($hesap['admin']== 'kullanici'){?> selected <?php } ?>>Kullanıcı</option><?php } ?>
                                                 </select>
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