<?php
session_start();
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");
include("../admin/include/product_options.php");





if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
 
    // Formdan gönderilen verileri alın
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productImage = $_POST['productImage'];
    $productCategory = $_POST['productCategory'];
    $productCargo = $_POST['productCargo'];
    $productCargos = $_POST['productCargos']; 
    $producttur = $_POST['producttur'];

    // MAS-46: müşterinin seçtiği selector değerlerini SUNUCUDA doğrula ve çöz (tamper-proof)
    $secimPost = isset($_POST['secim']) && is_array($_POST['secim']) ? $_POST['secim'] : [];
    $secimResolved = masq_resolve_selections($db, (int) $productId, (string) $producttur, $secimPost);
    if ($secimResolved['error'] !== null) {
        http_response_code(422);
        echo $secimResolved['error'];
        exit;
    }
    $secimlerJson = $secimResolved['json']; // null ya da JSON snapshot

    // Kullanıcı kimliğini oturumdan alın
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if ($userId !== null) {
        // Ürünün zaten sepette olup olmadığını kontrol et (aynı seçimlerle — farklı seçim = ayrı satır)
        $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ? AND UrunID = ? AND UrunAdi = ? AND secimler <=> ?");
        $stmt->execute([$userId, $productId, $productName, $secimlerJson]);
        $existingProduct = $stmt->fetch();

        if ($existingProduct) {
            // Ürün (aynı seçimlerle) sepette zaten var, miktarı artır
            $newQuantity = $existingProduct['UrunMiktari'] + $productQuantity;
            $newTotalPrice = $existingProduct['FiyatToplam'] + ($productPrice * $productQuantity);

            $stmt = $db->prepare("UPDATE sepet SET UrunMiktari = ?, FiyatToplam = ? WHERE SepetID = ?");
            $stmt->execute([$newQuantity, $newTotalPrice, $existingProduct['SepetID']]);
        } else {
            // Ürün sepette yok, yeni giriş yap
            $totalPrice = $productPrice * $productQuantity;

            $stmt = $db->prepare("INSERT INTO sepet (KullaniciID, UrunID, UrunAdi, UrunFiyati, UrunMiktari, FiyatToplam, urun_resim, urun_category, cargo, cargo_us, tur, secimler) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $productId, $productName, $productPrice, $productQuantity, $totalPrice, $productImage, $productCategory, $productCargo, $productCargos, $producttur, $secimlerJson]);
        }

        // Sepet içeriğini güncelleyin ve geri döndürün
        $updatedCart = getUpdatedCartContent($userId); // Bu işlev, güncellenmiş sepet içeriğini getirir
        echo $updatedCart;
    } else {
        // Kullanıcı oturumda değil
        session_name('noid');
        session_start();
    
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $cart = &$_SESSION['cart'];
    
        // Ürünün sepette olup olmadığını kontrol et: id + 'tur' + seçimler (farklı seçim = ayrı satır)
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['id'] === $productId && $item['tur'] === $producttur && (($item['secimler'] ?? null) === $secimlerJson)) {
                // Ürün (aynı seçimlerle) zaten sepette var, miktarı artır
                $cart[$key]['quantity'] += $productQuantity;
                $cart[$key]['totalPrice'] += $productPrice * $productQuantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Ürün sepette yok, yeni giriş yap (seçimler anahtarın parçası olur)
            $cartKey = $productId . '_' . $producttur . ($secimlerJson ? '_' . md5($secimlerJson) : '');
            $cart[$cartKey] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
                'totalPrice' => $productPrice * $productQuantity,
                'image' => $productImage,
                'category' => $productCategory,
                'cargo' => $productCargo,
                'cargo_us' => $productCargos,
                'tur' => $producttur,
                'secimler' => $secimlerJson
            ];
        }
    
        session_write_close(); // Oturumu kapat
    
        // Sepet içeriğini güncelleyin ve geri döndürün
        $updatedCart = getUpdatedCartContentFromSession(); // Bu işlev, güncellenmiş sepet içeriğini getirir
        echo $updatedCart;
    }
    
}


