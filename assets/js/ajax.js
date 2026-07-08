//AJAX// UNIFIED COMMENT FORM (all product categories)

$(document).ready(function() {
    $("[id^='comment-form']").submit(function(e) {
        e.preventDefault();
        var $form = $(this);
        var author = $form.find("input[name='author']").val();
        var email = $form.find("input[name='email']").val();
        var comment = $form.find("textarea[name='comment']").val();
        var yorumid = $form.find("#yorumid").val() || $("#yorumid").val();
        var tur = $form.data("tur") || $form.find("input[name='tur']").val();

        $.ajax({
            type: "POST",
            url: "functions/add-comment.php",
            data: {
                author: author,
                email: email,
                comment: comment,
                yorumid: yorumid,
                tur: tur
            },
            success: function(response) {
                $("#message-container").html(response);
            }
        });
    });
});

//AJAX// ADD TO CART

$(document).ready(function() {
    var subTotal = 0; // Toplam fiyatı saklamak için değişkeni tanımlayın

    $(".add-to-cart").click(function(e) {
        e.preventDefault(); // Default behavior engellenmesi

        var form = $(this).closest("form"); // Formu bulmak için en yakın formu seçin
        var productId = form.find("input[name='productId']").val();
        var productName = form.find("input[name='productName']").val();
        var productPrice = parseFloat(form.find("input[name='productPrice']").val()); // Fiyatı sayıya dönüştürün
        var productQuantity = parseInt(form.find("input[name='productQuantity']").val()); // Miktarı tam sayıya dönüştürün
        var productImage = form.find("input[name='productImage']").val();
        var productCategory = form.find("input[name='productCategory']").val();
        var productCargo = form.find("input[name='productCargo']").val();
        var productCargos = form.find("input[name='productCargos']").val();
        var producttur = form.find("input[name='producttur']").val();

        // MAS-46: yapılandırılabilir selector seçimlerini topla + zorunlu doğrulama
        var secim = {};
        var eksik = false;
        form.find("select.masq-option-select").each(function() {
            var name = $(this).attr("name") || "";
            var m = name.match(/secim\[(\d+)\]/);
            if (!m) return;
            var val = $(this).val();
            if ($(this).prop("required") && (!val || val === "")) {
                eksik = true;
                $(this).css("border-color", "#c0392b");
            } else {
                $(this).css("border-color", "");
            }
            if (val) { secim[m[1]] = val; }
        });
        if (eksik) {
            alert("Lütfen zorunlu seçenekleri seçiniz.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "functions/addToCart.php",
            data: {
                productId: productId,
                productName: productName,
                productPrice: productPrice,
                productQuantity: productQuantity,
                productImage: productImage,
                productCategory: productCategory,
                productCargo: productCargo,
                productCargos: productCargos,
                producttur:producttur,
                secim: secim, // MAS-46: {option_id: value_id}
                addToCart: 1 // Bu alanın eklenmesi önemlidir, AJAX işleminin çalışmasını sağlar
            },
            success: function(response) {
                // Sepet içeriğini güncelleyin
                $("#mini-cart").html(response);

                // Toplam fiyatı güncelleyin
                subTotal += productPrice * productQuantity;

                // Sadece en son eklenen ürünün altında sub total'i Showin
                $("#subTotal .price").text('$' + subTotal.toFixed(2));
            },
            // MAS-106: eskiden error handler YOKTU → AJAX sessizce başarısız olunca (mobilde
            // zayıf bağlantı/oturum) ürün eklenmediği halde animasyon "eklendi" gibi görünüyordu.
            // Artık başarısızlık kullanıcıya bildirilir.
            error: function() {
                alert('The product could not be added to your cart. Please check your connection and try again.');
            }
        });
    });
});


