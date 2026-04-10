<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$adi = $_POST['adi'];
$sira = $_POST['sira'];
$aciklama = $_POST['aciklama'];
$onaciklama = $_POST['onaciklama'];
$durum = $_POST['durum'];
$kategori = $_POST['kategori'];
$fiyat = $_POST['fiyat'];

function seflink($string)
{
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
    $string = strtolower(str_replace($find, $replace, $string));
    $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
    $string = trim(preg_replace('/\s+/', ' ', $string));
    $string = str_replace(' ', '-', $string);
    return $string;
}

$seo = seflink($adi);
$tur = "kampanya";
$id = $_GET['id'];

if ($_POST['kaydet'] && empty($_GET['islem'])) {
    // Yeni kampanya ekle
    $simdi = $db->prepare("insert into homedecorkampanya set adi=:adi, sira=:sira, resim=:resim, kategori=:kategori, durum=:durum, onaciklama=:onaciklama, fiyat=:fiyat, seo=:seo, tur=:tur, eklenme_tarihi=:eklenme_tarihi");
    $ekle = $simdi->execute(array("adi" => $adi, "sira" => $sira, "resim" => $resim, "kategori" => $kategori, "fiyat" => $fiyat, "seo" => $seo, "tur" => $tur, "onaciklama" => $onaciklama, "durum" => $durum, "eklenme_tarihi" => $tarih));

    if ($ekle) {
        $sonid = $db->query("select * from homedecorkampanya order by id desc")->fetch(PDO::FETCH_ASSOC);

        // Yeni kampanya eklendikten sonra urunler tablosunu güncelle
        $updateUrunlerQuery = "UPDATE homedecor SET kampanya = :fiyat WHERE kategori = :kategori";
        $updateUrunlerStatement = $db->prepare($updateUrunlerQuery);
        $updateUrunlerStatement->bindParam(':fiyat', $fiyat, PDO::PARAM_STR);
        $updateUrunlerStatement->bindParam(':kategori', $kategori, PDO::PARAM_STR);
        $updateUrunlerStatement->execute();

        $mesaj = "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Kategori Başarıyla Eklendi!</strong> 
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
}

if ($_POST['kaydet'] && $_GET['islem'] == 'duzenle') {
    // Kampanya güncelle
    $simdi1 = $db->prepare("update homedecorkampanya set adi=:adi, sira=:sira, resim=:resim, kategori=:kategori, durum=:durum, onaciklama=:onaciklama, fiyat=:fiyat, seo=:seo, tur=:tur, guncelleme_tarihi=:guncelleme_tarihi where id=:id");
    $ekle1 = $simdi1->execute(array("adi" => $adi, "sira" => $sira, "resim" => $resim, "kategori" => $kategori, "fiyat" => $fiyat, "seo" => $seo, "tur" => $tur, "onaciklama" => $onaciklama, "durum" => $durum, "guncelleme_tarihi" => $tarih, "id" => $id));

    if ($ekle1) {
        // Kampanya güncellendikten sonra urunler tablosunu güncelle
        $updateUrunlerQuery = "UPDATE homedecor SET kampanya = :fiyat WHERE kategori = :kategori";
        $updateUrunlerStatement = $db->prepare($updateUrunlerQuery);
        $updateUrunlerStatement->bindParam(':fiyat', $fiyat, PDO::PARAM_STR);
        $updateUrunlerStatement->bindParam(':kategori', $kategori, PDO::PARAM_STR);
        $updateUrunlerStatement->execute();

        $mesaj = "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Kategori Başarıyla Güncellendi!</strong> 
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
}

if ($_GET['islem'] == 'duzenle') {
    $gid = $_GET['id'];
    $guncelle = $db->query("select * from homedecorkampanya where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <title>Kampanya  Ekle | <?=$ayar['site_title']?></title>



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
                                    <h5 class="card-title">Add Coupon Category</h5>
									<a href="homedecor-kampanya-listele.php"  class="btn btn-primary m-b-md">List Category</a>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sira" placeholder="Kategori Sırası" value="<?=$guncelle['sira']?>">
                                        <label for="floatingInput">Coupon Order</label>
                                      </div>
                                   <div class="mb-3">
                                 <h5>Categories</h5>
								 <select class="form-select" name="kategori" >
							   <option value="0" selected>Choose Product Category </option>
							   <?php
							   $urun_kategori = $db->query("select * from mer_kategori  order by id desc",PDO::FETCH_ASSOC);
							   if($urun_kategori->rowCount()){foreach($urun_kategori as $urunkat){
							   ?>
							   <option value="<?=$urunkat['adi']?>" <?php if($urunkat['adi']==$guncelle['kategori']){?> selected <?php }?>><?=$urunkat['adi']?></option>
					  <?php }}?>
							 </select>
							 </div>

                                      
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Kategori Adı" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Kampanya Adı</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="fiyat" placeholder="Kategori Fiyatı" value="<?=$guncelle['fiyat']?>">
                                        <label for="floatingInput">Yüzdesi </label>
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
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>