<?php
include("include/baglan.php");
include("include/fonksiyonlar.php");

ob_start();
session_start();
oturumkontrolana();

$sql = "SELECT id, adsoyad, email, kayit_tarihi, onay_durumu, resim FROM uyeler";
$stmt = $db->prepare($sql);
$stmt->execute();
$uyeler = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        <title>Mail Ayarları - <?=$ayar['site_title']?></title>




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
                                    <h5 class="card-title">Website Users</h5>
                                    
                                    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
                                    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name-Surname</th>
            <th>Email</th>
            <th>2-Step Verification</th>
            <th>Registration Date</th>
            <th>IP Address</th>
            <th>Process</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($uyeler as $uye): ?>
            <tr>
                <td><?= htmlspecialchars($uye['id']) ?></td>
                <td><?= htmlspecialchars($uye['adsoyad']) ?></td>
                <td><?= htmlspecialchars($uye['email']) ?></td>
                <td>
    <?= $uye['onay_durumu'] == 0 ? 'Not Registered' : 'Registered' ?>
</td>

                <td><?= htmlspecialchars($uye['kayit_tarihi']) ?></td>
                <td><?= htmlspecialchars($uye['resim'] ?? '-') ?></td> <!-- 'resim' sütunundan IP adresi olarak veri çekiliyor -->
                <td>
                    <!-- Çöp Kutusu İkonu ve Silme Butonu -->
                    <button 
                        onclick="confirmDelete(<?= htmlspecialchars($uye['id']) ?>)" 
                        style="border: none; background: none; cursor: pointer;"
                    >
                        🗑️
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                                </div>
                            </div>
                        </div>
                    </div>
                  
                  
                    
                    
                    <script>
    function confirmDelete(userId) {
        // Kullanıcıdan onay al
        const confirmation = confirm("Do you really want to delete this user?");
        
        if (confirmation) {
            // Silme işlemi için form gönderimi
            const form = document.createElement("form");
            form.method = "POST";
            form.action = ""; // Mevcut sayfaya POST isteği yapılacak
            
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "delete_user_id";
            input.value = userId;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<?php
// Silme isteğini işleme al
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userId = $_POST['delete_user_id'];

    try {
        $deleteSql = "DELETE FROM uyeler WHERE id = :id";
        $stmt = $db->prepare($deleteSql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('User deleted successfully.');</script>";
        echo "<script>window.location.href = '';</script>"; // Sayfayı yeniden yükle
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred while deleting the user: " . $e->getMessage() . "');</script>";
    }
}
?>
    
                    


                </div>
                                  
                </div>
              
            </div>
         <script src="ckeditor-2/ckeditor.js"></script>
        <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        
        
	
        <script src="https://use.fontawesome.com/ca9a29c061.js"></script>

    </body>

</html>