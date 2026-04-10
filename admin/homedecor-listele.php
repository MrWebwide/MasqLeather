<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();

if($_GET['sil']){
	$idd=intval($_GET['sil']);
	 
	 $resim_sorgu=$db->query("select * from homedecor where id='$idd'")->fetch(PDO::FETCH_ASSOC);

	$simdi=$db->query("delete from homedecor where id='$idd'")->fetch(PDO::FETCH_ASSOC);
	
	


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
        <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
        <title>List Product | <?=$ayar['site_title']?></title>


        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="assets/plugins/DataTables/datatables.min.css" rel="stylesheet">   

      

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
                            <div class="card-body"style="overflow:scroll">
                                <h5 class="card-title">List Product</h5>
                           
                                <a href="homedecor-ekle.php"  class="btn btn-primary m-b-md">Add Product</a>
                                <table class="table invoice-table">
                                            <thead>
                                              <tr>
                                              <th scope="col">Change Order</th>
                                                <th scope="col">Product Order</th>
                                                <th scope="col">State</th>
                                                <th scope="col"> Stok Sayısı</th>

                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Main Picture</th>
                                                <th scope="col">Date of upload</th>
                                                <th scope="col">Process</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $urunlistele = $db->query("select * from homedecor order by sira asc",PDO::FETCH_ASSOC);
											if($urunlistele->rowCount()){foreach($urunlistele as $urungoster){
											?>
                                                 <tr draggable="true" data-oldorder="<?= $urungoster['sira'] ?>" data-id="<?= $urungoster['id'] ?>" ondragstart="start()"  ondragover="dragover()" ondragend="dragEnd()">
                    <th class="drag-handle" scope="row">
                      <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10"/>
</svg></button>
</th>
                                                <th scope="row"><?=$urungoster['sira']?></th>
                                                <th scope="row"><?php
// $urungoster['durum'] değerini alıyoruz
$durum = $urungoster['durum'];

// Eğer $durum değişkeni "on" ise, "on" kelimesini göster
if ($durum == "on") {
    echo "on";
} else {
    // Değilse, "off" kelimesini göster
    echo "off";
}
?></th>


<script>
var row;

function start() {
  row = event.target; 
  row.classList.add('selected-row'); // BU DA KASTIRIYOR OLABİLİR
  event.dataTransfer.setDragImage(new Image(), 0, 0);//BU KASTIRIYOR OLABİLİR

}

function dragover() {
  var e = event;
  e.preventDefault(); 
 
  
  let children = Array.from(e.target.parentNode.parentNode.children);
  
  if (children.indexOf(e.target.parentNode) > children.indexOf(row))
    e.target.parentNode.after(row);
  else
    e.target.parentNode.before(row);
}

function dragEnd() {
  var rows = document.querySelectorAll("tr");
  row.classList.remove('selected-row'); // BU DA KASTIRIYOR OLABİLİR
  // Tüm ürünlerin ID'lerini ve sıralamalarını içeren bir dizi oluştur
  var productData = [];
  rows.forEach(function(row) {
    var productOldOrder = row.getAttribute('data-oldorder');
    var productId = row.getAttribute('data-id');
    var productOrder = Array.from(row.parentNode.children).indexOf(row) + 1;
    productData.push({ oldorder: productOldOrder, order: productOrder, id: productId });
  });


  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_order_home.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log('Sıralama güncellendi');
    }
  };
  xhr.send(JSON.stringify(productData));
}



</script>


  

<?php
$stock = $urungoster['stock'];
$colorClass = '';

if ($stock > 20) {
    $colorClass = 'green'; // Stok 20'den fazlaysa yeşil
} elseif ($stock >= 5 && $stock <= 10) {
    $colorClass = 'yellow'; // Stok 5 ile 10 arasındaysa sarı
} else {
    $colorClass = 'red'; // Stok 5'ten azsa kırmızı
}
?>

<td>
    <div class="stock-box <?= $colorClass ?>">
        <?= $urungoster['stock'] ?>
    </div>
</td>      


                                                <td><?=$urungoster['adi']?></td>
                                                <td><img src="resimler/<?=$urungoster['resim']?>" alt="<?=$urungoster['adi']?>"> </td>
                                                <td><span class="badge bg-primary"><?=$urungoster['eklenme_tarihi']?></span></td>
                                                <td>
                                                  <a href="homedecor-ekle.php?islem=duzenle&id=<?=$urungoster['id']?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                                  <a href="../menu.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                                  <a class="silmeAlani"href="?sil=<?=$urungoster['id']?>"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                              </tr>
                                              
                                              <?php } }?>
                                              
                                              
                                            </tbody>
                                          </table>
                            </div>
                        </div>      
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
        <script src="assets/plugins/DataTables/datatables.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/pages/datatables.js"></script>
           <script src="https://use.fontawesome.com/ca9a29c061.js"></script><?php include("silme.php");?>
    </body>

