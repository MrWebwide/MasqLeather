<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
    background-size: 100%;
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
        <h1 style="margin-bottom: 20px;">Password Reset</h1>
      
        <div id="gizliForm" style="">
 <form  id="onayForm" action="onay_kodu_kontrol.php" method="post">
            <div class="input-container" style="display: flex; flex-direction: column;">
                <input type="email" name="email" placeholder="E-mail" id="onayEmail" required>
            </div>
           
            <div class="section-2">
           
            
          
                <button class="button2" type="submit" onclick="startCursorProgress(3)" style="--clr:#d67900;" id="onayKoduGonder"><span>Reset</span><i></i></button> 
            <div class="farrow">
                <a href="signin.php">
            <i class="fas fa-arrow-left fa-2x" style="padding-top: 0.5cm; "></i>
        </a>
        </div> 
        </form>
</div>-

        <div id="onayKoduForm" style="display: none;">
    <form id="onayKoduGirForm">
        <div class="row">
            <div class="form-group col-md-12">
                <input type="text" name="onay_kodu" class="form-control" id="onay_kodu" placeholder="Confirmation Code" required>
            </div>
            
            <div class="form-group col-md-12">
                <button class="button2" style="--clr:#d67900;" onclick="startCursorProgress(3)" type="submit" id="onayKoduGir"><span>Verification</span><i></i></button>
            </div>
        </div>
    </form>
</div>

<div id="sifreSifirlaForm" style="display: none;">
    <form id="sifreSifirlaFormInner">
        <div class="row">
            <div class="form-group col-md-12">
                <!-- Yeni şifreyi alacak input alanı -->
                <input type="password" name="yeniSifre" class="form-control" id="yeniSifre" placeholder="New Password" required>
                <!-- Email alanını ekleyelim -->
                <input type="hidden" name="email" id="email" value="">
            </div>
            <div class="form-group col-md-12">
                <button class="button2" style="--clr:#d67900;" type="submit" id="sifreSifirla"><span>Verification</span><i></i></button>
            </div>
        </div>
    </form>
</div>
<script>
// Birinci formu gönderdikten sonra ikinci formu görünür hale getir
document.getElementById("onayForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(event.target);

    fetch(event.target.action, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Onay kodu gönderildiyse, ikinci formu görünür hale getir
            document.getElementById("onayForm").style.display = "none"; // Birinci formu gizle
            document.getElementById("onayKoduForm").style.display = "block"; // İkinci formu görünür hale getir

            // Uyarı mesajını Show
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Hata:", error);
    });
});

document.getElementById("onayKoduGirForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(event.target);

    fetch("onay_kodu_gir.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // İkinci formu gizle
            document.getElementById("onayKoduForm").style.display = "none";

            // Üçüncü formu görünür hale getir
            document.getElementById("sifreSifirlaForm").style.display = "block";

            // Uyarı mesajını Show
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Hata:", error);
    });
});

document.getElementById("sifreSifirlaFormInner").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this); // "this" burada form elementini temsil eder.

    // Formdan email alanını alarak FormData'ya ekleyelim
    var email = document.getElementById("onayEmail").value;
    formData.append("email", email);

    fetch("sifre_sifirla.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            
            // Şifre sıfırlama işlemi başarılıysa, signin.php sayfasına yönlendirme yap
            window.location.href = "signin.php";
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Hata:", error);
    });

});




function startCursorProgress(seconds) {
    // Butona tıklandığında, cursor progress yap
    document.body.style.cursor = 'progress';

    // Belirtilen saniye kadar bekleyip sonra cursor'ı varsayılan yap
    setTimeout(function() {
        document.body.style.cursor = 'default';
    }, seconds * 1000); // Saniyeyi milisaniyeye çevir
}






</script>


       
   
    </div>
</body>
</html>
