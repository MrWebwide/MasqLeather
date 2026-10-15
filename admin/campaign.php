<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();

if($_POST['kaydet']){
	
	$id = 1;
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
	// MAS-112: popup tipi (link | newsletter), popup açıklaması (top bar'dan ayrı), buton metni
	$tur = (($_POST['tur'] ?? '') === 'newsletter') ? 'newsletter' : 'link';
	$popupAciklama = trim($_POST['aciklama'] ?? '');
	$yazi3 = trim($_POST['yazi3'] ?? '');
	$izinliSayfalar = array('', 'bagpurses.php', 'accessories.php', 'homedecor.php', 'jewelry.php');
	if (!in_array($yazi2, $izinliSayfalar, true)) { $yazi2 = ''; }
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
	
	function seflink($string){
$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
$string = strtolower(str_replace($find, $replace, $string));
$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
$string = trim(preg_replace('/\s+/', ' ', $string));
$string = str_replace(' ', '-', $string);
return $string;
}

$seo= seflink($ayarlar['site_title'] ?? 'campaign'); // MAS-77: $site_title tanımsızdı






	$klasor = "resimler/";

	// MAS-77: mevcut kaydi bir kez cek (logo/resim korunmasi icin)
	$ayar_kaydi = $db->query("SELECT * FROM campaign WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
	$logo  = $ayar_kaydi['logo'] ?? '';
	$resim = $ayar_kaydi['resim'] ?? '';

	$resim_tmp = $_FILES['logo']['tmp_name'] ?? '';
	if (!empty($resim_tmp)) {
		$ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
		$izinli = array('jpg','jpeg','png','gif','webp');
		if (in_array($ext, $izinli, true)) {
			if (!empty($ayar_kaydi['logo']) && $ayar_kaydi['logo'] != "resim-yok" && file_exists("resimler/".$ayar_kaydi['logo'])) {
				@unlink("resimler/".$ayar_kaydi['logo']);
			}
			$random = rand(0, 995959999);
			$logo = $random."-".$seo.".".$ext;
			move_uploaded_file($_FILES['logo']['tmp_name'], $klasor."/".$logo);
		} else {
			$bilgi = '<div class="alert alert-error"><strong>Hata!</strong> Lutfen uygun formatta bir resim seciniz ( .jpg .jpeg .png .gif .webp ).</div>';
		}
	}

	// MAS-112: "Remove image" işaretliyse görseli kaldır (newsletter popup görselsiz olabilir)
	if (!empty($_POST['logo_sil']) && empty($resim_tmp)) {
		if (!empty($logo) && file_exists("resimler/".$logo)) { @unlink("resimler/".$logo); }
		$logo = '';
	}

	$ekle  = $db->prepare("update campaign set adi=:adi,sira=:sira,resim=:resim,logo=:logo,kategori=:kategori,durum=:durum,onaciklama=:onaciklama,aciklama=:aciklama,tur=:tur,yazi1=:yazi1,yazi3=:yazi3,yazi2=:yazi2,yazi4=:yazi4 where id=:id");
	
	$simdi = $ekle->execute(array("adi"=>$adi,"sira"=>$sira,"resim"=>$resim,"logo"=>$logo,"kategori"=>$kategori,"durum"=>$durum,"onaciklama"=>$onaciklama,"aciklama"=>$popupAciklama,"tur"=>$tur,"yazi1"=>(string)$yazi1,"yazi3"=>$yazi3,"yazi2"=>$yazi2,"yazi4"=>(string)$yazi4,"id"=>$id));
	
	if($simdi){
		
		$mesaj = "
		
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <strong>Ayarlar Başarıyla Güncellendi!</strong> 
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
		
		";
	}
	
}


$guncelle = $db->query("select * from campaign where id='1'")->fetch(PDO::FETCH_ASSOC);

// Veritabanından durum verisini çek
$query = $db->query("SELECT durum FROM campaign");
$result = $query->fetch(PDO::FETCH_ASSOC);
$durum = $result['durum'];


// Veritabanından durum verisini çek
$query = $db->query("SELECT yazi1 FROM campaign");
$result = $query->fetch(PDO::FETCH_ASSOC);
$yazi1 = $result['yazi1'];
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
        <title>Campaign Set-up - <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">Promo Banner / Homepage Popup</h5>
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                    <form method="post" enctype="multipart/form-data" >
									<div class="toggle">
  <input name="durum" type="checkbox" id="btn">
  <label for="btn">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>
                                    <p class="text-muted mb-3">Homepage popup: shown when a visitor lands on the homepage. Once closed it stays hidden for 1 day (after a newsletter sign-up: 1 year).</p>
<?php
// MAS-112: popup tipi + açıklama (eski kayıtlarda açıklama onaciklama'daydı → fallback)
$popTur = ($guncelle['tur'] ?? '') === 'newsletter' ? 'newsletter' : 'link';
$popAciklama = ($guncelle['aciklama'] ?? '') !== '' ? $guncelle['aciklama'] : ($guncelle['onaciklama'] ?? '');
$popLink = $guncelle['yazi2'] ?? '';
?>
                                    <div class="mb-3">
                                        <h5>Popup Type</h5>
                                        <select class="form-select" name="tur" id="popup-tur">
                                            <option value="link" <?= $popTur === 'link' ? 'selected' : '' ?>>Image banner (links to a category)</option>
                                            <option value="newsletter" <?= $popTur === 'newsletter' ? 'selected' : '' ?>>Newsletter sign-up form (discount)</option>
                                        </select>
                                        <small class="text-muted" id="popup-tur-help-newsletter">Visitors enter their e-mail; they are added to Newsletter Subscribers and receive the discount code set in <a href="newsletter-indirim.php">System &rarr; Newsletter Discount</a>.</small>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="adi" placeholder="Popup Title" value="<?=htmlspecialchars($guncelle['adi'] ?? '')?>">
                                        <label for="floatingInput">Popup Title</label>
                                      </div>

										  <h5>Popup Description</h5>
										<div class=" mb-3">
													 <textarea class="form-control" name="aciklama" rows="4" cols="100"><?=htmlspecialchars($popAciklama)?></textarea>
												 </div>

                                    <div class="form-floating mb-3" id="popup-buton-wrap">
                                        <input type="text" class="form-control" name="yazi3" placeholder="Subscribe" value="<?=htmlspecialchars($guncelle['yazi3'] ?? '')?>">
                                        <label>Button Text (default: Subscribe)</label>
                                    </div>

												 <div class="mb-3" id="popup-link-wrap">
    <h5>Category Redirect</h5>
    <p>(Where the visitor goes when clicking the popup image)</p>
    <select class="form-select"  name="yazi2">
        <option value="" <?= $popLink === '' ? 'selected' : '' ?>>No link</option>
        <option value="bagpurses.php" <?= $popLink === 'bagpurses.php' ? 'selected' : '' ?>>Bags & Purses</option>
		<option value="accessories.php" <?= $popLink === 'accessories.php' ? 'selected' : '' ?>>Accessories</option>
		<option value="homedecor.php" <?= $popLink === 'homedecor.php' ? 'selected' : '' ?>>Home Decor</option>
		<option value="jewelry.php" <?= $popLink === 'jewelry.php' ? 'selected' : '' ?>>Jewelry</option>
    </select>
</div>

<script>
// MAS-112: kategori yönlendirmesi sadece görsel banner tipinde, buton metni sadece newsletter'da
document.addEventListener("DOMContentLoaded", function() {
  var tur = document.getElementById("popup-tur");
  function uygula() {
    var nl = tur.value === "newsletter";
    document.getElementById("popup-link-wrap").style.display = nl ? "none" : "";
    document.getElementById("popup-buton-wrap").style.display = nl ? "" : "none";
    document.getElementById("popup-tur-help-newsletter").style.display = nl ? "" : "none";
  }
  tur.addEventListener("change", uygula);
  uygula();
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

<script>
document.addEventListener("DOMContentLoaded", function() {
  var durum1 = "<?php echo $yazi1; ?>"; // PHP'den JavaScript'e durum verisini aktar

  var checkbox = document.getElementById("btn1");
  if (durum1 === 'on') {
    checkbox.checked = true;
  } else {
    checkbox.checked = false;
  }
});
</script>  
                                      
                                    
                                        <div class="mb-3">
                                        <label for="formFile" class="form-label">Popup Image (optional for the newsletter popup)</label>
                                        <input class="form-control" type="file" name="logo" id="formFile">
                                        
                                         <?php if (!empty($guncelle['logo'])) { ?><img src="resimler/<?=$guncelle['logo']?>" width="100">
                                         <div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="logo_sil" value="1" id="logo_sil"><label class="form-check-label" for="logo_sil">Remove image</label></div><?php } ?>
                                      </div>

                                      <h5>Homepage Top Bar</h5>

                                      <div class="toggle">
  <input name="yazi1" type="checkbox" id="btn1">
  <label for="btn1">
    <span class="track">
      <span class="txt"></span>
    </span>
    <span class="thumb">|||</span>
  </label>
</div>

                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="onaciklama" placeholder="Campaign Title" value="<?=$guncelle['onaciklama']?>">
                                        <label for="floatingInput">Top Bar Text</label>
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