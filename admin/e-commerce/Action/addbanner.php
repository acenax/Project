<?php
include_once("../Controller/connect.php");
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'addbaner') {
        $image = $_FILES['preimg']['name'];
        $newname = uniqidReal(20) . basename($image);
        $target = realpath(dirname(__FILE__) . "/../..") . "/assets/images/banner/" . $newname;
        $isUploaded2 = move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
        if ($isUploaded2) {
            $insert_banner = $con->query("INSERT INTO `tblecombanner`(`Ecombanner_path`) VALUES ('$newname')");
            if($insert_banner){
                echo alert_msg("success", "success");
                exit;
            }
        }
    }

    if($_POST['action'] == 'del_pic'){
        $chkdata = $con->query("SELECT * FROM `tblecombanner` WHERE Ecombanner_id = '".$_POST['id']."'");
        if($chkdata->num_rows > 0){
            $del = $con->query("DELETE FROM `tblecombanner`  WHERE Ecombanner_id = '".$_POST['id']."'");
            if($del){
                echo alert_msg("success", "success");
                exit;
            }
        }
    }  
}
