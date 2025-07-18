<?php
$id = (!empty($_GET['product_detail'])) ? (int) $_GET['product_detail'] : 0;
$product = $con->query("SELECT * FROM `tblproduct` WHERE `product_id` = '{$id}' LIMIT 1;")->fetch_assoc();
$detail = $con->query("SELECT * FROM `tblproduct_detail` WHERE `product_id` = '{$id}' LIMIT 1")->fetch_assoc();

$type_id = (!empty($product)) ? $product['product_typeID'] : 0;
$product_type = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '{$type_id}'")->fetch_assoc();

$files = [];
$sql = "SELECT * FROM `tblproduct_files` WHERE (`product_id` = '{$id}') ORDER BY `is_default` ASC;";
$rs = $con->query($sql);
while ($row = $rs->fetch_assoc()) {
    $files[] = $row;
}

$product_file_dir = sprintf('%s/%s', 'admin', PRODUCT_FILE_DIR);
$product_image = sprintf('%s/%s', dirname($product_file_dir), 'product-image.png');
?>

<style>
.btn-plus-minus {
    border: 1px solid #ddd;
    margin: 0 10px 0 10px;
}

#numberPlace {
    border: none !important;
    width: 23px;
    outline: none;
}

#product-images-slider {
    height: 600px;
    overflow-y: hidden;
}

.carousel-indicators button {
    width: 80px !important;
    height: 60px !important;
}

#lens {
    background-color: rgba(233, 233, 233, 0.4)
}

#lens,
#result {
    position: absolute;
    display: none;
    z-index: 1;
}

#lens,
.slideshow-items,
.slideshow-thumbnails,
#result {
    border: solid var(--light-grey-2) 1px;
}
</style>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <div class="box-shop">
        <div class="body-box">
            <nav aria-label="breadcrumb" class="fs-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="./?shop">สินค้า</a>
                    </li>
                    <?php if (!empty($product_type)) : ?>
                    <li class="breadcrumb-item">
                        <a
                            href="./?shop&cate=<?php echo $product_type['Type_id']; ?>"><?php echo $product_type['Type_name']; ?></a>
                    </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $product['product_name']; ?>
                    </li>
                </ol>
            </nav>
            <hr>
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3 text-center">
                    <div id="product-images-slider" class="carousel slide carousel-fade" data-bs-ride="false"
                        data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-inner">
                            <?php if (empty($files)) : ?>
                            <div class="carousel-item active">
                                <img src="<?php printf('%s', $product_image); ?>" class="d-block w-100 h-100 img-fluid"
                                    alt="Photo">
                            </div>
                            <?php else : ?>
                            <?php foreach ($files as $i => $file) : ?>
                            <div class="carousel-item <?php echo (0 == $i) ? 'active' : ''; ?>">
                                <img src="<?php printf('%s%s', $product_file_dir, $file['file_path']); ?>"
                                    class="d-block w-100 h-100 img-fluid" alt="<?php echo $file['file_name']; ?>">
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#product-images-slider"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">ก่อนหน้า</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#product-images-slider"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">ถัดไป</span>
                        </button>

                        <div class="carousel-indicators">
                            <?php if (empty($files)) : ?>
                            <button type="button" data-bs-target="#product-images-slider" data-bs-slide-to="0"
                                class="border border-4 active" aria-current="true" aria-label="Slide 1">
                                <img src="<?php printf('%s', $product_image); ?>" class="d-block w-100 h-100 img-fluid"
                                    alt="Photo">
                            </button>
                            <?php else : ?>
                            <?php foreach ($files as $i => $file) : ?>
                            <button type="button" data-bs-target="#product-images-slider"
                                data-bs-slide-to="<?php echo $i; ?>"
                                class="border border-4 <?php echo (0 == $i) ? 'active' : ''; ?>" aria-current="true"
                                aria-label="Slide 1">
                                <img src="<?php printf('%s%s', $product_file_dir, $file['file_path']); ?>"
                                    class="d-block w-100 h-100 img-fluid" alt="<?php echo $file['file_name']; ?>">
                            </button>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- eof .carousel -->

                    <div id="lens"></div>
                    <div id="result"></div>

                </div>
                <div class="col-md-6 col-sm-12 mb-3 mt-5">
                    <div class="product-name">
                        <h3 class="text-primary">
                            <?php echo $product['product_name'] ?>
                        </h3>
                    </div>
                    <div class="product-detail">
                        <p>
                            <?php echo $product['product_subdetail'] ?>
                        </p>
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
                            <?php echo $product['product_qty'] ?> ชิ้น
                        </span>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-12 mb-3">
                            <span class="ms-2">จำนวน</span>
                            <div id="mainDiv" class="mt-2">

                                <button class="btn btn-lg btn-plus-minus" id="minus">-</button>
                                <input type="text" id="numberPlace" value="1">
                                <button class="btn btn-lg btn-plus-minus" id="plus">+</button>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <?php if ($product['product_qty'] != 0) { ?>
                            <button class="btn btn-dark w-100 rounded-pill"
                                onclick="addcart('<?php echo $product['product_id'] ?>')">
                                <i class="far fa-cart-plus"></i>
                                หยิบใส่เข้าตะกร้า
                            </button>
                            <?php } else { ?>
                            <button class="btn btn-danger w-100 rounded-pill" disabled>
                                <i class="far fa-cart-plus"></i>
                                สินค้าหมด
                            </button>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <button class="btn btn-primary w-100 rounded-pill"
                                onclick="addItem(<?php echo $product['product_id']; ?>, <?php echo $product_type['Type_id']; ?>);">
                                <i class="fas fa-clone"></i>
                                เปรียบเทียบสินค้า
                            </button>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <button class="btn btn-primary w-100 rounded-pill">
                                <a class="nav-link active"
                                    href="https://www.messenger.com/t/113018983719873/?messaging_source=source%3Apages%3Amessage_shortlink&source_id=1441792&recurring_notification=0">ติดต่อสอบถาม</a>
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
                            <?php echo (!empty($detail)) ? $detail['product_detail'] : ''; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
<script>
function imageZoom(img, result, lens) {

    result.width(img.innerWidth() / 1.5);
    result.height(img.innerHeight() / 1.5);
    lens.width(img.innerWidth() / 4);
    lens.height(img.innerHeight() / 4);

    result.offset({
        top: img.offset().top,
        left: img.offset().left + img.outerWidth() + 10
    });

    var cx = img.innerWidth() / lens.innerWidth();
    var cy = img.innerHeight() / lens.innerHeight();

    result.css('backgroundImage', 'url(' + img.attr('src') + ')');
    result.css('backgroundSize', img.width() * cx + 'px ' + img.height() * cy + 'px');

    lens.mousemove(function(e) {
        moveLens(e);
    });

    img.mousemove(function(e) {
        moveLens(e);
    });

    lens.on('touchmove', function() {
        moveLens();
    })

    img.on('touchmove', function() {
        moveLens();
    })

    function moveLens(e) {
        var x = e.clientX - lens.outerWidth() / 2;
        var y = e.clientY - lens.outerHeight() / 2;
        if (x > img.outerWidth() + img.offset().left - lens.outerWidth()) {
            x = img.outerWidth() + img.offset().left - lens.outerWidth();
        }
        if (x < img.offset().left) {
            x = img.offset().left;
        }
        if (y > img.outerHeight() + img.offset().top - lens.outerHeight()) {
            y = img.outerHeight() + img.offset().top - lens.outerHeight();
        }
        if (y < img.offset().top) {
            y = img.offset().top;
        }
        lens.offset({
            top: y,
            left: x
        });
        result.css('backgroundPosition', '-' + (x - img.offset().left) * cx + 'px -' + (y - img.offset().top) * cy +
            'px');
    }
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
        success: function(response) {
            let data = JSON.parse(response)
            if (data.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: data.msg
                })
                setTimeout((e) => {
                    window.location = './?product_detail=<?php echo $_GET['product_detail'] ?>'
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: data.msg
                })
                setTimeout((e) => {
                    window.location = './?product_detail=<?php echo $_GET['product_detail'] ?>'
                }, 1500);
            }
        }
    })
}