</html>GET['sil']);
	 
	 $resim_sorgu=$db->query("select * from homedecor where id='$idd'")->fetch(PDO::FETCH_ASSOC);

	$simdi=$db->query("delete from homedecor where id='$idd'")->fetch(PDO::FETCH_ASSOC);
	
	


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
        <link rel="icon" type="image/png" href="resimler/<?=$ayar['favicon']?>">
        <title>List Product | <?=$ayar['site_title']?></title>


        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="assets/plugins/DataTables/datatables.min.css" rel="stylesheet">   

      

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
                            <div class="card-body"style="overflow:scroll">
                                <h5 class="card-title">List Product</h5>
                           
                                <a href="homedecor-ekle.php"  class="btn btn-primary m-b-md">Add Product</a>
                                <table class="table invoice-table">
                                            <thead>
                                              <tr>
                                              <th scope="col">Change Order</th>
                                                <th scope="col">Product Order</th>
                                                <th scope="col">State</th>
                                                <th scope="col"> Stok Sayısı</th>

                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Main Picture</th>
                                                <th scope="col">Date of upload</th>
                                                <th scope="col">Process</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $urunlistele = $db->query("select * from homedecor order by sira asc",PDO::FETCH_ASSOC);
											if($urunlistele->rowCount()){foreach($urunlistele as $urungoster){
											?>
                                                 <tr draggable="true" data-oldorder="<?= $urungoster['sira'] ?>" data-id="<?= $urungoster['id'] ?>" ondragstart="start()"  ondragover="dragover()" ondragend="dragEnd()">
                    <th class="drag-handle" scope="row">
                      <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10"/>
</svg></button>
</th>
                                                <th scope="row"><?=$urungoster['sira']?></th>
                                                <th scope="row"><?php
// $urungoster['durum'] değerini alıyoruz
$durum = $urungoster['durum'];

// Eğer $durum değişkeni "on" ise, "on" kelimesini göster
if ($durum == "on") {
    echo "on";
} else {
    // Değilse, "off" kelimesini göster
    echo "off";
}
?></th>


<script>
var row;

function start() {
  row = event.target; 
  row.classList.add('selected-row'); // BU DA KASTIRIYOR OLABİLİR
  event.dataTransfer.setDragImage(new Image(), 0, 0);//BU KASTIRIYOR OLABİLİR

}

function dragover() {
  var e = event;
  e.preventDefault(); 
 
  
  let children = Array.from(e.target.parentNode.parentNode.children);
  
  if (children.indexOf(e.target.parentNode) > children.indexOf(row))
    e.target.parentNode.after(row);
  else
    e.target.parentNode.before(row);
}

function dragEnd() {
  var rows = document.querySelectorAll("tr");
  row.classList.remove('selected-row'); // BU DA KASTIRIYOR OLABİLİR
  // Tüm ürünlerin ID'lerini ve sıralamalarını içeren bir dizi oluştur
  var productData = [];
  rows.forEach(function(row) {
    var productOldOrder = row.getAttribute('data-oldorder');
    var productId = row.getAttribute('data-id');
    var productOrder = Array.from(row.parentNode.children).indexOf(row) + 1;
    productData.push({ oldorder: productOldOrder, order: productOrder, id: productId });
  });


  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_order_home.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log('Sıralama güncellendi');
    }
  };
  xhr.send(JSON.stringify(productData));
}



</script>


  

<?php
$stock = $urungoster['stock'];
$colorClass = '';

if ($stock > 20) {
    $colorClass = 'green'; // Stok 20'den fazlaysa yeşil
} elseif ($stock >= 5 && $stock <= 10) {
    $colorClass = 'yellow'; // Stok 5 ile 10 arasındaysa sarı
} else {
    $colorClass = 'red'; // Stok 5'ten azsa kırmızı
}
?>

<td>
    <div class="stock-box <?= $colorClass ?>">
        <?= $urungoster['stock'] ?>
    </div>
</td>      


                                                <td><?=$urungoster['adi']?></td>
                                                <td><img src="resimler/<?=$urungoster['resim']?>" alt="<?=$urungoster['adi']?>"> </td>
                                                <td><span class="badge bg-primary"><?=$urungoster['eklenme_tarihi']?></span></td>
                                                <td>
                                                  <a href="homedecor-ekle.php?islem=duzenle&id=<?=$urungoster['id']?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                                  <a href="../menu.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                                  <a class="silmeAlani"href="?sil=<?=$urungoster['id']?>"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                              </tr>
                                              
                                              <?php } }?>
                                              
                                              
                                            </tbody>
                                          </table>
                            </div>
                        </div>      
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
        <script src="assets/plugins/DataTables/datatables.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/pages/datatables.js"></script>
           <script src="https://use.fontawesome.com/ca9a29c061.js"></script><?php include("silme.php");?>
    </body>

</html>