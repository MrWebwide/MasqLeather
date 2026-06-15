<?php
include_once("baglan.php");
function oturumkontrolana(){
	 if (empty($_SESSION["eposta"])){
		 echo '<script language="javascript">window.location="login.php";</script>'; die();
	 }
	 
}


date_default_timezone_set('Europe/Istanbul');


$tarih = date("d.m.Y");
$saat = date("H:i");

$yetkiid = $_SESSION['id']; 
$yetkiliogren_stmt = $db->prepare("select * from yonetici where id = ?");
$yetkiliogren_stmt->execute([$yetkiid]);
$yetkiliogren = $yetkiliogren_stmt->fetch(PDO::FETCH_ASSOC); 
$yetki = $yetkiliogren['admin'];

$bakim= $db->query("SELECT * FROM bakim_modu Where id='1'")->fetch(PDO::FETCH_ASSOC);

$yazi= $db->query("SELECT * FROM yazilar Where id='1'")->fetch(PDO::FETCH_ASSOC);
$contactform= $db->query("SELECT * FROM contactform Where id='1'")->fetch(PDO::FETCH_ASSOC);
$baslik= $db->query("SELECT * FROM baslik Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac= $db->query("SELECT * FROM sayac Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac2= $db->query("SELECT * FROM sayac2 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac3= $db->query("SELECT * FROM sayac3 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac4= $db->query("SELECT * FROM sayac4 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac5= $db->query("SELECT * FROM sayac5 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac6= $db->query("SELECT * FROM sayac6 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac7= $db->query("SELECT * FROM sayac7 Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayac8= $db->query("SELECT * FROM sayac8 Where id='1'")->fetch(PDO::FETCH_ASSOC);



$banner= $db->query("SELECT * FROM banner Where id='1'")->fetch(PDO::FETCH_ASSOC);



$ayarlar= $db->query("SELECT * FROM ayarlar Where id='1'")->fetch(PDO::FETCH_ASSOC);

$ayar= $db->query("SELECT * FROM yonetim Where id='1'")->fetch(PDO::FETCH_ASSOC);
$adminizin= $db->query("SELECT * FROM adminizni Where id='1'")->fetch(PDO::FETCH_ASSOC);
$izinler= $db->query("SELECT * FROM izinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
$kullaniciizinler= $db->query("SELECT * FROM kullaniciizinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
$sayfa= $db->query("SELECT * FROM sayfalar Where seo='hakkimizda'")->fetch(PDO::FETCH_ASSOC);
$iletisim= $db->query("SELECT * FROM iletisimbilgileri Where id='1'")->fetch(PDO::FETCH_ASSOC);

$sosyal= $db->query("SELECT * FROM sosyalmedya Where id='1'")->fetch(PDO::FETCH_ASSOC);

$anasayfa= $db->query("SELECT * FROM anasayfa Where id='1'")->fetch(PDO::FETCH_ASSOC);
$cargoprices= $db->query("SELECT * FROM icecek Where id='1'")->fetch(PDO::FETCH_ASSOC);






$campaign= $db->query("SELECT * FROM campaign Where id='1'")->fetch(PDO::FETCH_ASSOC);
$ekstra= $db->query("SELECT * FROM calisma Where id='1'")->fetch(PDO::FETCH_ASSOC);
$altbanner= $db->query("SELECT * FROM kazanc Where id='1'")->fetch(PDO::FETCH_ASSOC);

$smtp=$db->query("select * from mail where id='1'")->fetch(PDO::FETCH_ASSOC);

$facebook = $sosyal['facebook'];
$instagram = $sosyal['instagram'];
$twitter = $sosyal['twitter']; 
$youtube = $sosyal['youtube']; 
$linkedin = $sosyal['telegram']; 


$title = $ayarlar['site_title'];
$description = $ayarlar['site_description'];
$logo = $ayarlar['logo'];
$footerlogo = $ayarlar['footer_logo'];
$favicon  =$ayarlar['favicon'];
$calismasaat = $iletisim['calismasaat'];
$telefon1 = $iletisim['telefon1'];
$telefon2 = $iletisim['telefon2'];
$adres1 = $iletisim['adres1'];
$adres2 = $iletisim['adres2'];
$email1 = $iletisim['email1'];
$email2 = $iletisim['email2'];
$copyright = $ayar['footer_copyright'];
$whatsapp = $iletisim['whatsapp'];
$googlemaps = $iletisim['google_maps'];

$etiketcek= $db->query("SELECT * FROM etiket Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$hizmetcek= $db->query("SELECT * FROM hizmetler Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$hizmetcek6= $db->query("SELECT * FROM hizmetler Where durum='on' order by sira asc limit 6")->fetchAll(PDO::FETCH_ASSOC);
$yorumcek= $db->query("SELECT * FROM yorumlar Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);

$blogcek= $db->query("SELECT * FROM haberler Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$blogcekdesc= $db->query("SELECT * FROM haberler Where durum='on' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
$habercek3= $db->query("SELECT * FROM haberler Where durum='on' order by id desc limit 3")->fetchAll(PDO::FETCH_ASSOC);
$habercek5= $db->query("SELECT * FROM haberler Where durum='on' order by id desc limit 5")->fetchAll(PDO::FETCH_ASSOC);
$sayfacek= $db->query("SELECT * FROM sayfalar Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$ssscek= $db->query("SELECT * FROM sss Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$uruncek= $db->query("SELECT * FROM urunler Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$galericek = $db->query("SELECT * FROM galeri Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$galericek6 = $db->query("SELECT * FROM galeri Where durum='on' order by id desc limit 6")->fetchAll(PDO::FETCH_ASSOC);
$galericekfooter = $galericek6; // MAS-20: galericek6 ile aynı sorgu, tekrar çekme
$istatikcek= $db->query("SELECT * FROM istatik Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);
$kategoricek= $db->query("SELECT * FROM urun_kategori Where durum='on' order by sira asc")->fetchAll(PDO::FETCH_ASSOC);


$stmt = $db->prepare("SELECT * FROM referanslar WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $id = 26;
    $stmt->execute();

    // Sonucu al ve değişkene atama yap
    $refcek = $stmt->fetch(PDO::FETCH_ASSOC);

// MAS-20: 14 ayrı sorgu yerine tek sorgu + sira map (davranış korunur; yoksa false)
$yorumSiraMap = [];
foreach ($db->query("SELECT * FROM yorumlar")->fetchAll(PDO::FETCH_ASSOC) as $yr) {
    $yorumSiraMap[(int) $yr['sira']] = $yr;
}
$yorumcek1  = $yorumSiraMap[1]  ?? false;
$yorumcek2  = $yorumSiraMap[2]  ?? false;
$yorumcek3  = $yorumSiraMap[3]  ?? false;
$yorumcek4  = $yorumSiraMap[4]  ?? false;
$yorumcek5  = $yorumSiraMap[5]  ?? false;
$yorumcek6  = $yorumSiraMap[6]  ?? false;
$yorumcek7  = $yorumSiraMap[7]  ?? false;
$yorumcek8  = $yorumSiraMap[8]  ?? false;
$yorumcek9  = $yorumSiraMap[9]  ?? false;
$yorumcek10 = $yorumSiraMap[10] ?? false;
$yorumcek11 = $yorumSiraMap[11] ?? false;
$yorumcek12 = $yorumSiraMap[12] ?? false;
$yorumcek13 = $yorumSiraMap[13] ?? false;
$yorumcek14 = $yorumSiraMap[14] ?? false;

// MAS-20: 3 ayrı sorgu yerine tek sorgu + sira map
$sliderSiraMap = [];
foreach ($db->query("select * from slider")->fetchAll(PDO::FETCH_ASSOC) as $sr) {
    $sliderSiraMap[(int) $sr['sira']] = $sr;
}
$slider1 = $sliderSiraMap[1] ?? false;
$slider2 = $sliderSiraMap[2] ?? false;
$slider3 = $sliderSiraMap[3] ?? false;





/*
$idd=$hizmetd_dizi["id"];
$ip=$_SERVER["REMOTE_ADDR"];
$sor=$db->query("select * from ip_adresi where ip='$ip' and urun_id='$idd'")->fetch(PDO::FETCH_ASSOC);
	if($sor==false){
		if($sor["urun_id"]!=$hizmetd_dizi["id"]){
		$urun_id=$hizmetd_dizi["id"];
		$query=$db->prepare("insert into ip_adresi set ip = :ip, urun_id = :urun_id, zaman = :zaman");
		$insert=$query->execute(array("ip" =>$ip, "urun_id" =>$urun_id, "zaman" =>$tarih ));	
		
		$hitsayisi=$hizmetd_dizi["hit"]+1;
		
		
		$artir = $db->prepare("UPDATE hizmetler SET
		hit = :hit
		WHERE id = :id");
		$update = $artir->execute(array(
			 "hit" => $hitsayisi,
			 "id" => $id
		));
		}
	}
*/



?>