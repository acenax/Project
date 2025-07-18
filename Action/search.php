<?php
include_once("../Controller/connect.php");
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'searchtrack') {
        $chk_data = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_POST['track_number'] . "'");
        if ($chk_data->num_rows == 0) {
            echo alert_msg("notdata", "notdata");
            exit;
        } else {
            $rows_data = $chk_data->fetch_assoc();
            echo alert_msg("success", array(
                "bill_trx" => $rows_data['bill_trx'],
            ));
            exit;
        }
    }
}
