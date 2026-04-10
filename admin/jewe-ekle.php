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
$yazi1 = $_POST['yazi1'];
$yazi3 = $_POST['yazi3'];
$yazi2 = $_POST['yazi2'];
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
$yazi14 = $_POST['yazi14'];
$yazi15 = $_POST['yazi15'];
$yazi16 = $_POST['yazi16'];
$yazi17 = $_POST['yazi17'];
$yazi18 = $_POST['yazi18'];
$yazi19 = $_POST['yazi19'];
$yazi20 = $_POST['yazi20'];
$yazi21 = $_POST['yazi21'];
$yazi22 = $_POST['yazi22'];



$cargo = $_POST['cargo'];
$stock = $_POST['stock'];
$cargo_us = $_POST['cargo_us'];








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


$tur = "jewelry";

$id = $_GET['id'];






	  
 




if($_POST['kaydet'] and $_GET['islem']==''){
	
	
	
$klasord="resimler/";
$klasorv="videolar/";
	$resim_tmpd = $_FILES['video']['tmp_name'];
	if(empty($resim_tmpd))
	{
		$video = "video-yok";
	}
	else
	{
		
		if ($_FILES["video"]["type"] =="video/mp4" || $_FILES["video"]["type"] =="video/avi"|| $_FILES["video"]["type"] =="video/mov"|| $_FILES["video"]["type"] =="video/flv") 

		{
			$random = rand(0,99999);
			
			$video = $random."-".$seo.".".substr($_FILES['video']['name'], -3);
			
			move_uploaded_file($_FILES['video']['tmp_name'],$klasorv."/".$video);
	
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Video Dosyası Seçiniz ( .mp4 - .avi - .flv ).
			</div>';
		}
	}


$resim_tmpd = $_FILES['resim']['tmp_name'];
if(empty($resim_tmpd)) {
    $resim = "resim-yok";
} else {
    if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png" || $_FILES["resim"]["type"] =="image/jpg" || $_FILES["resim"]["type"] =="image/jpeg") {
        $random = rand(0,99999);
        $resim = $random . "-" . $seo . "." . substr($_FILES['resim']['name'], -3);
        move_uploaded_file($_FILES['resim']['tmp_name'], $klasord . "/" . $resim);
    } else {
        $bilgi = '<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Hata !</strong> Lütfen Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
        </div>';
    }
}

