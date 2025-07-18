<?php
include_once("../Controller/connect.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'addems') {
        if (empty($_POST['input1']) || empty($_POST['input2']) || empty($_POST['bill'])) {
            echo alert_msg("error", "error");
            exit;
        } else {
            // var_dump($_POST);
            $chk_ems = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_POST['bill'] . "'");
            if ($chk_ems->num_rows == 0) {
                echo alert_msg("error", "error");
                exit;
            } else {
                $date = date("Y-m-d H:i:s");
                $update_ems = $con->query("UPDATE `tblpayment` SET payment_ems = '" . $_POST['input1'] . "',
                payment_Express = '" . $_POST['input2'] . "',
                payment_ems_date = '$date',
                payment_status = 'จัดส่งแล้ว' WHERE bill_trx = '" . $_POST['bill'] . "'");

                if ($update_ems) {
                    echo alert_msg("success", "success");
                    exit;
                } else {
                    echo alert_msg("error", "error");
                    exit;
                }
            }
        }
    }
}
