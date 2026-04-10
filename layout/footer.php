<?php if (!isset($basePath)) $basePath = ''; ?>
<footer class="footer_section footer_bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="main_footer d-flex justify-content-between align-items-center">
                    <div class="footer_left">
                        <div class="footer_logo">
                            <a href="<?=$basePath?>index.php"><img src="<?=$basePath?>assets/img/logo/Artboard 1 copy 3.png" width="140px"
                                    alt=""></a>
                        </div>
                        <div class="footer_social">
                            <ul class="d-flex">
                                <li><a href="https://www.instagram.com/masq.leather"><i
                                            class="ion-social-instagram"></i></a></li>
                                <li><a href="https://www.pinterest.ca/masqleather/"><i
                                            class="ion-social-pinterest"></i></a></li>
                                <li><a href="https://www.facebook.com/p/Masq-Leather-100088953440796/"><i
                                            class="ion-social-facebook"></i></a></li>
                                <li><a href="https://www.tiktok.com/@masqleather"><svg style="margin-bottom:0.15cm;"
                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M412.19 118.66a109 109 0 0 1-9.45-5.5a133 133 0 0 1-24.27-20.62c-18.1-20.71-24.86-41.72-27.35-56.43h.1C349.14 23.9 350 16 350.13 16h-82.44v318.78c0 4.28 0 8.51-.18 12.69c0 .52-.05 1-.08 1.56c0 .23 0 .47-.05.71v.18a70 70 0 0 1-35.22 55.56a68.8 68.8 0 0 1-34.11 9c-38.41 0-69.54-31.32-69.54-70s31.13-70 69.54-70a68.9 68.9 0 0 1 21.41 3.39l.1-83.94a153.14 153.14 0 0 0-118 34.52a161.8 161.8 0 0 0-35.3 43.53c-3.48 6-16.61 30.11-18.2 69.24c-1 22.21 5.67 45.22 8.85 54.73v.2c2 5.6 9.75 24.71 22.38 40.82A167.5 167.5 0 0 0 115 470.66v-.2l.2.2c39.91 27.12 84.16 25.34 84.16 25.34c7.66-.31 33.32 0 62.46-13.81c32.32-15.31 50.72-38.12 50.72-38.12a158.5 158.5 0 0 0 27.64-45.93c7.46-19.61 9.95-43.13 9.95-52.53V176.49c1 .6 14.32 9.41 14.32 9.41s19.19 12.3 49.13 20.31c21.48 5.7 50.42 6.9 50.42 6.9v-81.84c-10.14 1.1-30.73-2.1-51.81-12.61" />
                                        </svg></a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="footer_sidebar d-flex">
                        <div class="footer_widget_list">
                            <div class="footer_widget_title">
                                <h3>COMPANY</h3>
                            </div>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="<?=$basePath?>about.php">About Us</a></li>
                                    <li><a href="<?=$basePath?>contact.php">Contact</a></li>


                                    <li><a href="#">Site Map</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="footer_widget_list">
                            <div class="footer_widget_title">
                                <h3>Support</h3>
                            </div>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="<?=$basePath?>legal/terms.php">Terms of Service</a></li>
                                    <li><a href="<?=$basePath?>legal/refund.php">Refund Policy</a></li>
                                    <li><a href="<?=$basePath?>legal/shipping.php">Shipping Policy</a></li>
                                    <li><a href="<?=$basePath?>legal/privacy.php">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="footer_widget_list">
                            <div class="footer_widget_title">
                                <h3>Latest Blogs</h3>
                            </div>
                            <div class="footer_menu">
                                <ul>
                                    <?php
    $sql = "SELECT adi, id FROM bloglar ORDER BY id DESC LIMIT 4";
    $stmt = $db->query($sql);

    if ($stmt) {
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li><a href="' . $basePath . 'blog-details.php?id=' . $row["id"] . '">' . $row["adi"] . '</a></li>';
            }
        } else {
            echo "Hiç blog bulunamadı.";
        }
    } else {
        echo "Sorgu hatası: " . print_r($conn->errorInfo());
    }
    ?>
                                </ul>

                            </div>

                        </div>
                        <div class="footer_widget_list">
                            <div class="footer_widget_title">
                                <h3>Sign up for newsletter</h3>
                            </div>
                            <div class="newsletter_subscribe">
                                <form id="newsletter_form">
                                    <input type="email" name="email" autocomplete="off" placeholder="Email address... "
                                        required>
                                    <button type="submit">Subscribe</button>
                                </form>

                            </div>
                            <div id="message_success" style="color: green; display: none;">
                                <p>Subscription successful!</p>
                            </div>
                            <div id="message_failed" style="color: red; display: none;">
                                <p>There was an error. Please try again.</p>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="footer_bottom">
                    <div class="copyright_right text-center">
                        <p>&copy; 2023 All rights reserved Made
                            by <a href="https://www.adwebture.com">Adwebture</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>