<?php
$dateNow = date("Ym");
$thai_months = [
    1 => 'มกราคม',
    2 => 'กุมภาพันธ์',
    3 => 'มีนาคม',
    4 => 'เมษายน',
    5 => 'พฤษภาคม',
    6 => 'มิถุนายน',
    7 => 'กรกฎาคม',
    8 => 'สิงหาคม',
    9 => 'กันยายน',
    10 => 'ตุลาคม',
    11 => 'พฤศจิกายน',
    12 => 'ธันวาคม'
];
$current_month = $thai_months[date("n")];
$current_year = date("Y");
?>
<div class="content-page">
    <div class="content">
        <div class="container">
            <form id="GEThistory">
                <input type="hidden" name="action" value="GEThistory">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">เลือกเดือนที่จะค้นหา</label>
                        <select class="form-control" name="m" id="">
                            <option value="01">มกราคม</option>
                            <option value="02">กุมภาพันธ์</option>
                            <option value="03">มีนาคม</option>
                            <option value="04">เมษายน</option>
                            <option value="05">พฤษภาคม</option>
                            <option value="06">มิถุนายน</option>
                            <option value="07">กรกฎาคม</option>
                            <option value="08">สิงหาคม</option>
                            <option value="09">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <label for="">เลือกปีที่จะค้นหา</label>
                        <input type="text" class="form-control" name="y" value="<?= date("Y") ?>">
                    </div>
                    <div class="col-xs-4">
                        <br>
                        <button type="submit" class="btn btn-info" style="margin-top: 7px;">
                            <i class="far fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <hr>
            <style>
                h3,
                th {
                    font-family: 'Mitr', sans-serif;
                }
            </style>
            <div class="row">

                <div class="col-xs-12">
                    <div class="card" style="border: 1px solid #ddd; padding: 10px 30px; border-radius: 5px ;">
                        <div class="card-header">
                            <h3>ประวัติของเดือน : <?= $current_month ?> ปี : <?= $current_year ?></h3>
                        </div>
                        <div class="card-body">
                            <table class="table" id="dataal">
                                <thead>
                                    <tr>
                                        <th>หมายเลขสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ราคา</th>
                                        <th>จำนวน</th>
                                        <th>ราคารวม</th>
                                        <th>วันที่ทำรายการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $total_all = 0;
                                    $get_record = $con->query("SELECT * FROM `tblrecord` WHERE EXTRACT(YEAR_MONTH FROM `created`) = '$dateNow' AND record_status = 'แจ้งชำระเงินแล้ว' AND record_payment_status = 'ยืนยันแล้ว'");
                                    while ($rows_record = $get_record->fetch_assoc()) {
                                        $get_product = $con->query("SELECT * FROM `tblproduct` WHERE product_id = '" . $rows_record['product_id'] . "'")->fetch_assoc();
                                        $total = $rows_record['price'] * $rows_record['counts'];
                                        $total_all = $total_all + $total;
                                    ?>
                                        <tr>
                                            <td><?= $rows_record['bill_trx'] ?></td>
                                            <td><?= $get_product['product_name'] ?></td>
                                            <td><?= $rows_record['price'] ?></td>
                                            <td><?= $rows_record['counts'] ?></td>
                                            <td><?= $total ?></td>
                                            <td><?= $rows_record['created'] ?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?=$total_all?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>



<script>
    $(function() {
        $(".modal").removeAttr("tabindex");
    });
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return JSON.stringify(indexed_array);
    }

    function wait() {
        swal.fire({
            html: '<h5>กรุณารอซักครู่...</h5>',
            showConfirmButton: false,
        });
    }
</script>

<script>
    $("#GEThistory").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: "POST",
            url: 'Action/history.php',
            data: data,
            beforeSend: (e) => {
                wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'ค้นหาสำเร็จ !'
                    })
                    setTimeout((e) => {
                        window.location = './?historyRecord=' + res.msg
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่พบประวัติที่ค้นหา !'
                    })
                    setTimeout((e) => {
                        window.location = './?history'
                    }, 1500);
                }
            }
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('#dataal').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Data export',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var tfoot = $('tfoot tr', '#dataal')[0];
                    var row = sheet.createElement('row');

                    $('td', tfoot).each(function(i, td) {
                        var cell = sheet.createElement('c');
                        cell.setAttribute('t', 'inlineStr');
                        var inlineStr = sheet.createElement('is');
                        var t = sheet.createElement('t');
                        var text = document.createTextNode(td.textContent);

                        t.appendChild(text);
                        inlineStr.appendChild(t);
                        cell.appendChild(inlineStr);
                        row.appendChild(cell);
                    });

                    sheet.getElementsByTagName('sheetData')[0].appendChild(row);
                }
            }],
            // ... other DataTables settings
        });
    });
    // $(document).ready(function() {
    //     $('#dataal').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: [
    //             'excel'
    //         ],
    //         "oLanguage": {
    //             "sLengthMenu": "แสดงรายการ _MENU_ รายการ ต่อหน้า",
    //             "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
    //             "sInfo": "จำนวน _START_ ถึง _END_ ใน _TOTAL_ รายการทั้งหมด",
    //             "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการทั้งหมด",
    //             "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
    //             "sSearch": "ค้นหา :",
    //             "aaSorting": [
    //                 [0, 'desc']
    //             ],
    //             "oPaginate": {
    //                 "sFirst": "หน้าแรก",
    //                 "sPrevious": "ก่อนหน้า",
    //                 "sNext": "ถัดไป",
    //                 "sLast": "หน้าสุดท้าย"
    //             },
    //         },
    //         "order": [
    //             [0, "desc"]
    //         ]
    //     });
    // });
</script>