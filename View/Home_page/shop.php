<?php
$categories = [];
$sql = "SELECT * FROM `tblproducttype` WHERE `Type_status` = '0' ORDER BY Type_name ASC;";
$rs = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $sql = "SELECT * FROM `tblproduct` WHERE `product_typeID` = '{$row['Type_id']}';";
    $row['products'] = mysqli_query($con, $sql)->num_rows;
    $categories[$row['Type_id']] = $row;
}

$category = (!empty($_GET['cate'])) ? (int) $_GET['cate'] : '';
$keyword = (!empty($_GET['keyword'])) ? $_GET['keyword'] : '';
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

$products = [];
$per_page_rows = 12;
$found_rows = 0;
$offset = 0;

if (!empty($page)) {
    $offset = (($page * $per_page_rows) - $per_page_rows);
}

$sql = " WHERE (`product_status` = '0')";
$qstring = './?shop';
if (!empty($category)) {
    $sql .= (!empty($sql)) ? ' AND ' : '';
    $sql .= "(product_typeID = '{$category}')";
    $qstring .= "&cate={$category}";
}

if (!empty($keyword)) {
    $sql .= (!empty($sql)) ? ' AND ' : '';
    $sql .= " (CONCAT_WS('', `product_name`,`product_subdetail`) LIKE '%{$keyword}%')";
    $qstring .= "&keyword={$keyword}";
}


$found_rows = mysqli_query($con, "SELECT * FROM `tblproduct` {$sql}")->num_rows;

$sql = "SELECT * FROM `tblproduct` {$sql} ORDER BY product_name ASC LIMIT {$offset},{$per_page_rows}";
$rs = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
    $products[] = $row;
}

//pagination create
$show_page = 5;
echo 'max => ' .
$page_max = (0 < $found_rows % $per_page_rows) ? 1 + floor($found_rows / $per_page_rows) : $found_rows / $per_page_rows;
$pages = [];


if ($page_max > 1) {
    $start = $page - 2;
    if ($start < 1) {
        $start = 1;
    }


    while (sizeof($pages) < $show_page) {
        $pages[] = [
            'uri' => site_url($qstring . '&page=' . $start),
            'no' => $start++,
        ];

        if ($page_max < $start) {
            break;
        }
    }
}

print_r($pages);
?>

<style>
    .card {
        height: 50vh;
    }

    .card-img-top {
        max-height: 200px;
    }

    .card-title {
        height: 72px;
    }

    .card {
        position: relative;
    }

    .card .btn-add-to-cart {
        position: absolute;
        top: 0;
        right: 0;
        background-color: rgba(211, 211, 211, 0.5);
        /* Change the background color to a transparent light gray */
        color: #3a32d1;
        /* Change the text color to match your website */
        border: none;
        padding: 5px;
        font-size: 20px;
        cursor: pointer;
    }

    .card .btn-add-to-cart:hover {
        background-color: #c2c1d9;
        /* Change the hover background color to match your website */
    }

    .card .btn-add-to-cart i {
        margin-right: 5px;
    }

    .card .btn-add-to-cart i.fa-shopping-basket {
        color: #ffffff;
        /* Change the basket icon color to red */
    }

    .out-of-stock {
        color: #dc3545;
        cursor: not-allowed;
    }
