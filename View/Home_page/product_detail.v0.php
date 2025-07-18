<?php
if ($_GET['product_detail'] == '' || $_GET['product_detail'] == null) {
    echo "<script>window.location = './?shop'</script>";
} else {
    $chk_detail = $con->query("SELECT * FROM `tblproduct` WHERE `product_id` = '" . $_GET['product_detail'] . "' ");
    if ($chk_detail->num_rows == 0) {
        echo "<script>window.location = './?shop'</script>";
    } else {
        $product = $chk_detail->fetch_assoc();
        $rows_detail = $con->query("SELECT * FROM `tblproduct_detail` WHERE `product_id` = '" . $_GET['product_detail'] . "'")->fetch_assoc();
    }
}
?>
<br>
<br>
<br>
<br>
<br>

<style>
    .btn-plus-minus {
        border: 1px solid #ddd;
        margin: 0 10px 0 10px;
    }

    #numberPlace {
        border: none !important;
        width: 15px;
        outline: none;
    }
</style>
<div class="container">
    <div class="box-shop">
        <div class="body-box">
            <div class="row">
                <div class="col-6 mb-3 text-center">
                    <img src="admin/assets/images/product/<?= $product['product_picshow'] ?>" width="80%" alt="">
                </div>
                <div class="col-6 mb-3 mt-5">
                    <div class="product-name">
                        <h3>
                            <?= $product['product_name'] ?>
                        </h3>
                    </div>
                    <div class="product-detail">
                        <h4>
                            <?= $product['product_subdetail'] ?>
                        </h4>
                    </div>
                    <hr>
                    <div class="product-price">
                        <span>ราคา
                            <?php if ($product['product_price']) {
                                echo number_format($product['product_price']);
                            } ?> บาท
                        </span>
                    </div>
                    <div class="product-qty">
                        <span>สินค้าคงเหลือ
                            <?= $product['product_qty'] ?> ชิ้น
                        </span>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-12 mb-3">
                            <span class="ms-2">จำนวน</span>
                            <div id="mainDiv" class="mt-2">
                                <button class="btn btn-lg btn-plus-minus" id="minus">-</button>
                                <input type="text" id="numberPlace" value="1" readonly>
                                <button class="btn btn-lg btn-plus-minus" id="plus">+</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <?php if ($product['product_qty'] != 0) { ?>
                                <?php if (isset($_SESSION['login'])) { ?>
                                    <button class="btn btn-dark w-100" style="border-radius: 15px ;"
                                        onclick="addcart('<?= $product['product_id'] ?>')">
                                        <i class="far fa-cart-plus"></i>
                                        เพิ่มสินค้าเข้าตะกร้า
                                    </button>
                                <?php } else { ?>
                                    <button class="btn btn-dark w-100" style="border-radius: 15px ;" onclick="loginale()">
                                        <i class="far fa-cart-plus"></i>
                                        เพิ่มสินค้าเข้าตะกร้า
                                    </button>
                                <?php } ?>
                            <?php } else { ?>
                                <button class="btn btn-danger w-100" style="border-radius: 15px ;" disabled>
                                    <i class="far fa-cart-plus"></i>
                                    สินค้าหมด
                                </button>
                            <?php } ?>
                        </div>

                        <div class="col-6">
                            <button class="btn btn-primary w-100" style="border-radius: 15px ;">
                                <i class="fad fa-headphones-alt"></i>
                                ติดต่อสอบถาม
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3 mt-3">
                    <div class="nav-link-item">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">รายละเอียดสินค้า</a>
                            </li>
                        </ul>
                    </div>
                    <div class="all-detail-product">
                        <div class="mt-3 mb-3">
                            <?= $rows_detail['product_detail'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var minusBtn = document.getElementById("minus"),
            plusBtn = document.getElementById("plus"),
            numberPlace = document.getElementById("numberPlace"),
            submitBtn = document.getElementById("submit"),
            number = 1,
            min = 1,
            max = <?= $product['product_qty'] ?>;

        minusBtn.onclick = function () {
            if (number > min) {
                number = number - 1;
                numberPlace.value = number;
            }
            if (number == min) {
                numberPlace.style.color = "red";
                setTimeout(function () {
                    numberPlace.style.color = "black"
                }, 500)
            } else {
                numberPlace.style.color = "black";
            }
        }
        plusBtn.onclick = function () {
            if (number < max) {
                number = number + 1;
                numberPlace.value = number;
            }
            if (number == max) {
                numberPlace.style.color = "red";
                setTimeout(function () {
                    numberPlace.style.color = "black"
                }, 500)
            } else {
                numberPlace.style.color = "black";
            }
        }

    });

    function loginale() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณา Login ก่อนสั่งซื้อ'
        }).then(function () {
            window.location = './?login';
        }), setTimeout(function () {
            window.location = './?login';
        }, 5000);
    }

    function addcart(data) {
        var countitem = $('#numberPlace').val()
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?addcart',
            data: {
                countitem: countitem,
                id: data
            },
            success: function (response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มสินค้าเข้าตะกร้าแล้ว !'
                    })
                    setTimeout((e) => {
                        window.location = './?product_detail=<?= $_GET['product_detail'] ?>'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })
                    setTimeout((e) => {
                        window.location = './?product_detail=<?= $_GET['product_detail'] ?>'
                    }, 1500);
                }
            }
        })
    }
</script>

<br>
<br>