/* AJAX SHIPPING CALCULATION BU KISIM İPTAL

$(document).ready(function() {
    $("#country").on("change", function() {
        if ($(this).val() === "2") {
            $.ajax({
                url: "functions/calculate_shipping_canada.php",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#shipping_id").text("$" + data.maxCargo);
                    $("#cargo_transfer").val(data.maxCargo);
                    $("#order_id").text("$" + data.totalAmount.toFixed(2));
                },
                error: function() {
                    // Hata işleme kodunu buraya ekleyin
                }
            });
        } else if ($(this).val() === "3") { // Burada "else if" kullanılır.
            $.ajax({
                url: "functions/calculate_shipping_us.php",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#shipping_id").text("$" + data.maxCargo);
                    $("#cargo_transfer").val(data.maxCargo);
                    $("#order_id").text("$" + data.totalAmount.toFixed(2));
                },
                error: function() {
                    // Hata işleme kodunu buraya ekleyin
                }
            });
        }else if ($(this).val() === "1") {
            // "1" seçildiğinde her iki değeri de 0 olarak ayarla
            $("#shipping_id").text("$0");
            $("#order_id").text("$0.00");
        }
    });
});
*/
//AJAX// SIGN-UP IKINCI FORM SISTEMI

$(document).ready(function(){
    $('#ikinci_form').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'onay.php',
            data: formData,
            success: function(response){
                $('#message-container').html(response);
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });
});





//AJAX// COUPON SISTEMI

$(document).ready(function(){
    $('#couponf').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'functions/cupon.php',
            data: formData,
            success: function(response){
                $('#message-container').html(response);
                if (response.indexOf("Invalid Coupon Code") !== -1 || response.indexOf("This coupon was used before") !== -1) {
                    // Eğer geçersiz bir kupon kodu veya daha önce kullanılmış bir kupon koduysa
                    // sayfa yeniden yüklenmeyecek, sadece hata mesajı gösterilecek
                    return;
                }
                // Eğer geçerli bir kupon koduysa yönlendirme yap
                // Ekranı temizle
$('body').empty();

                window.location.href = "./cart.php";
            },
        });
    });
});



//ITEM SİLME İŞLEMİ//


$(document).ready(function() {
    var subTotal = 0;

    function updateSubtotal() {
        $(".cart_total span.price").text("$" + subTotal.toFixed(2));
    }

    $(".delete_item").on("click", function(event) {
        event.preventDefault();
        
        var productId = $(this).data("product-id");
        var productCategory = $(this).data("product-category");
        var productPrice = $(this).data("product-price");
        var productQuantity = $(this).data("product-quantity");

        $.ajax({
            url: "functions/delete_product.php",
            method: "POST",
            data: { productId: productId, productCategory: productCategory, productPrice: productPrice, productQuantity: productQuantity },
            success: function(data) {
                if (data === "success") {
                    $(".cart_item[data-product-id='" + productId + "'][data-product-category='" + productCategory + "']").remove();

                    // Toplam fiyatı güncelleyin
                    subTotal = calculateRemainingTotal();

                    // Ekrandaki toplamı güncelleyin
                    updateSubtotal();
                }
                else if (data === "empty") {
                    $(".cart_item").remove();
                    $("#mini-cart").html("Your cart is empty.");
                }
            }
        });
    });

    // Kalan ürünlerin toplam fiyatını hesaplayan fonksiyon
    function calculateRemainingTotal() {
        var total = 0;
        $(".cart_item").each(function() {
            var price = parseFloat($(this).find(".cart_info p span").text().replace("$", ""));
            var quantity = parseFloat($(this).find(".cart_info p").text().split(' x ')[0]);
            total += price * quantity;
        });
        return total;
    }
});




//CART DOSYASI İÇİN İTEM SİLME İŞLEMİ//

