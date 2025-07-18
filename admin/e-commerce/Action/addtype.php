<?php
include_once("../Controller/connect.php");
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Addtype_product') {
        $chknametype = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_name` = '" . $_POST['Type_name'] . "'");
        if ($chknametype->num_rows > 0) {
            echo alert_msg("taken", "taken");
            exit;
        } else {
            $insert_type = $con->query("INSERT INTO `tblproducttype`(`Type_name`) VALUES ('" . $_POST['Type_name'] . "')");
            if ($insert_type) {
                echo alert_msg("success", "success");
                exit;
            } else {
                echo alert_msg("error", "error");
                exit;
            }
        }
    }

    if ($_POST['action'] == 'getType') {
        $getdata = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata) {
            $rowdata = $getdata->fetch_assoc();
            echo alert_msg("success", array(
                "Type_name" => $rowdata['Type_name'],
                "Type_status" => $rowdata['Type_status'],
            ));
            exit;
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }

    if ($_POST['action'] == 'edittype_product') {

        $chktype = $con->query("SELECT * FROM `tblproducttype` WHERE Type_name = '" . $_POST['Type_name'] . "'");
        if ($chktype->num_rows > 0) {
            echo alert_msg("taken", "taken");
            exit;
        } else {

            if ($_POST['Type_name'] == '' || $_POST['Type_name'] == null) {
                $chk = $con->query("UPDATE `tblproducttype` SET `Type_status` = '" . $_POST['Type_status'] . "' WHERE `Type_id` = '" . $_POST['id'] . "'");
                if ($chk) {
                    echo alert_msg("success", "ok");
                    exit;
                } else {
                    echo alert_msg("error", "wrong");
                    exit;
                }
            } else {
                $chk = $con->query("UPDATE `tblproducttype` SET `Type_name` = '" . $_POST['Type_name'] . "',
                `Type_status` = '" . $_POST['Type_status'] . "'
                WHERE `Type_id` = '" . $_POST['id'] . "'");
                if ($chk) {
                    echo alert_msg("success", "ok");
                    exit;
                } else {
                    echo alert_msg("error", "wrong");
                    exit;
                }
            }
        }
    }

    if ($_POST['action'] == 'del_type') {
        $chk_data = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '" . $_POST['del_type'] . "' LIMIT 1");
        if ($chk_data->num_rows > 0) {
            $del_data = $con->query("DELETE FROM `tblproducttype` WHERE `Type_id` = '" . $_POST['del_type'] . "' LIMIT 1");
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
