    <?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();

if(isset($_COOKIE["hatirla"]) && isset($_SESSION["eposta"])){
			header("Location:index.php");
			}

			// burada giriş yapma eylemlerini sırayla gerçekleştiriyoruz

			if (isset($_POST["giris"])) 
			{
			$email_adres  = $_POST["email"];    
				$sifre = $_POST["sifre"];
				$hatirla = $_POST["hatirla"];
				
				if (empty($email_adres) || empty($sifre)) {
              	$bilgi = '<div class="alert alert-error">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Hata !</strong> E-Mail yada Şifre Boş Olamaz.
						   </div>' ;
				}else {
					$query = $db->prepare("SELECT * FROM yonetici WHERE eposta = :eposta");
              		$query->execute(array('eposta' => $email_adres));
              		$result = $query->fetch(PDO::FETCH_ASSOC);	
					
					// Verify password: try bcrypt first, fallback to SHA1 for migration
					$passwordValid = false;
					if ($result) {
						if (password_verify($sifre, $result['sifre'])) {
							$passwordValid = true;
						} elseif ($result['sifre'] === sha1($sifre)) {
							// Old SHA1 hash — migrate to bcrypt
							$passwordValid = true;
							$newHash = password_hash($sifre, PASSWORD_BCRYPT);
							$rehash = $db->prepare("UPDATE yonetici SET sifre = :sifre, normalsifre = '' WHERE id = :id");
							$rehash->execute(array('sifre' => $newHash, 'id' => $result['id']));
						}
					}
					
					if($passwordValid){ 
					$_SESSION["ad_soyad"]  =  $result["ad_soyad"];
					$_SESSION["eposta"] =  $result["eposta"];
					

					$_SESSION["id"]   =  $result["id"];
					
					$id = $result["id"] ;
					
					$update = $db->prepare("UPDATE yonetici SET 
						son_giris 	= :son_giris
						WHERE 
						id 			= :id
					");
					$result = $update->execute(
						array(
							'son_giris'	=>$tarih,
							'id'   		=>$id
						)); 
					
					
					if($hatirla==1)
					{
						setcookie("hatirla",$email_adres,time()+2592000);
					}
					
			
				    $bilgi= "<div style='color:#0f0;'>Giriş Yapıldı. Yönlendiriliyorsunuz..</div>";
		?>			
				
						<meta http-equiv='refresh' content='1;URL=index.php'>
					
					
				


<?php

  }else{
					$bilgi = "<div style='color:#f00;'>Şifreniz Hatalı. </div>" ;
				  }	
									
				}
				
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
        <title>Tekrar Giriş Yap - <?=$ayar['site_title']?></title>
    


        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

      
     
        <link href="assets/css/main.min.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">

    
    </head>
    <body class="login-page" style="background: url(bg/<?=(rand(1,6))?>.jpg) no-repeat center center fixed;   -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover;  background-size: cover;">  
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 col-lg-4">
                    <div class="card login-box-container" style="border: solid 1px;">
                        <div class="card-body">
                            <div class="authent-logo">
                                <img src="../resimler/<?=$ayar['logo']?>" alt="<?=$ayar['site_title']?>" width="100%">
                            </div>
                            <div class="authent-text">
                                <p><?=$ayar['site_title']?></p>
                                <p>Admin Paneli</p>
                                <?=$bilgi?>
                            </div>

                            <form method="post">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                                        <label for="floatingInput">Email Adresiniz</label>
                                      </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword" name="sifre" placeholder="Password">
                                        <label for="floatingPassword">Şifreniz</label>
                                      </div>
                                </div>
                                <div class="mb-3 form-check">
                                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                  <label class="form-check-label" for="exampleCheck1">Beni Hatırla</label>
                                </div>
                                <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs" name="giris">Giriş Yap</button>
                                <p style="text-align:center;font-weight:510;">VEYA</p>
                                 <button class="btn btn-info m-b-xs" ><a href="../">Siteye Geç</a></button>
                            </div>
                              </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
        

        <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="assets/js/main.min.js"></script>
    </body>

</html>