$resim_tmpd1 = $_FILES['resim1']['tmp_name'];
if(empty($resim_tmpd1)) {
    $resim1 = "resim-yok";
} else {
    if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png" || $_FILES["resim1"]["type"] =="image/jpg" || $_FILES["resim1"]["type"] =="image/jpeg") {
        $random = rand(0,99999);
        $resim1 = $random . "-" . $seo . "." . substr($_FILES['resim1']['name'], -3);
        move_uploaded_file($_FILES['resim1']['tmp_name'], $klasord . "/" . $resim1);
    } else {
        $bilgi = '<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Hata !</strong> Lütfen Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
        </div>';
    }
}

	
	
      
	  
	  
	  
	$simdi = $db->prepare("insert into jewe set video=:video, adi=:adi,sira=:sira,resim=:resim,resim1=:resim1,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,aciklama=:aciklama,seo=:seo,yazi1=:yazi1,yazi3=:yazi3,yazi2=:yazi2,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,yazi11=:yazi11,yazi12=:yazi12,yazi13=:yazi13,yazi14=:yazi14,yazi15=:yazi15,yazi16=:yazi16,yazi17=:yazi17,yazi18=:yazi18,yazi19=:yazi19,yazi20=:yazi20,yazi21=:yazi21,yazi22=:yazi22,cargo=:cargo,stock=:stock,cargo_us=:cargo_us,tur=:tur,eklenme_tarihi=:eklenme_tarihi");
	$ekle = $simdi->execute(array("video"=>$video,"adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"resim1"=>$resim1,"kategori"=>$kategori,"aciklama"=>$aciklama,"seo"=>$seo,"tur"=>$tur,"yazi1"=>$yazi1,"yazi3"=>$yazi3,"yazi2"=>$yazi2,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"yazi11"=>$yazi11,"yazi12"=>$yazi12,"yazi13"=>$yazi13,"yazi14"=>$yazi14,"yazi15"=>$yazi15,"yazi16"=>$yazi16,"yazi17"=>$yazi17,"yazi18"=>$yazi18,"yazi19"=>$yazi19,"yazi20"=>$yazi20,"yazi21"=>$yazi21,"yazi22"=>$yazi22,"cargo"=>$cargo,"stock"=>$stock,"cargo_us"=>$cargo_us,"onaciklama"=>$onaciklama,"durum"=>$durum,"eklenme_tarihi"=>$tarih));
	if($ekle){
		
		
		
		  $sonid=$db->query("select * from jewe order by id desc")->fetch(PDO::FETCH_ASSOC);
				
        $yeni =$sonid['id'];
        if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
    		$islem = $db->prepare("INSERT INTO jewe_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($yeni,$img,$tur));
    	}}
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ürün Başarıyla Eklendi!</strong>
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
}

if($_POST['kaydet'] and $_GET['islem']=='duzenle'){

      // Check if a new video file is uploaded
		if (!empty($_FILES['video']['tmp_name'])) {
			$klasor = "videolar/";
	
			if (
				$_FILES["video"]["type"] == "video/mp4" ||
				$_FILES["video"]["type"] == "video/avi" ||
				$_FILES["video"]["type"] == "video/mov" ||
				$_FILES["video"]["type"] == "video/flv"
			) {
				$ayar_kaydi = $db->query("SELECT * FROM jewe WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
				
				if ($ayar_kaydi['video'] != "resim-yok") {
					unlink("videolar/" . $ayar_kaydi['video']);
				}
	
				$random = rand(0, 999999);
				$video = $random . "-" . $adii . "." . substr($_FILES['video']['name'], -3);
				
				move_uploaded_file($_FILES['video']['tmp_name'], $klasor . "/" . $video);
			} else {
				$bilgi = '<div class="alert alert-error">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Hata !</strong> Lütfen Uygun Formatta Bir Video Dosyası Seçiniz ( .mp4 - .avi - .flv ).
				</div>';
			}
		} else {
			// No new video uploaded, keep the existing one
			$duzenlenecek_id = $_GET['id'];
			$ayar_kaydi = $db->query("SELECT * FROM jewe WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
			$video = $ayar_kaydi['video'];
		}
		
		
			$klasor="resimler/";


	
	 $resim_tmp = $_FILES['resim']['tmp_name'];

    if(empty($resim_tmp)) {
        $duzenlenecek_id = $_GET['id'];
        $ayar_kaydi = $db->query("SELECT * FROM jewe WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
        $resim = $ayar_kaydi['resim'];
    } else {
        if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png" || $_FILES["resim"]["type"] =="image/jpg" || $_FILES["resim"]["type"] =="image/jpeg") {
            $random = rand(0, 99999);
            $resim = $random . "-" . $_FILES['resim']['name']; // Dosya adını rastgele bir sayı ile birleştirerek oluşturuyoruz
            move_uploaded_file($_FILES['resim']['tmp_name'], $klasor . "/" . $resim);
        } else {
            $bilgi = '<div class="alert alert-error">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Hata !</strong> Lütfen Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
                </div>';
        }
    }

    $resim_tmp1 = $_FILES['resim1']['tmp_name'];

    if(empty($resim_tmp1)) {
        $duzenlenecek_id = $_GET['id'];
        $ayar_kaydi = $db->query("SELECT * FROM jewe WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
        $resim1 = $ayar_kaydi['resim1'];
    } else {
        if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png" || $_FILES["resim1"]["type"] =="image/jpg" || $_FILES["resim1"]["type"] =="image/jpeg") {
            $random = rand(0, 99999);
            $resim1 = $random . "-" . $_FILES['resim1']['name']; // Dosya adını rastgele bir sayı ile birleştirerek oluşturuyoruz
            move_uploaded_file($_FILES['resim1']['tmp_name'], $klasor . "/" . $resim1);
        } else {
            $bilgi = '<div class="alert alert-error">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Hata !</strong> Lütfen Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
                </div>';
        }
    }




	
	
		
		  $deleteee = $db->exec("DELETE FROM jewe_img WHERE urun_id = '$id' ");
        
	if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
			
	
    		$islem = $db->prepare("INSERT INTO jewe_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($id,$img,$tur));
    	}
    }
	

		
		
		
	 $simdi1 = $db->prepare("update jewe set video=:video, adi=:adi,sira=:sira,resim=:resim,resim1=:resim1,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,yazi1=:yazi1,yazi3=:yazi3,yazi2=:yazi2,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,yazi10=:yazi10,yazi11=:yazi11,yazi12=:yazi12,yazi13=:yazi13,yazi14=:yazi14,yazi15=:yazi15,yazi16=:yazi16,yazi17=:yazi17,yazi18=:yazi18,yazi19=:yazi19,yazi20=:yazi20,yazi21=:yazi21,yazi22=:yazi22,cargo=:cargo,stock=:stock,aciklama=:aciklama,cargo_us=:cargo_us,seo=:seo,tur=:tur,guncelleme_tarihi=:guncelleme_tarihi where id=:id");
	$ekle1 = $simdi1->execute(array("video"=>$video,"adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"resim1"=>$resim1,"kategori"=>$kategori,"aciklama"=>$aciklama,"seo"=>$seo,"tur"=>$tur,"onaciklama"=>$onaciklama,"durum"=>$durum,"yazi1"=>$yazi1,"yazi3"=>$yazi3,"yazi2"=>$yazi2,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"yazi7"=>$yazi7,"yazi8"=>$yazi8,"yazi9"=>$yazi9,"yazi10"=>$yazi10,"yazi11"=>$yazi11,"yazi12"=>$yazi12,"yazi13"=>$yazi13,"yazi14"=>$yazi14,"yazi15"=>$yazi15,"yazi16"=>$yazi16,"yazi17"=>$yazi17,"yazi18"=>$yazi18,"yazi19"=>$yazi19,"yazi20"=>$yazi20,"yazi21"=>$yazi21,"yazi22"=>$yazi22,"cargo"=>$cargo,"cargo_us"=>$cargo_us,"stock"=>$stock,"guncelleme_tarihi"=>$tarih,"id"=>$id));
	if($ekle1){
		
		
		
		
		
		
		
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ürün Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
	
	
}





if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from jewe where id='$gid'")->fetch(PDO::FETCH_ASSOC);
}

// 1. Son 'sira' değerini al
// 1. URL'den 'islem' parametresini kontrol et
if (isset($_GET['islem']) && $_GET['islem'] == 'duzenle') {
    // Düzenleme modunda ise, mevcut 'sira' değerini al
    $stmt = $db->prepare("SELECT sira FROM jewe WHERE id = ?");
    $stmt->execute(array($id)); // $id değişkeni düzenlenen ürünün ID'sini içeriyor olmalı
    $ayni_sira = $stmt->fetch(PDO::FETCH_ASSOC)['sira'];
    $yeni_sira = $ayni_sira;
} else {
    // Düzenleme modunda değilse, yeni 'sira' değerini bir artır
    $stmt = $db->query("SELECT MAX(sira) AS max_sira FROM jewe");
    $son_sira = $stmt->fetch(PDO::FETCH_ASSOC)['max_sira'];
    $yeni_sira = $son_sira + 1;
}



// Veritabanından durum verisini çek
$query = $db->query("SELECT durum FROM jewe WHERE id='$id'");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum = $result['durum'];


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
        <title>Add Product | <?=$ayar['site_title']?></title>

        

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
								<h5 class="card-title">Add Product</h5>
									
                               
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
									<div class="d-flex butoncu">
                                   
								   <a href="jewe-listele.php"  class="btn btn-primary m-b-md">List Products</a> <!-- Ürünü kopyalamak için bir buton -->
							 
<button id="productCopy" class="btn btn-primary m-b-md">Copy This Product</button>
<div class="mb-3">
	 <button type="submit" name="kaydet" value="kaydet" class="btn btn-primary">Save</button>
 </div>
</div>
										<h6>Product listing status:</h6>
									<div class="toggle">
  <input name="durum" type="checkbox" id="btn" >
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>


<h5>SEO AREA</h5>

<div class="row mb-3">

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi20" placeholder="Title" value="<?=$guncelle['yazi20']?>">
<label for="floatingInput5">Title</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi21" placeholder="Descriptions" value="<?=$guncelle['yazi21']?>">
<label for="floatingInput5">Descriptions</label>
</div>
</div>

<div class="col-md-4">
<div class="form-floating">
<input type="text" class="form-control" id="floatingInput5" name="yazi22" placeholder="Keywords" value="<?=$guncelle['yazi22']?>">
<label for="floatingInput5">Keywords</label>
</div>
</div>




</div>

									<div class="mb-3">
                                 <h5>Categories</h5>
								 <select class="form-select" name="kategori" >
							   <option value="0" selected>Choose Product Category </option>
							   <?php
							   $urun_kategori = $db->query("select * from jewe_kategori  order by id desc",PDO::FETCH_ASSOC);
							   if($urun_kategori->rowCount()){foreach($urun_kategori as $urunkat){
							   ?>
							   <option value="<?=$urunkat['adi']?>" <?php if($urunkat['adi']==$guncelle['kategori']){?> selected <?php }?>><?=$urunkat['adi']?></option>
					  <?php }}?>
							 </select>
							 </div>
							 <div class="form-floating mb-3">
    <input type="hidden" class="form-control" id="floatingInput" name="sira" placeholder="Product Order" value="<?= $yeni_sira ?>">
    <label for="floatingInput">Product Order</label>
</div>

<div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="onaciklama" placeholder="Product Order" value="<?=$guncelle['onaciklama']?>">
                                        <label for="floatingInput">Product Unique ID</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="stock" placeholder="Product Order" value="<?=$guncelle['stock']?>">
                                        <label for="floatingInput">Product Stock Count</label>
                                      </div>
                                      
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Product Name" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Product Name</label>
                                      </div>
									
									  <div class="mb-3">
                                 <h5>Spesification</h5>
								 <select class="form-select" name="yazi2" >
							   <option value="0" selected>Choose One </option>
							   <?php
							   $urun_kategori = $db->query("select * from spe_kategori  order by id desc",PDO::FETCH_ASSOC);
							   if($urun_kategori->rowCount()){foreach($urun_kategori as $urunkat){
							   ?>
							   <option value="<?=$urunkat['adi']?>" <?php if($urunkat['adi']==$guncelle['yazi2']){?> selected <?php }?>><?=$urunkat['adi']?></option>
					  <?php }}?>
							 </select>
							 </div>
									
									

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="Product Price" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput">Product Price</label>
                                      </div>

									  

								
									<div class="mb-3">
			<h5>Cargo Size</h5>
			<select class="form-select" name="cargo_us" onchange="getFiyat(this.value)">
				<option value="0" selected>Cargo Size USA </option>
				<?php
				$urun_kategori = $db->query("select * from cargo_kategori_us order by id desc", PDO::FETCH_ASSOC);
				if ($urun_kategori->rowCount()) {
					foreach ($urun_kategori as $urunkat) {
						?>
						<option value="<?= $urunkat['fiyat'] ?>" <?php if ($urunkat['fiyat'] == $guncelle['cargo_us']) { ?> selected <?php } ?>>
							<?= $urunkat['adi'] ?>
						</option>
					<?php }}?>
			</select>
		</div>


				<div class="mb-3">
   			 <h5>Cargo Size</h5>
  	  <select class="form-select" name="cargo" onchange="getFiyat(this.value)">
        <option value="0" selected>Cargo Size CA</option>
        <?php
        $urun_kategori = $db->query("select * from cargo_kategori order by id desc", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?= $urunkat['fiyat'] ?>" <?php if ($urunkat['fiyat'] == $guncelle['cargo']) { ?> selected <?php } ?>>
                    <?= $urunkat['adi'] ?>
                </option>
            <?php }}?>
    </select>
</div>

<div class="mb-3">
    <h5>Color Variant</h5>
    <p>(If the product doesn't have any color variants, don't choose anything)</p>
    <select class="form-select" name="yazi10" onchange="updateImage(this)">
        <option value="" <?php if(empty($guncelle['yazi10'])) echo "selected"; ?>>Choose One</option>
        <?php
        $urun_kategori = $db->query("SELECT * FROM jewe ORDER BY id DESC", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?=$urunkat['id']?>" data-resim="<?=$urunkat['resim']?>" <?php if($urunkat['id'] == $guncelle['yazi10']) echo "selected"; ?>>
                    <?=$urunkat['adi']?>
                </option>
                <?php
            }
        }
        ?>
    </select>
    <input type="hidden" name="yazi15" id="yazi15" value="<?=$guncelle['yazi15']?>">
</div>

<script>
    function updateImage(select) {
        var selectedOption = select.options[select.selectedIndex];
        var resim = selectedOption.getAttribute('data-resim');
        if (select.value !== "0" && resim !== null) {
            document.getElementById("yazi15").value = resim;
        } else {
            document.getElementById("yazi15").value = ""; // 0 seçildiğinde değeri temizle
        }
    }
</script>


<div class="mb-3">
    <h5>Color Variant</h5>
    <p>(If the product doesn't have any color variants, don't choose anything)</p>
    <select class="form-select" name="yazi11" onchange="updateImage1(this)">
        <option value="" <?php if(empty($guncelle['yazi11'])) echo "selected"; ?>>Choose One</option>
        <?php
        $urun_kategori = $db->query("SELECT * FROM jewe ORDER BY id DESC", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?=$urunkat['id']?>" data-resim="<?=$urunkat['resim']?>" <?php if($urunkat['id'] == $guncelle['yazi11']) echo "selected"; ?>>
                    <?=$urunkat['adi']?>
                </option>
                <?php
            }
        }
        ?>
    </select>
    <input type="hidden" name="yazi16" id="yazi16" value="<?=$guncelle['yazi16']?>">
</div>

<script>
    function updateImage1(select) {
        var selectedOption = select.options[select.selectedIndex];
        var resim = selectedOption.getAttribute('data-resim');
        if (select.value !== "0" && resim !== null) {
            document.getElementById("yazi16").value = resim;
        } else {
            document.getElementById("yazi16").value = ""; // 0 seçildiğinde değeri temizle
        }
    }
</script>

<div class="mb-3">
    <h5>Color Variant</h5>
    <p>(If the product doesn't have any color variants, don't choose anything)</p>
    <select class="form-select" name="yazi12" onchange="updateImage2(this)">
        <option value="" <?php if(empty($guncelle['yazi12'])) echo "selected"; ?>>Choose One</option>
        <?php
        $urun_kategori = $db->query("SELECT * FROM jewe ORDER BY id DESC", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?=$urunkat['id']?>" data-resim="<?=$urunkat['resim']?>" <?php if($urunkat['id'] == $guncelle['yazi12']) echo "selected"; ?>>
                    <?=$urunkat['adi']?>
                </option>
                <?php
            }
        }
        ?>
    </select>
    <input type="hidden" name="yazi17" id="yazi17" value="<?=$guncelle['yazi17']?>">
