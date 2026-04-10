<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

if($_POST['kaydet']){
	
	$sliderizni = $_POST['sliderizni'];
    $sliderizniiki = $_POST['sliderizniiki'];
    $sliderizniuc = $_POST['sliderizniuc'];
    $slideriznidort = $_POST['slideriznidort'];
    $slideriznibes = $_POST['slideriznibes'];
	$sayfaizni = $_POST['sayfaizni'];
	$emlakizni = $_POST['emlakizni'];
	$varyantizni = $_POST['varyantizni'];
	$haberizni = $_POST['haberizni'];
	$sssizni = $_POST['sssizni'];
	$istatikizni = $_POST['istatikizni'];
	$uyeizni = $_POST['uyeizni'];
	$galeriizni = $_POST['galeriizni'];
	$videoizni = $_POST['videoizni'];
	$ekibimizizni = $_POST['ekibimizizni'];
	$referansizni = $_POST['referansizni'];
	$yorumizni = $_POST['yorumizni'];
	$paytrizni = $_POST['paytrizni'];
	$iyzicoizni = $_POST['iyzicoizni'];
	$mailizni = $_POST['mailizni'];
	$hizmetizni = $_POST['hizmetizni'];
	$yoneticiizni = $_POST['yoneticiizni'];
	$iletisimizni = $_POST['iletisimizni'];
	$siteyonetimizni = $_POST['siteyonetimizni'];
	$bakimmoduizni = $_POST['bakimmoduizni'];
	$dilizni = $_POST['dilizni'];
	$urunizni = $_POST['urunizni'];
	$kategoriizni = $_POST['kategoriizni'];
	$telefoniconizni = $_POST['telefoniconizni'];
	$whatsappiconizni = $_POST['whatsappiconizni'];
	$medyaizni = $_POST['medyaizni'];
	$id = 1;
	
	
	
	$ekle  = $db->prepare("update izinler set sliderizni=:sliderizni,sliderizniiki=:sliderizniiki,sliderizniuc=:sliderizniuc,slideriznidort=:slideriznidort,slideriznibes=:slideriznibes,telefoniconizni=:telefoniconizni,whatsappiconizni=:whatsappiconizni,kategoriizni=:kategoriizni,sayfaizni=:sayfaizni,emlakizni=:emlakizni,hizmetizni=:hizmetizni,medyaizni=:medyaizni,yoneticiizni=:yoneticiizni,iletisimizni=:iletisimizni,siteyonetimizni=:siteyonetimizni,bakimmoduizni=:bakimmoduizni,varyantizni=:varyantizni,haberizni=:haberizni,sssizni=:sssizni,istatikizni=:istatikizni,uyeizni=:uyeizni,galeriizni=:galeriizni,videoizni=:videoizni,ekibimizizni=:ekibimizizni,referansizni=:referansizni,yorumizni=:yorumizni,paytrizni=:paytrizni,iyzicoizni=:iyzicoizni,mailizni=:mailizni,dilizni=:dilizni,urunizni=:urunizni where id=:id");
	
	$simdi = $ekle->execute(array("sliderizni"=>$sliderizni,"sliderizniiki"=>$sliderizniiki,"sliderizniuc"=>$sliderizniuc,"slideriznidort"=>$slideriznidort,"slideriznibes"=>$slideriznibes,"kategoriizni"=>$kategoriizni,"telefoniconizni"=>$telefoniconizni,"whatsappiconizni"=>$whatsappiconizni,"sayfaizni"=>$sayfaizni,"emlakizni"=>$emlakizni,"hizmetizni"=>$hizmetizni,"medyaizni"=>$medyaizni,"yoneticiizni"=>$yoneticiizni,"iletisimizni"=>$iletisimizni,"siteyonetimizni"=>$siteyonetimizni,"bakimmoduizni"=>$bakimmoduizni,"varyantizni"=>$varyantizni,"haberizni"=>$haberizni,"sssizni"=>$sssizni,"istatikizni"=>$istatikizni,"uyeizni"=>$uyeizni,"galeriizni"=>$galeriizni,"videoizni"=>$videoizni,"ekibimizizni"=>$ekibimizizni,"referansizni"=>$referansizni,"yorumizni"=>$yorumizni,"paytrizni"=>$paytrizni,"iyzicoizni"=>$iyzicoizni,"mailizni"=>$mailizni,"dilizni"=>$dilizni,"urunizni"=>$urunizni,"id"=>$id));
	
	if($simdi){
		
		$mesaj = "
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>İzinler Başarıyla Güncellendi!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
	}
	
}

$guncelle = $db->query("select * from izinler where id='1'")->fetch(PDO::FETCH_ASSOC);



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
        <title>İzinler - <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">İzinler</h5>
                                    <p class="card-description">Processler Sadece Panelde Geçerli Olacaktır !</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
                                    
                                    <div class="row">
                                        
                                     <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Slider İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="sliderizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['sliderizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>    

                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">2.Slider İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="sliderizniiki" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['sliderizniiki']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>    

                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">3.Slider İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="sliderizniuc" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['sliderizniuc']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>   
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">4.Slider İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="slideriznidort" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['slideriznidort']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>   

                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">5.Slider İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="slideriznibes" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['slideriznibes']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>   
                                      
                                        <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Sayfa İzni</h5>
                                                     <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                        <input class="form-check-input" name="sayfaizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                         <?php if($guncelle['sayfaizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                        
                                       <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Ürünler İzni</h5>
                                               <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="urunizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['urunizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      
                                       <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Kategori İzni</h5>
                                               <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="kategoriizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['kategoriizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      
                                     
                                     <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Varyant İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="varyantizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['varyantizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                    
                                     <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Haber İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="haberizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                         <?php if($guncelle['haberizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">SSS İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="sssizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['sssizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Medya İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="medyaizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['medyaizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Hizmet İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="hizmetizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['hizmetizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">İstatik İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="istatikizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['istatikizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Üye İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="uyeizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['uyeizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Galeri İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="galeriizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                         <?php if($guncelle['galeriizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Yorum İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="yorumizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['yorumizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Video İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="videoizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['videoizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Ekibimiz İzni</h5>
                                               <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="ekibimizizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['ekibimizizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                    
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Refarans İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="referansizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                       <?php if($guncelle['referansizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                   
                                   
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Emlak İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="emlakizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                         <?php if($guncelle['emlakizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                     
                                      
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Paytr İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="paytrizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['paytrizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">İyzico İzni</h5>
                                                 <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="iyzicoizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['iyzicoizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Mail Ayarları İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="mailizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['mailizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Yönetici İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="yoneticiizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['yoneticiizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">İletişim İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="iletisimizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['iletisimizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Site Yönetimi İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="siteyonetimizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['siteyonetimizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                       <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Bakım Modu İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="bakimmoduizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['bakimmoduizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                    
                                     <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Dil İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="dilizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['dilizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                      
                                       <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Whatsapp İcon İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="whatsappiconizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['whatsappiconizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                        <div class="card stat-widget">
                                            <div class="card-body">
                                                <h5 class="card-title">Telefon İcon İzni</h5>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="telefoniconizni" type="checkbox" id="flexSwitchCheckChecked" 
                                                        <?php if($guncelle['telefoniconizni']=='on'){ ?> checked <?php } ?> >
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Show</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                      </div>
                                      
                                     
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