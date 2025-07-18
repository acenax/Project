<?php
include_once("../Controller/connect.php");

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'Add_product') {
        $image = $_FILES['preimg']['name'];
        $file_type = $_FILES['preimg']['type'];
        $allowed = array("image/jpeg", "image/gif", "image/png");
        if (!in_array($file_type, $allowed)) {
            echo alert_msg("notpic", "notpic");
            exit();
        } else {
            $newname = uniqidReal(20) . basename($image);
            $target = realpath(dirname(__FILE__) . "/../..") . "/assets/images/product/" . $newname;
            $isUploaded2 = move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
            if ($isUploaded2) {
                $inser_product = $con->query("INSERT INTO `tblproduct`(`product_code`, `product_name`, `product_typeID`, `product_subdetail`, `product_qty`, `product_price`, `product_picshow`) 
            VALUES ('" . $_POST['product_code'] . "','" . $_POST['product_name'] . "','" . $_POST['product_typeID'] . "', '" . $_POST['product_subdetail'] . "', '" . $_POST['product_qty'] . "','" . $_POST['product_price'] . "','$newname')");
                if ($inser_product) {
                    echo alert_msg("success", "success");
                    exit;
                } else {
                    echo alert_msg("error", "error");
                    exit;
                }
            }
        }
    }

    if ($_POST['action'] == 'getProduct') {
        $getdata = $con->query("SELECT * FROM `tblproduct` WHERE `product_id` = '" . $_POST['id'] . "' LIMIT 1");
        if ($getdata) {
            $rowdata = $getdata->fetch_assoc();
            echo alert_msg("success", array(
                "product_code" => $rowdata['product_code'],
                "product_name" => $rowdata['product_name'],
                "product_typeID" => $rowdata['product_typeID'],
                "product_subdetail" => $rowdata['product_subdetail'],
                "product_qty" => $rowdata['product_qty'],
                "product_price" => $rowdata['product_price'],
                "product_status" => $rowdata['product_status'],
                "product_picshow" => $rowdata['product_picshow'],
            )
            );
            exit;
        } else {
            echo alert_msg("error", "wrong");
            exit;
        }
    }

    if ($_POST['action'] == 'edit_product') {
        $image = $_FILES['preimg2']['name'];
        $file_type = $_FILES['preimg2']['type'];
        $allowed = array("image/jpeg", "image/gif", "image/png");

        if (!in_array($file_type, $allowed)) {
            echo alert_msg("notpic", "notpic");
            exit();
        } else {

            if ($image) {
                $newname = uniqidReal(20) . basename($image);
                $target = realpath(dirname(__FILE__) . "/../..") . "/assets/images/product/" . $newname;
                $isUploaded2 = move_uploaded_file($_FILES['preimg2']['tmp_name'], $target);
                if ($isUploaded2) {
                    $chk = $con->query("UPDATE `tblproduct` SET `product_code` = '" . $_POST['product_code'] . "',
                    `product_name` = '" . $_POST['product_name'] . "',
                    `product_typeID` = '" . $_POST['product_typeID'] . "',
                    `product_subdetail` = '" . $_POST['product_subdetail'] . "',
                    `product_qty` = '" . $_POST['product_qty'] . "',
                    `product_price` = '" . $_POST['product_price'] . "',
                    `product_status` = '" . $_POST['product_status'] . "',
                    `product_picshow` = '$newname'
                    WHERE `product_id` = '" . $_POST['id'] . "'");
                    if ($chk) {
                        echo alert_msg("success", "ok");
                        exit;
                    } else {
                        echo alert_msg("error", "wrong");
                        exit;
                    }
                }
            } else {
                $chk = $con->query("UPDATE `tblproduct` SET `product_code` = '" . $_POST['product_code'] . "',
            `product_name` = '" . $_POST['product_name'] . "',
            `product_typeID` = '" . $_POST['product_typeID'] . "',
            `product_subdetail` = '" . $_POST['product_subdetail'] . "',
            `product_qty` = '" . $_POST['product_qty'] . "',
            `product_price` = '" . $_POST['product_price'] . "',
            `product_status` = '" . $_POST['product_status'] . "'
            WHERE `product_id` = '" . $_POST['id'] . "'");
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

    if ($_POST['action'] == 'del_product') {
        $chk_data = $con->query("SELECT * FROM `tblproduct` WHERE `product_id` = '" . $_POST['del_product'] . "' LIMIT 1");
        if ($chk_data->num_rows > 0) {
            $del_data = $con->query("DELETE FROM `tblproduct` WHERE `product_id` = '" . $_POST['del_product'] . "' LIMIT 1");
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

    if ($_POST['action'] == 'addDetailProduct') {
        // var_dump($_POST);
        $chk_data = $con->query("SELECT * FROM `tblproduct_detail` WHERE product_id = '" . $_POST['id'] . "'");
        if ($chk_data->num_rows == 0) {
            $insert_detail = $con->query("INSERT INTO `tblproduct_detail`(`product_detail`, `product_id`) VALUES ('" . $_POST['product_detail'] . "', '" . $_POST['id'] . "')");
            if ($insert_detail) {
                echo alert_msg("success", "ok");
                exit;
            } else {
                echo alert_msg("error", "wrong");
                exit;
            }
        } else {
            $rows_data = $chk_data->fetch_assoc();
            $update_detail = $con->query("UPDATE `tblproduct_detail` SET `product_detail` = '" . $_POST['product_detail'] . "',
            `product_id`='" . $_POST['id'] . "' WHERE `product_detail_id` = '" . $rows_data['product_detail_id'] . "'");
            if ($update_detail) {
                echo alert_msg("success", "ok");
                exit;
            } else {
                echo alert_msg("error", "wrong");
                exit;
            }
        }
    }
}