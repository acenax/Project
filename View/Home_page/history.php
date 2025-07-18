<br><br><br>
<style>
    .body-payment {
        display: flex;
        width: 100%;
        height: auto;
        border: 4px solid #212529;
        border-radius: 15px;
        margin-bottom: 100px;
        box-shadow: 5px 5px #cecccc;
        background-color: #fff;

    }

    .bank-payment {
        background-color: #ddd;
        padding: 5px 10px;
        text-align: center;
        border-radius: 15px;
    }

    .header-payment {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 10px;
        box-shadow: 5px 5px #cecccc;
    }

    .body-payment .sidebarprofile {
        top: 0;
        left: 0;
        width: 400px;
        margin: 25px 0;
        border-right: 1px solid #000;
    }

    .sidebarprofile-header {
        text-align: center;
        margin-top: 15px;
        border-bottom: 1px solid #000;
        width: 80%;
        margin-left: 35px;
    }

    .ulbodyprofile {
        display: block;
        width: 80%;
        margin-left: 80px;
    }

    .ulbodyprofile a {
        display: flex;
        font-size: 20px;
        font-style: normal;
        list-style-type: none;
        margin-top: 30px;
        width: 100%;
        color: #212529;
        text-decoration: none;
    }

    .profile-content {
        margin-left: 50px;
        margin-top: 50px;
        font-size: 16px;
        width: 800px;
    }

    .dataTables_filter {
        text-align: right;
    }

    .dataTables_filter input {
        display: unset !important;
        width: 200px !important;
        margin-left: 5px;
    }

    .dataTables_paginate {
        margin-bottom: 10px;
        display: flex;
        align-items: flex-end;
        justify-content: end;
    }

    .dataTables_info {
        margin-top: 10px;
    }

    .dataTables_info {
        font-family: Mitr;
    }

    .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 5px;
        display: unset !important;
        width: 45px !important;
    }

    @media screen and (max-width: 400px) {
        .body-payment {
            display: flex;
            flex-direction: column;
        }

        .profile-content {
            padding: 0 50px;
            margin: 0 !important;
            width: 100%;
        }

        #dataal_wrapper>.row {
            overflow-x: auto;
        }
    }

    .btn-light-warning {
        background-color: #02569b;
        border-color: #ffc107;
    }

    .btn-yellow {
        background-color: #ffcc00;
        border-color: #ffcc00;
    }
</style>

<?php
$rows_user = $con->query("SELECT * FROM `tbluser` WHERE `user_id` ='" . $_SESSION['user_id'] . "'")->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-5">
            <div class="header-payment">
                <span style="font-size: 20px;" class="ms-3">
                    <i class="fas fa-user-circle" style="font-size: 30px;"></i>
                    ยินดีต้อนรับ :
                    <?= $rows_user['user_username'] ?>
                </span>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-payment">
                <?php include_once('sildeprofile.php'); ?>
                <div class="profile-content">
                    <div class="sub-content">
                        <div class="input-profile">
                            <div class="">
                                <table class="table" id="dataal">
                                    <thead>
                                        <tr>
                                            <th scope="col">หมายเลขคำสั่งซื้อ</th>
                                            <th scope="col">สถานะการแจ้งชำระ</th>
                                            <th scope="col">สถานะการสั่งซื้อ</th>
                                            <th scope="col">วันที่สั่งซื้อ</th>
                                            <th scope="col">การสั่งซื้อ/ชำระ/ยืนยัน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $datahistory = $con->query("SELECT `bill_trx`,`created`,record_status,record_payment_status, record_receipt_status FROM `tblrecord` WHERE `user_id` = '" . $_SESSION['user_id'] . "' GROUP BY `bill_trx` ORDER BY created DESC");
                                        while ($rowhistory = $datahistory->fetch_assoc()) {
                                            $billtrx = $rowhistory['bill_trx'];
                                            $created = ThaiDatetime::to_short_date($rowhistory['created']);
                                            $record_status = $rowhistory['record_status'];
                                            $total_price = 0;
                                            $total_quantity = 0;
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $billtrx ?>
                                                    <input type="hidden" id="hidden-billtrx" value="<?= $billtrx ?>">
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($record_status == 'ยังไม่ได้แจ้งชำระเงิน') {
                                                        echo "<span class='text-danger'> $record_status</span>";
                                                    } else {
                                                        echo "<span class='text-success'> $record_status </span>";
                                                    }
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($rowhistory['record_receipt_status'])) {
                                                        echo "<span class='text-success'> " . $rowhistory['record_receipt_status'] . " </span>";
                                                    } else if ($rowhistory['record_payment_status'] == 'รายการนี้ถูกยกเลิก') {
                                                        echo "<span class='text-danger'> " . $rowhistory['record_payment_status'] . "</span>";
                                                    } else
                                                        if ($rowhistory['record_payment_status'] == 'รอการยืนยัน') {
                                                        echo "<span class='text-warning'> " . $rowhistory['record_payment_status'] . "</span>";
                                                    } else {
                                                        echo "<span class='text-success'> " . $rowhistory['record_payment_status'] . " </span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= $created ?>
                                                </td>
                                                <td>
                                                    <a href="./?historybill=<?= $billtrx ?>" target="_blank" title="ประวัติการซื้อ" class="btn btn-yellow text-white">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <!-- ... -->
                                                    <a href="javascript:void(0);" onclick="saveBillTrx('<?= $billtrx ?>');" title="ไปยังหน้าชำระเงิน" class="btn btn-light-warning text-white">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </a>
                                                    <!-- ... -->

                                                    <?php if (!empty($rowhistory['record_receipt_status'])) : ?>
                                                        <a href="./?receiptdetail=<?= $billtrx ?>" target="_blank" title="รายละเอียดการรับสินค้า" class="btn btn-success text-white">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    <?php elseif (in_array($rowhistory['record_payment_status'], ['ยืนยันแล้ว']) && empty($rowhistory['record_receipt_status'])) : ?>
                                                        <a href="./?receipt=<?= $billtrx ?>" target="_blank" title="บันทึกรับสินค้า" class="btn btn-success text-white">
                                                            <i class="far fa-box-open"></i>
                                                        </a>
                                                    <?php else : ?>
                                                        <a href="javascript:;" class="btn btn-light" disabled title="บันทึกรับสินค้า">
                                                            <i class="far fa-box-open"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>


                                            </tr>
                                        <?php } // eof while 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end text-danger mt-2">
                                <!-- Add your comment here -->
                                <span class="text-danger font-weight-bold"> #หลังจากได้รับสินค้าแล้วกรุณากดไอคอนรูปกล่องเพื่อยืนยันสินค้า</span>
                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
    $(document).ready(function() {
        $('#dataal').DataTable({
            "oLanguage": {
                "sLengthMenu": "แสดงรายการ _MENU_ รายการ ต่อหน้า",
                "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                "sInfo": "จำนวน _START_ ถึง _END_ ใน _TOTAL_ รายการทั้งหมด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการทั้งหมด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา :",
                "aaSorting": [
                    [0, 'desc']
                ],
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
            },
            "order": [
                [0, "desc"]
            ]
        });
    });

    function saveBillTrx(billTrx) {
        sessionStorage.setItem('billtrx', billTrx);
        window.open('./?payment', '_blank');
    }
</script>