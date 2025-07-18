<?php
include_once("../Controller/connect.php");
require_once('../../../Controller/constants.php');

// Authentication validation
if (empty($_SESSION['login']) || empty($_SESSION['user_level']) || USER_LEVEL > $_SESSION['user_level']) {
    echo alert_msg("error", "error");
    exit;
}

$ACTION = (!empty($_POST['action'])) ? $_POST['action'] : '';
if (empty($ACTION)) {
    echo alert_msg("error", "error");
    exit;
}
if ('getItem' == $ACTION) {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;
    $rs = $con->query("SELECT `shipping_id`, `provider_name`, `shipping_rate`, `status` FROM `tblshipping` WHERE `shipping_id` = '{$id}' LIMIT 1");
    if (0 < $rs->num_rows) {
        echo alert_msg("success", $rs->fetch_assoc());
    } else {
        echo alert_msg("error", "ไม่พบข้อมูล");
    }
    exit;
} else if ('addnew' == $ACTION) {
    if (empty($_POST['provider']) || empty($_POST['price'])) {
        echo alert_msg("error", "กรุณาป้อนข้อมูลให้ครบด้วยค่ะ");
        exit;
    }

    $rs = $con->query("INSERT INTO `tblshipping`(`provider_name`, `shipping_rate`, `status`) VALUES ('{$_POST['provider']}', '" . (float) $_POST['price'] . "', 'ACTIVE')");
    if ($rs) {
        echo alert_msg("success", "เพิ่มข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit;
} else if ('update' == $ACTION) {
    if (empty($_POST['provider']) || empty($_POST['price']) || empty($_POST['status'])) {
        echo alert_msg("error", "กรุณาป้อนข้อมูลให้ครบด้วยค่ะ");
        exit;
    }
    $sql = "UPDATE `tblshipping` SET `provider_name` = '{$_POST['provider']}'
        , `shipping_rate` = '" . (float) $_POST['price'] . "'
        , `status` = '{$_POST['status']}'
        WHERE (`shipping_id` = '{$_POST['id']}');
    ";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit();
} else if ('delete' == $ACTION) {

    $sql = "DELETE FROM `tblshipping` WHERE (`shipping_id` = '{$_POST['id']}');";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "ลบข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit();
}