</div>

<script>
    function updateImage2(select) {
        var selectedOption = select.options[select.selectedIndex];
        var resim = selectedOption.getAttribute('data-resim');
        if (select.value !== "0" && resim !== null) {
            document.getElementById("yazi17").value = resim;
        } else {
            document.getElementById("yazi17").value = ""; // 0 seçildiğinde değeri temizle
        }
    }
</script>


<div class="mb-3">
    <h5>Color Variant</h5>
    <p>(If the product doesn't have any color variants, don't choose anything)</p>
    <select class="form-select" name="yazi13" onchange="updateImage3(this)">
        <option value="" <?php if(empty($guncelle['yazi13'])) echo "selected"; ?>>Choose One</option>
        <?php
        $urun_kategori = $db->query("SELECT * FROM jewe ORDER BY id DESC", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?=$urunkat['id']?>" data-resim="<?=$urunkat['resim']?>" <?php if($urunkat['id'] == $guncelle['yazi13']) echo "selected"; ?>>
                    <?=$urunkat['adi']?>
                </option>
                <?php
            }
        }
        ?>
    </select>
    <input type="hidden" name="yazi18" id="yazi18" value="<?=$guncelle['yazi18']?>">
</div>

<script>
    function updateImage3(select) {
        var selectedOption = select.options[select.selectedIndex];
        var resim = selectedOption.getAttribute('data-resim');
        if (select.value !== "0" && resim !== null) {
            document.getElementById("yazi18").value = resim;
        } else {
            document.getElementById("yazi18").value = ""; // 0 seçildiğinde değeri temizle
        }
    }
