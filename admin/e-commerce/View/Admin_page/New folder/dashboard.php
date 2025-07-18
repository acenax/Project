<br><br>

<style>
    h3,
    th {
        font-family: 'Mitr', sans-serif;
    }

    .box-content1 {
        background-color: #6ac1d1;
        width: 350px;
        height: 80px;
        margin-left: 10px;
        border-radius: 5px;
        color: #fff;
        padding: 5px 30px 5px 50px;
        box-shadow: 5px 5px #cecccc;
    }

    .box-content2 {
        background-color: #68e86e;
        width: 350px;
        height: 80px;
        margin-left: 10px;
        border-radius: 5px;
        color: #fff;
        padding: 5px 30px 5px 50px;
        box-shadow: 5px 5px #cecccc;
    }

    .box-content3 {
        background-color: #e8ae68;
        width: 350px;
        height: 80px;
        margin-left: 10px;
        border-radius: 5px;
        color: #fff;
        padding: 5px 30px 5px 50px;
        box-shadow: 5px 5px #cecccc;
    }

    .box-content4 {
        background-color: #f74c4c;
        width: 350px;
        height: 80px;
        margin-left: 10px;
        border-radius: 5px;
        color: #fff;
        padding: 5px 30px 5px 50px;
        box-shadow: 5px 5px #cecccc;
    }
</style>

<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <div class="box-content1">
                        <?php
                        $total = 0;
                        $get_price = $con->query("SELECT * FROM `tblrecord` WHERE record_payment_status = 'ยืนยันแล้ว' AND record_status = 'แจ้งชำระเงินแล้ว'");
                        while ($price = $get_price->fetch_assoc()) {
                            $price_tot = $price['counts'] * $price['price'];
                            $total += $price_tot;
                        }
                        ?>
                        <h3 style="color: #fff;"><?= $total ?> บาท</h3>
                        <span>รายได้ทั้งหมด </span>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="box-content2">
                        <?php
                        $get_Payent = $con->query("SELECT COUNT(`payment_status`) as tot_payment FROM `tblpayment` WHERE `payment_status` = 'ยืนยันแล้ว กำลังเตรียมการจัดส่ง'")->fetch_assoc();
                        ?>
                        <h3 style="color: #fff;"><?= $get_Payent['tot_payment'] ?> ชิ้น</h3>
                        <span>จำนวนสินค้ารอจัดส่ง</span>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="box-content3">
                        <?php
                        $get_record = $con->query("SELECT COUNT(`record_id`) as tot_record FROM `tblrecord` WHERE `record_status` = 'แจ้งชำระเงินแล้ว' AND record_payment_status = 'รอการยืนยัน'")->fetch_assoc();
                        ?>
                        <h3 style="color: #fff;"><?= $get_record['tot_record'] ?> ชิ้น</h3>
                        <span>จำนวนรายการสินค้ารออนุมัติ</span>
                        <?php
                            if($get_record['tot_record'] > 0){
                                $total_record = $get_record['tot_record'];
                                echo "<script>";
                                echo "Swal.fire({";
                                echo "icon: 'warning',";
                                echo "title: 'มีรายการสินค้ารออนุมัติ $total_record ชิ้น'";
                                echo "})";
                                echo "</script>";
                            }
                        ?>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="box-content4">
                        <?php
                        $get_prodcut = $con->query("SELECT COUNT(`product_qty`) as tot_product FROM `tblproduct` WHERE `product_qty` < 10")->fetch_assoc();
                        ?>
                        <h3 style="color: #fff;"><?= $get_prodcut['tot_product'] ?> ชิ้น</h3>
                        <span>สินค้าใกล้หมดสต๊อก</span>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
                    <div class="card" style="border: 1px solid #ddd; padding: 10px 30px; border-radius: 5px ;">
                        <canvas id="myChart" width="400" height="100"></canvas>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card" style="border: 1px solid #ddd; padding: 10px 30px; border-radius: 5px ;">
                        <div class="card-header">
                            <h3>สินค้าใกล้หมดสต๊อก</h3>
                        </div>
                        <div class="card-body">
                            <table class="table" id="dataal">
                                <thead>
                                    <tr>
                                        <th>รูป</th>
                                        <th>รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวน</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get_low_product = $con->query("SELECT * FROM `tblproduct` WHERE product_qty < 10");
                                    while ($rows_data = $get_low_product->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="../assets/images/product/<?= $rows_data['product_picshow'] ?>" alt="" width="60px">
                                            </td>
                                            <td><?= $rows_data['product_code'] ?></td>
                                            <td><?= $rows_data['product_name'] ?></td>
                                            <td><?= $rows_data['product_qty'] ?></td>
                                            <td>
                                                <button class="btn btn-info" onclick="window.location = './?Product'">จัดการเพิ่มสินค้า</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$getdata = $con->query("SELECT product_id, SUM(counts) AS tot FROM tblrecord GROUP BY product_id order by SUM(counts) DESC LIMIT 5");
$getdata2 = $con->query("SELECT product_id, SUM(counts) AS tot FROM tblrecord GROUP BY product_id order by SUM(counts) DESC LIMIT 5");
?>


<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                while ($rows_counts2 = $getdata2->fetch_assoc()) {
                    $product = $con->query("SELECT * FROM `tblproduct` WHERE product_id = '" . $rows_counts2['product_id'] . "'")->fetch_assoc();
                    $proname = $product['product_name'];
                ?> '<?= "$proname" ?>',
                <?php } ?>
            ],
            datasets: [{
                label: 'สินค้าขายดี',
                data: [
                    <?php while ($rows_counts = $getdata->fetch_assoc()) { ?>
                        <?= $rows_counts['tot'] ?>,
                    <?php } ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
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