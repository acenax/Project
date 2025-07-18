<?php
$user = $con->query("SELECT * FROM `tbluser` WHERE `user_id` = '" . $_SESSION['user_id'] . "'")->fetch_assoc();

// shiping address
$addresss = [];
$curaddr = [];
$rs = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '{$user['user_id']}' ORDER BY userAddress_id DESC;");
while ($row = $rs->fetch_assoc()) {
    $addresss[] = $row;

    if (!empty($_SESSION['address']) && $_SESSION['address'] == $row['userAddress_id']) {
        $curaddr = $row;
    } else if (empty($_SESSION['address'])) {
        $curaddr = $row;
    }
}

// shipping
$shippings = [];
$curshipping = [];
$sql = "SELECT * FROM `tblshipping` WHERE (`status` = 'ACTIVE') ORDER BY shipping_rate ASC;";
$rs = $con->query($sql);
while ($row = $rs->fetch_assoc()) {
    $shippings[] = $row;
    if (!empty($_SESSION['shipping']) && $_SESSION['shipping'] == $row['shipping_id']) {
        $curshipping = $row;
    } else if (empty($_SESSION['shipping'])) {
        $curshipping = $row;
    }
}

// orders
$products = [];
$total = [
    'currency' => 0,
    'qty' => 0
];

if (!empty($_SESSION['cart']['product_id'])) {
    $rs = $con->query("SELECT `product_id`, `product_name`, `product_price`, `product_picshow` FROM `tblproduct` WHERE (`product_id` IN ('" . implode("','", array_keys($_SESSION['cart']['product_id'])) . "'));");
    while ($row = $rs->fetch_assoc()) {
        $row['qty'] = (!empty($_SESSION['cart']['product_id'])) ? (int) $_SESSION['cart']['product_id'][$row['product_id']] : 0;
        $row['currency'] = ($row['qty']) * (!empty($row['product_price']) ? (float) $row['product_price'] : 0);

        $total['qty']++;
        $total['currency'] += $row['currency'];

        $products[] = $row;
    }
}
?>
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


