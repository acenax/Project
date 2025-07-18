<?php
// when is not loggedin
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location = './?login';</script>";
}

$bill_no = (!empty($_GET['historybill'])) ? $_GET['historybill'] : 0;
$bill = $con->query("SELECT * FROM `tblrecord` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND bill_trx = '{$bill_no}' GROUP BY `bill_trx`")->fetch_assoc();

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
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="body-payment">
                <h4>
                    การสั่งซื้อของหมายเลข :
                    <?php echo $billtrx ?>
                </h4>
                <span style="font-size: 18px;">
                    สถานะ :
                    <?php
                    if ($bill['record_status'] == 'ยังไม่ได้แจ้งชำระเงิน') {
                        echo "<span class='badge bg-danger'> {$bill['record_status']} </span>";
                    } else {
                        echo "<span class='badge bg-success'> {$bill['record_status']} </span>";
                    }
                    ?>
                </span>
                <span>วันที่สั่งซื้อ :
                    <?php echo ThaiDatetime::to_human_date($bill['created']); ?>
                </span>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-payment">
                <div class="row">
                    <div class="col-12">
                        <h5>ข้อมูลจัดส่ง</h5>
                        <span>ชื่อผู้รับ :
                            <?php echo $bill['fname'] ?>
                            <?php echo $bill['lname'] ?>
                        </span><br>
                        <span>บ้านเลขที่ :
                            <?php echo $bill['userAddress_number'] ?>
                        </span>
                        <span>หมู่ที่ :
                            <?php echo $bill['userAddress_group'] ?>
                        </span> <br>
                        <span>ซอย :
                            <?php echo $bill['userAddress_alley'] ?>
                        </span>
                        <span>แยก :
                            <?php echo $bill['userAddress_separate'] ?>
                        </span> <br>
                        <span>ตำบล / แขวง :
                            <?php echo $bill['userAddress_district'] ?>
                        </span><br>
                        <span>อำเภอ / เขต :
                            <?php echo $bill['userAddress_canton'] ?>
                        </span> <br>
                        <span>จังหวัด :
                            <?php echo $bill['userAddress_province'] ?>
                        </span><br>
                        <span>รหัสไปรษณีย์ :
                            <?php echo $bill['userAddress_num_post'] ?>
                        </span> <br>
                        <span>หมายเลขโทรศัพท์ :
                            <?php echo $bill['phone'] ?>
                        </span>
                    </div>
                    <hr class="mt-4 mb-3">
                    <div class="col-12">
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
                            <?php
                            $databilltrx = $con->query("SELECT * FROM `tblrecord` WHERE `bill_trx` = '{$bill_no}'");
                            while ($row_bill = $databilltrx->fetch_assoc()) {
                                $product_id = $row_bill['product_id'];
                                $record_status = $row_bill['record_status'];
                                $val = $row_bill['counts'];
                                $address_post = $row_bill['record_address_post'];
                                $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = '{$product_id}'")->fetch_assoc();
                                $makeprice = $val * $rowcartproduct['product_price'];
                                $total_quantity += $val;
                                $total_price += $makeprice;
                            }

                            // $shipping_rate = (float) $bill['shipping_rate'];
                            // if ($total_price >= 3000) {
                            //     $shipping_rate = 0;
                            // }

                            ?>
                            <tbody>
                                <?php foreach ($databilltrx as $row_bill) { ?>
                                    <tr class="text-center">
                                        <td>
                                            <img src="./admin/assets/images/product/<?php echo $rowcartproduct['product_picshow'] ?>" width="50px" alt="">
                                        </td>
                                        <td>
                                            <?php echo $rowcartproduct['product_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($rowcartproduct['product_price'], 2) ?>
                                        </td>
                                        <td>
                                            <?php echo $val ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($total_price, 2) ?> บาท
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td></td>
                                    <td class="text-center">ยอดรวม
                                        <?php echo number_format($total_price, 2) ?> บาท
                                    </td>
                                    <td class="text-center" colspan="2">ค่าจัดส่งสินค้า
                                        <?php if (0 < (float) $bill['shipping_rate']) : ?>
                                        <?php echo number_format((float) $bill['shipping_rate'], 2); ?> บาท
                                        <?php else : ?>
                                            <?php printf('(%s)', $bill['record_address_post']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>ยอดรวมสุทธิ
                                        <?php echo number_format($total_price + (float) $bill['shipping_rate'], 2) . ' ' . 'บาท' ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mt-4 mb-3">
                    <style>
                        .sub-hisCart {
                            display: flex;
                            flex-direction: column;
                            margin-bottom: 20px;
                            align-items: center;
                            font-size: 17px;
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-6 sub-hisCart">
                            <?php $getbank = $con->query("SELECT * FROM `tblbank`")->fetch_assoc(); ?>
                            <span>วิธีการชำระเงิน</span>
                            <span>โอนเงินผ่านบัญชีธนาคาร</span>
                            <span>ธนาคาร :
                                <?php echo $getbank['bank_bank'] ?>
                            </span>
                            <span>เลขที่บัญชี :
                                <?php echo $getbank['bank_number'] ?> <br> ชื่อบัญชี :
                                <?php echo $getbank['bank_name'] ?>
                            </span>

                        </div>
                        <div class="col-lg-6 sub-hisCart">
                            <span>วิธีการจัดส่ง</span>
                            <span>
                                <?php echo $address_post ?>
                            </span>
                            <span>(ระยะเวลาขนส่ง 1-3 วัน)</span>
                        </div>
                        <?php
                        $get_payment = $con->query("SELECT * FROM `tblpayment` WHERE bill_trx = '" . $_GET['historybill'] . "'");
                        if ($get_payment->num_rows > 0) {
                            $rows_payment = $get_payment->fetch_assoc();
                        ?>
                            <hr>
                            <div class="col-lg-12 sub-hisCart">
                                <span>สลิปจ่ายเงิน</span>
                                <img src="./admin/assets/images/payment/<?php echo $rows_payment['payment_pic'] ?>" width="50%" alt="">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>