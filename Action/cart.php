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

if (isset($_GET['update_cart'])) {
    $product_id = $_POST['id'];
    $newCount = $_POST['countitem'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'])) {
        $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = $product_id")->fetch_assoc();
        if (isset($_SESSION['cart']['product_id'][$product_id])) {
            if ($newCount > $rowcartproduct['product_qty']) {
                $newCount = $rowcartproduct['product_qty'];
            } elseif ($newCount < 1) {
                $newCount = 1;
            }
            $_SESSION['cart']['product_id'][$product_id] = $newCount;
            echo alert_msg("success", "อัปเดตจำนวนสินค้าแล้ว !");
        } else {
            $_SESSION['cart']['product_id'][$product_id] = $newCount;
            echo alert_msg("success", "เพิ่มสินค้าเข้าตะกร้าแล้ว !");
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
    if (empty($_SESSION['user_id'])) {
        echo alert_msg("error", "กรุณาล็อกอินก่อนทำรายการด้วยค่ะ");
        exit;
    }

    if (empty($_SESSION['cart']['product_id'])) {
        echo alert_msg("error", "ยังไม่มีรายการสินค้า");
        exit;
    }

    // get shipping address
    $address = [];
    $id = (!empty($_POST['userAddress_id'])) ? (int) $_POST['userAddress_id'] : 0;
    $sql = "SELECT * FROM `tbluseraddress` WHERE `userAddress_id` = '{$id}' LIMIT 1;";
    $rs = $con->query($sql);
    if ($rs) {
        $address = $rs->fetch_assoc();
    }

    if (empty($address)) {
        echo alert_msg("error", "กรุณาระบุที่อยู่จัดส่งสินค้าด้วยค่ะ");
        exit;
    }

    // get shipping provider
    $shipping = [];
    $id = (!empty($_POST['shipping'])) ? (int) $_POST['shipping'] : 0;
    $sql = "SELECT * FROM `tblshipping` WHERE (`shipping_id` = '{$id}') AND (`status` = 'ACTIVE') LIMIT 1;";
    $rs = $con->query($sql);
    if ($rs) {
        $shipping = $rs->fetch_assoc();
    }

    if (empty($shipping)) {
        echo alert_msg("error", "กรุณาเลือกผู้จัดส่งสินค้าด้วยค่ะ");
        exit;
    }

    $bill_no = uniqidReal(6);
    $shipping_data = [
        'user_id' => $_SESSION['user_id'],
        'bill_trx' => uniqidReal(6),
        'created' => date("Y-m-d H:i:s"),
        'fname' => (!empty($_POST['user_fname'])) ? $_POST['user_fname'] : '',
        'lname' => (!empty($_POST['user_lname'])) ? $_POST['user_lname'] : '',
        'phone' => (!empty($_POST['user_lname'])) ? $_POST['user_phone'] : '',

        'record_address_post' => $shipping['provider_name'],
        'shipping_id' => $shipping['shipping_id'],

        'provider_name' => $shipping['provider_name'],
        'shipping_rate' => $shipping['shipping_rate'],

        'userAddress_id' => $address['userAddress_id'],
        'userAddress_number' => $address['userAddress_number'],
        'userAddress_group' => $address['userAddress_group'],
        'userAddress_alley' => $address['userAddress_alley'],
        'userAddress_separate' => $address['userAddress_separate'],
        'userAddress_district' => $address['userAddress_district'],
        'userAddress_canton' => $address['userAddress_canton'],
        'userAddress_province' => $address['userAddress_province'],
        'userAddress_num_post' => $address['userAddress_post']
    ];

    // get products
    $products = [];
    $records = [];
    $total_amount = 0;

    $rs = $con->query("SELECT `product_id`, `product_name`, `product_price`, `product_qty` FROM `tblproduct` WHERE (`product_id` IN ('" . implode("','", array_keys($_SESSION['cart']['product_id'])) . "'));");
    while ($row = $rs->fetch_assoc()) {
        $qty = (!empty($_SESSION['cart']['product_id'][$row['product_id']])) ? (int) $_SESSION['cart']['product_id'][$row['product_id']] : 0;
        if ((float) $row['product_qty'] < $qty) {
            echo alert_msg("error", "สินค้า \"{$row['product_name']}\" มีจำนวนคงเหลือไม่เพียงพอในการทำรายการ !");
            exit;
        }

        $record = $shipping_data;

        $record['product_id'] = $row['product_id'];
        $record['price'] = (float) $row['product_price'];
        $record['counts'] = $qty;

        $records[] = $record;

        $total_amount += ($qty*(float)$row['product_price']);

        // keep to update stock
        $row['product_qty'] -= $qty;
        $products[$row['product_id']] = $row;
    }
    

    $success = false;
    foreach ($records as $record) {
        // when total amount per bill is >= 3000 
        // set to free shipping
        if ($total_amount >= 3000) {
            $record['shipping_rate'] = 0;
            $record['record_address_post'] = 'ส่งฟรีทั่วไทย';
        }


        $sql = "INSERT INTO `tblrecord` "
            . "(`" . implode("`,`", array_keys($record)) . "`)"
            . " VALUES('" . implode("','", $record) . "')";

        $rs = $con->query($sql);
        if (!$rs) {
            continue;
        }

        // update product stock
        $product_id = $record['product_id'];
        $sql = "UPDATE `tblproduct` 
            SET `product_qty` = '{$products[$product_id]['product_qty']}' 
            WHERE `product_id` = '{$product_id}';";

        $con->query($sql);

        $success = true;
    }

    if ($success) {
        unset($_SESSION['cart']);
        unset($_SESSION['shipping']);
        unset($_SESSION['address']);
        echo alert_msg("success", "บันทึกรายการสำเร็จ");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();

    // $id = $_SESSION['user_id'];
    // if (!isset($_SESSION['cart']['product_id'])) {
    //     echo alert_msg("error", "ยังไม่มีรายการสินค้า");
    //     exit;
    // } else {
    //     $chkaddress = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
    //     if ($chkaddress->num_rows == 0) {
    //         echo alert_msg("error", "ยังไม่มีรายการสินค้า");
    //         exit;
    //     } else {
    //         $rows_address = $chkaddress->fetch_assoc();
    //         $total_quantity = 0;
    //         $total_price = 0;
    //         $bill_trx = uniqidReal(6);
    //         $created = date("Y-m-d H:i:s");

    //         foreach ($_SESSION['cart']['product_id'] as $key => $val) {
    //             $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = ${key}")->fetch_assoc();
    //             $makeprice = $val * $rowcartproduct['product_price'];
    //             $total_quantity += $val;
    //             $total_price += $makeprice;
    //             $product_quantity = $rowcartproduct['product_qty'] - $val;
    //             $_SESSION['product_qty'] = $product_quantity;
    //             $chkuser = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
    //             if ($chkuser->num_rows == 0) {
    //                 echo alert_msg("error", "ยังไม่มีรายการสินค้า");
    //                 exit;
    //             } else {
    //                 $rows_user = $chkuser->fetch_assoc();
    //                 $con->query("INSERT INTO tblrecord(product_id, `user_id`, bill_trx, created, counts, price, record_address_post, userAddress_number, userAddress_group, userAddress_alley, userAddress_separate, userAddress_district, userAddress_canton, userAddress_province, userAddress_num_post, fname, lname, phone) VALUES
    //          ('$key', '$id', '$bill_trx', '$created', '$val', '" . $rowcartproduct['product_price'] . "', '" . $_POST['address_Post'] . "' , '" . $rows_address['userAddress_number'] . "', '" . $rows_address['userAddress_group'] . "', '" . $rows_address['userAddress_alley'] . "', '" . $rows_address['userAddress_separate'] . "', '" . $rows_address['userAddress_district'] . "', '" . $rows_address['userAddress_canton'] . "', '" . $rows_address['userAddress_province'] . "', '" . $rows_address['userAddress_post'] . "', '" . $rows_user['user_fname'] . "' , '" . $rows_user['user_lname'] . "' , '" . $rows_user['user_phone'] . "') ");

    //                 $con->query("UPDATE tblproduct SET product_qty = '$product_quantity' WHERE product_id = '" . $rowcartproduct['product_id'] . "' ");
    //             }
    //         }
    //         unset($_SESSION['cart']);
    //         echo alert_msg("success", "บันทึกรายการสำเร็จ");
    //     }
    // }
}
