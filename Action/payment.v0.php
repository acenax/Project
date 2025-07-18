<?php
include_once("../Controller/connect.php");
if (isset($_POST['payment_chk'])) {
    $paymentid = $_POST['paymentid'];
    $datahistory = $con->query("SELECT `bill_trx`,`created`,record_status FROM `tblrecord` WHERE `user_id` = '" . $_SESSION['user_id'] . "' GROUP BY `bill_trx`");

    $chkpayment = $con->query("SELECT `bill_trx`, SUM(`price`) As total ,`fname`,`lname`,`phone`, `record_status` FROM `tblrecord` WHERE `bill_trx` = '$paymentid' GROUP BY `bill_trx`");
    if ($chkpayment->num_rows > 0) {
        while ($rows_payment = $chkpayment->fetch_assoc()) {

            if ($rows_payment['record_status'] != 'ยังไม่ได้แจ้งชำระเงิน') {
                echo alert_msg("notpayment", "notpayment");
                exit;
            } else {
                $totalprice = 0;
                $totalprice = $rows_payment['total'] + 60;
                echo alert_msg("success", array(
                    "fname" => $rows_payment['fname'],
                    "lname" => $rows_payment['lname'],
                    "phone" => $rows_payment['phone'],
                    "totalprice" => $totalprice,
                )
                );
                exit;
            }
        }
    } else {
        echo alert_msg("notdata", "notdata");
        exit;
    }
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'confirmPayment') {
        if (empty($_POST['paymentid']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['phone']) || empty($_POST['price']) || empty($_POST['date']) || empty($_POST['time'])) {
            echo alert_msg("empty", "empty");
            exit;
        } else {
            $image = $_FILES['preimg']['name'];
            $file_type = $_FILES['preimg']['type'];

            if (strlen($image) == 0) {
                echo alert_msg("empty", "empty");
                exit;
            } else {
                $newname = uniqidReal(20) . basename($image);
                $target = realpath(dirname(__FILE__) . "/..") . "/admin/assets/images/payment/" . $newname;

                $allowed = array("image/jpeg", "image/gif", "image/png");

                if (!in_array($file_type, $allowed)) {
                    echo alert_msg("notpic", "notpic");
                    exit();
                } else {
                    // echo $target;
                    $isUploaded2 = move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
                    if ($isUploaded2) {
                        if ($_POST['note'] == '' || empty($_POST['note'])) {
                            $note = 'ไม่ได้ระบุ';
                        } else {
                            $note = $_POST['note'];
                        }
                        $fullname = $_POST['fname'] . ' ' . $_POST['lname'];
                        $insert_payment = $con->query("INSERT INTO `tblpayment`(`payment_fullname`, `payment_phone`, `payment_qty`, `payment_date`, `payment_time`, `payment_pic`, `payment_note`, `bill_trx`) 
                    VALUES ('$fullname','" . $_POST['phone'] . "','" . $_POST['price'] . "','" . $_POST['date'] . "','" . $_POST['time'] . "','$newname','$note','" . $_POST['paymentid'] . "')");

                        if ($insert_payment) {
                            $update_record = $con->query("UPDATE tblrecord SET record_status = 'แจ้งชำระเงินแล้ว' WHERE bill_trx = '" . $_POST['paymentid'] . "'");
                            if ($update_record) {
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
        }
    }
}