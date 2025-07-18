<?php
include_once("../Controller/connect.php");
require_once('../../../Controller/constants.php');

$product_file_dir = '../../' . PRODUCT_FILE_DIR;

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

if ($ACTION == 'addnew') {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    $error = true;

    for ($loop = 0; $loop < 1; $loop++) {
        // allow file upload validation
        if (!empty($_FILES['file'])) {

            if (!is_dir($product_file_dir)) {
                echo alert_msg("error", "ไม่พบไดเรคทอรี่สำหรับจัดเก็บรูปภาพ ({$product_file_dir}).");
                exit();
            }

            foreach ($_FILES['file']['name'] as $idx => $original_name) {
                if (0 < $_FILES['file']['error'][$idx]) {
                    continue;
                }

                if (!in_array($_FILES['file']['type'][$idx], ["image/jpeg", "image/gif", "image/png"])) {
                    echo alert_msg("error", "รองรับเฉพาะไฟล์รูปภาพเท่านั้น");
                    exit;
                }
            }
        }

        $data = [
            'product_code' => (isset($_POST['product_code'])) ? $_POST['product_code'] : '',
            'product_name' => (isset($_POST['product_name'])) ? $_POST['product_name'] : '',
            'product_typeID' => (isset($_POST['product_typeID'])) ? $_POST['product_typeID'] : '',
            'product_subdetail' => (isset($_POST['product_subdetail'])) ? $_POST['product_subdetail'] : '',
            'product_min' => (isset($_POST['product_min'])) ? $_POST['product_min'] : '0',
            'product_qty' => (isset($_POST['product_qty'])) ? $_POST['product_qty'] : '0',
            'product_price' => (isset($_POST['product_price'])) ? $_POST['product_price'] : '0',
            'product_status' => (isset($_POST['product_status'])) ? $_POST['product_status'] : '0',
            'product_picshow' => (isset($_POST['product_picshow'])) ? $_POST['product_picshow'] : '',
        ];

        // update product detail
        $sql = "INSERT INTO `tblproduct` (`" . implode("`,`", array_keys($data)) . "`) VALUES ('" . implode("','", $data) . "');";
        $rs = $con->query($sql);

        if (!$rs) {
            break;
        }

        $product_id = $con->insert_id;

        $detail = (isset($_POST['product_detail'])) ? $_POST['product_detail'] : '';
        $sql = "INSERT INTO `tblproduct_detail` SET `product_detail` = '{$detail}', `product_id` = '{$product_id}';";
        $rs = $con->query($sql);

        // upload files
        if (!empty($_FILES['file'])) {
            foreach ($_FILES['file']['name'] as $idx => $original_name) {
                if (0 < $_FILES['file']['error'][$idx]) {
                    continue;
                }

                if (!in_array($_FILES['file']['type'][$idx], ["image/jpeg", "image/gif", "image/png"])) {
                    continue;
                }

                $file_extension = explode('.', $original_name);
                if (empty($file_extension)) {
                    continue;
                }

                $file_name = sprintf('%s.%s', uniqidReal(20), array_pop($file_extension));
                $file_path = sprintf('%s%s', $product_file_dir, $file_name);

                if (!is_dir($product_file_dir)) {
                    echo alert_msg("error", "{$product_file_dir} is not exists.");
                    exit();
                }

                // do upload file
                $uploaded = move_uploaded_file($_FILES['file']['tmp_name'][$idx], $file_path);
                if ($uploaded) {
                    $is_default = (!empty($_POST['profile'][$idx]) && 1 == $_POST['profile'][$idx]) ? 'YES' : 'NO';
                    $sql = "INSERT INTO `tblproduct_files` (`product_id`, `is_default`, `file_name`, `file_type`,`file_path`) 
                        VALUES ('{$product_id}', '{$is_default}', '{$original_name}', '{$file_type}', '{$file_name}');";

                    $con->query($sql);

                    if ('YES' == $is_default) {
                        $sql = "UPDATE `tblproduct` SET `product_picshow` = '{$file_name}' WHERE (`product_id` = '{$product_id}');";
                        $con->query($sql);
                    }
                } else {
                    echo alert_msg("error", "การอัพโหลดรูปภาพล้มเหลว");
                    exit();
                }
            }
        }

        $error = false;
    }

    if (false == $error) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
} else if ($ACTION == 'update') {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    $error = true;

    for ($loop = 0; $loop < 1; $loop++) {
        // allow file upload validation
        if (!empty($_FILES['file'])) {

            if (!is_dir($product_file_dir)) {
                echo alert_msg("error", "ไม่พบไดเรคทอรี่สำหรับจัดเก็บรูปภาพ ({$product_file_dir}).");
                exit();
            }

            foreach ($_FILES['file']['name'] as $idx => $original_name) {
                if (0 < $_FILES['file']['error'][$idx]) {
                    continue;
                }

                if (!in_array($_FILES['file']['type'][$idx], ["image/jpeg", "image/gif", "image/png"])) {
                    echo alert_msg("error", "รองรับเฉพาะไฟล์รูปภาพเท่านั้น");
                    exit;
                }
            }
        }

        $data = [
            'product_name' => (isset($_POST['product_name'])) ? $_POST['product_name'] : '',
            'product_typeID' => (isset($_POST['product_typeID'])) ? $_POST['product_typeID'] : '',
            'product_subdetail' => (isset($_POST['product_subdetail'])) ? $_POST['product_subdetail'] : '',
            'product_min' => (isset($_POST['product_min'])) ? $_POST['product_min'] : '0',
            'product_qty' => (isset($_POST['product_qty'])) ? $_POST['product_qty'] : '0',
            'product_price' => (isset($_POST['product_price'])) ? $_POST['product_price'] : '0',
            'product_status' => (isset($_POST['product_status'])) ? $_POST['product_status'] : '0',
        ];

        // update product data
        $sql = '';
        foreach ($data as $key => $val) {
            $sql .= (empty($sql)) ? '' : ',';
            $sql .= "`{$key}` = '{$val}'";
        }

        $sql = "UPDATE `tblproduct` SET {$sql} WHERE (`product_id` = '{$id}');";
        $rs = $con->query($sql);

        if (!$rs) {
            break;
        }

        // update product detail
        $detail = (isset($_POST['product_detail'])) ? $_POST['product_detail'] : '';
        $exits = $con->query("SELECT * FROM `tblproduct_detail` WHERE (`product_id` = '{$id}') LIMIT 1;")->fetch_assoc();
        if (!empty($exits)) {
            $sql = "UPDATE `tblproduct_detail` SET `product_detail` = '{$detail}' WHERE (`product_id` = '{$id}');";
        } else {
            $sql = "INSERT INTO `tblproduct_detail` SET `product_detail` = '{$detail}' , `product_id` = '{$id}';";
        }
        $rs = $con->query($sql);

        // upload files
        if (!empty($_FILES['file'])) {
            foreach ($_FILES['file']['name'] as $idx => $original_name) {
                if (0 < $_FILES['file']['error'][$idx]) {
                    continue;
                }

                if (!in_array($_FILES['file']['type'][$idx], ["image/jpeg", "image/gif", "image/png"])) {
                    continue;
                }

                $file_extension = explode('.', $original_name);
                if (empty($file_extension)) {
                    continue;
                }

                $file_name = sprintf('%s.%s', uniqidReal(20), array_pop($file_extension));
                $file_path = sprintf('%s%s', $product_file_dir, $file_name);

                if (!is_dir($product_file_dir)) {
                    echo alert_msg("error", "{$product_file_dir} is not exists.");
                    exit();
                }

                // do upload file
                $uploaded = move_uploaded_file($_FILES['file']['tmp_name'][$idx], $file_path);
                if ($uploaded) {
                    $is_default = (!empty($_POST['profile'][$idx]) && 1 == $_POST['profile'][$idx]) ? 'YES' : 'NO';
                    $sql = "INSERT INTO `tblproduct_files` (`product_id`, `is_default`, `file_name`, `file_type`,`file_path`) 
                        VALUES ('{$id}', '{$is_default}', '{$original_name}', '{$file_type}', '{$file_name}');";

                    $con->query($sql);

                    if ('YES' == $is_default) {
                        $sql = "UPDATE `tblproduct` SET `product_picshow` = '{$file_name}' WHERE (`product_id` = '{$id}');";
                        $con->query($sql);
                    }
                } else {
                    echo alert_msg("error", "การอัพโหลดรูปภาพล้มเหลว");
                    exit();
                }
            }
        }

        $error = false;
    }

    if (false == $error) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
} else if ($ACTION == 'del_product') {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';

    $row = $con->query("SELECT * FROM `tblproduct` WHERE `product_id` = '{$id}' LIMIT 1")->fetch_assoc();
    if (empty($row)) {
        echo alert_msg("error", "ไม่พบรายการสินค้า");
        exit();
    }

    // delete files
    $sql = "SELECT * FROM `tblproduct_files` WHERE `product_id` = '{$id}'";
    $rs = $con->query($sql);
    while ($row = $rs->fetch_assoc()) {
        $file_path = sprintf('%s%s', $product_file_dir, $row['file_path']);
        if (is_file($file_path)) {
            unlink($file_path);
        }
    }

    $sql = "DELETE FROM `tblproduct_files` WHERE `product_id` = '{$id}'";
    $con->query($sql);

    // delete product detail
    $sql = "DELETE FROM `tblproduct_detail` WHERE `product_id` = '{$id}'";
    $con->query($sql);

    // delete product
    $sql = "DELETE FROM `tblproduct` WHERE `product_id` = '{$id}'";
    $rs = $con->query($sql);

    if ($rs) {
        echo alert_msg("success", "ลบข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }
    exit;

} else if ('delfile' == $ACTION) {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    $sql = "SELECT * FROM `tblproduct_files` WHERE (`file_id` = '{$id}') LIMIT 1;";
    $row = $con->query($sql)->fetch_assoc();
    if (empty($row)) {
        echo alert_msg("error", "ไม่พบไฟล์รูปภาพ");
        exit();
    }

    $file_path = sprintf('%s%s', $product_file_dir, $row['file_path']);
    if (is_file($file_path)) {
        @unlink($file_path);
    }

    $sql = "DELETE FROM `tblproduct_files` WHERE (`file_id` = '{$id}');";
    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "ลบรูปภาพเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();

} else if ('setdefault' == $ACTION) {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    $sql = "SELECT * FROM `tblproduct_files` WHERE (`file_id` = '{$id}') LIMIT 1;";
    $row = $con->query($sql)->fetch_assoc();
    if (empty($row)) {
        echo alert_msg("error", "ไม่พบไฟล์รูปภาพ");
        exit();
    }

    // reset all to NO
    $sql = "UPDATE `tblproduct_files` SET `is_default` = 'NO' WHERE (`product_id` = '{$row['product_id']}') AND (`is_default` = 'YES');";
    $con->query($sql);

    // set myself
    $is_default = ('NO' == $row['is_default']) ? 'YES' : 'NO';
    $sql = "UPDATE `tblproduct_files` SET `is_default` = '{$is_default}' WHERE (`file_id` = '{$row['file_id']}');";
    $con->query($sql);

    // update tblproduct data
    if ('YES' == $is_default) {
        $sql = "UPDATE `tblproduct` SET `product_picshow` = '{$row['file_path']}' WHERE (`product_id` = '{$row['product_id']}');";
    } else {
        // get the first image and set to default image
        $sql = "SELECT * FROM `tblproduct_files` WHERE (`product_id` = '{$row['product_id']}') ORDER BY file_id ASC LIMIT 1;";
        $row = $con->query($sql)->fetch_assoc();

        $sql = "UPDATE `tblproduct_files` SET `is_default` = 'YES' WHERE (`file_id` = '{$row['file_id']}');";
        $con->query($sql);

        $sql = "UPDATE `tblproduct` SET `product_picshow` = '{$row['file_path']}' WHERE (`product_id` = '{$row['product_id']}');";
    }

    $rs = $con->query($sql);
    if ($rs) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
}