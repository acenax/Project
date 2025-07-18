<style>
    .chk_payment {
        border: 3px solid #36404e;
        padding: 20px 40px;
        border-radius: 5px;

    }

    h1,
    h3 {
        font-family: 'Mitr', sans-serif;
    }

    th {
        font-family: 'Mitr', sans-serif;
    }
</style>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>
</head>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 30px;">
                    <div class="chk_payment">
                        <div class="card">
                            <div class="card-header text-center">
                                <h1>สินค้าที่สั่งซื้อ</h1>
                                <!-- <small>หมายเลขที่สั่งซื้อ : 63cefd</small> -->
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>สินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ราคา/ชื้น</th>
                                            <th>จำนวน</th>
                                            <th>ราคารวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $databilltrx = $con->query("SELECT * FROM `tblrecord` WHERE `bill_trx` = '" . $_GET['check_payment'] . "' ");
                                        while ($row_bill = $databilltrx->fetch_assoc()) {
                                            $product_id = $row_bill['product_id'];
                                            $record_status = $row_bill['record_status'];
                                            $val = $row_bill['counts'];
                                            $address_post = $row_bill['record_address_post'];
                                            $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = '${product_id}'")->fetch_assoc();
                                            $makeprice = $val * $rowcartproduct['product_price'];
                                            $total_quantity += $val;
                                            $total_price += $makeprice;

                                        ?>
                                            <tr>
                                                <td>
                                                    <img src="../assets/images/product/<?= $rowcartproduct['product_picshow'] ?>" width="50px" alt="">
                                                </td>
                                                <td><?= $rowcartproduct['product_name']; ?></td>
                                                <td><?= $rowcartproduct['product_price'] ?></td>
                                                <td><?= $val ?></td>
                                                <td><?= $total_price ?> บาท</td>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td></td>
                                            <td class="text-center">ยอดรวม <?= number_format($total_price) ?> บาท</td>
                                            <td class="text-center" colspan="2"></td>
                                            <td>ยอดรวมสุทธิ <?= number_format($total_price ) . ' ' . 'บาท' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $rows_address = $con->query("SELECT * FROM `tblrecord` WHERE bill_trx = '" . $_GET['check_payment'] . "'")->fetch_assoc();  ?>
                <?php $rows_payment = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_GET['check_payment'] . "'")->fetch_assoc();  ?>
                <div class="col-xs-6">
                    <div class="card-body text-center" id="deliveryData">
                        <div class="chk_payment">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3>ข้อมูล ที่จัดส่ง</h3>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <h5>ข้อมูลจัดส่ง</h5>
                                    <span>ชื่อผู้รับ <?= $rows_address['fname'] ?> <?= $rows_address['lname'] ?></span><br>
                                    <span>บ้านเลขที่ <?= $rows_address['userAddress_number'] ?></span>
                                    <span>หมู่ที่ <?= $rows_address['userAddress_group'] ?></span><br>
                                    <span>ซอย <?= $rows_address['userAddress_alley'] ?></span>
                                    <span>ถนน <?= $rows_address['userAddress_separate'] ?></span><br>
                                    <span>ตำบล/แขวง <?= $rows_address['userAddress_district'] ?></span><br>
                                    <span>อำเภอ/เขต <?= $rows_address['userAddress_canton'] ?></span><br>
                                    <span>จังหวัด <?= $rows_address['userAddress_province'] ?></span><br>
                                    <span>รหัสไปรษณีย์ <?= $rows_address['userAddress_num_post'] ?></span><br>
                                    <span>หมายเลขโทรศัพท์ <?= $rows_address['phone'] ?></span><br>
                                    <span>หมายเหตุ</span>
                                    <textarea class="form-control" name="" id="" cols="28" rows="8" readonly><?= $rows_payment['payment_note'] ?></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-primary" onclick="takeScreenshot()">บันทึกภาพข้อมูลจัดส่ง</button>
                            </div>
                        </div>
                        <script>
                            function takeScreenshot() {
                                var deliveryData = document.getElementById("deliveryData");
                                html2canvas(deliveryData).then(function(canvas) {
                                    var link = document.createElement("a");
                                    link.href = canvas.toDataURL("image/png");
                                    link.download = "delivery_data_screenshot.png";
                                    link.click();
                                });
                            }
                        </script>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="chk_payment">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3>ข้อมูลแจ้งการชำระเงิน</h3>
                                <small>วันที่แจ้งโอน <?= $rows_payment['payment_date'] ?> เวลาที่แจ้งโอน <?= $rows_payment['payment_time'] ?></small>
                            </div>
                            <hr>
                            <div class="card-body text-center">
                                <img src="../assets/images/payment/<?= $rows_payment['payment_pic'] ?>" alt="" style="width: 350px; height: 550px;">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>