</style>
<br><br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h5>ค้นหาสินค้า</h5>
            <hr>
            <form method="get" id="search-form">
                <div class="mb-3">
                    <label class="form-label">คำค้น</label>
                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" autocomplete="off" placeholder="ป้อนคำเพื่อค้นหา...">
                </div>

                <input type="hidden" name="shop" value="1">
                <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                <br>
                <div class="mb-3">
                    <label class="form-label">หมวดหมู่สินค้า</label>
                    <select name="cate" class="form-select">
                        <option value="" selected>ทั้งหมด</option>
                        <?php foreach ($categories as $cate) : ?>
                            <option value="<?php echo $cate['Type_id']; ?>" <?php echo ($category == $cate['Type_id']) ? 'selected' : ''; ?>>
                                <?php echo $cate['Type_name']; ?>
                                (<?php printf('%s %s', $cate['products'], 'รายการ') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>


            </form>

        </div>
        <div class="col-md-9">
            <h5>
                <span>หมวดหมู่สินค้า</span>
                <span>
                    <i class="fa fa-angle-right"></i>
                </span>
                <span>
                    <?php echo (isset($categories[$category])) ? $categories[$category]['Type_name'] : 'ทั้งหมด'; ?>
                </span>
            </h5>
            <hr>
            <?php if (empty($products)) : ?>
                <div class="text-center text-danger">ไม่พบรายการสินค้า</div>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($products as $pd) : ?>
                        <div class="col-md-3 col-sm-6 pb-3">
                            <div class="card">
                                <img src="admin/assets/images/product/<?php echo $pd['product_picshow'] ?>" class="w-100 h-100 card-img-top img-fluid" alt="...">
                                <div class="card-body pb-0">
                                    <h6 class="card-title text-primary">
                                        <?php echo $pd['product_name'] ?>
                                    </h6>
                                    <div class="card-text mb-2">
                                        <div class="text-center">
                                            <span>ราคา</span>
                                            <span>
                                                <?php printf('%s %s', number_format($pd['product_price']), 'บาท'); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-outline-primary" onclick="window.location = './?product_detail=<?= $pd['product_id'] ?>'">
                                            <i class="far fa-chevron-circle-right"></i>
                                            ดูรายละเอียดสินค้า
                                        </button>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-outline-warning" onclick="addItem(<?php echo $pd['product_id']; ?>, <?php echo $pd['Type_id']; ?>);">
                                            <i class="far fa-clone"></i>
                                            เปรียบเทียบสินค้า
                                        </button>
                                        <div class="text-right">
                                            <a class="btn-add-to-cart <?php echo ($pd['product_qty'] == 0) ? 'out-of-stock' : '' ?>" data-product-id="<?php echo $pd['product_id'] ?>" onclick="<?php echo ($pd['product_qty'] == 0) ? 'javascript:void(0)' : 'addcart(' . $pd['product_id'] . ')' ?>" <?php echo ($pd['product_qty'] == 0) ? 'disabled' : '' ?>>
                                                <?php if ($pd['product_qty'] == 0) { ?>
                                                    <i class="fas fa-ban text-danger"></i> <!-- replace with your disabled icon -->
                                                <?php } else { ?>
                                                    <i class="fas fa-cart-plus"></i>
                                                <?php } ?>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row mt-4">
                    <div class="col pt-2">
                        <?php printf('รายการ %s - %s จากทั้งหมด %s รายการ', ($offset + 1), $offset + sizeof($products), $found_rows); ?>
                    </div>
                    <?php if (!empty($pages)) : ?>
                        <div class="col">
                            <nav class="float-end">
                                <ul class="pagination">
                                    <?php if (1 == $page) : ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="ก่อนหน้า">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php else : ?>

                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo site_url($qstring . '&page=' . ($page - 1)); ?>" aria-label="ก่อนหน้า">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php foreach ($pages as $i => $p) : ?>
                                        <li class="page-item <?php echo ($page == $p['no']) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo $p['uri']; ?>">
                                                <?php echo $p['no']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>

                                    <?php if ($p['no'] == $page_max) : ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="ถัดไป">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo site_url($qstring . '&page=' . ($page + 1)); ?>" aria-label="ถัดไป">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
<br>
<br>
<br>
<script>
    const $form = $("#search-form");
    $("select", $form).on('change', function() {
        $form.submit();
    })

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

    function addcart(product_id) {
        // var countitem = $('#numberPlace').val(); // ตรงนี้ด้วย 3 จุด
        var countitem = 1;
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?addcart', // ลืมใส่ ?addcart และ ตัวแปรผิด
            data: {
                countitem: countitem,
                id: product_id,
                addcart: 1
            },
            success: function(response) {
                var data = JSON.parse(response);
                var message = data.status === "success" ? "เพิ่มสินค้าสำเร็จ" : "เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง";
                var icon = data.status === "success" ? "success" : "error";
                Swal.fire({
                    icon: icon,
                    title: message
                }).then(() => {
                    window.location = './?home=<?php echo $_GET['product_detail'] ?>';
                });
            }
        });
    }
</script>