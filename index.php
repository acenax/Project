<?php
include_once('Controller/connect.php');
require_once('Controller/routes.php');
require_once('Controller/helpers.php');
require_once('Controller/constants.php');
require_once('Controller/ThaiDatetime.php');

// html
include_once('Plugin/header.php');

// page navigation
include_once('View/Home_page/Navbar_page.php');
// page body
$page_not_found = true;
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
    // home page
    include_once('View/Home_page/carousel.php');
    include_once('View/Home_page/home.php');
}
// page footer
// include_once('Plugin/footer.php');
