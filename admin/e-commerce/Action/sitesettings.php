<?php
include_once("../Controller/connect.php");
require_once('../../../Controller/constants.php');

// Authentication validation
if (empty($_SESSION['login']) || empty($_SESSION['user_level']) || USER_LEVEL > $_SESSION['user_level']) {
    echo alert_msg("error", "error");
    exit;
}

$ACTION = (!empty($_POST['action'])) ? $_POST['action'] : '';
if ('update_settings' == $ACTION) {
    $error = true;
    // site title
    if (isset($_POST['site_title'])) {
        $sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitesettings` SET `setting_value` = '{$_POST['site_title']}' WHERE (`setting_key` = 'SITE_TITLE')";
        } else {
            $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_TITLE', '{$_POST['site_title']}')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }

    }

    // site logo
    if (isset($_FILES['logo']) && 0 == $_FILES['logo']['error']) {
        $logo = (object) [
            'mim_type' => mime_content_type($_FILES['logo']['tmp_name']),
            'raw_content' => base64_encode(file_get_contents($_FILES['logo']['tmp_name'])),
        ];

        $sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_LOGO' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitesettings` SET `setting_value` = '" . json_encode($logo) . "' WHERE (`setting_key` = 'SITE_LOGO')";
        } else {
            $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_LOGO', '" . json_encode($logo) . "')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }
    }

    // login banner
    if (isset($_FILES['banlog']) && 0 == $_FILES['banlog']['error']) {
        $logo = (object) [
            'mim_type' => mime_content_type($_FILES['banlog']['tmp_name']),
            'raw_content' => base64_encode(file_get_contents($_FILES['banlog']['tmp_name'])),
        ];

        $sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANLOG' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitesettings` SET `setting_value` = '" . json_encode($logo) . "' WHERE (`setting_key` = 'SITE_BANLOG')";
        } else {
            $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_BANLOG', '" . json_encode($logo) . "')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }
    }

     // login banner
     if (isset($_FILES['banhow']) && 0 == $_FILES['banhow']['error']) {
        $logo = (object) [
            'mim_type' => mime_content_type($_FILES['banhow']['tmp_name']),
            'raw_content' => base64_encode(file_get_contents($_FILES['banhow']['tmp_name'])),
        ];

        $sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANHOW' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitesettings` SET `setting_value` = '" . json_encode($logo) . "' WHERE (`setting_key` = 'SITE_BANHOW')";
        } else {
            $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_BANHOW', '" . json_encode($logo) . "')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }
    }

    // register banner
    if (isset($_FILES['banres']) && 0 == $_FILES['banres']['error']) {
        $logo = (object) [
            'mim_type' => mime_content_type($_FILES['banres']['tmp_name']),
            'raw_content' => base64_encode(file_get_contents($_FILES['banres']['tmp_name'])),
        ];

        $sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANRES' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitesettings` SET `setting_value` = '" . json_encode($logo) . "' WHERE (`setting_key` = 'SITE_BANRES')";
        } else {
            $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_BANRES', '" . json_encode($logo) . "')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }
    }

    if (false == $error) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
} else if ('update_pages' == $ACTION) {
    $error = true;
    if (isset($_POST['footer_content'])) {
        $sql = "SELECT * FROM `tblsitepages` WHERE `page_name` = 'SITE_FOOTER' LIMIT 1;";
        $rs = $con->query($sql);
        if (0 < $rs->num_rows) {
            $sql = "UPDATE `tblsitepages` SET `page_content` = '{$_POST['footer_content']}' WHERE (`page_name` = 'SITE_FOOTER')";
        } else {
            $sql = "INSERT INTO `tblsitepages` (`page_name`, `page_content`) VALUES ('SITE_FOOTER', '{$_POST['footer_content']}')";
        }

        $rs = $con->query($sql);
        if ($rs) {
            $error = false;
        }
    }

    if (false === $error) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
}