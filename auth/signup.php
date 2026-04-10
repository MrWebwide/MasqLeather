<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT unqid FROM uyeler ORDER BY unqid DESC LIMIT 1";
$stmt = $db->query($sql);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$last_unqid = $row["unqid"];

$new_unqid = $last_unqid + 1 ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZEP4PW1YH0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZEP4PW1YH0');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/minty/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    max-width: 100%;
    background-image: url(../assets/shutterstock/deri2.jpeg) !important;
    background-size: cover;
    background-position: center;
    
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container2 {
    background-color: #fff;
    border-radius: 15px;
    border: 1px solid #ccc;
    padding: 60px 10px 80px 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 450px;
}

h1 {
    margin-top: 0px;
    padding-bottom: 1cm;
    
    font-size: 45px;
}

form {
    display: flex;
    flex-direction: column;
}

.input-container {
    margin: 7px 0; /* Tüm input alanları arasında 5px boşluk bırakır */
}
input[type="text"],
input[type="name"],
input[type="email"],
.passwrd {
    margin: 5px 0;
    padding: 15px;
  
    margin-right: 15px; /* Sağa 15px boşluk bırakır */
    margin-left: 15px; /* Sola 15px boşluk bırakır */
    justify-content: center;
 
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




     <div class="login-container2">
        <h1 style="margin-bottom: 20px;"> Register</h1>
       
    <!-- Birinci Form Başlangıcı -->
<form class="password-strength form p-4" action="form.php" method="post" role="form" id="ilk_form">

<input type="hidden" name="unqid" value="<?=$new_unqid?>">
<div class="input-container">
                <input type="text" name="adsoyad" id="adsoyad" placeholder="Name-Surname" required>
               
            </div>

<div class="input-container">
        <input type="email" name="email" id="email" placeholder="E-mail" required>
    </div>
    <input type="hidden" name="resim" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">


    <div class="content">
        <div class="content__inner">
            <div class="form-group">
                <div class="input-group">
                    <input class="password-strength__input form-control" type="password" name="sifre" id="sifre" placeholder="Password:"
                        aria-describedby="passwordHelp" required>
                    <div class="input-group-append">
                        <button class="password-strength__visibility btn btn-outline-secondary" type="button"><span
                                class="password-strength__visibility-icon" data-visible="hidden"><i
                                    class="fas fa-eye-slash"></i></span><span class="password-strength__visibility-icon js-hidden"
                                data-visible="visible"><i class="fas fa-eye"></i></span></button>
                    </div>
                </div>
                <small class="password-strength__error text-danger js-hidden">This symbol cannot be used!</small>
                <small class="form-text text-muted mt-2" id="passwordHelp">Your password should contain at least 8 characters, including lowercase and uppercase letters, numbers, and special symbols to provide a high level of security.</small>
            </div>
            <div class="password-strength__bar-block progress mb-4">
                <div class="password-strength__bar progress-bar bg-danger" role="progressbar" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <style>
    .row {
        display: grid;
        place-items: center; /* Yatay ve dikey olarak ortala */
    }
</style>
        <div class="row">
    <div class="g-recaptcha " data-sitekey="6LeKXjEnAAAAAHAs0ZHPz4jO4k3YV6aUY5ruh19T"></div>
    </div>
    <div class="section-2">
        <input type="hidden" name="submit" value="1">
        <button class="button2" type="submit" onclick="startCursorProgress(3)" id="ilkbuton" style="--clr:#d67900; font-size: 1.1em;"><span>Register</span><i></i></button>
        <div class="farrow">
            <a href="signin.php">
                <i class="fas fa-arrow-left fa-2x" style="padding-top: 0.5cm;"></i>
            </a>
        </div>
    </div>
</form>
<!-- Birinci Form Sonu -->
<!-- İkinci Form Başlangıcı (ilk başta görünmez olacak) -->
<form action="onay.php" method="post" role="form" id="ikinci_form" style="display: none;">
    <div class="form-group col-md-12">
        <input type="text" name="onay_kodu" class="form-control" id="onay_kodu" placeholder="Code:" required>
        <div id="sayaç" class="sayaç-container">Remaining time: <span id="counter">120</span></div>
    </div>
    <div id="message-container">
                                            <!-- AJAX ile güncellenecek alan -->
                                        </div>
    <div class="text-center">
        <button class="button2" onclick="startCursorProgress(3)" style="--clr:#d67900; font-size: 1.1em;" type="submit"><span class="iki">Validate</span></button>
    </div>
</form>

<!-- İkinci Form Sonu -->

<style>

#message-container p{
    color:red;
    font-weight:700;

}


</style>

<script>
    // İkinci form Showildiğinde sayaçı başlatın
    let timer;
let timeout;

function startCounter() {
    let count = 120;
    const counterElement = document.getElementById('counter');

    // Bekleme süresini başlat
    timeout = setTimeout(function () {
        const ikinciForm = document.getElementById('ikinci_form');
        ikinciForm.style.display = 'none';
        deleteMember(memberId);
    }, 120000);

    // Geri sayımı başlatan zamanlayıcı
    timer = setInterval(function () {
        counterElement.textContent = count + "seconds";

        count--;

        // Sayacın sıfıra ulaştığında işlemleri yapın
        if (count < 0) {
            clearInterval(timer);
            clearTimeout(timeout); // Beklemeyi temizle
        }
    }, 1000);
}


    // İlk formu seçelim
    const ilkForm = document.getElementById('ilk_form');

    ilkForm.addEventListener('submit', function (event) {
        event.preventDefault();

        fetch(ilkForm.action, {
            method: 'POST',
            body: new URLSearchParams(new FormData(ilkForm))
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.show_second_form) {
    const ikinciForm = document.getElementById('ikinci_form');
    ikinciForm.style.display = 'block';

    const memberId = data.member_id;
    startCounter(); // Sayacı başlat

    // 20 saniye sonra işlem yapılacak
    timeout = setTimeout(function () {
        deleteMember(memberId);
    }, 120000);


    const ilkButon = document.getElementById('ilkbuton');
                    ilkButon.style.display = 'none';

}

                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Form işleminde hata oluştu: ', error);
            });
    });

    function deleteMember(memberId) {
        $.ajax({
            type: "POST",
            url: "delete_member.php",
            data: { member_id: memberId },
            success: function (response) {
                alert("Your registration has been deleted due to not entering the confirmation code within the specified time. Please register again.");
                window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Üye silme işleminde hata oluştu: " + errorThrown);
            }
        });
    }

    $("input[name='onay_kodu']").on("input", function () {
        clearTimeout(timer);
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
    </div>


 <!-- partial -->
 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js'></script>
 <script src="../assets/js/psswrdplug-in.js"></script>
 <script src="../assets/js/ajax.js"></script>


</body>
</html>
