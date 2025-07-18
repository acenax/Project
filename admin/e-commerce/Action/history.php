<?php
include_once("../Controller/connect.php");

if(isset($_POST['action'])){
    if($_POST['action'] == 'GEThistory'){
        $ym = $_POST['y'] . $_POST['m'];
        $get_record = $con->query("SELECT * FROM `tblrecord` WHERE EXTRACT(YEAR_MONTH FROM `created`) = '$ym' AND record_status = 'แจ้งชำระเงินแล้ว' AND record_payment_status = 'ยืนยันแล้ว'");
        if($get_record->num_rows > 0){
            echo alert_msg("success", "$ym");
            exit;
        } else {
            echo alert_msg("error", "error");
            exit;
        }
    }
}