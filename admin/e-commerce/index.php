<?php
include_once('Controller/connect.php');
include_once('../../Controller/constants.php');
include_once('../../Controller/ThaiDatetime.php');
include_once('../../Controller/helpers.php');
include_once('Controller/routes.php');
include_once('Controller/menus.php');

if (!isset($_SESSION['login'])) {
    header('location: ?Login');
}

if (empty($_SESSION['user_level']) || USER_LEVEL > $_SESSION['user_level']) {
    header('location: ' . site_url());
}

// page header
include_once("Plugins/header.php");

// page body
$page_not_found = true;

// page route
foreach ($routes as $key => $page) {
    if (isset($_GET[$key])) {
        foreach ($page['files'] as $file) {
            if (is_file($file)) {
                require_once($file);
                $page_not_found = false;
            }
        }

        if ($page_not_found) {
            include_once('View/Error_page/404.php');

            $page_not_found = false;
        }

        break;
    }
}

if ($page_not_found) {
    include_once("View/Admin_page/dashboard.php");
}

// page footer
include_once("Plugins/footer.php");
