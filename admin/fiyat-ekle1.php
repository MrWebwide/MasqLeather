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
$durum = 'on';
$kategori = $_POST['kategori'];
$buton= $_POST['buton'];
$linki = $_POST['linki'];

$yazi1 = $_POST['yazi1'];
$yazi2 = $_POST['yazi2'];
$yazi3 = $_POST['yazi3'];
$yazi4 = $_POST['yazi4'];
$yazi5 = $_POST['yazi5'];
$yazi6 = $_POST['yazi6'];

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
	
      
	  
	  
	  
	 $simdi = $db->prepare("insert into fiyatlar1 set adi=:adi,resim=:resim,durum=:durum,onaciklama=:onaciklama,kategori=:kategori,aciklama=:aciklama,buton=:buton,linki=:linki,yazi1=:yazi1,yazi2=:yazi2,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,sira=:sira");
	$ekle = $simdi->execute(array("adi"=>$adi,"durum"=>$durum,"resim"=>$resim,"onaciklama"=>$onaciklama,"kategori"=>$kategori,"aciklama"=>$aciklama,"buton"=>$buton,"linki"=>$linki,"yazi1"=>$yazi1,"yazi2"=>$yazi2,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"sira"=>$sira));
	if($ekle){
		
		
		
		  $sonid=$db->query("select * from fiyatlar1 order by id desc")->fetch(PDO::FETCH_ASSOC);
				
$yeni =$sonid['id'];
    if(isset($_POST['img'])){
    	foreach ($_POST['img'] as $img) {
    		$islem = $db->prepare("INSERT INTO urun_img SET urun_id = ?, img = ?,tur=?");
        	$islem = $islem->execute(array($yeni,$img,$tur));
    	}}
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong> Fiyat  Başarıyla Eklendi!</strong>
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
		$ayar_kaydi = $db->query("SELECT * FROM fiyatlar1 WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
		$resim = $ayar_kaydi['resim'];
	}
	else
	{
		if ($_FILES["resim"]["type"] =="image/gif" || $_FILES["resim"]["type"] =="image/png"|| $_FILES["resim"]["type"] =="image/jpg"|| $_FILES["resim"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM fiyatlar1 WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
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
	

		
		
		
	 $simdi1 = $db->prepare("update fiyatlar1 set adi=:adi,resim=:resim,durum=:durum,onaciklama=:onaciklama,kategori=:kategori,aciklama=:aciklama,buton=:buton,linki=:linki,yazi1=:yazi1,yazi2=:yazi2,yazi3=:yazi3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,sira=:sira where id=:id");
	$ekle1 = $simdi1->execute(array("adi"=>$adi,"resim"=>$resim,"durum"=>$durum,"onaciklama"=>$onaciklama,"kategori"=>$kategori,"aciklama"=>$aciklama,"buton"=>$buton,"linki"=>$linki,"yazi1"=>$yazi1,"yazi2"=>$yazi2,"yazi3"=>$yazi3,"yazi4"=>$yazi4,"yazi5"=>$yazi5,"yazi6"=>$yazi6,"sira"=>$sira,"id"=>$id));
	if($ekle1){
		
		
		
		
		
		
		
		
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong> Fiyat Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
	
	
	
}





if($_GET['islem']=='duzenle'){
	
	
	$gid = $_GET['id'];
	
	$guncelle = $db->query("select * from fiyatlar1 where id='$gid'")->fetch(PDO::FETCH_ASSOC);
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
        <title> Fiyat Ekle | <?=$ayar['site_title']?></title>



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
                                    <h5 class="card-title">Fiyat   Ekle</h5>
                                    
                                      <a href="fiyat-listele1.php"  class="btn btn-primary m-b-md">Fiyat Listele</a>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                               
									<div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sira" placeholder="Fiyat Sırası" value="<?=$guncelle['sira']?>">
                                        <label for="floatingInput">Fiyat Sırası</label>
                                      </div>  
									<div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="Fiyat Kategorisi" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput">Fiyat Kategorisi</label>
                                      </div>  
                                     
									<div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Fiyatı" value="<?=$guncelle['adi']?>">
                                        <label for="floatingInput">Fiyatı</label>
                                      </div>
                                     
                                      
									  
													
                                     <!--      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="onaciklama" placeholder="Fiyat  " value="<?=$guncelle['onaciklama']?>">
                                        <label for="floatingInput">Fiyat  </label>
                                      </div>-->
                                     
                                        
                                      
                                      
                                       
                                      
									  <div class="mb-3">
                                        <label for="formFile" class="form-label">Fiyat İkonu</label>
                                        <input class="form-control" type="file" name="resim" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim']?>" width="200">
                                      </div> 
                                       
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi2" placeholder="Paket İçeriği" value="<?=$guncelle['yazi2']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>
									 
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi3" placeholder="Paket İçeriği" value="<?=$guncelle['yazi3']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>
									  
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi4" placeholder="Paket İçeriği" value="<?=$guncelle['yazi4']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>
									  
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi5" placeholder="Paket İçeriği" value="<?=$guncelle['yazi5']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi6" placeholder="Paket İçeriği" value="<?=$guncelle['yazi6']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>

									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="linki" placeholder="Paket İçeriği" value="<?=$guncelle['linki']?>">
                                        <label for="floatingInput">Paket İçeriği</label>
                                      </div>
									  
									 
									
									  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="buton" placeholder="Button Name" value="<?=$guncelle['buton']?>">
                                        <label for="floatingInput">Button Name</label>
                                      </div>
                                      
                                     
									 
									  <!--
									  <div class="mb-3">
                                 
								 <textarea  class="ckeditor" name="aciklama"  rows="10"><?=$guncelle['aciklama']?></textarea>
						</div>
                                      
                                         !-->
                                       
                                       
                                       
                                
                                      
                                      
                                      
               
                                      
                                      
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