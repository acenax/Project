<?php

include_once('Controller/connect.php');
include_once('Plugin/header.php');

if (isset($_SESSION['login'])) {

    include_once('View/Home_page/Navbar_page.php');

    


    if (isset($_GET['payment_product'])) {
        include_once('View/Home_page/payment_product.php');
    } else
        if (isset($_GET['check_status_order'])) {
            include_once('View/Home_page/check_order.php');
        } else
            if (isset($_GET['historybill'])) {
                include_once('View/Home_page/historybill.php');
            } else
                if (isset($_GET['shop'])) {
                    include_once('View/Home_page/carousel.php');
                    include_once('View/Home_page/shop.php');
                } else
                    if (isset($_GET['payment'])) {
                        include_once('View/Home_page/payment_page.php');
                    } else
                        if (isset($_GET['Status_track'])) {
                            include_once('View/Home_page/Status_track.php');
                        } else
                            if (isset($_GET['gettype'])) {
                                include_once('View/Home_page/carousel.php');
                                include_once('View/Home_page/gettype.php');
                            } else
                                if (isset($_GET['product_detail'])) {
                                    include_once('View/Home_page/product_detail.php');
                                } else
                                    if (isset($_GET['Cart_shop'])) {
                                        include_once('View/Home_page/Cart_page.php');
                                    } else
                                        if (isset($_GET['Profile'])) {
                                            include_once('View/Home_page/Profile.php');
                                        } else
                                            if (isset($_GET['Address'])) {
                                                include_once('View/Home_page/Address.php');
                                            } else
                                                if (isset($_GET['history'])) {
                                                    include_once('View/Home_page/history.php');
                                                } else
                                                    if (isset($_GET['comparison'])) {
                                                        include_once('View/Home_page/comparison.php');
                                                    } else
                                                        if (isset($_GET['howtopayment'])) {
                                                            include_once('View/Home_page/howtopayment.php');
                                                        } else {
                                                            include_once('View/Error_page/404.php');
                                                        }
} else {
    include_once('View/Home_page/Navbar_page.php');
    if (isset($_GET['Cart_shop'])) {
        include_once('View/Home_page/Cart_page.php');
        } else
         if (isset($_GET['check_status_order'])) {
            include_once('View/Home_page/check_order.php');
         } else
            if (isset($_GET['howtopayment'])) {
                include_once('View/Home_page/howtopayment.php');
            } else
                if (isset($_GET['payment'])) {
                    include_once('View/Home_page/payment_page.php');
                } else
                    if (isset($_GET['Status_track'])) {
                        include_once('View/Home_page/Status_track.php');
                    } else
                        if (isset($_GET['gettype'])) {
                            include_once('View/Home_page/carousel.php');
                            include_once('View/Home_page/gettype.php');
                        } else
                            if (isset($_GET['product_detail'])) {
                                include_once('View/Home_page/product_detail.php');
                            } else
                                if (isset($_GET['shop'])) {
                                    include_once('View/Home_page/carousel.php');
                                    include_once('View/Home_page/shop.php');
                                } else
                                    if (isset($_GET['login'])) {
                                        include_once('View/login_register/login.php');
                                    } else
                                        if (isset($_GET['register'])) {
                                            include_once('View/login_register/register.php');
                                        } else {
                                            include_once('View/login_register/login.php');
                                        }
}

include_once('Plugin/footer.php');

