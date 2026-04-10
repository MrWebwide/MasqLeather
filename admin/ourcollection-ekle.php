<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();



$adi = $_POST['adi'];
$sira=$_POST['sira'];
$kategori = $_POST['kategori'];
$durum = $_POST['durum'];
$onaciklama = $_POST['onaciklama'];




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


$tur = "ourcollection";

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
	
	
      
	  
	  
	  
	$simdi = $db->prepare("insert into ourcollection set onaciklama=:onaciklama,kategori=:kategori,adi=:adi,sira=:sira,resim=:resim,durum=:durum,seo=:seo,tur=:tur,eklenme_tarihi=:eklenme_tarihi");
	$ekle = $simdi->execute(array("onaciklama"=>$onaciklama,"kategori"=>$kategori,"adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"seo"=>$seo,"tur"=>$tur,"durum"=>$durum,"eklenme_tarihi"=>$tarih));
	if($ekle){
		
		
		
		  $sonid=$db->query("select * from ourcollection order by id desc")->fetch(PDO::FETCH_ASSOC);
				
$yeni =$sonid['id'];
    if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
    		$islem = $db->prepare("INSERT INTO urun_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($yeni,$img,$tur));
    	}}
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Created!</strong>
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
		$ayar_kaydi = $db->query("SELECT * FROM ourcollection WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim = $ayar_kaydi['resim'];
	}
	else
	{
		if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png"|| $_FILES["resim"]["type"] =="image/jpg"|| $_FILES["resim"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM ourcollection WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
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

	
	
		
		  $deleteee = $db->exec("DELETE FROM urun_img WHERE urun_id = '$id' ");
        
	if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
			
	
    		$islem = $db->prepare("INSERT INTO urun_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($id,$img,$tur));
    	}
    }
	

		  
		
		
	 $simdi1 = $db->prepare("update ourcollection set onaciklama=:onaciklama,kategori=:kategori,adi=:adi,sira=:sira,resim=:resim,durum=:durum,seo=:seo,tur=:tur,guncelleme_tarihi=:guncelleme_tarihi where id=:id");
	$ekle1 = $simdi1->execute(array("onaciklama"=>$onaciklama,"kategori"=>$kategori,"adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"seo"=>$seo,"tur"=>$tur,"durum"=>$durum,"guncelleme_tarihi"=>$tarih,"id"=>$id));
	if($ekle1){
		
		
		
		
		
		
		
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Updated!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
	
	
}





if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from ourcollection where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <title>Our Collection | <?=$ayar['site_title']?></title>

        

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
                                    <h5 class="card-title">Our Collection</h5>
                                      <a href="ourcollection-listele.php"  class="btn btn-primary m-b-md">Our Collection List</a>
                                    <p class="card-description"></p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sira" placeholder="Product Order" value="<?=$guncelle['sira']?>">
                                        <label for="floatingInput">Our Collection Queue</label>
                                      </div>
                                      
                                      
                                           <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Product Name" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Our Collection Name</label>
                                      </div>
									

									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Our Collection Picture</label>
                                        <input class="form-control" type="file" name="resim" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim']?>" width="200">
                                      </div>  

									  <div class="mb-3">
    <h5>Categories</h5>
	<select class="form-select" name="kategori" onchange="updateOnaciklama(this)">
    <option value="0" <?= ($onaciklama == null || $onaciklama == '') ? 'selected' : '' ?>>Choose Product Category</option>
    <?php
    $urun_kategori_query = $db->query("SELECT adi, durum FROM urun_kategori ORDER BY id DESC");
    $bolge_kategori_query = $db->query("SELECT adi, durum FROM bolge_kategori ORDER BY id DESC");

    $all_categories = array();

    if ($urun_kategori_query->rowCount() > 0) {
        foreach ($urun_kategori_query as $urunkat) {
            $all_categories[$urunkat['adi']] = $urunkat['durum'];
        }
    }

    if ($bolge_kategori_query->rowCount() > 0) {
        foreach ($bolge_kategori_query as $bolgekat) {
            $all_categories[$bolgekat['adi']] = $bolgekat['durum'];
        }
    }

    foreach ($all_categories as $adi => $durum) {
        $encodedDurum = str_replace('&', '%26', $durum); // Sadece & işaretini değiştirdik
        ?>
        <option value="<?= $encodedDurum ?>" <?= ($adi == $onaciklama) ? 'selected' : '' ?>>
            <?= htmlspecialchars($adi) ?>
        </option>
        <?php
    }
    ?>
</select>


    <input type="hidden" name="onaciklama" id="onaciklama" value="<?= isset($guncelle['kategori']) ? htmlspecialchars($guncelle['kategori']) : '' ?>">

    <script>
        window.onload = function() {
            var onaciklamaInput = document.getElementById('onaciklama');
            var kategoriSelect = document.getElementsByName('kategori')[0];

            if (onaciklamaInput.value) {
                var selectedOption = kategoriSelect.querySelector('option[value="' + onaciklamaInput.value + '"]');
                if (selectedOption) {
                    selectedOption.selected = true;
                }
            }
        };

        function updateOnaciklama(select) {
            var selectedOption = select.options[select.selectedIndex];
            var onaciklamaInput = document.getElementById('onaciklama');
            var selectedAdi = selectedOption.textContent.trim();
            
            // Seçilen değeri encodeURIComponent ile kodlayarak sakla
            onaciklamaInput.value = encodeURIComponent(selectedAdi);
        }
    </script>
</div>


									
  								 <!--
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="Product Price" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput">Our Collection Fiyatı</label>
                                      </div>

									  <div class="mb-3">
                                 <h5>Categories</h5>
								 <select class="form-select" name="kategori" >
							   <option value="0" selected>Choose Product Category </option>
							   <?php
							   $urun_kategori = $db->query("select * from urun_kategori  order by id desc",PDO::FETCH_ASSOC);
							   if($urun_kategori->rowCount()){foreach($urun_kategori as $urunkat){
							   ?>
							   <option value="<?=$urunkat['adi']?>" <?php if($urunkat['adi']==$guncelle['kategori']){?> selected <?php }?>><?=$urunkat['adi']?></option>
					  <?php }}?>
							 </select>
							 </div>
									 
									  <div class=" mb-3">
                                            <label for="floatingInput">Ürün Preliminary Statement</label>
                                          <textarea class="form-control" name="yazi3" rows="10" cols="100"><?=$guncelle['yazi3']?></textarea>
                                        
                                      </div>

									        -->
									 
									  
									
									 
									
									   <!--
									 
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Button Name" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">Button Name</label>
                                      </div>
									
									  
                                      
                             
                                    
									
                                       
                                     
									
									  <div class="mb-3">
                                 
									 

									
                                    
									
							    <div class="mb-3">
                                 
                                               <textarea  class="ckeditor" name="aciklama"  rows="10"><?=$guncelle['aciklama']?></textarea>
                                      </div>
                                       -->
										
									  <div class="mb-3">
                                 
								 <div class="form-check form-switch">
						   <input class="form-check-input" name="durum" type="checkbox" id="flexSwitchCheckChecked" checked>
						   <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
						 </div>
						 </div>
						 <br>
                                      
                                      
                                       
                                      
                                      
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
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>