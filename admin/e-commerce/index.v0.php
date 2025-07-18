<?php
include_once('Controller/connect.php');
include_once('../../Controller/constants.php');
include_once('../../Controller/helpers.php');

if (!isset($_SESSION['login'])) {
    header('location: ?Login');
}

if (empty($_SESSION['user_level']) || USER_LEVEL > $_SESSION['user_level']) {
    header('location: ' . site_url());
}

include_once("Plugins/header.php");

if (isset($_GET['logout'])) {
        session_destroy();
        echo "<script>";
        echo "Swal.fire({";
        echo "icon:'success',";
        echo "title: 'ออกจากระบบเรียบร้อย'";
        echo "}).then(function() {";
        echo "window.location = './?login' ";
        echo " }),setTimeout(function(){ ";
        echo "window.location = './?login' },5000)";
        echo "</script>";
    }

if (strlen($_SESSION['login']) != 0) {
    if (isset($_GET['historyRecord'])) {
        include_once("View/Admin_page/historyRecord.php");
    } else
        if (isset($_GET['history'])) {
            include_once("View/Admin_page/history.php");
        } else
            if (isset($_GET['dashboard'])) {
                include_once("View/Admin_page/dashboard.php");
            } else
                if (isset($_GET['bank'])) {
                    include_once("View/Admin_page/bank.php");
                } else
                    if (isset($_GET['Admin'])) {
                        include_once("View/Admin_page/Admin.php");
                    } else
                        if (isset($_GET['Users'])) {
                            include_once("View/Admin_page/Users.php");
                        } else
                            if (isset($_GET['ProductType'])) {
                                include_once("View/Admin_page/product_type.php");
                            } else
                                if (isset($_GET['Product'])) {
                                    include_once("View/Admin_page/product.php");
                                } else
                                    if (isset($_GET['PendingProduct'])) {
                                        include_once("View/Admin_page/pending_type.php");
                                    } else
                                        if (isset($_GET['ProductStatus'])) {
                                            include_once("View/Admin_page/product_status.php");
                                        } else
                                            if (isset($_GET['DetailProduct'])) {
                                                include_once("View/Admin_page/product_detail.php");
                                            } else
                                                if (isset($_GET['check_payment'])) {
                                                    include_once("View/Admin_page/check_payment.php");
                                                } else
                                                    if (isset($_GET['banner'])) {
                                                        include_once("View/Admin_page/banner.php");
                                                    } else {
                                                        include_once("View/Admin_page/dashboard.php");
                                                    }
}



include_once("Plugins/footer.php");