</script>

<div class="mb-3">
    <h5>Color Variant</h5>
    <p>(If the product doesn't have any color variants, don't choose anything)</p>
    <select class="form-select" name="yazi14" onchange="updateImage4(this)">
        <option value="" <?php if(empty($guncelle['yazi14'])) echo "selected"; ?>>Choose One</option>
        <?php
        $urun_kategori = $db->query("SELECT * FROM jewe ORDER BY id DESC", PDO::FETCH_ASSOC);
        if ($urun_kategori->rowCount()) {
            foreach ($urun_kategori as $urunkat) {
                ?>
                <option value="<?=$urunkat['id']?>" data-resim="<?=$urunkat['resim']?>" <?php if($urunkat['id'] == $guncelle['yazi14']) echo "selected"; ?>>
                    <?=$urunkat['adi']?>
                </option>
                <?php
            }
        }
        ?>
    </select>
    <input type="hidden" name="yazi19" id="yazi19" value="<?=$guncelle['yazi19']?>">
</div>

<script>
    function updateImage4(select) {
        var selectedOption = select.options[select.selectedIndex];
        var resim = selectedOption.getAttribute('data-resim');
        if (select.value !== "0" && resim !== null) {
            document.getElementById("yazi19").value = resim;
        } else {
            document.getElementById("yazi19").value = ""; // 0 seçildiğinde değeri temizle
        }
    }