function getUpdatedCartContent($userId) {
    global $db; // $db değişkenini bu işlev içinde kullanabilmek için global olarak tanımlayın

    // Kullanıcının sepet verilerini veritabanından çekin
    $stmt = $db->prepare("SELECT * FROM sepet WHERE KullaniciID = ?");
    $stmt->execute([$userId]);

   // Toplam fiyatı saklamak için bir değişken tanımlayın
   $totalPrice = 0;

   $updatedCartContent = ''; // Güncellenmiş sepet içeriğini saklayacak değişken

   if ($stmt->rowCount() == 0) {
       // Sepet boşsa uygun bir mesaj döndürün
       $updatedCartContent = "Your cart is empty.";
   } else {
       // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
       $groupedItems = [];

       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $productId = $row['UrunID'];
           $productName = $row['UrunAdi'];
           $productQuantity = $row['UrunMiktari'];
           $productPrice = $row['UrunFiyati'];
           $productImage = $row['urun_resim'];
           $productCategory = $row['urun_category']; // Ürünün kategorisini alın
           $productSecimler = $row['secimler']; // MAS-46: seçim snapshot'ı (JSON ya da null)

           // Categoriese göre gruplanmış ürünleri diziye ekleyin
           if (!isset($groupedItems[$productCategory])) {
               $groupedItems[$productCategory] = [];
           }

           // Aynı ürün + aynı seçimler daha önce eklenmişse miktarı artır (farklı seçim = ayrı satır)
           $found = false;
           foreach ($groupedItems[$productCategory] as &$item) {
               if ($item['id'] === $productId && ($item['secimler'] ?? null) === $productSecimler) {
                   $item['quantity'] += $productQuantity;
                   $item['totalPrice'] += $productPrice * $productQuantity;
                   $found = true;
                   break;
               }
           }
           unset($item);

           // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
           if (!$found) {
               $groupedItems[$productCategory][] = [
                   'id' => $productId,
                   'name' => $productName,
                   'quantity' => $productQuantity,
                   'price' => $productPrice,
                   'totalPrice' => $productPrice * $productQuantity,
                   'image' => $productImage,
                   'secimler' => $productSecimler,
               ];
           }
       }

       

       // Categoriese göre gruplanmış ürünleri listeleyin
       foreach ($groupedItems as $category => $products) {
       
    
        foreach ($products as $product) {
            echo '<div class="cart_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '">';
            echo '<div class="cart_img">';
            echo '<a href="#"><img src="admin/resimler/' . $product['image'] . '" alt=""></a>';
            echo '</div>';
            echo '<div class="cart_info">';
            echo '<div class="close-sec d-flex">';
            echo ' <a href="#">' . $product['name'] . '</a>';
            echo '<a href="#" class="delete_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '"  style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
            echo ' </div>';
            echo masq_format_selections($product['secimler'] ?? null);
            echo '    <p>' . $product['quantity'] . ' x <span> $' . $product['price'] . '</span></p>';
            echo '  </div>';
            echo '  <div class="cart_remove">';
            echo '    <a href="#"><i class="icon-close icons"></i></a>';
            echo '  </div>';
            echo '</div>';
    
            // Product Pricenı toplam fiyata ekleyin
            $totalPrice += $product['totalPrice'];
        }
    }

    

// Toplam fiyatı ekrana yazdırın
echo '<div class="cart_total">';
echo '  <span>Sub total:</span>';
echo '  <span class="price">$' . number_format($totalPrice, 2) . '</span>';
echo '</div>';

      
   }

   $updatedCartContent .= "<script>$('.mini_cart,.body_overlay').addClass('active');</script>";

   return $updatedCartContent;
}




