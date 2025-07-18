<?php
include_once("../Controller/connect.php");

if (!isset($_SESSION['comparison'])) {
    $_SESSION['comparison'] = [];
}

$ACTION = (isset($_POST['action'])) ? $_POST['action'] : '';

if ('addItem' == $ACTION) {
    if (empty($_POST['id'])) {
        echo alert_msg("error", "กรุณาระบุรายการสินค้าด้วยค่ะ !");
        exit();
    }

    $idx = array_search((int) $_POST['id'], $_SESSION['comparison']);
    if (false !== $idx) {
        echo alert_msg("error", "รายการสินค้านี้มีอยู่แล้วค่ะ");
        exit();
    }

    $_SESSION['comparison'][] = (int) $_POST['id'];
    echo alert_msg("success", "เพิ่มรายการเรียบร้อยแล้ว");

    exit();
} else if ('delItem' == $ACTION) {
    if (empty($_POST['id'])) {
        echo alert_msg("error", "กรุณาระบุรายการสินค้าด้วยค่ะ !");
        exit();
    }

    $idx = array_search((int) $_POST['id'], $_SESSION['comparison']);
    if (false !== $idx) {
        unset($_SESSION['comparison'][$idx]);
    }

    echo alert_msg("success", "ลบรายการเรียบร้อยแล้ว");
    exit();
}