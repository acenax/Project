<?php
include_once("../Controller/connect.php");

$ACTION = (isset($_POST['action'])) ? $_POST['action'] : '';

if ($ACTION == 'getAddr') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;

    $data = [
        'userAddress_id',
        'userAddress_number',
        'userAddress_group',
        'userAddress_alley',
        'userAddress_separate',
        'userAddress_district',
        'userAddress_canton',
        'userAddress_province',
        'userAddress_post',
    ];

    $sql = "SELECT `" . implode("`,`", $data) . "` FROM `tbluseraddress`
    WHERE (`userAddress_id` = '{$id}') LIMIT 1;";

    $rs = $con->query($sql);
    if (0 == $rs->num_rows) {
        echo alert_msg("error", "ไม่พบข้อมูล");
    } else {
        echo alert_msg("success", $rs->fetch_assoc());
    }
} else if ($ACTION == 'save_address') {
    $data = [
        'userAddress_number' => (isset($_POST['userAddress_number'])) ? $_POST['userAddress_number'] : null,
        'userAddress_group' => (isset($_POST['userAddress_group'])) ? $_POST['userAddress_group'] : null,
        'userAddress_alley' => (isset($_POST['userAddress_alley'])) ? $_POST['userAddress_alley'] : null,
        'userAddress_separate' => (isset($_POST['userAddress_separate'])) ? $_POST['userAddress_separate'] : null,
        'userAddress_district' => (isset($_POST['userAddress_district'])) ? $_POST['userAddress_district'] : null,
        'userAddress_canton' => (isset($_POST['userAddress_canton'])) ? $_POST['userAddress_canton'] : null,
        'userAddress_province' => (isset($_POST['userAddress_province'])) ? $_POST['userAddress_province'] : null,
        'userAddress_post' => (isset($_POST['userAddress_post'])) ? $_POST['userAddress_post'] : null,
        'user_id' => (int) $_SESSION['user_id'],
    ];

    $sql = "INSERT INTO `tbluseraddress` (`" . implode("`,`", array_keys($data)) . "`) VALUES('" . implode("','", $data) . "');";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "เพิ่มข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
} else if ($ACTION == 'edit_address') {
    $id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;
    $data = [
        'userAddress_number' => (isset($_POST['userAddress_number'])) ? $_POST['userAddress_number'] : null,
        'userAddress_group' => (isset($_POST['userAddress_group'])) ? $_POST['userAddress_group'] : null,
        'userAddress_alley' => (isset($_POST['userAddress_alley'])) ? $_POST['userAddress_alley'] : null,
        'userAddress_separate' => (isset($_POST['userAddress_separate'])) ? $_POST['userAddress_separate'] : null,
        'userAddress_district' => (isset($_POST['userAddress_district'])) ? $_POST['userAddress_district'] : null,
        'userAddress_canton' => (isset($_POST['userAddress_canton'])) ? $_POST['userAddress_canton'] : null,
        'userAddress_province' => (isset($_POST['userAddress_province'])) ? $_POST['userAddress_province'] : null,
        'userAddress_post' => (isset($_POST['userAddress_post'])) ? $_POST['userAddress_post'] : null,
        'user_id' => (int) $_SESSION['user_id'],
    ];

    $sql = '';
    foreach ($data as $field => $val) {
        $sql .= (empty($sql)) ? '' : ',';
        $sql .= (null === $val) ? sprintf('`%s` = %s', $field, $val) : sprintf("`%s` = '%s'", $field, $val);
    }


    $sql = "UPDATE `tbluseraddress` SET {$sql} WHERE (`userAddress_id` = '{$id}') AND (`user_id` = '{$_SESSION['user_id']}');";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit;
} else if ('delete_address' == $ACTION) {

    $sql = "DELETE FROM `tbluseraddress` WHERE (`userAddress_id` = '{$_POST['id']}') AND (`user_id` = '{$_SESSION['user_id']}');";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "ลบข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit;
}


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save_profile') {
        // Update user profile information
        $update_user = $con->query("UPDATE `tbluser` SET user_fname = '" . $_POST['fname'] . "',
       user_lname = '" . $_POST['lname'] . "',
       user_phone = '" . $_POST['phone'] . "',
       user_email = '" . $_POST['email'] . "'
       WHERE user_id = '" . $_SESSION['user_id'] . "'");

        // Check if a new password is provided
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if the new password and confirm password match
            if ($password === $confirm_password) {
                $hashed_password = md5($password);

                // Update the user's password and real password
                $update_password = $con->query("UPDATE `tbluser` SET user_password = '" . $hashed_password . "', user_Real_password = '" . $password . "' WHERE user_id = '" . $_SESSION['user_id'] . "'");

                if ($update_password) {
                    echo alert_msg("success", "success");
                } else {
                    echo alert_msg("error", "error");
                }
            } else {
                echo alert_msg("error", "password_mismatch");
            }
        } else {
            // Check if the profile update was successful
            if ($update_user) {
                echo alert_msg("success", "success");
            } else {
                echo alert_msg("error", "error");
            }
        }
        exit;
    }







    // if ($_POST['action'] == 'save_address') {
    //     $chk_address = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
    //     if ($chk_address->num_rows == 0) {
    //         $insert_data = $con->query("INSERT INTO `tbluseraddress`(`userAddress_number`, `userAddress_group`, `userAddress_alley`, `userAddress_separate`, `userAddress_district`, `userAddress_canton`, `userAddress_province`, `userAddress_post`, `user_id`)
    //          VALUES ('" . $_POST['userAddress_number'] . "','" . $_POST['userAddress_group'] . "','" . $_POST['userAddress_alley'] . "','" . $_POST['userAddress_separate'] . "','" . $_POST['userAddress_district'] . "','" . $_POST['userAddress_canton'] . "','" . $_POST['userAddress_province'] . "','" . $_POST['userAddress_post'] . "','" . $_SESSION['user_id'] . "')");
    //         if ($insert_data) {
    //             echo alert_msg("success", "success");
    //             exit;
    //         } else {
    //             echo alert_msg("error", "error");
    //             exit;
    //         }
    //     } else {
    //         $update_data = $con->query("UPDATE `tbluseraddress` SET `userAddress_number` = '" . $_POST['`userAddress_number`'] . "',
    //         `userAddress_group` = '" . $_POST['`userAddress_group`'] . "',
    //         `userAddress_alley` = '" . $_POST['`userAddress_alley`'] . "',
    //         `userAddress_separate` = '" . $_POST['`userAddress_separate`'] . "',
    //         `userAddress_district` = '" . $_POST['`userAddress_district`'] . "',
    //         `userAddress_canton` = '" . $_POST['`userAddress_canton`'] . "',
    //         `userAddress_province` = '" . $_POST['`userAddress_province`'] . "',
    //         `userAddress_post` = '" . $_POST['`userAddress_post`'] . "'
    //         WHERE user_id = '" . $_SESSION['user_id'] . "'");

    //         if ($update_data) {
    //             echo alert_msg("success", "success");
    //             exit;
    //         } else {
    //             echo alert_msg("error", "error");
    //             exit;
    //         }
    //     }
    // }

    if ($_POST['action'] == 'getAddress') {
        $getdata = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata) {
            $rowdata = $getdata->fetch_assoc();
            echo alert_msg(
                "success",
                array(
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

    // if ($_POST['action'] == 'edit_address') {
    //     $chk = $con->query("UPDATE `tbluseraddress` SET `userAddress_number` = '" . $_POST['userAddress_number'] . "',
    //     `userAddress_group` = '" . $_POST['userAddress_group'] . "',
    //     `userAddress_alley` = '" . $_POST['userAddress_alley'] . "',
    //     `userAddress_separate` = '" . $_POST['userAddress_separate'] . "',
    //     `userAddress_district` = '" . $_POST['userAddress_district'] . "',
    //     `userAddress_canton` = '" . $_POST['userAddress_canton'] . "',
    //     `userAddress_province` = '" . $_POST['userAddress_province'] . "',
    //     `userAddress_post` = '" . $_POST['userAddress_post'] . "'
    //     WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
    //     if ($chk) {
    //         echo alert_msg("success", "ok");
    //         exit;
    //     } else {
    //         echo alert_msg("error", "wrong");
    //         exit;
    //     }
    // }
}
