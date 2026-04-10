<?php
$basePath = '';
require_once __DIR__ . '/includes/init.php';

$pageTitle       = 'Masq Leather - Contact';
$pageDescription = 'Contact us';
$pageKeywords    = '';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<?php include __DIR__ . '/functions/analytics.php'; ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>
<?php include __DIR__ . '/includes/head-css.php'; ?>
<?php include __DIR__ . '/includes/head-js.php'; ?>
    <style>
        #exzoom { width: 400px; }
        .main_menu nav > ul > li > a { color: rgb(245, 245, 245) !important; }
    </style>
</head>
<body>

    <!--offcanvas menu area start-->
    <div class="body_overlay">

    </div>
    <?php include("./layout/header-2.php");?>

    <!-- contact section start -->
    <section class="contact_page_section">

        <div class="contact_page_details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact_info">
                           

                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="contact_form wow fadeInUp text-center" data-wow-delay="0.1s"
                            data-wow-duration="1.1s">
                            <form id="contact-form" method="POST" action="./functions/mailer/contact-form.php">
    <div class="contact_info_title text-center">
        <h3 class="wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">Contact Us</h3>
    </div>
    <div class="form_input_inner d-flex">
        <div class="form_input">
            <select name="title" id="">
                <option value="null">Choose a Title</option>
                <option value="Refund">Refund</option>
                <option value="Question about Product">Question about Product</option>
                <option value="Shipment">Shipment</option>
                <option value="Payment Issues">Payment Issues</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form_input">
            <input name="name" class="border-0" placeholder="Fullname" type="text" required>
        </div>
        <div class="form_input">
            <input name="email" class="border-0" placeholder="Email address" type="text" required>
        </div>
        <input type="hidden" name="senderip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    </div>
    <div class="form_textarea">
        <textarea name="message" class="border-0" placeholder="Write us a message..." required></textarea>
    </div>
    <div class="form_input_btn">
         <div class="recaptcha-container">
            <div class="g-recaptcha" data-sitekey="6LeKXjEnAAAAAHAs0ZHPz4jO4k3YV6aUY5ruh19T"></div>
        </div>
        <button class="btn btn-link">Send message</button>
    </div>
</form>
                            <div id="success" class="success" style="text-align:center">
                            <p class="form-messege" style="font-size:50px; margin-top:50px !important;">Your message has been delivered.</p>
                            <img src="./assets/shutterstock/confirm.png" width="200px" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <style>
    .success {
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
       
        
    }
    .form-messege {
        font-size: 50px;
        margin-top: 50px !important;
        text-align: center;
    }
</style>

                <style>
                    
#contact-form {
    display: block;
}
#contact-form.success {
    display: none;
}

                </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        function filterInput(input) {
            // Zararlı kod içeren karakterleri temizle
            var cleanedInput = input.replace(/<script.*?>.*?<\/script>/gi, ''); // Script etiketlerini kaldır
            cleanedInput = cleanedInput.replace(/<.*?>/gi, ''); // HTML etiketlerini kaldır
            cleanedInput = cleanedInput.replace(/[&<>"']/gi, ''); // Özel HTML karakterlerini kaldır

            return cleanedInput;
        }

        function filterMessage() {
            var selectElement = $('#contact-form select');
            var title = selectElement.val();
            var name = $('#contact-form input[name="name"]').val();
            var email = $('#contact-form input[name="email"]').val();
            var message = $('#contact-form textarea[name="message"]').val();

            // Mesaj uzunluğu kontrolü
var messageLength = message.trim().length;

// Maksimum 300 karakter sınırı kontrolü
if (messageLength > 500) {
    alert('Your message should be at most 500 characters long.');
    return false;
}


            // Yasaklı kelimelerin veya ifadelerin listesi
            var blacklist = ["nigga", "nig", "fuck", "bitch", "ass", "nigger", "faggot", "asshole", "dumb", "retard", "loser", "kys", "kill", "death", "rape", "murder", "pussy", "vagina", "penis", "dick", "virgin", "motherfucker", "mofo", "lame", "fag", "sex", "dildo", "hitler", "balls", "sexy", "idiot"];

            // Mesajı küçük harfe çevirerek, büyük küçük harf duyarlılığını kaldırıyoruz
            var lowercaseMessage = message.toLowerCase();

            // Filtreleme işlemi
            for (var i = 0; i < blacklist.length; i++) {
                if (lowercaseMessage.includes(blacklist[i])) {
                    alert('Blacklisted word detected. Please use appropriate language.');
                    return false; // Eğer yasaklı bir ifade bulunursa formun gönderilmesini engelle
                }
            }

            // Eğer seçilen başlık "Choose a Title" ise formun gönderilmesini engelle
            if (title === 'null') {
                alert('Please choose a title.');
                return false;
            }

            // E-posta adresinin doğru formatta olup olmadığını kontrol etme
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid e-mail address.');
                return false;
            }

            // Eğer herhangi bir doğrulama hatası yoksa formun gönderilmesine izin ver
            return true;
        }

        $('#contact-form').on('submit', function(e){
            e.preventDefault(); // Sayfanın yeniden yüklenmesini önle

            if (filterMessage()) {
                var formData = $(this).serialize(); // Form verilerini al
                $.ajax({
                    type: 'POST',
                    url: './functions/mailer/contact-form.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response){
                        var messageContainer = $('.form-message'); // Mesajları gösteren alanı seç
                        messageContainer.text(response.message); // Yanıt mesajını göster
                        if(response.success){
                            // Eğer başarılı ise formu gizle
                            $('#contact-form').addClass('success');
                            $('#success').css('display', 'flex');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error("İstek sırasında bir hata oluştu: " + error);
                    }
                });
            }
        });
    });
</script>






            </div>
        </div>
    </section>
    <!-- contact section end -->


    <!-- footer section start -->
    <?php include("./layout/footer.php");?>
    <!-- footer section end -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
<?php include __DIR__ . '/includes/product-listing-scripts.php'; ?>
</body>
</html>