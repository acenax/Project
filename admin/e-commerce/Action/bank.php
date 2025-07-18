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

// get bank
if ($ACTION == 'getbank') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;

    $getdata = $con->query("SELECT `bank_id`, `bank_bank`, `bank_number`, `bank_name` FROM `tblbank` WHERE (`bank_id` = '{$id}') LIMIT 1;");
    if (0 == $getdata->num_rows) {
        echo alert_msg("error", "wrong");
        exit();
    }

    $rowdata = $getdata->fetch_assoc();
    echo alert_msg("success", $rowdata);
    exit;
}

// delete bank
if ($ACTION == 'del_bank') {
    $id = (!empty($_POST['del_bank'])) ? (int) $_POST['del_bank'] : 0;

    $chk_data = $con->query("SELECT * FROM `tblbank` WHERE (`bank_id` = '{$id}') LIMIT 1");
    if (0 == $chk_data->num_rows) {
        echo alert_msg("error", "notnum");
        exit();
    }

    $del_data = $con->query("DELETE FROM `tblbank` WHERE (`bank_id` = '{$id}') LIMIT 1");

    if ($del_data) {
        echo alert_msg("success", "ok");
    } else {
        echo alert_msg("error", "wrong");
    }

    exit;
}


// addnew and update user
$bank_data = [
    'bank_bank' => (!empty($_POST['bank'])) ? $_POST['bank'] : '',
    'bank_number' => (!empty($_POST['banknumber'])) ? $_POST['banknumber'] : '',
    'bank_name' => (!empty($_POST['bankname'])) ? $_POST['bankname'] : '',
];

// insert new user
if ($ACTION == 'addbank') {
    // duplicate bank number check
    $chk_user = $con->query("SELECT * FROM `tblbank` WHERE (bank_number = '{$bank_data['bank_number']}') LIMIT 1;");
    if ($chk_user->num_rows > 0) {
        echo alert_msg("taken", "taken");
        exit;
    }

    $sql = "INSERT INTO `tblbank` (`" . implode('`,`', array_keys($bank_data)) . "`) VALUES ('" . implode("','", $bank_data) . "')";
    $insert_user = $con->query($sql);

    if ($insert_user) {
        echo alert_msg("success", "success");
    } else {
        echo alert_msg("error", "error");
    }

    exit;
}

// update bank data
if ($ACTION == 'editbank') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;

    // check existing user
    $rs = $con->query("SELECT * FROM `tblbank` WHERE (`bank_id` = '{$id}') LIMIT 1;");
    if (0 == $rs->num_rows) {
        echo alert_msg("error", "wrong");
        exit();
    }

    // check duplicate bank number
    $rs = $con->query("SELECT * FROM `tblbank` WHERE (`bank_number` = '{$bank_data['bank_number']}' AND `bank_id` <> '{$id}')");
    if (0 < $rs->num_rows) {
        echo alert_msg("taken", "taken");
        exit;
    }


    $update_fields = '';
    foreach ($bank_data as $field_name => $val) {
        $update_fields .= (!empty(($update_fields))) ? ',' : '';
        $update_fields .= "`{$field_name}` = '{$val}'";
    }

    $sql = "UPDATE `tblbank` SET {$update_fields} WHERE (`bank_id` = '{$id}');";

    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "success");
    } else {
        echo alert_msg("error", "wrong");
    }

    exit;
}