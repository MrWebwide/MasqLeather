<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");


ob_start();
session_start();
oturumkontrolana();






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
  <link rel="icon" type="image/png" href="resimler/<?=$ayarlar['logo']?>">
  <title>
    <?=$ayar['site_title']?>
  </title>


  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
  <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
  <link href="assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">



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











          <div class="col-md-6 col-xl-3">
            <?php
                $slidercek11 = $db->query("select * from bloglar",PDO::FETCH_ASSOC);
        if($slidercek11->rowCount()){foreach($slidercek11 as $slidergoster11){
        }
        }
        $slidersay11 = $slidercek11->rowCount();
        ?>
            <div class="card stat-widget">
              <div class="card-body">
                <h5 class="card-title">Blogs </h5>
                <h2>
                  <?=$slidersay11?>
                </h2>
                <p>Total Blog Count(∞)</p>
                <div class="progress">
                  <div class="progress-bar bg-info progress-bar-striped" role="progressbar"
                    style="width: <?=$slidersay11?>%" aria-valuenow="100000000" aria-valuemin="0"
                    aria-valuemax="100000000"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <?php
                $slidercek111 = $db->query("select * from yorumlar",PDO::FETCH_ASSOC);
        if($slidercek111->rowCount()){foreach($slidercek111 as $slidergoster111){
        }
        }
        $slidersay111 = $slidercek111->rowCount();
        ?>
            <div class="card stat-widget">
              <div class="card-body">
                <h5 class="card-title">Comments </h5>
                <h2>
                  <?=$slidersay111?>
                </h2>
                <p>Total Comment Count(∞)</p>
                <div class="progress">
                  <div class="progress-bar bg-info progress-bar-striped" role="progressbar"
                    style="width: <?=$slidersay111?>%" aria-valuenow="100000000" aria-valuemin="0"
                    aria-valuemax="100000000"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <?php
                $slidercek111 = $db->query("select * from mailgelen",PDO::FETCH_ASSOC);
        if($slidercek111->rowCount()){foreach($slidercek111 as $slidergoster111){
        }
        }
        $slidersay111 = $slidercek111->rowCount();
        ?>
            <div class="card stat-widget">
              <div class="card-body">
                <h5 class="card-title">Sales </h5>
                <h2>
                  <?=$slidersay111?>
                </h2>
                <p>Total Sold Product(∞)</p>
                <div class="progress">
                  <div class="progress-bar bg-info progress-bar-striped" role="progressbar"
                    style="width: <?=$slidersay111?>%" aria-valuenow="100000000" aria-valuemin="0"
                    aria-valuemax="100000000"></div>
                </div>
              </div>
            </div>
          </div>




          <?php 
            if($_GET['sil']){
             $idd=intval($_GET['sil']);
             $simdi=$db->query("delete from mailgelen where id='$idd'")->fetch(PDO::FETCH_ASSOC);}?>

          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body" style="overflow:scroll;">
                  <h5 class="card-title">Sales</h5>
                  <div class="form-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by Order Number">
                </div>
                  <table class="table invoice-table">
                    <thead>
                      <tr>

                        <th scope="col">Order Number</th>
                        <th scope="col">Name Surname</th>

                        <th scope="col">E-Mail</th>
                        <th scope="col">Tracking Number</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Process</th>
                      </tr>

                    </thead>

                    <tbody>
                 

                      <?php
    $urunlistele = $db->query("select * from mailgelen order by id desc", PDO::FETCH_ASSOC);
    if ($urunlistele->rowCount()) {
        foreach ($urunlistele as $urungoster) {
         
          // Sipariş durumuna göre renk belirleme
          $orderStatus = $urungoster['orderstatus'];
          $color = '';
          switch ($orderStatus) {
              case 'Order Completed':
                  $color = 'green'; // Yeşil renk
                  break;
              case 'Order Cancelled':
                  $color = 'red'; // Kırmızı renk
                  break;
              case 'Shipped':
                  $color = 'orange'; // Sarı renk
                  break;
              default:
                  $color = 'black'; // Varsayılan renk
                  break;
          }
          
            ?>
                      <tr>
                        <th scope="row">
                          <?= $urungoster['siparisid'] ?>
                        </th>
                        <th scope="row">
                          <?= $urungoster['adsoyad'] ?>
                        </th>
                        <td>
                          <?= $urungoster['email'] ?>
                        </td>
                        <?php
                if (empty($urungoster['trackingid']) || empty($urungoster['orderstatus'])) {
                    ?>
                        <th scope="row">
                          <?= (empty($urungoster['trackingid']) ? 'Waiting For Input' : $urungoster['trackingid']) ?>
                        </th>
                        <th scope="row" style="color: <?= $color ?>">
                          <?= (empty($urungoster['orderstatus']) ? 'Waiting For Input' : $urungoster['orderstatus']) ?>
                        </th>
                        <?php
                } else {
                    ?>
                        <th scope="row" >
                          <?= $urungoster['trackingid'] ?>
                        </th>

                        <?php
                    // Sipariş durumuna göre renk belirleme
                    $orderStatus = $urungoster['orderstatus'];
                    $color = '';
                    switch ($orderStatus) {
                        case 'Order Completed':
                            $color = 'green'; // Yeşil renk
                            break;
                        case 'Order Cancelled':
                            $color = 'red'; // Kırmızı renk
                            break;
                        case 'Shipped':
                            $color = 'orange'; // Sarı renk
                            break;
                        default:
                            $color = 'black'; // Varsayılan renk
                            break;
                    }
                    ?>
                        <th scope="row" style="color: <?= $color ?>">
                          <?= $urungoster['orderstatus'] ?>
                        </th>
                        
                        <?php
                }
                ?>

                        <td><span class="badge bg-primary">
                            <?= $urungoster['eklenme_tarihi'] ?>
                          </span></td>
                        <td>
                          <a href="habergelen.php?islem=duzenle&id=<?= $urungoster['id'] ?>"><svg
                              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              class="feather feather-edit">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg></a>
                          <a class="silmeAlani" href="?sil=<?= $urungoster['id'] ?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                      <?php
        }
    }
    ?>
                    </tbody>


                  </table>
                  <div id="noProductMessage" style="display: none; font-weight:bolder; text-align: center; margin-top: 10px; color: red;">No product found with the given order number.</div>
                </div>
              </div>
            </div>
          </div>

          <?php 


