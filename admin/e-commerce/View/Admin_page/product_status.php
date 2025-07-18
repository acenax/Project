<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่มเลขจัดส่งให้รายการ </h4>
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
                            <th>สถานะรายการ</th>
                            <th>การจัดส่งที่ลูกค้าอยากให้จัดส่ง </th>
                            <th>Express ที่จัดส่ง </th>
                            <th>หมายเลข EMS </th>
                            <th>เพิ่มเลขจัดส่ง</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $payment = $con->query("SELECT * FROM `tblpayment` WHERE payment_status = 'ยืนยันแล้ว กำลังเตรียมการจัดส่ง' OR payment_status = 'จัดส่งแล้ว' ");

                        while ($rows_payemt = $payment->fetch_assoc()) {
                            $i++;
                            $record = $con->query("SELECT * FROM `tblrecord` WHERE bill_trx = '" . $rows_payemt['bill_trx'] . "'")->fetch_assoc();
                        ?>
                            <tr>
                                <td><?= $i ?> </td>
                                <td><?= $rows_payemt['bill_trx'] ?></td>
                                <td><?= $rows_payemt['payment_fullname'] ?></td>
                                <td><?= $rows_payemt['payment_status'] ?></td>
                                <td><?= $record['record_address_post'] ?></td>
                                <td><?= $rows_payemt['payment_Express'] ?></td>
                                <td>
                                    <?php
                                    if ($rows_payemt['payment_ems'] == null) {
                                        echo 'ยังไม่ได้ทำการจัดส่ง';
                                    } else {
                                        echo $rows_payemt['payment_ems'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-info" onclick="addems('<?= $rows_payemt['bill_trx'] ?>')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

</div>




<script>
    function addems(bill) {
        Swal.fire({
            title: 'กรอกหมายเลข EMS',
            html: '<input id="swal-input1" class="form-control" style="margin-bottom: 10px;">' +
                '<select class="form-control" id="swal-input2"><option>ไปรษณีย์ไทย</option><option>J&T Express</option><option>Kerry Express</option><option>Flash Express</option></select>',
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ปิด',
            showLoaderOnConfirm: true,
        }).then((result) => {
            var input1 = $('#swal-input1').val()
            var input2 = $('#swal-input2').val()
            $.ajax({
                type: "POST",
                url: "Action/addems.php",
                data: {
                    action: 'addems',
                    input2: input2,
                    input1: input1,
                    bill: bill
                },
                success: (data) => {
                    let res = JSON.parse(data)
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ '
                        })
                        setTimeout((e) => {
                            window.location = './?ProductStatus'
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ '
                        })
                        setTimeout((e) => {
                            window.location = './?ProductStatus'
                        }, 1500);
                    }
                }
            });
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