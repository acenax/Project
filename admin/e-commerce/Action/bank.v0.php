<?php
include_once("../Controller/connect.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'savebank') {
        $update = $con->query("UPDATE `tblbank` SET `bank_bank`='" . $_POST['bank'] . "',`bank_number`='" . $_POST['banknumber'] . "',`bank_name`='" . $_POST['bankname'] . "' WHERE bank_id = 1");
        if ($update) {
            echo alert_msg("success", "success");
            exit;
        } else {
            echo alert_msg("error", "error");
            exit;
        }
    }
}