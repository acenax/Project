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
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-payment">
                <h3 class="text-center">ตะกร้าสินค้า</h3>
            </div>
        </div>

        <?php if (isset($_SESSION['cart']['product_id'])) { ?>
            <div class="col-lg-8 mb-3">
                <div class="body-payment">
                    <div class="row">
                        <div class="col-lg-1 text-center font-weight-bold">
                            <span>สินค้า</span>
                        </div>

                        <div class="col-lg-4 d-none d-lg-block px-0">
                        </div>

                        <div class="col-lg-2 text-end font-weight-bold">
                            <span>ราคา/ชิ้น</span>
                        </div>

                        <div class="col-lg-2 text-center font-weight-bold">
                            <span>จำนวน</span>
                        </div>

                        <div class="col-lg-2 text-end font-weight-bold">
                            <span>ราคารวม</span>
                        </div>

                        <div class="col-lg-1 text-center font-weight-bold">
                        </div>
                    </div>
                    <hr>

                    <?php
                    $total_quantity = 0;
                    foreach ($_SESSION['cart']['product_id'] as $key => $val) {

                        $rowcartproduct = $con->query("SELECT * FROM tblproduct WHERE product_id = '{$key}'")->fetch_assoc();

                        $makeprice = $val * $rowcartproduct['product_price'];
                        $total_quantity += $val;
                        $price = $val * $rowcartproduct['product_price'];
                        $total_price += $makeprice;
                        $product_quantity = $rowcartproduct['product_qty'] - $val;
                        $_SESSION['product_quantity'] = $product_quantity;
                        $_SESSION['total_quantity'] = $total_quantity;
                    ?>
                        <div class="row mb-4">
                            <div class="col-1">
                                <img src="./admin/assets/images/product/<?php echo  $rowcartproduct['product_picshow'] ?>" width="50px" height="50px" alt="">
                            </div>


                            <div class="col-4">
                                <span><?php echo $rowcartproduct['product_name']; ?></span><br>
                                <span style="font-size: smaller; color: grey;">
                                    <small>จำนวนที่เหลือ
                                        <?php echo  number_format((float)$rowcartproduct['product_qty']) ?>
                                        ชิ้น
                                    </small>
                                </span>
                            </div>


                            <div class="col-2 text-end">
                                <small>
                                    <?php echo number_format((float)$rowcartproduct['product_price'], 2); ?> บาท
                                </small>
                            </div>
                            <!-- จำนวนสินค้าหน้า cast_shop -->
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-btn"><button type="button" class="btn btn-default btn-sm" onclick="minuscart('<?php echo  $rowcartproduct['product_id'] ?>')"><i class="fa fa-minus"></i></button></span>
                                    </div>
                                    <input type="text" value="<?php echo $val ?>" id="numberInput" class="form-control form-control-sm text-center" onchange="updateCart('<?php echo  $rowcartproduct['product_id'] ?>', this.value)">
                                    <div class="input-group-append">
                                        <span class="input-group-btn"><button type="button" class="btn btn-default btn-sm" onclick="addcart('<?php echo  $rowcartproduct['product_id'] ?>')"><i class="fa fa-plus"></i></button></span>
                                    </div>
                                </div>

                            </div>
                            <!-- จบจำนวนสินค้าหน้า cast_shop -->
                            <div class="col-2 text-end">
                                <small><?php echo number_format($price, 2) ?> บาท</small>
                            </div>

                            <div class="col-1 text-center">
                                <i class="far fa-trash-alt adelete" data-id="<?php echo  $rowcartproduct['product_id'] ?>" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        <!-- eof .row -->
                    <?php } ?>
                    <hr>
                    <div class="row">
                        <div class="col text-end">
                            <button class="btn btn-danger btn_empty" data-id="<?php echo  $rowcartproduct['product_id'] ?>" id="btnEmpty">ลบสินค้าในตะกร้าทั้งหมด</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start text-danger mt-2">
                        <!-- Add your comment here -->
                        <span class="text-danger font-weight-bold"> #ส่งฟรีทั่วไทย
                            ช้อปครบ 3,000.- ขึ้นไป</span>
                    </div>

                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="body-payment">
                    <div class="row">
                        <div class="col-12">
                            <h3>ยอดรวมตะกร้าสินค้า</h3>
                        </div>
                        <hr>
                        <div class="col-12">
                            <span>ยอดรวมสินค้า <?php echo  $total_quantity ?> ชิ้น</span>
                            <span class="text-B"><?php echo  number_format($total_price) ?> บาท</span>
                        </div>

                        <div class="col-12">
                            <hr class="hr-Dotted">
                        </div>

                        <div class="col-12">
                            <span>ยอดรวมตะกร้าสินค้า</span>
                            <span class="text-B"><?php echo  number_format($total_price) ?> บาท</span>
                        </div>

                        <div class="col-12">
                            <hr class="hr-Dotted">
                        </div>
                        <div class="text-end btnComfirm_text">
                            <?php if (isset($_SESSION['login'])) : ?>
                                <a href="./?payment_product" class="btn btn-primary">สั่งซื้อสินค้า</a>
                            <?php else : ?>
                                <a href="javascript:;" class="btn btn-primary" onclick="loginale();">สั่งซื้อสินค้า</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php  } else { ?>
            <div class="col-12 mb-3">
                <div class="body-payment">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6 text-center">
                            <div class="mb-3">
                                <br>
                                <div class="icon-header-cart">
                                    <h1 style="color: #ccc; font-size: 65px;"><i class="far fa-shopping-cart"></i></h1>
                                </div>
                                <br>
                                <div class="text-header-cart">
                                    <h1 style="color: #ccc;">ไม่มีสินค้าในตะกร้าของคุณ</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                        <div class="col-6 mt-3">
                            <div class="text-center mb-3">
                                <button class="btn btn-dark" onclick="window.location= './?shop'">
                                    <i class="far fa-shopping-cart"></i>
                                    กลับไปซื้อสินค้า
                                </button>
                            </div>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
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
<br>
<br>
<br>
<br>
<br>
<br>


<script>
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

    function loginale() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณา Login ก่อนค่ะ'
        }).then(function() {
            window.location = './?login';
        }), setTimeout(function() {
            window.location = './?login';
        }, 5000);
    }

    function addcart(productId) {
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?addcart',
            data: {
                id: productId,
                countitem: 1
            },
            success: function(response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Toast.fire({
                        icon: 'success',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                }
            }
        })
    }

    function minuscart(productId) {
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?minuscart',
            data: {
                id: productId,
                countitem: 1
            },
            success: function(response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Toast.fire({
                        icon: 'success',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                }
            }
        })
    }

    function updateCart(productId, newCount) {
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?update_cart',
            data: {
                id: productId,
                countitem: newCount
            },
            success: function(response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Toast.fire({
                        icon: 'success',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.msg,
                    })
                    setTimeout((e) => {
                        window.location = './?Cart_shop'
                    }, 1500);
                }
            }
        });
    }

    $('#btnEmpty').click(function(e) {
        var product_id = $(this).data('id')
        e.preventDefault();
        clearcart(product_id);
    })

    function clearcart(product_id) {
        Swal.fire({
            title: 'คุณแน่ใจใช่ไหม ?',
            text: "คุณจะไม่สามารถย้อนกลับได้นะ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        type: "POST",
                        url: 'Action/cart.php?clearcart',
                        data: {
                            product_id: product_id,
                        },
                        success: function(response) {
                            let data = JSON.parse(response)
                            if (data.status == "success") {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.msg,
                                })
                                setTimeout((e) => {
                                    window.location = './?Cart_shop'
                                }, 1500);
                            }
                        }
                    });
                });
            },
        });
    }

    $('.adelete').click(function(e) {
        var product_id = $(this).data('id')
        e.preventDefault();
        deleteitmecart(product_id);
    })

    function deleteitmecart(product_id) {
        Swal.fire({
            title: 'คุณแน่ใจใช่ไหม ?',
            text: "คุณจะไม่สามารถย้อนกลับได้นะ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        type: "POST",
                        url: 'Action/cart.php?deleteitmecart',
                        data: {
                            product_id: product_id,
                        },
                        success: function(response) {
                            let data = JSON.parse(response)
                            if (data.status == "success") {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'ลบสินค้าแล้ว !',
                                })
                                setTimeout((e) => {
                                    window.location = './?Cart_shop'
                                }, 1500);
                            }
                            alerts(data.status, data.msg);
                        }
                    });
                });
            },
        });
    }
</script>