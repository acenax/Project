<?php
include_once("../Controller/connect.php");
require_once('../Controller/constants.php');

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'register_form') {
        if ($_POST['username'] == '' || $_POST['password'] == '' || $_POST['Cpassword'] == '') {
            echo alert_msg("empty", "empty");
            exit;
        } else {
            $chkuser = $con->query("SELECT * FROM `tbluser` WHERE user_username = '" . $_POST['username'] . "'");
            if ($chkuser->num_rows > 0) {
                echo alert_msg("taken", "taken");
                exit;
            } else {
                if ($_POST['password'] != $_POST['Cpassword']) {
                    echo alert_msg("worngPass", "worngPass");
                    exit;
                } else {
                    $passmd5 = md5($_POST['password']);
                    $insert_data = $con->query("INSERT INTO `tbluser`(`user_username`, `user_password`, `user_Real_password`, `user_type`) VALUES ('" . $_POST['username'] . "','$passmd5', '" . $_POST['password'] . "', 'member')");
                    if ($insert_data) {
                        echo alert_msg("success", "success");
                        exit;
                    }
                }
            }
        }
    }

    if ($_POST['action'] == 'login_form') {
        if ($_POST['username'] == '' || $_POST['password'] == '') {
            echo alert_msg("empty", "empty");
            exit;
        } else {
            $passmd5 = md5($_POST['password']);
            $chkuser = $con->query("SELECT * FROM `tbluser` WHERE user_username = '" . $_POST['username'] . "' AND user_password = '$passmd5'");
            if ($chkuser->num_rows == 0) {
                echo alert_msg("worngPass", "worngPass");
                exit;
            } else {
                $rowuser = $chkuser->fetch_assoc();

                $_SESSION['user_id'] = $rowuser['user_id'];
                $_SESSION['user_fullname'] = sprintf('%s %s', ucfirst($rowuser['user_fname']), ucfirst($rowuser['user_lname']));
                $_SESSION['login'] = 'login';

                if ($rowuser['user_type'] == 'admin') {
                    $_SESSION['user_level'] = ADMIN_LEVEL;
                    echo alert_msg("success_admin", "success_admin");
                    exit;
                } else if ($rowuser['user_type'] == 'user') {
                    echo alert_msg("success_user", "success_user");
                    $_SESSION['user_level'] = USER_LEVEL;
                    exit;
                } else {
                    $_SESSION['user_level'] = MEMBER_LEVEL;
                    echo alert_msg("success", "success");
                    exit;
                }
            }
        }
    }
}