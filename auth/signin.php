<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");



session_start();


function getRedirectURL(){
if(isset($_COOKIE['memet'])) {
    // Cookie'den URL'yi al
    $url = $_COOKIE['memet'];
    
    // URL'yi güvenli hale getir
    $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    
    // HTML içindeki link olarak kullanmak için a etiketi oluştur
    return "$url";
} else {
    echo "Cookie'den URL bulunamadı.";
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-In</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/minty/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
</head>
<body>
    
    <style>
        body {
    font-family: Arial, sans-serif;
    max-width: 100%;
    background-image: url(../assets/shutterstock/deri2.jpeg) !important;
    background-size:cover;
    background-position: center;


    
    
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background-color: #fff;
    border-radius: 15px;
    border: 1px solid #ccc;
    padding: 60px 70px 80px 70px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    margin-top: 0px;
    padding-bottom: 1cm;
    font-family: "Montserrat", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 45px;
    line-height: 20px;
    font-weight: 300;
}

form {
    display: flex;
    flex-direction: column;
}

.input-container {
    margin: 7px 0; /* Tüm input alanları arasında 5px boşluk bırakır */
}

input[type="email"],
input[type="text"],
input[type="password"] {
    margin: 5px 0;
    padding: 15px;
  
    margin-right: 15px; /* Sağa 15px boşluk bırakır */
    margin-left: 15px; /* Sola 15px boşluk bırakır */
    justify-content: center;
    display: flex;
    border: 1px solid #ccc;
    border-radius: 5px;
    
}

label {
    display: inline-block;
    margin-top: 10px;
}



.button2{
    position: relative;
    background: black; /* Arka planı kaldırın veya istediğiniz bir değeri ayarlayın */
    color: white; /* Metin rengini istediğiniz renge ayarlayın */
    text-decoration: none;
    text-transform: uppercase;
    font-size: 1.2em;
    letter-spacing: 0.1em;
    font-weight: 400;
    padding: 20px 40px;
    transition: 0.5s;
    white-space: nowrap;
    margin: 0 auto; /* Butonu yatayda ortala */
    cursor: pointer;
    margin-top: 20px;
    
}
.button2:hover{
    letter-spacing: 0.25em;
    background: var(--clr);
    box-shadow: 0 0 35px var(--clr);
    color: var(--clr);
}
.button2:before{
    content: '';
    position: absolute;
    inset: 2px;
    background: #27282c;
}

.button2 span{
    position: relative;
    z-index: 1;
}

.button2 i{
    position: absolute;
    inset: 0;
    display: block;
}

.button2 i::before{
    content: '';
    position: absolute;
    top: 0;
    left: 80%;
    width: 10px;
    height: 4px;
    background: wheat;
    transform: translateX(-50%) skewX(325deg);
    transition: 0.5s;
}

.button2:hover i::before {
    width: 20px;
    left: 20%;
}

.button2 i::after{
    content: '';
    position: absolute;
    bottom: 0;
    left: 20%;
    width: 10px;
    height: 4px;
    background: wheat;
    transform: translateX(-50%) skewX(325deg);
    transition: 0.5s;
}

.button2:hover i::after  {
    width: 20px;
    left: 80%;
   
}

.section-2{
    display: flex;
    flex-direction: column;
    padding-top: 15px;
    
}

    </style>




     <div class="login-container">
        <h1 style="margin-bottom: 20px;">Log-In</h1>
        <form action="giris.php" method="post" class="php">
        <input type="hidden" name="previous_page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">

            <div class="input-container">
                <input type="email" name="email"  id="email" placeholder="E-mail" required>
            </div>
            <div class="input-container">
                <input type="password" name="sifre"  id="sifre" placeholder="Password" required>
            </div>
            <div class="section-2">
            <label>
                <input type="checkbox" name="remember"> Keep me signed in
            </label>
            <a style="text-decoration: none !important; color: #a36200; padding-top: 15px;" href="forgot.php">Forgot my password</a>
            <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div style="color: red;">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>
            <button type="submit" class="button2" style="--clr:#d67900;" ><span>Log-In</span><i></i></button>
            <a href="signup.php" class="button2" style="--clr:#d67900; font-size: 1.1em; text-decoration:none; "><span>Register</span><i></i></a>  
            <div class="farrow">
                <a href="<?php echo getRedirectURL(); ?>">
            <i class="fas fa-arrow-left fa-2x" style="padding-top: 0.5cm; "></i>
        </a>
        </div> 
        
        </form>
        <!-- Gizli HTML formu -->
<div id="gizliForm" style="display: none;">
    <form id="onayForm" action="onay_kodu_kontrol.php" method="post">
        <div class="row">
            <div class="form-group col-md-12">
                <input type="email" name="email" class="form-control" id="onayEmail" placeholder="E-posta Adresinizi Girin" required>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" id="onayKoduGonder">Onay Kodunu Gönder</button>
            </div>
        </div>
    </form>
</div>

<<div id="onayKoduForm" style="display: none;">
    <form id="onayKoduGirForm">
        <div class="row">
            <div class="form-group col-md-12">
                <input type="text" name="onay_kodu" class="form-control" id="onay_kodu" placeholder="Onay Kodunu Girin" required>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" id="onayKoduGir">Onay Kodunu Gir</button>
            </div>
        </div>
    </form>
</div>

<div id="sifreSifirlaForm" style="display: none;">
    <form id="sifreSifirlaFormInner">
        <div class="row">
            <div class="form-group col-md-12">
                <!-- Yeni şifreyi alacak input alanı -->
                <input type="password" name="yeniSifre" class="form-control" id="yeniSifre" placeholder="Yeni Şifrenizi Girin" required>
                <!-- Email alanını ekleyelim -->
                <input type="hidden" name="email" id="email" value="">
            </div>
            <div class="form-group col-md-12">
                <button type="submit" id="sifreSifirla">Şifreyi Sıfırla</button>
            </div>
        </div>
    </form>
</div>

       
    </div>





   

</body>
</html>
