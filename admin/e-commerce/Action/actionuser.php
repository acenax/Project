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

// get users
if ($ACTION == 'getuser') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;

    $getdata = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '{$id}' LIMIT 1;");
    if (0 == $getdata->num_rows) {
        echo alert_msg("error", "wrong");
        exit();
    }

    $rowdata = $getdata->fetch_assoc();
    echo alert_msg(
        "success",
        array(
            "user_username" => $rowdata['user_username'],
            "user_password" => $rowdata['user_Real_password'],
            "user_fname" => $rowdata['user_fname'],
            "user_lname" => $rowdata['user_lname'],
            "user_phone" => $rowdata['user_phone'],
            "user_email" => $rowdata['user_email'],
            "user_type" => $rowdata['user_type'],
        )
    );
    exit;
}

// delete user
if ($ACTION == 'del_user') {
    $id = (!empty($_POST['del_user'])) ? (int) $_POST['del_user'] : 0;

    $chk_data = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '{$id}' LIMIT 1");
    if (0 == $chk_data->num_rows) {
        echo alert_msg("error", "notnum");
        exit();
    }

    $del_data = $con->query("DELETE FROM `tbluser` WHERE `user_id` = '{$id}' LIMIT 1");

    if ($del_data) {
        echo alert_msg("success", "ok");
    } else {
        echo alert_msg("error", "wrong");
    }

    exit;
}

// addnew and update user
$user_data = [
    'user_fname' => (!empty($_POST['user_fname'])) ? $_POST['user_fname'] : '',
    'user_lname' => (!empty($_POST['user_lname'])) ? $_POST['user_lname'] : '',
    'user_phone' => (!empty($_POST['user_phone'])) ? $_POST['user_phone'] : '',
    'user_email' => (!empty($_POST['user_email'])) ? $_POST['user_email'] : '',
    'user_type' => (!empty($_POST['user_type'])) ? $_POST['user_type'] : ''
];

$username = (!empty($_POST['user_username'])) ? $_POST['user_username'] : '';
$real_password = (!empty($_POST['user_password'])) ? $_POST['user_password'] : '';
$passmd5 = (!empty($real_password)) ? md5($real_password) : '';

// insert new user
if ($ACTION == 'Add_Users') {
    // duplicate username check
    $chk_user = $con->query("SELECT * FROM `tbluser` WHERE user_username = '{$username}'");
    if ($chk_user->num_rows > 0) {
        echo alert_msg("taken", "taken");
        exit;
    }

    $user_data['user_username'] = $username;


    // password prepaire
    if (!empty($real_password)) {
        $user_data['user_Real_password'] = $real_password;
        $user_data['user_password'] = $passmd5;
    }

    $sql = "INSERT INTO `tbluser` (`" . implode('`,`', array_keys($user_data)) . "`) VALUES ('" . implode("','", $user_data) . "')";
    $insert_user = $con->query($sql);

    if ($insert_user) {
        echo alert_msg("success", "success");
    } else {
        echo alert_msg("error", "error");
    }

    exit;
}

// update user data
if ($ACTION == 'Edit_Users') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;

    // check existing user
    $getdata = $con->query("SELECT * FROM `tbluser` WHERE (`user_id` = '{$id}') LIMIT 1;");
    if (0 == $getdata->num_rows) {
        echo alert_msg("error", "wrong");
        exit();
    }

    // when change username
    // check duplicate username
    if (!empty($username)) {
        $chkusers = $con->query("SELECT * FROM `tbluser` WHERE (`user_username` = '{$username}' AND `user_id` <> '{$id}')");
        if (0 < $chkusers->num_rows) {
            echo alert_msg("taken", "taken");
            exit;
        }

        $user_data['user_username'] = $username;
    }

    // when change password
    if (!empty($real_password)) {
        $user_data['user_Real_password'] = $real_password;
        $user_data['user_password'] = $passmd5;
    }

    $update_fields = '';
    foreach ($user_data as $field_name => $val) {
        $update_fields .= (!empty(($update_fields))) ? ',' : '';
        $update_fields .= "`{$field_name}` = '{$val}'";
    }

    $sql = "UPDATE `tbluser` SET {$update_fields} WHERE `user_id` = '{$id}';";

    $update_user = $con->query($sql);
    if ($update_user) {
        echo alert_msg("success", "success");
    } else {
        echo alert_msg("error", "wrong");
    }

    exit;
}