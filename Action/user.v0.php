<?php
include_once("../Controller/connect.php");
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_profile') {
        $update_user = $con->query("UPDATE `tbluser` SET user_fname = '" . $_POST['fname'] . "',
       user_lname = '" . $_POST['lname'] . "',
       user_phone = '" . $_POST['phone'] . "',
       user_email = '" . $_POST['email'] . "'
       WHERE user_id = '" . $_SESSION['user_id'] . "'");

        if ($update_user) {
            echo alert_msg("success", "success");
            exit;
        } else {
            echo alert_msg("error", "error");
            exit;
        }
    }

    if ($_POST['action'] == 'save_address') {
        $chk_address = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
        if ($chk_address->num_rows == 0) {
            $insert_data = $con->query("INSERT INTO `tbluseraddress`(`userAddress_number`, `userAddress_group`, `userAddress_alley`, `userAddress_separate`, `userAddress_district`, `userAddress_canton`, `userAddress_province`, `userAddress_post`, `user_id`)
             VALUES ('" . $_POST['userAddress_number'] . "','" . $_POST['userAddress_group'] . "','" . $_POST['userAddress_alley'] . "','" . $_POST['userAddress_separate'] . "','" . $_POST['userAddress_district'] . "','" . $_POST['userAddress_canton'] . "','" . $_POST['userAddress_province'] . "','" . $_POST['userAddress_post'] . "','" . $_SESSION['user_id'] . "')");
            if ($insert_data) {
                echo alert_msg("success", "success");
                exit;
            } else {
                echo alert_msg("error", "error");
                exit;
            }
        } else {
            $update_data = $con->query("UPDATE `tbluseraddress` SET `userAddress_number` = '" . $_POST['`userAddress_number`'] . "',
            `userAddress_group` = '" . $_POST['`userAddress_group`'] . "',
            `userAddress_alley` = '" . $_POST['`userAddress_alley`'] . "',
            `userAddress_separate` = '" . $_POST['`userAddress_separate`'] . "',
            `userAddress_district` = '" . $_POST['`userAddress_district`'] . "',
            `userAddress_canton` = '" . $_POST['`userAddress_canton`'] . "',
            `userAddress_province` = '" . $_POST['`userAddress_province`'] . "',
            `userAddress_post` = '" . $_POST['`userAddress_post`'] . "'
            WHERE user_id = '" . $_SESSION['user_id'] . "'");

            if ($update_data) {
                echo alert_msg("success", "success");
                exit;
            } else {
                echo alert_msg("error", "error");
                exit;
            }
        }
    }

    if ($_POST['action'] == 'getAddress') {
        $getdata = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata) {
            $rowdata = $getdata->fetch_assoc();
            echo alert_msg("success", array(
                "userAddress_number" => $rowdata['userAddress_number'],
                "userAddress_group" => $rowdata['userAddress_group'],
                "userAddress_alley" => $rowdata['userAddress_alley'],
                "userAddress_separate" => $rowdata['userAddress_separate'],
                "userAddress_district" => $rowdata['userAddress_district'],
                "userAddress_canton" => $rowdata['userAddress_canton'],
                "userAddress_province" => $rowdata['userAddress_province'],
                "userAddress_post" => $rowdata['userAddress_post'],
            )
            );
            exit;
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }

    if ($_POST['action'] == 'edit_address') {
        $chk = $con->query("UPDATE `tbluseraddress` SET `userAddress_number` = '" . $_POST['userAddress_number'] . "',
        `userAddress_group` = '" . $_POST['userAddress_group'] . "',
        `userAddress_alley` = '" . $_POST['userAddress_alley'] . "',
        `userAddress_separate` = '" . $_POST['userAddress_separate'] . "',
        `userAddress_district` = '" . $_POST['userAddress_district'] . "',
        `userAddress_canton` = '" . $_POST['userAddress_canton'] . "',
        `userAddress_province` = '" . $_POST['userAddress_province'] . "',
        `userAddress_post` = '" . $_POST['userAddress_post'] . "'
        WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
        if ($chk) {
            echo alert_msg("success", "ok");
            exit;
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }
}