if($_GET['sil']){
    $idd=intval($_GET['sil']);
    $simdi=$db->query("delete from bloggelen where id='$idd'")->fetch(PDO::FETCH_ASSOC);}?>

          <div class="row" id="hbrfrm">
            <div class="col">
              <div class="card">
                <div class="card-body" style="overflow:scroll;">

                  <strong> Product Reviews
                  </strong>

                  <table class="table invoice-table2">
                    <thead>
                      <tr>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ürün İD</th>
                        <th scope="col">Durum</th>
                        <th scope="col">Alan</th>
                        <th scope="col">Tarih</th>
                        <th scope="col">Process</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                                            
                                            $urunlistele = $db->query("select * from bloggelen  order by id desc",PDO::FETCH_ASSOC);
                                          if($urunlistele->rowCount()){foreach($urunlistele as $urungoster){
                                            if($urungoster["durum"]=='on'){$aktifpasif='AKTİF';}else{$aktifpasif='PASİF';}
                                          ?>
                      <tr>
                        <th scope="row">
                          <?=$urungoster['name']?>
                        </th>
                        <th scope="row">
                          <?=$urungoster['email']?>
                        </th>
                        <td>
                          <?=$urungoster['yorumid']?>
                        </td>

                        <td>
                          <?=$aktifpasif?>
                        </td>
                        <td>
                          <?=$urungoster['tur']?>
                        </td>

                        <td><span class="badge bg-primary">
                            <?=$urungoster['eklenme_tarihi']?>
                          </span></td>
                        <td>
                          <a href="../<?= $urungoster['tur'] ?>-detail.php?id=<?= $urungoster['yorumid'] ?>"
                            target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                              <circle cx="12" cy="12" r="3"></circle>
                            </svg></a>
                          <a href="bloggelen.php?islem=duzenle&id=<?=$urungoster['id']?>"><svg
                              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              class="feather feather-edit">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg></a>
                          <a class="silmeAlani" href="?sil=<?=$urungoster['id']?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>

                      <?php } }?>


                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>



          <script>
    // Arama kutusunu seçin
    var searchInput = document.getElementById('searchInput');

    // Tablodaki her bir satırı seçin
    var rows = document.querySelectorAll('.invoice-table tbody tr');

    // Arama kutusuna her yazıldığında
    searchInput.addEventListener('keyup', function(event) {
        var searchText = event.target.value.toLowerCase(); // Arama metnini alın ve küçük harfe dönüştürün

        // Eşleşen ürün sayacını sıfırlayın
        var matchCount = 0;

        // Her bir satırı döngüyle kontrol edin
        rows.forEach(function(row) {
            var orderNumber = row.querySelector('th:first-child').textContent.toLowerCase(); // Sipariş numarasını alın

            // Eğer sipariş numarası arama metniyle eşleşiyorsa, satırı gösterin, değilse gizleyin
            if (orderNumber.includes(searchText)) {
                row.style.display = '';
                matchCount++; // Eşleşen ürün sayısını artırın
            } else {
                row.style.display = 'none';
            }
        });

        // Eğer hiçbir ürün bulunamadıysa
        if (matchCount === 0) {
            // "No product found with the given order number." mesajını görüntüleyin
            document.getElementById('noProductMessage').style.display = 'block';
        } else {
            // Eğer eşleşen bir ürün bulunduysa, mesajı gizleyin
            document.getElementById('noProductMessage').style.display = 'none';
        }
    });
</script>



        </div>
      </div>
    </div>
  </div>

  <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
  <script src="assets/plugins/apexcharts/apexcharts.min.js"></script>
  <script src="assets/js/main.min.js"></script>
  <script src="assets/js/pages/dashboard.js"></script>
</body>
<script src="https://use.fontawesome.com/ca9a29c061.js"></script>
<?php include("silme.php");?>

</html>
