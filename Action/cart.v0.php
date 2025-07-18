<?php
include_once("../Controller/connect.php");

if (isset($_GET['addcart'])) {
    // var_dump($_POST);
    $product_id = $_POST['id'];
    $counts = $_POST['countitem'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'])) {
        $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = $product_id")->fetch_assoc();
        if (isset($_SESSION['cart']['product_id'][$product_id])) {
            $oldcount = $_SESSION['cart']['product_id'][$product_id];
            $newcount = $counts + $oldcount;
            if ($newcount > $rowcartproduct['product_qty']) {
                $newcount = $rowcartproduct['product_qty'];
            }
            $_SESSION['cart']['product_id'][$product_id] = $newcount;
            echo alert_msg("success", "เพิ่มสินค้าเข้าตะกร้าแล้ว !");
        } else {
            $_SESSION['cart']['product_id'][$product_id] = $counts;
            echo alert_msg("success", "เพิ่มสินค้าเข้าตะกร้าแล้ว !");
        }
    }
}

if (isset($_GET['minuscart'])) {

    $product_id = $_POST['id'];
    $counts = $_POST['countitem'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'])) {
        if (isset($_SESSION['cart']['product_id'][$product_id])) {
            $oldcount = $_SESSION['cart']['product_id'][$product_id];
            $newcount = $oldcount - $counts;
            if ($newcount <= 0) {
                $newcount = 1;
            }
            $_SESSION['cart']['product_id'][$product_id] = $newcount;
            echo alert_msg("success", "ลบจำนวนจากเดิม");
        } else {
            $_SESSION['cart']['product_id'][$product_id] = $counts;
            echo alert_msg("success", "ลบรายการแล้ว");
        }
    }
}

if (isset($_GET['clearcart'])) {
    unset($_SESSION['cart']);
    unset($_SESSION['cart']['product_id'][$product_id]);
    echo alert_msg("success", "เคลียร์ตะกร้าสินค้า");
}

if (isset($_GET['deleteitmecart'])) {
    $product_id = $_POST['product_id'];
    $items_in_cart = count($_SESSION['cart']['product_id']);
    if ($items_in_cart == 1) {
        unset($_SESSION['cart']);
        echo alert_msg("success", "ลบสินค้าเรียบร้อย");
    } else {
        unset($_SESSION['cart']['product_id'][$product_id]);
        echo alert_msg("success", "ลบสินค้าเรียบร้อย");
    }
}

if (isset($_GET['confirmorder'])) {
    $id = $_SESSION['user_id'];
    if (!isset($_SESSION['cart']['product_id'])) {
        echo alert_msg("error", "ยังไม่มีรายการสินค้า");
        exit;
    } else {
        $chkaddress = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
        if ($chkaddress->num_rows == 0) {
            echo alert_msg("error", "ยังไม่มีรายการสินค้า");
            exit;
        } else {
            $rows_address = $chkaddress->fetch_assoc();
            $total_quantity = 0;
            $total_price = 0;
            $bill_trx = uniqidReal(6);
            $created = date("Y-m-d H:i:s");

            foreach ($_SESSION['cart']['product_id'] as $key => $val) {
                $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = ${key}")->fetch_assoc();
                $makeprice = $val * $rowcartproduct['product_price'];
                $total_quantity += $val;
                $total_price += $makeprice;
                $product_quantity = $rowcartproduct['product_qty'] - $val;
                $_SESSION['product_qty'] = $product_quantity;
                $chkuser = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
                if ($chkuser->num_rows == 0) {
                    echo alert_msg("error", "ยังไม่มีรายการสินค้า");
                    exit;
                } else {
                    $rows_user = $chkuser->fetch_assoc();
                    $con->query("INSERT INTO tblrecord(product_id, `user_id`, bill_trx, created, counts, price, record_address_post, userAddress_number, userAddress_group, userAddress_alley, userAddress_separate, userAddress_district, userAddress_canton, userAddress_province, userAddress_num_post, fname, lname, phone) VALUES
             ('$key', '$id', '$bill_trx', '$created', '$val', '" . $rowcartproduct['product_price'] . "', '" . $_POST['address_Post'] . "' , '" . $rows_address['userAddress_number'] . "', '" . $rows_address['userAddress_group'] . "', '" . $rows_address['userAddress_alley'] . "', '" . $rows_address['userAddress_separate'] . "', '" . $rows_address['userAddress_district'] . "', '" . $rows_address['userAddress_canton'] . "', '" . $rows_address['userAddress_province'] . "', '" . $rows_address['userAddress_post'] . "', '" . $rows_user['user_fname'] . "' , '" . $rows_user['user_lname'] . "' , '" . $rows_user['user_phone'] . "') ");

                    $con->query("UPDATE tblproduct SET product_qty = '$product_quantity' WHERE product_id = '" . $rowcartproduct['product_id'] . "' ");
                }
            }
            unset($_SESSION['cart']);
            echo alert_msg("success", "บันทึกรายการสำเร็จ");
        }
    }
}