<?php
include_once("../Controller/connect.php");
require_once('../Controller/constants.php');

$receipt_file_dir = '../' . implode('/', ['admin', dirname(PRODUCT_FILE_DIR),  'receipts', '']);

if (!is_dir($receipt_file_dir)) {
    $arr = explode('/', $receipt_file_dir);
    $path = '';
    foreach ($arr as $dir) {
        $path .= ($path == '') ? '' : '/';

        if ('..' == $dir) {
            $path .= $dir;
            continue;
        } else {
            $path .= $dir;
            if (!is_dir($path)) {
                @mkdir($path);
                chmod($path, 755);
            }
        }
    }
}

// Authentication validation
if (empty($_SESSION['login']) || empty($_SESSION['user_level']) || MEMBER_LEVEL > $_SESSION['user_level']) {
    echo alert_msg("error", "error");
    exit;
}

$ACTION = (!empty($_POST['action'])) ? $_POST['action'] : '';
if (empty($ACTION)) {
    echo alert_msg("error", "error");
    exit;
}

if ($ACTION == 'addnew') {
    $now = date('Y-m-d H:i:m');

    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    $error = true;

    for ($loop = 0; $loop < 1; $loop++) {
        // allow file upload validation
        if (!empty($_FILES['file'])) {

            if (!is_dir($receipt_file_dir)) {
                echo alert_msg("error", "ไม่พบไดเรคทอรี่สำหรับจัดเก็บรูปภาพ ({$receipt_file_dir}).");
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

        // insert receipt data
        $data = [
            'bill_trx' => $id,
            'acception_result' => (isset($_POST['acception'])) ? strtoupper($_POST['acception']) : NULL,
            'product_score' => (isset($_POST['product_score'])) ? (int) $_POST['product_score'] : NULL,
            'service_score' => (isset($_POST['service_score'])) ? (int) $_POST['service_score'] : NULL,
            'shipping_score' => (isset($_POST['shipping_score'])) ? (int) $_POST['shipping_score'] : NULL,
            'comment' => (isset($_POST['comment'])) ? $_POST['comment'] : '0',
            'user_id' => $_SESSION['user_id'],
            'created' => $now,
        ];

        // update product detail
        $sql = "INSERT INTO `tblreceipts` (`" . implode("`,`", array_keys($data)) . "`) VALUES ('" . implode("','", $data) . "');";
        $rs = $con->query($sql);

        if (!$rs) {
            break;
        }

        $receipt_id = $con->insert_id;

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
                $file_path = sprintf('%s%s', $receipt_file_dir, $file_name);

                if (!is_dir($receipt_file_dir)) {
                    echo alert_msg("error", "{$receipt_file_dir} is not exists.");
                    exit();
                }

                // do upload file
                $uploaded = move_uploaded_file($_FILES['file']['tmp_name'][$idx], $file_path);
                if ($uploaded) {
                    $sql = "INSERT INTO `tblreceipt_files` (`receipt_id`, `file_name`, `file_type`,`file_path`) 
                        VALUES ('{$receipt_id}', '{$original_name}', '{$file_type}', '{$file_name}');";

                    $con->query($sql);
                } else {
                    echo alert_msg("error", "การอัพโหลดรูปภาพล้มเหลว");
                    exit();
                }
            }
        }

        // update record status
        $sql = "UPDATE `tblrecord` SET `record_receipt_status` = 'ได้รับสินค้าแล้ว', `record_receipt_date` = '{$now}' WHERE (`bill_trx` = '{$id}');";
        $con->query($sql);

        // update payment record
        $sql = "UPDATE `tblpayment` SET `payment_receipt_status` = 'ได้รับสินค้าแล้ว', `payment_receipt_date` = '{$now}' WHERE (`bill_trx` = '{$id}');";
        $con->query($sql);

        $error = false;
    }

    if (false == $error) {
        echo alert_msg("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    } else {
        echo alert_msg("error", "การดำเนินการล้มเหลว");
    }

    exit();
}
