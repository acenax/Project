<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">ตรวจสอบ และ อนุมัติ รายการสั้งซื้อ </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="">
                <table class="table" id="dataal">
                    <thead>
                        <tr>
                            <th>รายการ</th>
                            <th>เลขใบสั่งซื้อ</th>
                            <th>ชื่อผู้ทำรายการ</th>
                            <th>วันที่ทำรายการ</th>
                            <th>จำนวนวันที่ทำรายการ</th>
                            <th class="text-center">สถานะรายการ</th>
                            <th class="text-center">ตรวจสอบรายการ</th>
                            <th class="text-center">อนุมัติรายการ</th>
                            <th class="text-center">ยกเลิกรายการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 0;
                        $get_payment = $con->query("SELECT * FROM `tblrecord` WHERE record_payment_status = 'รอการยืนยัน' GROUP BY `bill_trx`");
                        while ($rows_payment = $get_payment->fetch_assoc()) {
                            $i++;
                        ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td><?= $rows_payment['bill_trx'] ?></td>
                                    <td><?= $rows_payment['fname'] . ' ' . $rows_payment['lname']   ?></td>
                                    <td><?= $rows_payment['created'] ?></td>
                                    <td>
                                        <?php
                                        $datenow = date("Y-m-d H:i:s");
                                        $a = new DateTime($rows_payment['created']);
                                        $b = new DateTime($datenow);
                                        $interval = $a->diff($b);
                                        if ($interval->format('%m') == 0 and $interval->format('%d') == 0) {
                                            echo 'พึ่งทำรายการวันนี้';
                                        } else
                                    if ($interval->format('%m') == 0) {
                                            echo $interval->format("%d วัน");
                                        } else {
                                            echo $interval->format("%m เดือน %d วัน");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($rows_payment['record_status'] == 'ยังไม่ได้แจ้งชำระเงิน') {
                                            echo '<span class="text-danger">ยังไม่ได้แจ้งชำระเงิน	</span>';
                                        } else {
                                            echo '<span class="text-success">แจ้งชำระเงินแล้ว</span>';
                                        }
                                        ?>
                                    </td>
                                    <?php if ($rows_payment['record_status'] == 'ยังไม่ได้แจ้งชำระเงิน') { ?>
                                        <td class="text-center">
                                            <button class="btn btn-warning rounded" onclick="notpayment()">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-success rounded" onclick="notpayment()">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger rounded" onclick="cancelPayment('<?= $rows_payment['bill_trx'] ?>')">
                                                <i class="fas fa-times"></i>
                                            </button>

                                        </td>
                                    <?php } else { ?>
                                        <td class="text-center">
                                            <button class="btn btn-warning rounded" onclick="window.location= './?check_payment=<?= $rows_payment['bill_trx'] ?>' ">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-success rounded" onclick="confirmPayment('<?= $rows_payment['bill_trx'] ?>')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger rounded" onclick="cancelPayment('<?= $rows_payment['bill_trx'] ?>')">
                                                <i class="fas fa-times"></i>
                                            </button>

                                        </td>
                                    <?php } ?>
                                </tr>
                        <?php }?>
                    </tbody>

                </table>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>

<script>
    function notpayment() {
        Swal.fire({
            icon: 'warning',
            title: 'ยังไม่ได้แจ้งชำระเงิน'
        })
    }

    function confirmPayment(data) {
        $.ajax({
            type: "POST",
            url: "Action/confirmPayment.php",
            data: {
                action: 'confirmPayment',
                bill: data
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ยืนยันรายการแล้ว'
                    })
                    setTimeout((e) => {
                        window.location = './?ProductStatus'
                    }, 1500);
                } else {
                    if (res.status == 'notdata') {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่พบรายการนี้'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?PendingProduct'
                    }, 1500);
                }
            }
        })
    }

    function cancelPayment(data) {
        $.ajax({
            type: "POST",
            url: "Action/confirmPayment.php",
            data: {
                action: 'cancelPayment',
                bill: data
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ยืนยันรายการแล้ว'
                    })
                    setTimeout((e) => {
                        window.location = './?PendingProduct'
                    }, 1500);
                } else {
                    if (res.status == 'notdata') {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่พบรายการนี้'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด'
                        })
                    }
                    // setTimeout((e) => {
                    //     window.location = './?PendingProduct'
                    // }, 1500);
                }
            }
        })
    }
</script>

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
</script>