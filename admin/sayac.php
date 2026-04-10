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
	
	
	
$klasor="resimler/";
	

	
    	$resim_tmp3 = $_FILES['resim4']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim4 = $ayar_kaydi['resim4'];
	}
	else
	{
		if ($_FILES["resim4"]["type"] =="image/gif" || $_FILES["resim4"]["type"] =="image/png"|| $_FILES["resim4"]["type"] =="image/jpg"|| $_FILES["resim4"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim4']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim4']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim4 = $random."-".$seo.".".substr($_FILES['resim4']['name'], -3);
			
			move_uploaded_file($_FILES['resim4']['tmp_name'],$klasor."/".$resim4);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 
	
  $resim_tmp3 = $_FILES['resim3']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim3 = $ayar_kaydi['resim3'];
	}
	else
	{
		if ($_FILES["resim3"]["type"] =="image/gif" || $_FILES["resim3"]["type"] =="image/png"|| $_FILES["resim3"]["type"] =="image/jpg"|| $_FILES["resim3"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim3']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim3']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim3 = $random."-".$seo.".".substr($_FILES['resim3']['name'], -3);
			
			move_uploaded_file($_FILES['resim3']['tmp_name'],$klasor."/".$resim3);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 

  $resim_tmp3 = $_FILES['resim2']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim2 = $ayar_kaydi['resim2'];
	}
	else
	{
		if ($_FILES["resim2"]["type"] =="image/gif" || $_FILES["resim2"]["type"] =="image/png"|| $_FILES["resim2"]["type"] =="image/jpg"|| $_FILES["resim2"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim2']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim2']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim2 = $random."-".$seo.".".substr($_FILES['resim2']['name'], -3);
			
			move_uploaded_file($_FILES['resim2']['tmp_name'],$klasor."/".$resim2);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 

  $resim_tmp3 = $_FILES['resim1']['tmp_name'];
	
	if(empty($resim_tmp3))
	{
		$duzenlenecek_id = 1;
		$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
		$resim1 = $ayar_kaydi['resim1'];
	}
	else
	{
		if ($_FILES["resim1"]["type"] =="image/gif" || $_FILES["resim1"]["type"] =="image/png"|| $_FILES["resim1"]["type"] =="image/jpg"|| $_FILES["resim1"]["type"] =="image/jpeg") 
		{
			
			$ayar_kaydi = $db->query("SELECT * FROM sucuk WHERE id = '$duzenlenecek_id'")->fetch(PDO::FETCH_ASSOC);
  			if($ayar_kaydi['resim1']!="resim-yok")
			{
			  unlink("resimler/".$ayar_kaydi['resim1']);	  
			}
			
			$random = rand(0,995959999);
			
			$resim1 = $random."-".$seo.".".substr($_FILES['resim1']['name'], -3);
			
			move_uploaded_file($_FILES['resim1']['tmp_name'],$klasor."/".$resim1);
		}
		else
		{
			$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> Lütfen  Uygun Formatta Bir Resim Dosyası Seçiniz ( .jpg - .gif - .png ).
			</div>';
		}
	} 
      
	  
	  
	 $simdi = $db->prepare("update sucuk set yazi1=:yazi1,sayi1=:sayi1,icon1=:icon1,yazi2=:yazi2,sayi2=:sayi2,icon2=:icon2,yazi3=:yazi3,sayi3=:sayi3,icon3=:icon3,yazi4=:yazi4,yazi5=:yazi5,yazi6=:yazi6,yazi7=:yazi7,yazi8=:yazi8,yazi9=:yazi9,sayi4=:sayi4,icon4=:icon4,resim4=:resim4,resim3=:resim3,resim2=:resim2,resim1=:resim1");
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







	
	$guncelle = $db->query("select * from sucuk where id='1'")->fetch(PDO::FETCH_ASSOC);





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
                                    <h5 class="card-title">Security Options</h5>
                                    
                                    <p class="card-description">Please fill all of the available spaces.</p>
                                    <?=$mesaj?>
                                        
                                    
                                     
                                     <!--  <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> -->
                                      
                                      <style>
        .ip-container {
            position: relative;
        }
        .ip-input {
            width: 100%;
            padding-right: 40px; /* Noktaların sağında yeterli boşluk bırakmak için */
            font-size: 1rem;
            text-align: center;
        }
        .dot {
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            margin-right: 10px;
        }
        .dot:nth-of-type(2) {
            right: 0;
        }
        .dot:nth-of-type(3) {
            right: 80px;
        }
        .dot:nth-of-type(4) {
            right: 160px;
        }
    </style>
</head>
<body>
<?php
// IP adresini eklemek için kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ip_address = $_POST['IP'];

  // IP adresini veritabanına ekle
  if (!empty($ip_address)) {
      $stmt = $db->prepare("INSERT INTO ip (IP) VALUES (:ip)");
      $stmt->bindParam(':ip', $ip_address);

      if ($stmt->execute()) {
          echo "IP adresi başarıyla eklendi.";
      } else {
          echo "Hata: " . $stmt->errorInfo()[2];
      }
  }
}

// Bloklanmış IP'leri çek
$sql = "SELECT IP FROM ip";
$stmt = $db->query($sql);

$blocked_ips = [];
if ($stmt) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $blocked_ips[] = htmlspecialchars($row['IP']);
  }
}



?>

<div class="mb-3">
        <h3>Bloklanmış IP'ler:</h3>
        <?php if (!empty($blocked_ips)): ?>
            <ul class="list-group">
                <?php foreach ($blocked_ips as $ip): ?>
                    <li class="list-group-item position-relative">
                        <?= htmlspecialchars($ip) ?>
                        <a href="delete_ip.php?delete_ip=<?= urlencode($ip) ?>" class="delete-button">&times;</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Henüz bloklanmış IP yok.</p>
        <?php endif; ?>
    </div>
    
    <div class="form-floating mb-3">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="ipAddress">Bloklanacak IP Adresi</label>
            <div class="ip-container">
                <input type="text" id="ipAddress" name="IP" class="form-control ip-input" placeholder="IP Adresi" onkeydown="allowOnlyNumbersAndDots(event)" maxlength="15" oninput="formatIP(this)">
              
            </div>
            <button type="submit" class="btn btn-primary mt-2">Ekle</button>
        </form>
    </div>

<script>
    function formatIP(input) {
        let formattedValue = '';

        // Bölümleri kontrol edin
        const parts = [];
        for (let i = 0; i < value.length; i += 3) {
            let part = value.substring(i, i + 3);
            if (parseInt(part, 10) > 255) {
                part = '255';
            }
            parts.push(part);
        }

        // Tekrar formatla
        formattedValue = parts.join('.');

        if (formattedValue.length > 15) {
            formattedValue = formattedValue.substring(0, 15); // Maksimum uzunluğu 15 karaktere sınırla
        }

        input.value = formattedValue;

        // Kontrol ve geçişler
        if (parts.length > 4) {
            input.value = parts.slice(0, 4).join('.');
            input.setSelectionRange(input.value.length, input.value.length); // İmleci sonuna koy
        }
    }

    function allowOnlyNumbersAndDots(event) {
        const key = event.key;
        // Rakamlar ve noktalara izin ver
        if (!/[0-9.]|\bBackspace\b|Tab/.test(key)) {
            event.preventDefault(); // Diğer tuşlara izin verme
        }
    }
</script>

<form method="post" enctype="multipart/form-data" >

                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="yazi1" placeholder="İçerik" value="<?=$guncelle['yazi1']?>">
                                        <label for="floatingInput">İçerik</label>
                                      </div> 
                                      
                                     <!--   <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim4" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim4']?>" width="200">
                                      </div>

                                            <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="icon1" placeholder="İcon 1" value="<?=$guncelle['icon1']?>">
                                        <label for="floatingInput">İcon 1</label>
                                      </div> -->
                                      
                                        <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="sayi2" placeholder="Başlık" value="<?=$guncelle['sayi2']?>">
                                        <label for="floatingInput">Başlık</label>
                                      </div> 
                                      
                                    
                                        <!-- <div class="mb-3">
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

-->

                                       <!--
                                      
                                      
                                       <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim2" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim2']?>" width="200">
                                      </div>

                                           <div class="mb-3">
                                        <label for="formFile" class="form-label">Hizmet İkonu</label>
                                        <input class="form-control" type="file" name="resim1" id="formFile">
                                        
                                         <img src="resimler/<?=$guncelle['resim1']?>" width="200">
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

                <style>
                    .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: red;
            font-size: 24px; /* Çarpı işaretinin boyutunu arttır */
            font-weight: bold;
        }
                </style>
              
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