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
        <li class="sidebar-title">Menu</li>

        <li>
            <a href="index.php"><i data-feather="home"></i>Dashboard</a>
        </li>

        <!-- ============ CATALOG ============ -->
        <li class="sidebar-title">Catalog</li>

        <li>
            <a href="urun-listele.php"><i data-feather="shopping-bag"></i>Products</a>
        </li>

        <li>
            <a href="urun-kategori-listele.php"><i data-feather="grid"></i>Categories</a>
        </li>

        <li>
            <a href="bag-purses-kampanya-listele.php"><i data-feather="percent"></i>Campaigns</a>
        </li>

        <!-- ============ CONTENT ============ -->
        <li class="sidebar-title">Content</li>

        <li>
            <a href="index.php"><i data-feather="edit-3"></i>Blog<i class="fa fa-chevron-right dropdown-icon"></i></a>
            <ul class="">
                <li><a href="blog-listele.php"><i class="fa fa-circle"></i>Blog Masq</a></li>
                <li><a href="blog-ekle.php"><i class="fa fa-circle"></i>Blog Masq — Add</a></li>
                <li><a href="blogmer-listele.php"><i class="fa fa-circle"></i>Blog Mercantile</a></li>
                <li><a href="blogmer-ekle.php"><i class="fa fa-circle"></i>Blog Mercantile — Add</a></li>
            </ul>
        </li>

        <li>
            <a href="index.php"><i data-feather="message-square"></i>Comments<i class="fa fa-chevron-right dropdown-icon"></i></a>
            <ul class="">
                <li><a href="sc-listele.php"><i class="fa fa-circle"></i>List Comments</a></li>
                <li><a href="sc-ekle.php"><i class="fa fa-circle"></i>Add Comment</a></li>
            </ul>
        </li>

        <li>
            <a href="index.php"><i data-feather="file-text"></i>Pages<i class="fa fa-chevron-right dropdown-icon"></i></a>
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

        <!-- ============ MARKETING ============ -->
        <li class="sidebar-title">Marketing</li>

        <li>
            <a href="index.php"><i data-feather="tag"></i>Promotions<i class="fa fa-chevron-right dropdown-icon"></i></a>
            <ul class="">
                <li><a href="cupon-listele.php"><i class="fa fa-circle"></i>Coupons</a></li>
                <li><a href="cupon-ekle.php"><i class="fa fa-circle"></i>Coupons — Add</a></li>
                <li><a href="gift-card-list.php"><i class="fa fa-circle"></i>Gift Cards</a></li>
                <li><a href="gift-card-add.php"><i class="fa fa-circle"></i>Gift Cards — Add</a></li>
            </ul>
        </li>

        <li>
            <a href="abone-listele.php"><i data-feather="mail"></i>Newsletter Subscribers</a>
        </li>

        <li>
            <a href="campaign.php"><i data-feather="film"></i>Promo Banner</a>
        </li>

        <!-- ============ STORE SETTINGS ============ -->
        <li class="sidebar-title">Store</li>

        <li>
            <a href="index.php"><i data-feather="truck"></i>Shipping &amp; Tax<i class="fa fa-chevron-right dropdown-icon"></i></a>
            <ul class="">
                <li><a href="cargo-range.php"><i class="fa fa-circle"></i>Cargo Fee</a></li>
                <li><a href="province-tax.php"><i class="fa fa-circle"></i>Province Tax Rates</a></li>
            </ul>
        </li>

        <li>
            <a href="yazilar.php"><i data-feather="search"></i>SEO Settings</a>
        </li>

        <!-- ============ ADMINISTRATION ============ -->
        <li class="sidebar-title">Administration</li>

        <li>
            <a href="index.php"><i data-feather="settings"></i>System<i class="fa fa-chevron-right dropdown-icon"></i></a>
            <ul class="">
                <li><a href="sayac.php"><i class="fa fa-circle"></i>Security</a></li>
                <li><a href="mailayarlari.php"><i class="fa fa-circle"></i>User Accounts</a></li>
                <li><a href="mail-metinleri.php"><i class="fa fa-circle"></i>Mail Texts</a></li>
                <?php if($izin['yoneticiizni'] == 'on'){ ?>
                <li><a href="yonetici-listele.php"><i class="fa fa-circle"></i>Admins</a></li>
                <li><a href="yonetici-ekle.php"><i class="fa fa-circle"></i>Admins — Add</a></li>
                <?php } ?>
                <?php if($izin['siteyonetimizni'] == 'on'){ ?>
                <li><a href="ayarlar.php"><i class="fa fa-circle"></i>Panel Administration</a></li>
                <?php } ?>
            </ul>
        </li>

        <li>
            <a href="cikis.php"><i data-feather="log-out"></i>Log Out</a>
        </li>
    </ul>
</div>