function addItem(id, type_id) {
    $.ajax({
        type: "POST",
        url: 'Action/comparison.php',
        data: {
            action: 'addItem',
            id: id,
            type_id: type_id
        },
        success: function(response) {
            let data = JSON.parse(response)
            if (data.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: data.msg
                })
                setTimeout((e) => {
                    window.location.reload();
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: data.msg
                })
            }
        }
    })
}

$(document).ready(function() {
    var minusBtn = document.getElementById("minus"),
        plusBtn = document.getElementById("plus"),
        numberPlace = document.getElementById("numberPlace"),
        submitBtn = document.getElementById("submit"),
        number = 1,
        min = 1,
        max = <?php echo $product['product_qty'] ?>;

    minusBtn.onclick = function() {
        if (number > min) {
            number = number - 1;
            numberPlace.value = number;
        }
        if (number == min) {
            numberPlace.style.color = "red";
            setTimeout(function() {
                numberPlace.style.color = "black"
            }, 500)
        } else {
            numberPlace.style.color = "black";
        }
    }

    plusBtn.onclick = function() {
        if (number < max) {
            number = number + 1;
            numberPlace.value = number;
        }
        if (number == max) {
            numberPlace.style.color = "red";
            setTimeout(function() {
                numberPlace.style.color = "black"
            }, 500)
        } else {
            numberPlace.style.color = "black";
        }
    }

    $(document).mousemove(function(e) {
        var x = e.clientX;
        var y = e.clientY;

        var x = e.clientX;
        var y = e.clientY;
        var imgx1 = $(".carousel-item.active > img").offset().left;
        var imgx2 = $(".carousel-item.active > img").outerWidth() + imgx1;
        var imgy1 = $(".carousel-item.active > img").offset().top;
        var imgy2 = $(".carousel-item.active > img").outerHeight() + imgy1;

        if (x > imgx1 && x < imgx2 && y > imgy1 && y < imgy2) {
            $('#lens').show();
            $('#result').show();
            imageZoom($(".carousel-item.active img"), $('#result'), $('#lens'));
        } else {
            $('#lens').hide();
            $('#result').hide();
        }

    });
});
</script>