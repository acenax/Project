<?php
if ($_GET['check_status_order'] == '' || $_GET['check_status_order'] == null) {
    echo "<script>";
    echo "Swal.fire({";
    echo "icon:'warning',";
    echo "title: 'ไม่พบหมายเลขสั้งซื้อ '";
    echo "}).then(function() {";
    echo "window.location = './?Status_track' ";
    echo " }),setTimeout(function(){ ";
    echo "window.location = './?Status_track' },5000)";
    echo "</script>";
} else {
    $chk_bill = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_GET['check_status_order'] . "'");
    if ($chk_bill->num_rows == 0) {
        echo "<script>";
        echo "Swal.fire({";
        echo "icon:'warning',";
        echo "title: 'ไม่พบหมายเลขสั้งซื้อ '";
        echo "}).then(function() {";
        echo "window.location = './?Status_track' ";
        echo " }),setTimeout(function(){ ";
        echo "window.location = './?Status_track' },5000)";
        echo "</script>";
    } else {
        $rows_bill = $chk_bill->fetch_assoc();
        $rows_record = $con->query("SELECT * FROM `tblrecord` WHERE bill_trx = '" . $rows_bill['bill_trx'] . "'")->fetch_assoc();
    }
}
?>
<br><br><br>

<style>
    .body-payment {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 25px 40px;
        box-shadow: 5px 5px #cecccc;
    }

    .bank-payment {
        background-color: #ddd;
        padding: 5px 10px;
        text-align: center;
        border-radius: 15px;
    }

    .item-box {
        display: flex;
        align-items: center;
        flex-direction: column;
    }
</style>
<br>
<br>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="body-payment text-center">
                <h4>ติดตามสถานะการสั่งซื้อ</h4>
                <small>หมายเลขคำสั่งซื้อ : <?= $rows_bill['bill_trx'] ?> </small>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="body-payment">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="item-box">
                            <h3>ที่อยู่จัดส่ง</h3>
                            <hr>
                            <p>ชื่อจริง  <?= $rows_record['fname'] ?> นามสกุล  <?= $rows_record['lname'] ?> </p>
                            <p>บ้านเลขที่  <?= $rows_record['userAddress_number'] ?> หมู่ที่  <?= $rows_record['userAddress_group'] ?> </p>
                            <p>ซอย  <?= $rows_record['userAddress_alley'] ?> แยก  <?= $rows_record['userAddress_separate'] ?> </p>
                            <p>ตำบล/แขวง  <?= $rows_record['userAddress_district'] ?> อำเภอ/เขต  <?= $rows_record['userAddress_canton'] ?> </p>
                            <p>จังหวัด  <?= $rows_record['userAddress_province'] ?> รหัสไปรษณีย์  <?= $rows_record['userAddress_num_post'] ?> </p>
                            <p>หมายเลขโทรศัพท์  <?= $rows_record['phone'] ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item-box">
                            <h3>การจัดส่ง</h3>
                            <hr>
                            <?php if ($rows_bill['payment_status'] == 'กำลังรอการยืนยัน') { ?>
                                <p>วันที่จัดส่ง : ยังไม่ได้จัดส่งสินค้า</p>
                                <p>สถานะการจัดส่ง : <span class='badge bg-warning'>กำลังรอการยืนยัน</span></p>
                                <p>บริษัทที่จัดส่ง : ยังไม่ได้จัดส่งสินค้า</p>
                                <p>หมายเลขจัดส่ง : ยังไม่ได้จัดส่งสินค้า</p>
                            <?php } else if ($rows_bill['payment_status'] == 'รายการนี้ถูกยกเลิก') { ?>
                                <p>วันที่จัดส่ง : - </p>
                                <p>สถานะการจัดส่ง : <span class='badge bg-danger'><?= $rows_bill['payment_status'] ?></span></p>
                                <p>บริษัทที่จัดส่ง : - </p>
                                <p>หมายเลขจัดส่ง : - </p>
                            <?php } else { ?>
                                <p>วันที่จัดส่ง : <?= $rows_bill['payment_ems_date'] ?></p>
                                <p>สถานะการจัดส่ง : <span class='badge bg-success'><?= $rows_bill['payment_status'] ?></span></p>
                                <p>บริษัทที่จัดส่ง : <?= $rows_bill['payment_Express'] ?></p>
                                <p>หมายเลขจัดส่ง : <?= $rows_bill['payment_ems'] ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>