</script>


							


									 
							 <h5>Product Details</h5>
									
							 <div class=" mb-3">
                                            <label for="floatingInput">Product Short Info</label>
                                          <textarea class="form-control" name="yazi3" rows="10" cols="100"><?=$guncelle['yazi3']?></textarea>
                                        
                                      </div>
						
									  <h5>Product Additional Detail</h5>

									  <div class="row">
    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi7" placeholder="Product Price" value="<?=$guncelle['yazi7']?>">
            <label for="floatingInput">Short İnfo Heading 1</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi8" placeholder="Product Price" value="<?=$guncelle['yazi8']?>">
            <label for="floatingInput">Short İnfo Heading 2</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi9" placeholder="Product Price" value="<?=$guncelle['yazi9']?>">
            <label for="floatingInput">Short İnfo Heading 3</label>
        </div>
    </div>
</div>
							
									  <div class="row">
    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Product Price" value="<?=$guncelle['yazi4']?>">
            <label for="floatingInput">Short İnfo 1</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi5" placeholder="Product Price" value="<?=$guncelle['yazi5']?>">
            <label for="floatingInput">Short İnfo 2</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="yazi6" placeholder="Product Price" value="<?=$guncelle['yazi6']?>">
            <label for="floatingInput">Short İnfo 3</label>
        </div>
    </div>