function getUpdatedCartContentFromSession() {
    session_name('noid');
    session_start();

    // Sepet oturumda yoksa boş bir dizi oluşturun
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Toplam fiyatı saklamak için bir değişken tanımlayın
    $totalPrice = 0;

    $updatedCartContent = ''; // Güncellenmiş sepet içeriğini saklayacak değişken

    if (empty($cart)) {
        // Sepet boşsa uygun bir mesaj döndürün
        $updatedCartContent = "Your cart is empty.";
    } else {
        // Categoriese göre gruplanmış ürünleri saklayacak bir dizi tanımlayın
        $groupedItems = [];

        foreach ($cart as $productId => $product) {
            $productName = $product['name'];
            $productQuantity = $product['quantity'];
            $productPrice = $product['price'];
            $productImage = $product['image'];
            $productCategory = $product['category']; // Ürünün kategorisini alın
            $productSecimler = $product['secimler'] ?? null; // MAS-46: seçim snapshot'ı

            // Categoriese göre gruplanmış ürünleri diziye ekleyin
            if (!isset($groupedItems[$productCategory])) {
                $groupedItems[$productCategory] = [];
            }

            // Aynı ürün + aynı seçimler daha önce eklenmişse miktarı artır (farklı seçim = ayrı satır)
            $found = false;
            foreach ($groupedItems[$productCategory] as &$item) {
                if ($item['id'] === $productId && ($item['secimler'] ?? null) === $productSecimler) {
                    $item['quantity'] += $productQuantity;
                    $item['totalPrice'] += $productPrice * $productQuantity;
                    $found = true;
                    break;
                }
            }
            unset($item);

            // Yeni bir ürün ise, gruplanmış ürünlere ekleyin
            if (!$found) {
                $groupedItems[$productCategory][] = [
                    'id' => $productId,
                    'name' => $productName,
                    'quantity' => $productQuantity,
                    'price' => $productPrice,
                    'totalPrice' => $productPrice * $productQuantity,
                    'image' => $productImage,
                    'secimler' => $productSecimler,
                ];
            }
        }

        // Categoriese göre gruplanmış ürünleri listeleyin
        foreach ($groupedItems as $category => $products) {
            foreach ($products as $product) {
                $updatedCartContent .= '<div class="cart_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '">';
                $updatedCartContent .= '<div class="cart_img">';
                $updatedCartContent .= '<a href="#"><img src="admin/resimler/' . $product['image'] . '" alt=""></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '<div class="cart_info">';
                $updatedCartContent .= '<div class="close-sec d-flex">';
                $updatedCartContent .= '<a href="#">' . $product['name'] . '</a>';
                $updatedCartContent .= '<a href="#" class="delete_item" data-product-id="' . $product['id'] . '" data-product-category="' . $category . '" data-product-price="' . $product['price'] . '" data-product-quantity="' . $product['quantity'] . '" style="padding-left: 5.5em;"><i class="ion-ios-trash" style="font-size: 20px;"></i></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= masq_format_selections($product['secimler'] ?? null);
                $updatedCartContent .= '<p>' . $product['quantity'] . ' x <span> $' . $product['price'] . '</span></p>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '<div class="cart_remove">';
                $updatedCartContent .= '<a href="#"><i class="icon-close icons"></i></a>';
                $updatedCartContent .= '</div>';
                $updatedCartContent .= '</div>';

                // Product Pricenı toplam fiyata ekleyin
                $totalPrice += $product['totalPrice'];
            }
        }

        // Toplam fiyatı ekrana yazdırın
        $updatedCartContent .= '<div class="cart_total">';
        $updatedCartContent .= '<span>Sub total:</span>';
        $updatedCartContent .= '<span class="price">$' . number_format($totalPrice, 2) . '</span>';
        $updatedCartContent .= '</div>';
    }

    $updatedCartContent .= "<script>$('.mini_cart,.body_overlay').addClass('active');</script>";

    session_write_close(); // Oturumu kapat

    return $updatedCartContent;
}





?>

<script>

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
            total += price;
        });
        return total;
    }
});






</script>

<script>
        function closeMiniCart() {
            $('.mini_cart, .body_overlay').removeClass('active');
        }
        </script>

       