$(document).ready(function() {
    
    // Sayfa yüklendiğinde çalışacak kod
    checkCart();

    // Sepette ürün olup olmadığını kontrol etmek için fonksiyon
    function checkCart() {
        $.ajax({
            url: "functions/calculate_total_price.php",
            method: "GET",
            success: function(data) {
                var responseData = JSON.parse(data);
                
            },
            error: function(xhr, status, error) {
                console.error("AJAX isteği başarısız oldu:", error);
            }
        });
    }

    // Checkout butonuna tıklama olayı
    $("#checkoutButton").on("click", function(event) {
        event.preventDefault();
        checkCart(); // Butona her tıklamada sepette ürün kontrolü yap
    });

    // Ürün silme işlemi
    $(".delete_item_cart").on("click", function(event) {
        event.preventDefault();
        
        var productId = $(this).data("product-id");
        var productCategory = $(this).data("product-category");
        var productPrice = $(this).data("product-price");
        var productQuantity = $(this).data("product-quantity");
        var parentRow = $(this).closest("tr");
        
        // Tabloda sadece 1 ürün varsa ve bu ürünü siliyorsak tabloyu tamamen kaldır
        if ($("tbody tr").length === 1) {
            parentRow.closest("tbody").remove();
            // Tablo boşaltıldığında sepette ürün kontrolü yap
            checkCart();
        } else {
            $.ajax({
                url: "functions/delete_product.php",
                method: "POST",
                data: { productId: productId, productCategory: productCategory, productPrice: productPrice, productQuantity: productQuantity },
                success: function(data) {
                    if (data === "success") {
                        parentRow.remove();
                        // Ürün silindiğinde sepette ürün kontrolü yap
                        checkCart();
                    }
                }
            });
        }
        
        // Tablonun içindeki tbody kaybolduysa (tablo boşaldıysa), butonu kaldır
        if ($("tbody").length === 0) {
            $("#checkoutButton").remove();
        }
    });
});




//CART DOSYASI İÇİN FİYAT HESAPLAMA İŞLEMİ//

$(document).ready(function() {
    $(".delete_item_cart").on("click", function(event) {
        event.preventDefault();
        
        var productId = $(this).data("product-id");
        var productCategory = $(this).data("product-category");
        var productPrice = $(this).data("product-price");
        var productQuantity = $(this).data("product-quantity");
        var parentRow = $(this).closest("tr");
        
        // Tabloda sadece 1 ürün varsa ve bu ürünü siliyorsak tabloyu tamamen kaldır
        if ($("tbody tr").length === 1) {
            parentRow.closest("tbody").remove();
            $(".total-amount").text("$0"); // Tüm ürünler silindiğinde total fiyatı sıfırla
        } else {
            $.ajax({
                url: "functions/delete_product.php",
                method: "POST",
                data: { productId: productId, productCategory: productCategory, productPrice: productPrice, productQuantity: productQuantity },
                success: function(data) {
                    if (data === "success") {
                        parentRow.remove();
                        // Silme işlemi başarılıysa, kalan ürünlerin toplam fiyatını güncelle
                        updateTotalPrice();
                    } else {
                        if ($("tbody tr").length === 0) {
                            $("#message-container3").html("This cart is empty.").css({
                                "padding-top": "2cm",
                                "padding-bottom": "2cm",
                                "text-align":"center"
                            });
                            $(".total-amount").text("$0"); // Tüm ürünler silindiğinde total fiyatı sıfırla
                            $(".sub-amount").text("$0"); // Tüm ürünler silindiğinde total fiyatı sıfırla
                        }
                    }
                }
            });
        }
    });
    
    // Kalan ürünlerin toplam fiyatını güncelleyen fonksiyon
    function updateTotalPrice() {
        $.ajax({
            url: "functions/calculate_total_price.php",
            method: "GET",
            success: function(data) {
                // Dönen verileri JSON olarak alınan string formatından bir objeye dönüştürün
                var responseData = JSON.parse(data);
                
                // totalAmount ve totalPrice değerlerini alarak HTML elementlerine yazın
                $(".total-amount").text("$" + responseData.totalAmount);
                $(".sub-amount").text("$" + responseData.totalPrice);
            },
            error: function(xhr, status, error) {
                // İsteğin başarısız olduğu durumda bir hata mesajı yazdırın
                console.error("AJAX isteği başarısız oldu:", error);
            }
        });
    }
    
    
});




//CART DOSYASINDAKİ TÜM İTEMLERİ SİLME//


$(document).ready(function() {
    $(".delete_item_cart_all").on("click", function(event) {
        event.preventDefault();
        
        $.ajax({
            url: "functions/delete_all_product.php",
            method: "POST",
            success: function(data) {
                if (data === "success") {
                    $("tbody").empty();
                    $("#message-container3").html("This cart is empty.").show().css({
                        "padding-top": "2cm",
                        "padding-bottom": "2cm",
                        "text-align":"center"
                    });
                    $("#checkoutButton").remove();

                    $(".price").text("$0.00");
                } 
            }
        });
    });
});



// newsletter handler moved to assets/js/newsletter.js (site-wide, MAS-26)


