<div class="container mt-5">
    <form id="confirm-order">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="header-payment">
                    <h3 class="text-center">ยืนยันการสั่งซื้อ</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="body-payment">
                    <h5>ชื่อ-สกุล ผู้รับ</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="">ชื่อ</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user['user_fname'] ?>" name="user_fname">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="">นามสกุล</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user['user_lname'] ?>" name="user_lname">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="">เบอร์โทร</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user['user_phone'] ?>" name="user_phone">
                        </div>
                    </div>
                    <h5 class="mt-4">ที่อยู่จัดส่ง</h5>
                    <hr>
                    <div class="row" id="shipping-address">
                        <div class="col-6 mb-3">
                            <label for="">บ้านเลขที่</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_number'] ?>" name="userAddress_number">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">หมู่ที่</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_group'] ?>" name="userAddress_group">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">ซอย</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_alley'] ?>" name="userAddress_alley">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">ถนน</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_separate'] ?>" name="userAddress_separate">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">ตำบล / แขวง</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_district'] ?>" name="userAddress_district">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">อำเภอ / เขต</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_canton'] ?>" name="userAddress_canton">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">จังหวัด</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_province'] ?>" name="userAddress_province">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" readonly value="<?php echo $curaddr['userAddress_post'] ?>" name="userAddress_post">
                        </div>

                        <input type="hidden" name="userAddress_id" value="<?php echo $curaddr['userAddress_id']; ?>">
                    </div>
                    <div class="row">
                        <div class="col-12 mt-4">
                            <div class="btn-group float-end">
                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    เปลี่ยนแปลงที่อยู่จัดส่ง
                                </button>
                                <ul class="dropdown-menu">
                                    <?php foreach ($addresss as $addr) : ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:;" onclick="getAddr(<?php echo $addr['userAddress_id']; ?>);">
                                                <?php printf('%s %s %s %s', 'บ้านเลขที่', $addr['userAddress_number'], 'หมู่ที่', $addr['userAddress_group']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <?php if (!empty($addresss)) : ?>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addAddrModal">เพิ่มที่อยู่</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">ค่าจัดส่ง</h5>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="" class="mb-2">เลือกผู้จัดส่ง</label>
                            <select class="form-select" name="shipping" id="shipping">
                                <?php foreach ($shippings as $shipping) : ?>
                                    <option value="<?php echo $shipping['shipping_id']; ?>" <?php echo ($curshipping['shipping_id'] == $shipping['shipping_id']) ? 'selected' : ''; ?>>
                                        <?php printf('%s (ค่าจัดส่ง %s บาท) ', $shipping['provider_name'], number_format($shipping['shipping_rate'], 2)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- epf left -->

            <div class="col-md-6 mb-3">
                <div class="body-payment">
                    <div class="header-payments">
                        <h5>สรุปรายการสั่งซื้อ</h5>
                    </div>
                    <hr>
                    <div class="order-payment">
                        <?php foreach ($products as $pd) : ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="./admin/assets/images/product/<?php echo $pd['product_picshow'] ?>" alt="<?php echo $pd['product_name']; ?>" class="w-100">
                                </div>
                                <div class="col-md-10">
                                    <div>
                                        <?php echo $pd['product_name']; ?>
                                    </div>
                                    <div class="text-end">
                                        <small>
                                            <?php printf('%s %s X %s %s', $pd['qty'], 'ชิ้น', number_format($pd['product_price'], 2), 'บาท'); ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <small>
                                            <?php printf('%s %s %s', 'รวม', number_format($pd['currency'], 2), 'บาท'); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                        <?php
                        // Check if the total order amount is equal to or greater than 3000
                        if ($total['currency'] >= 3000) {
                            $shipping_rate = 0; // Free shipping for orders over 3000
                            // $shipping_provider_name = 'ส่งฟรีทั่วไทย'; // Change the shipping provider name
                        } else {
                            $shipping_rate = (float) $curshipping['shipping_rate'];
                        }

                        $shipping_provider_name = $curshipping['provider_name'];
                        ?>

                        <div class="row">
                            <div class="col-md-9">ยอดรวมสินค้า (
                                <?php printf('%s %s', $total['qty'], 'รายการ'); ?>)
                            </div>
                            <div class="col-md-3 text-end">
                                <?php printf('%s %s', number_format($total['currency'], 2), 'บาท'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">ค่าจัดส่ง (
                                <?php echo $shipping_provider_name; ?>)
                            </div>
                            <div class="col-md-3 text-end">
                                <?php if (0 < $shipping_rate) : ?>
                                <?php printf('%s %s', number_format((float) $shipping_rate, 2), 'บาท'); ?>
                                <?php else : ?>
                                    (ส่งฟรีทั่วไทย)
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">ยอดรวมสุทธิ</div>
                            <div class="col-md-3 text-end">
                                <?php printf('%s %s', number_format($total['currency'] + (float) $shipping_rate, 2), 'บาท'); ?>
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="row">
                            <div class="submitform text-end">
                                <button type="button" class="btn btn-primary" onclick="confirm_order()">ยืนยันการสั่งซื้อ</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- eof right -->
        </div>
        <!-- eof .row -->
    </form>
</div>


<div class="modal fade" id="addAddrModal" tabindex="-1" aria-labelledby="addAddrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="add-address">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddrModalLabel">เพิ่มที่อยู่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">บ้านเลขที่</label>
                                <input type="text" class="form-control" name="userAddress_number" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" name="userAddress_group" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ซอย</label>
                                <input type="text" class="form-control" name="userAddress_alley" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ถนน</label>
                                <input type="text" class="form-control" name="userAddress_separate" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ตำบล/แขวง</label>
                                <input type="text" class="form-control" name="userAddress_district" id="district1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">อำเภอ/เขต</label>
                                <input type="text" class="form-control" name="userAddress_canton" id="amphoe1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">จังหวัด</label>
                                <input type="text" class="form-control" name="userAddress_province" id="province1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">รหัสไปรษณีย์</label>
                                <input type="text" class="form-control" name="userAddress_post" id="zipcode1" autocomplete="off">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="save_address">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function wait() {
        swal.fire({
            html: '<h5>กรุณารอซักครู่...</h5>',
            showConfirmButton: false,
        });
    }

    function confirm_order() {
        // var address_Post = $("#address_Post").val()
        // $.ajax({
        //     type: "POST",
        //     url: "Action/cart.php?confirmorder",
        //     data: {
        //         id: data,
        //         address_Post: address_Post,
        //     },
        //     success: function(response) {
        //         console.log(response)
        //         let data = JSON.parse(response)
        //         if (data.status == "success") {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'โปรดแจ้งชำระเงิน !',
        //             })
        //             setTimeout((e) => {
        //                 window.location = './?history'
        //             }, 1500);
        //         } else {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
        //             })
        //             setTimeout((e) => {
        //                 window.location = './?Cart_shop'
        //             }, 1500);
        //         }
        //     }
        // });

        var form = $("#confirm-order")[0]
        var formdata = new FormData(form)

        $.ajax({
            type: "POST",
            url: 'Action/cart.php?confirmorder',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (e) => {
                wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setTimeout((e) => {
                        window.location = './?history'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            },
        });
    }


    function getAddr(id) {
        $.ajax({
            type: "POST",
            url: 'Action/user.php',
            data: {
                action: 'getAddr',
                id: id
            },
            beforeSend: (e) => {
                // wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    const $addr = $("#shipping-address");
                    $("input[name='userAddress_number']", $addr).val(res.msg.userAddress_number);
                    $("input[name='userAddress_group']", $addr).val(res.msg.userAddress_group);
                    $("input[name='userAddress_alley']", $addr).val(res.msg.userAddress_alley);
                    $("input[name='userAddress_separate']", $addr).val(res.msg.userAddress_separate);
                    $("input[name='userAddress_district']", $addr).val(res.msg.userAddress_district);
                    $("input[name='userAddress_province']", $addr).val(res.msg.userAddress_province);
                    $("input[name='userAddress_post']", $addr).val(res.msg.userAddress_post);
                    $("input[name='userAddress_id']", $addr).val(res.msg.userAddress_id);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            },
        });


        $.ajax({
            type: "POST",
            url: 'Action/confirmOrder.php',
            data: {
                action: 'update_address',
                id: id
            },
            beforeSend: (e) => {
                // wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                // if (res.status == "success") {
                //     Swal.fire({
                //         icon: 'success',
                //         title: res.msg
                //     })
                // } else {
                //     Swal.fire({
                //         icon: 'error',
                //         title: res.msg
                //     })
                // }
            },
        });
    }

    $("#add-address").submit(function(e) {
        e.preventDefault();

        var form = $("#add-address")[0]
        var formdata = new FormData(form)

        $.ajax({
            type: "POST",
            url: 'Action/user.php',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (e) => {
                wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setTimeout((e) => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            },
        });
    });

    $("#shipping").on('change', function() {
        const $self = $(this);
        $.ajax({
            type: "POST",
            url: 'Action/confirmOrder.php',
            data: {
                action: 'update_shipping',
                id: $self.val(),
            },
            beforeSend: (e) => {
                // wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: res.msg
                    // })
                    window.location.reload();
                } else {
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: res.msg
                    // })
                }
            },
        });
    })
</script>