</div>

									  <div class="mb-3">
                                 
								 <textarea  class="ckeditor" name="aciklama"  rows="10"><?=$guncelle['aciklama']?></textarea>
						</div>

									   <!--
									  <div class="mb-3">
                                 <h5>Categories</h5>
								 <select class="form-select" name="kategori" >
							   <option value="0" selected>Choose Product Category </option>
							   <?php
							   $urun_kategori = $db->query("select * from jewe_kategori  order by id desc",PDO::FETCH_ASSOC);
							   if($urun_kategori->rowCount()){foreach($urun_kategori as $urunkat){
							   ?>
							   <option value="<?=$urunkat['adi']?>" <?php if($urunkat['adi']==$guncelle['kategori']){?> selected <?php }?>><?=$urunkat['adi']?></option>
					  <?php }}?>
							 </select>
							 </div>
									  
									
									 
									
									
									 
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Button Name" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">Button Name</label>
                                      </div>
									
									  
                                      
                                     -->
                                    
									
                                       
                                     
									
									
						 <br>
                                      
                                      
                                       <div class="row" id="resimler">
                            
                            	<div class="form-group row col-md-12" id="resimler">
                            
                            
                            	<?php
									$i = 0;
									
									$iddd=intval($_GET['id']);
									if($_GET['islem']=='duzenle'){
										$cek = $db->query("SELECT * FROM jewe_img WHERE urun_id = '$iddd' order by id asc", PDO::FETCH_ASSOC);
										if($cek->rowCount()){
											foreach( $cek as $c ){
												echo '<div class="col-md-3" data-resim-dis-id="'.$i.'">
									                    <div class="uploaddis pasif" style="float:left;">
									        			  <div class="yuklendi">
									        				  <img src="resimler/'.$c['img'].'" width="100%">
									        				  <div class="icon" data-resim-sil-id="'.$i.'"><span class="fa fa-trash"></span></div>
									        				  <input type="hidden" name="img[]" value="'.$c['img'].'" required="">
									        			  </div>
									        			</div>
									                </div>';
									            $i++;
											}
										}
									}
								?>
                            </div>
                            
							<div class="mb-3">
                                 
                            <div class="mb-3">
								   <label for="formFile" class="form-label">Product Video</label>
								   <input class="form-control" type="file" name="video" id="formFile">
								   
									<video controls src="videolar/<?=$guncelle['video']?>" width="200">
								 </div>

									
								 <div class="mb-3">
								   <label for="formFile" class="form-label">Product Main Picture</label>
								   <input class="form-control" type="file" name="resim" id="formFile">
								   
									<img src="resimler/<?=$guncelle['resim']?>" width="200">
								 </div>  

                                 <div class="mb-3">
								   <label for="formFile" class="form-label">Product Second Picture</label>
								   <input class="form-control" type="file" name="resim1" id="formFile">
								   
									<img src="resimler/<?=$guncelle['resim1']?>" width="200">
								 </div>  
								  <!--
						  
								  -->
							
						
							<div class="form-group row col-md-12">
						 <div class="col-md-4 " style="margin:auto;padding:auto;">
								<div class="uploaddis aktif" data-id="1" style="margin:0 auto;">
								  <div class="upload1">
									  <span class="metin" style="width: 100%;float: left;">Multiple Product Images</span>
									  <div class="icon"><span class="fa fa-upload" data-id="1"></span></div>
								  </div>
								</div>
							</div>
						
						
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
				        				  <img src="resimler/'+data+'" width="100%">\
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

<script>
document.getElementById("productCopy").addEventListener("click", function(event){
    event.preventDefault(); // Butonun varsayılan tıklama işlemini engeller

    // Kopyalanacak ürünün ID'sini alıyoruz
    var productId = <?php echo $_GET['id']; ?>;

    // AJAX isteği ile mevcut ürün bilgilerini alıyoruz
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "copy_product_jewelry.php?id=" + productId, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // İşlem başarılı olduğunda kullanıcıya bilgi vermek için bir alert kullanabilirsiniz
            alert("Ürün kopyalandı!");
            // Sayfayı yenilemek isterseniz aşağıdaki satırı kullanabilirsiniz
            // location.reload();
        }
    };
    xhr.send();
});



</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum = "<?php echo $durum; ?>"; // PHP'den JavaScript'e durum verisini aktar

  var checkbox = document.getElementById("btn");
  if (durum === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script>   

        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>