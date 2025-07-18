<?php
$records = [];
$rs = $con->query("SELECT * FROM `tblpayment` WHERE payment_status IN ('จัดส่งแล้ว') ");
while ($row = $rs->fetch_assoc()) {
    $records[] = $row;
}

?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">ติดตามสถานะการจัดส่งสินค้า </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (empty($records)) : ?>
                        <div class="text-center text-danger">(ไม่พบข้อมูล)</div>
                    <?php else : ?>
                        <table class="table" id="dataal">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>สถานะการจัดส่ง</th>
                                    <th>Express ที่จัดส่ง </th>
                                    <th>วันที่จัดส่ง </th>
                                    <th>วันที่ได้รับ</th>
                                    <th>เลขอ้างอิง</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($records as $i => $row) : ?>
                                    <tr <?php echo (!empty($row['payment_receipt_date'])) ? 'class="text-success"' : ''; ?>>
                                        <td><?php echo ++$i ?>.</td>
                                        <td><?php echo $row['bill_trx'] ?></td>
                                        <td><?php echo $row['payment_fullname'] ?></td>
                                        <td>
                                            <?php echo (!empty($row['payment_receipt_status'])) ? $row['payment_receipt_status'] : $row['payment_status']; ?>
                                        </td>
                                        <td><?php echo $row['payment_Express'] ?></td>
                                        <td><?php echo (empty($row['payment_ems_date'])) ? '(ยังไม่ได้ไม่ระบุ)' : ThaiDatetime::to_human_date((string) $row['payment_ems_date']); ?>
                                        </td>
                                        <td><?php echo (empty($row['payment_receipt_date'])) ? '(ยังไม่ได้ไม่ระบุ)' : ThaiDatetime::to_human_date((string) $row['payment_receipt_date']); ?>
                                        </td>
                                        <td><?php echo (empty($row['payment_ems'])) ? '(ยังไม่ได้ไม่ระบุ)' : $row['payment_ems']; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['payment_receipt_date'])) : ?>
                                                <a href="./?shipmentdetail=<?php echo $row['bill_trx']; ?>" target="_blank" class="btn btn-warning" title="รายละเอียด"><i class="fa fa-eye"></i></a>
                                            <?php else : ?>
                                                <a href="javascript:;" class="btn btn-default" title="รายละเอียด" disabled><i class="fa fa-eye"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
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