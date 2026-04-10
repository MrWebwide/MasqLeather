<?php 
$yetkiid = $_SESSION['id'];
$yetkiliogren = $db->query("select * from yonetici where id='$yetkiid'")->fetch(PDO::FETCH_ASSOC);
$yetki = $yetkiliogren['admin'];
?>
<?php 
if($yetki == 'yetkili') { 
    $izin = $db->query("SELECT * FROM izinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
}else if($yetki == 'kullanici'){
    $izin = $db->query("SELECT * FROM kullaniciizinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
}else if($yetki == 'admin'){
    $izin = $db->query("SELECT * FROM adminizni Where id='1'")->fetch(PDO::FETCH_ASSOC);
}
?>

<nav class="navbar navbar-expand-lg d-flex justify-content-between">
              <div class="" id="navbarNav">
                <ul class="navbar-nav" id="leftNav">
                  <li class="nav-item">
                    <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                  </li>
                     <?php
                    if($yetki == 'admin'){ ?>
                    <li class="nav-item">
                       <a class="nav-link" href="adminizinler.php">Permissions</a>
                    </li>
                    <?php } else  if($yetki == 'yetkili'){ ?>
                    <li class="nav-item">
                       <a class="nav-link" href="kullaniciizinler.php">Permissions</a>
                    </li><?php } ?>
                  
                   <?php if($izin['bakimmoduizni'] == 'on'){ ?>
                   <li class="nav-item">
                    <a class="nav-link" href="bakim_modu.php">Maintenance Mode</a>
                  </li>
                  <?php } ?>
                
                   <li class="nav-item">
                    <a class="nav-link" href="../" target="_blank">Go to the Website</a>
                  </li>
                 
                </ul>
                </div>
                <div class="">
                  <a class="" href="../"><img src="resimler/<?=$ayar['logo']?>" width="70"></a>
                </div>
                    <div class="" id="headerNav">
                      <ul class="navbar-nav">
                       
                       
                        <li class="nav-item dropdown">
                          <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="resimler/<?=$ayar['favicon']?>" alt=""></a>
                          <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                               <a class="dropdown-item"><?=$yetkiliogren['ad_soyad']?></a>
                                <div class="dropdown-divider"></div>
                            <a class="dropdown-item"  href="ayarlar.php"><i data-feather="settings"></i>Settings</a>
                             <?php if($yetki == 'admin'){ ?> <a class="dropdown-item"  href="yonetim.php"><i data-feather="settings"></i>Admin Settings</a><?php } ?>
                         <a class="dropdown-item" href="yonetici-ekle.php?islem=duzenle&id=<?=$yetkiliogren['id']?>"><i data-feather="user"></i>My Account</a>
                           
                             <a class="dropdown-item" target="_blank" href="../"><i data-feather="log-out"></i>Go to the Website</a>
                            <div class="dropdown-divider"></div>
                             
                            <a class="dropdown-item" href="cikis.php"><i data-feather="check-circle"></i>Log Out</a>
                          </div>
                        </li>
                      </ul>
                  </div>
              
            </nav>