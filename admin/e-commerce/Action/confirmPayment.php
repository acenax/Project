<?php
include_once("../Controller/connect.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'confirmPayment') {
        $chkbill = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_POST['bill'] . "'");
        if ($chkbill->num_rows == 0) {
            echo alert_msg("notdata", "notdata");
            exit;
        } else {
            $update_payment = $con->query("UPDATE tblpayment SET payment_status = 'ยืนยันแล้ว กำลังเตรียมการจัดส่ง' WHERE bill_trx = '" . $_POST['bill'] . "'");
            if ($update_payment) {
                $update_record = $con->query("UPDATE tblrecord SET record_payment_status = 'ยืนยันแล้ว' WHERE bill_trx = '" . $_POST['bill'] . "'");
                if ($update_record) {
                    echo alert_msg("success", "success");
                    exit;
                }
            } else {
                echo alert_msg("error", "error");
                exit;
            }
        }
    }

    if ($_POST['action'] == 'cancelPayment') {
        $databilltrx = $con->query("SELECT * FROM `tblrecord` WHERE `bill_trx` = '" . $_POST['bill'] . "' ");
        while ($row_bill = $databilltrx->fetch_assoc()) {
            $product_id = $row_bill['product_id'];
            $val = $row_bill['counts'];
            $update_qty_product = $con->query("UPDATE `tblproduct` SET product_qty = product_qty+'$val' WHERE product_id = '$product_id' ");
        }

        if ($update_qty_product) {
            $update_payment = $con->query("UPDATE tblpayment SET payment_status = 'รายการนี้ถูกยกเลิก' WHERE bill_trx = '" . $_POST['bill'] . "' ");
            if ($update_payment) {
                $update_record = $con->query("UPDATE tblrecord SET record_payment_status = 'รายการนี้ถูกยกเลิก' WHERE bill_trx = '" . $_POST['bill'] . "'");
                if ($update_record) {
                    echo alert_msg("success", "success");
                    exit;
                }
            }
        }
    }
}
