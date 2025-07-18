<br><br><br>

<style>
    .body-payment {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 50px 40px 30px 40px;
        box-shadow: 5px 5px #cecccc;
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
        padding: 30px 10px;
        box-shadow: 5px 5px #cecccc;
    }

    .product-name {
        width: 100%;
        word-wrap: break-word;
    }

    .summarize,
    .post-order,
    .total-price {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>


<?php
$user = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_SESSION['user_id'] . "'")->fetch_assoc();
$chk_address = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $user['user_id'] . "'");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-payment">
                <h3 class="text-center">ยืนยันการสั่งซื้อ</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="body-payment">
                <div class="header-payments">
                    <h5>ที่อยู่จัดส่ง</h5>
                </div>
                <hr>
                <div class="address-payment">
                    <?php if ($chk_address->num_rows == 0) { ?>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-dark" onclick="window.location = './?Address'">
                                    <i class="far fa-plus"></i>
                                    เพิ่มที่อยู่
                                </button>
                            </div>
                        </div>
                        <?php
                    } else {
                        $address = $chk_address->fetch_assoc(); ?>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="">ชื่อ</label>
                                <input type="text" class="form-control" readonly value="<?= $user['user_fname'] ?>"
                                    name="user_fname">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">นามสกุล</label>
                                <input type="text" class="form-control" readonly value="<?= $user['user_lname'] ?>"
                                    name="user_lname">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">เบอร์โทร</label>
                                <input type="text" class="form-control" readonly value="<?= $user['user_phone'] ?>"
                                    name="user_phone">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">บ้านเลขที่</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_number'] ?>" name="userAddress_number">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_group'] ?>" name="userAddress_group">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">ซอย</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_alley'] ?>" name="userAddress_alley">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">แยก</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_separate'] ?>" name="userAddress_separate">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">ตำบล / แขวง</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_district'] ?>" name="userAddress_district">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">อำเภอ / เขต</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_canton'] ?>" name="userAddress_canton">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">จังหวัด</label>
                                <input type="text" class="form-control" readonly
                                    value="<?= $address['userAddress_province'] ?>" name="userAddress_province">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">รหัสไปรษณีย์</label>
                                <input type="text" class="form-control" readonly value="<?= $address['userAddress_post'] ?>"
                                    name="userAddress_post">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">เลือกการจัดส่ง</label>
                                <select class="form-select" id="address_Post">
                                    <option value="ไปรษณีย์ไทย" selected>ไปรษณีย์ไทย ราคา 60 บาท</option>
                                    <option value="J&T Express">J&T Express ราคา 60 บาท</option>
                                    <option value="Kerry Express">Kerry Express ราคา 60 บาท</option>
                                    <option value="Flash Express">Flash Express ราคา 60 บาท</option>
                                </select>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="body-payment">
                <div class="header-payments">
                    <h5>สรุปรายการสั่งซื้อ</h5>
                </div>
                <hr>
                <div class="order-payment">
                    <div class="row">
                        <?php
                        $total_quantity = 0;
                        $total_price = 0;
                        if (isset($_SESSION["cart"])) {
                            foreach ($_SESSION['cart']['product_id'] as $key => $val) {
                                $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = ${key}")->fetch_assoc();
                                $makeprice = $val * $rowcartproduct['product_price'];
                                $total_quantity += $val;
                                $price = $val * $rowcartproduct['product_price'];
                                $total_price += $makeprice;
                                $order_express = 60;
                                $totalplus60 = $total_price + $order_express;
                                ?>
                                <div class="col-12">
                                    <div class="product-name">
                                        <img src="./admin/assets/images/product/<?= $rowcartproduct['product_picshow'] ?>"
                                            width="50px" height="50px" alt="">
                                        <span class=" ms-3">
                                            <?= $rowcartproduct['product_name'] ?>
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <small>จำนวน
                                            <?= $val ?> ชิ้น * ราคา
                                            <?php if ($rowcartproduct['product_price']) {
                                                echo number_format($rowcartproduct['product_price']);


                                            } ?> =
                                            <?php if ($price) {
                                                echo number_format($price);
                                            } ?> บาท
                                        </small>
                                    </div>
                                    <hr>

                                </div>
                                <?php
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="summarize">
                                <span>ยอดรวมสินค้า
                                    <?= $total_quantity ?> ชิ้น
                                </span>
                                <span>จำนวน
                                    <?php if ($rowcartproduct['product_price']) {
                                        echo number_format($rowcartproduct['product_price']);
                                    } ?> บาท
                                </span>
                            </div>
                            <div class="post-order">
                                <span>ค่าจัดส่ง </span>
                                <span>จำนวน
                                    <?= $order_express ?> บาท
                                </span>
                            </div>
                            <div class="total-price">
                                <span>ยอดรวมสุทธิ </span>
                                <span>จำนวน
                                    <?php if ($totalplus60) {
                                        echo number_format($totalplus60);
                                    } ?> บาท
                                </span>
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="row">
                            <div class="submitform text-end">
                                <button type="button" class="btn btn-primary"
                                    onclick="confirm_order('<?= $rowcartproduct['product_id'] ?>')">ยืนยันการสั่งซื้อ</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirm_order(data) {
        var address_Post = $("#address_Post").val()
        $.ajax({
            type: "POST",
            url: "Action/cart.php?confirmorder",
            data: {
                id: data,
                address_Post: address_Post,
            },
            success: function (response) {
                console.log(response)
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'โปรดแจ้งชำระเงิน !',
                    })
                    setTimeout((e) => {
                        window.location = './?history'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                }
            }
        });
    }
</script>