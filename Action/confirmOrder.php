<?php
include_once("../Controller/connect.php");

$ACTION = (isset($_POST['action'])) ? $_POST['action'] : '';

if ($ACTION == 'update_shipping') {
    if (empty($_POST['id'])) {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    } else {
        $_SESSION['shipping'] = (int) $_POST['id'];
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    exit();
} else if ($ACTION == 'update_address') {
    if (empty($_POST['id'])) {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    } else {
        $_SESSION['address'] = (int) $_POST['id'];
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    exit();
}