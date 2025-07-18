<?php
include_once("../Controller/connect.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Add_Users') {
        $chk_user = $con->query("SELECT * FROM `tbluser` WHERE user_username = '" . $_POST['user_username'] . "'");
        if ($chk_user->num_rows > 0) {
            echo alert_msg("taken", "taken");
            exit;
        } else {
            $passmd5 = md5($_POST['user_password']);
            $insert_user = $con->query("INSERT INTO `tbluser`(`user_username`, `user_password`, `user_Real_password` , `user_fname`, `user_lname`, `user_phone`, `user_email`, `user_type`) 
            VALUES ('" . $_POST['user_username'] . "','$passmd5','" . $_POST['user_password'] . "','" . $_POST['user_fname'] . "','" . $_POST['user_lname'] . "','" . $_POST['user_phone'] . "','" . $_POST['user_email'] . "','" . $_POST['user_type'] . "')");
            if ($insert_user) {
                echo alert_msg("success", "success");
                exit;
            } else {
                echo alert_msg("error", "error");
                exit;
            }
        }
    }

    if ($_POST['action'] == 'getuser') {
        $getdata = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata) {
            $rowdata = $getdata->fetch_assoc();
            echo alert_msg("success", array(
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
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }

    if ($_POST['action'] == 'Edit_Users') {
        $getdata = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata->num_rows > 0) {

            $chkusers = $con->query("SELECT * FROM `tbluser` WHERE user_username = '" . $_POST['user_username'] . "'");

            if ($chkusers->num_rows > 0) {
                echo alert_msg("taken", "taken");
                exit;
            } else {
                $passmd5 = md5($_POST['user_password']);
                if ($_POST['user_username'] == '' || $_POST['user_username'] == null) {

                    $update_user = $con->query("UPDATE `tbluser` SET user_password = '$passmd5',
                        user_Real_password = '" . $_POST['user_password'] . "',
                        user_fname = '" . $_POST['user_fname'] . "',
                        user_lname = '" . $_POST['user_lname'] . "',
                        user_phone = '" . $_POST['user_phone'] . "',
                        user_email = '" . $_POST['user_email'] . "',
                        user_type = '" . $_POST['user_type'] . "'
                        WHERE `user_id` = '" . $_POST['id'] . "'");
                    if ($update_user) {
                        echo alert_msg("success", "success");
                        exit;
                    } else {
                        echo alert_msg("error", "wrong");
                        exit;
                    }
                } else {
                    $update_user = $con->query("UPDATE `tbluser` SET user_username = '" . $_POST['user_username'] . "',
                        user_password = '$passmd5',
                        user_Real_password = '" . $_POST['user_password'] . "',
                        user_fname = '" . $_POST['user_fname'] . "',
                        user_lname = '" . $_POST['user_lname'] . "',
                        user_phone = '" . $_POST['user_phone'] . "',
                        user_email = '" . $_POST['user_email'] . "',
                        user_type = '" . $_POST['user_type'] . "'
                        WHERE `user_id` = '" . $_POST['id'] . "'");
                    if ($update_user) {
                        echo alert_msg("success", "success");
                        exit;
                    } else {
                        echo alert_msg("error", "wrong");
                        exit;
                    }
                }
            }
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }

    if ($_POST['action'] == 'del_user') {
        $chk_data = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_POST['del_user'] . "' LIMIT 1");
        if ($chk_data->num_rows > 0) {
            $del_data = $con->query("DELETE FROM `tbluser` WHERE `user_id` = '" . $_POST['del_user'] . "' LIMIT 1");
            if ($del_data) {
                echo alert_msg("success", "ok");
                exit;
            } else {
                echo alert_msg("error", "wrong");
                exit;
            }
        } else {
            echo alert_msg("error", "notnum");
            exit;
        }
    }
}