<?php 
if($yetki == 'yetkili') { 
    $izin = $db->query("SELECT * FROM izinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
}else if($yetki == 'kullanici'){
    $izin = $db->query("SELECT * FROM kullaniciizinler Where id='1'")->fetch(PDO::FETCH_ASSOC);
}else if($yetki == 'admin'){
    $izin = $db->query("SELECT * FROM adminizni Where id='1'")->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="page-sidebar">
                <ul class="list-unstyled accordion-menu">
                  <li class="sidebar-title">
                    Menu
                  </li>
                  <li>
                    <a href="index.php"><i data-feather="home"></i>Home Page</a>
                  </li>
                 
               
             
            
              
                <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Add Product<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="urun-ekle.php"><i class="fa fa-circle"></i>Bags & Purses</a></li>
                    <li><a href="accessories-ekle.php"><i class="fa fa-circle"></i>Accessories</a></li>
                    <li><a href="homedecor-ekle.php"><i class="fa fa-circle"></i>Home Decor</a></li>
                    <li><a href="jewe-ekle.php"><i class="fa fa-circle"></i>Jewelery</a></li>
                    <li><a href="ourcollection-ekle.php"><i class="fa fa-circle"></i>Our Collection</a></li>
              
                    <li><a href="blog-ekle.php"><i class="fa fa-circle"></i>Blog Masq</a></li>
                    <li><a href="blogmer-ekle.php"><i class="fa fa-circle"></i>Blog Mercantile</a></li>

                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="server"></i>List Product<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="urun-listele.php"><i class="fa fa-circle"></i>List Bags & Purses</a></li>
                    <li><a href="accessories-listele.php"><i class="fa fa-circle"></i>List Accessories</a></li>
                    <li><a href="homedecor-listele.php"><i class="fa fa-circle"></i>List Home Decor</a></li>
                    <li><a href="jewe-listele.php"><i class="fa fa-circle"></i>List Jewelery</a></li>
                    <li><a href="ourcollection-listele.php"><i class="fa fa-circle"></i>List Our Collection</a></li>
                    
                    <li><a href="blog-listele.php"><i class="fa fa-circle"></i>List Blog</a></li> 
                    <li><a href="blogmer-listele.php"><i class="fa fa-circle"></i>List Blog Mercantile</a></li>
                  </ul>
                  </li>

                  
<!--
                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Cargo Price Range<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="cargo-range.php"><i class="fa fa-circle"></i>Cargo Range</a></li>
                    
                    <li><a href="cargo-kategori-listele.php"><i class="fa fa-circle"></i>List Cargo Category</a></li>

                   </ul>
                  </li>
                   
                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Cargo Price US  <i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="cargo-kategori-us-ekle.php"><i class="fa fa-circle"></i>Add Cargo Price</a></li>
                    <li><a href="cargo-kategori-us-listele.php"><i class="fa fa-circle"></i>List Cargo Category</a></li>
                   
                   </ul>
                  </li>
-->
                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Index C. Mgment.<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="sc-ekle.php"><i class="fa fa-circle"></i>Add Comment</a></li>
                    <li><a href="sc-listele.php"><i class="fa fa-circle"></i>List Comment</a></li>
                   
                   </ul>
                  </li>


                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Bags & Purses  <i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="urun-kategori-ekle.php"><i class="fa fa-circle"></i>Add Category</a></li>
                    <li><a href="urun-kategori-listele.php"><i class="fa fa-circle"></i>List Categories</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Accessories <i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="bolge-kat-ekle.php"><i class="fa fa-circle"></i>Add Category</a></li>
                    <li><a href="bolge-kat-listele.php"><i class="fa fa-circle"></i>List Categories</a></li>
                   
                   </ul>
                  </li>
                
                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Home Decor <i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="mer-kategori-ekle.php"><i class="fa fa-circle"></i>Add Category</a></li>
                    <li><a href="mer-kategori-listele.php"><i class="fa fa-circle"></i>List Categories</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Jewelery <i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="jewe-kat-ekle.php"><i class="fa fa-circle"></i>Add Category</a></li>
                    <li><a href="jewe-kat-listele.php"><i class="fa fa-circle"></i>List Categories</a></li>
                   
                   </ul>
                  </li>

                 



                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Coupons<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="cupon-ekle.php"><i class="fa fa-circle"></i>Add Coupon</a></li>
                    <li><a href="cupon-listele.php"><i class="fa fa-circle"></i>List Coupon</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Register Coupons<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="register-cupon-ekle.php"><i class="fa fa-circle"></i>Add Coupon</a></li>
                    <li><a href="register-cupon-listele.php"><i class="fa fa-circle"></i>List Coupon</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Gift Cards<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                   
                    <li><a href="gift-card-add.php"><i class="fa fa-circle"></i>Add Gift Cards</a></li>
                    <li><a href="gift-card-list.php"><i class="fa fa-circle"></i>List Gift Cards</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Campaign Set-Up<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">


                   
                    <li><a href="bag-purses-kampanya-ekle.php"><i class="fa fa-circle"></i>BagPurses  Add</a></li>
                    <li><a href="bag-purses-kampanya-listele.php"><i class="fa fa-circle"></i>BagPurses  List</a></li>
                    <li><a href="accessories-kampanya-ekle.php"><i class="fa fa-circle"></i>Accessories  Add</a></li>
                    <li><a href="accessories-kampanya-listele.php"><i class="fa fa-circle"></i>Accessories  List</a></li>
                    <li><a href="jewe-kampanya-ekle.php"><i class="fa fa-circle"></i>Jewelry  Add</a></li>
                    <li><a href="jewe-kampanya-listele.php"><i class="fa fa-circle"></i>Jewelry  List</a></li>
                    <li><a href="homedecor-kampanya-ekle.php"><i class="fa fa-circle"></i>Homedecor  Add</a></li>
                    <li><a href="homedecor-kampanya-listele.php"><i class="fa fa-circle"></i>Homedecor  List</a></li>
                   
                   </ul>
                  </li>

                  <li>
                    <a href="cargo-range.php"><i data-feather="box"></i>Cargo Fee</a>
                  </li>

                  <li>
                    <a href="campaign.php"><i data-feather="film"></i>Campaign Settings</a>
                  </li>

                  <li>
                    <a href="yazilar.php"><i data-feather="film"></i>SEO Settings</a>
                  </li>

                  <li>
                    <a href="sayac.php"><i data-feather="shield"></i>Security</a>
                  </li>

                  <li>
                    <a href="mailayarlari.php"><i data-feather="user"></i>User Accounts</a>
                  </li>

                  <li>
                    <a href="index.php"><i data-feather="plus-circle"></i>Page Customization<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">

                    <li><a href="page.php"><i class="fa fa-circle"></i>Main Page</a></li>
                    <li><a href="page3.php"><i class="fa fa-circle"></i>Main Page 2</a></li>
                    <li><a href="page2.php"><i class="fa fa-circle"></i>About Us</a></li>
                    <li><a href="page5.php"><i class="fa fa-circle"></i>Terms</a></li>
                    <li><a href="page6.php"><i class="fa fa-circle"></i>Refund Policy</a></li>
                    <li><a href="page7.php"><i class="fa fa-circle"></i>Shipping Policy</a></li>
                    <li><a href="page4.php"><i class="fa fa-circle"></i>Privacy Policy</a></li>
                    
                   
                   </ul>
                  </li>


                  <?php if($izin['yoneticiizni'] == 'on'){ ?>
                    <li>
                    <a href="index.php"><i data-feather="user"></i>Admin Management<i class="fa fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="yonetici-ekle.php"><i class="fa fa-circle"></i>Add Admin</a></li>
                      <li><a href="yonetici-listele.php"><i class="fa fa-circle"></i>List Admin</a></li>
                     
                    </ul>
                  </li>
                   <?php } ?>
                  
                    <?php if($izin['siteyonetimizni'] == 'on') { ?> <li>
                    <a href="ayarlar.php"><i data-feather="settings"></i>Panel Administration</a>
                   
                  </li>
                   <?php } ?>
                  <li>
                    <a href="cikis.php"><i data-feather="check-circle"></i>Log Out</a>
                  </li>
                </ul>
            </div>