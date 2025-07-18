<?php
$comparison_products = [];
$product_types = [];

// get current comparision product type 
$cur_tpe_id = (empty($_GET['tpe'])) ? 0 : (int) $_GET['tpe'];

if (!empty($_SESSION['comparison'])) {
    // get product type id
    $sql = "SELECT `product_typeID` 
FROM `tblproduct` 
WHERE (`product_id` IN ('" . implode("','", $_SESSION['comparison']) . "')) 
    AND (`product_typeID` IS NOT NULL) 
    AND (`product_typeID` <> '') 
    AND (`product_typeID` <> 0) 
    ;";

    $tpeids = [0];

    $rs = $con->query($sql);
    while ($row = $rs->fetch_assoc()) {
        if (empty($cur_tpe_id)) {
            $cur_tpe_id = $row['product_typeID'];
        }

        $tpeids[] = $row['product_typeID'];
    }

    // get product types
    $rs = $con->query("SELECT `Type_id`, `Type_name` FROM `tblproducttype` WHERE `Type_id` IN ('" . implode("','", $tpeids) . "')");
    while ($row = $rs->fetch_assoc()) {
        if (!isset($product_types[$row['Type_id']])) {
            $product_types[$row['Type_id']] = [
                'label' => $row['Type_name'],
                'qty' => 1,
            ];
        } else {
            $product_types[$row['Type_id']]['qty']++;
        }
    }


    // get current type's products
    $sql = "SELECT `pd`.`product_id`, 
        `pd`.`product_name`, 
        `pd`.`product_qty`, 
        `pd`.`product_price`, 
        `pd`.`product_picshow`, 
        `pd`.`product_subdetail`,
        `pd`.`product_typeID`
    FROM `tblproduct` AS pd 
    WHERE `pd`.`product_id` IN ('" . implode("','", $_SESSION['comparison']) . "') 
        AND (`product_typeID` = '{$cur_tpe_id}')
    ORDER BY `pd`.product_price ASC, `pd`.`product_name` ASC
    ;";

    $rs = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($rs)) {
        $comparison_products[] = $row;
    }
}
?>

<style>
    .body-comparison {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 60px 40px;
        box-shadow: 5px 5px #cecccc;
    }

    .bank-comparison {
        background-color: #ddd;
        padding: 5px 10px;
        text-align: center;
        border-radius: 15px;
    }
</style>
<!-- เริ่ม -->
<br><br><br>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-comparison">
                <h3 class="text-center">เปรียบเทียบสินค้า</h3>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-comparison">
                <div class="row">
                    <div class="col-6">
                        <form action="./?comparison" method="get">
                            <div class="form-group row">
                                <label for="" class="col-3 text-end pt-2 text-primary">ประเภทสินค้า</label>
                                <div class="col-9">
                                    <select name="tpe" class="form-control" id="product-type-selection">
                                        <?php foreach ($product_types as $id => $tpe) : ?>
                                            <option value="<?php echo $id; ?>" <?php echo ($id == $cur_tpe_id) ? 'selected' : ''; ?>>
                                                <?php printf('%s  ', $tpe['label'], $tpe['qty']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="comparison" value="1">
                        </form>
                    </div>
                    <div class="col-6">
                        <a href="./?shop" class="btn btn-primary float-end">
                            <i class="fa fa-plus-circle"></i>
                            <span>เพิ่มรายการสินค้า</span>
                        </a>
                    </div>
                </div>
                <hr>
                <?php if (empty($comparison_products)) : ?>
                    <div class="text-center text-danger">ไม่พบรายการสินค้า</div>
                <?php else : ?>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="10%"></td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="border-start border-top border-end">
                                        <img src="admin/assets/images/product/<?php echo $product['product_picshow'] ?>" class="w-100" alt="<?php echo $product['product_name']; ?>">

                                    </td>
                                <?php endforeach; ?>
                            </tr>

                            <tr>
                                <td class="text-primary">ชื่อสินค้า</td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="border-start border-end">
                                        <div class="fs-6">
                                            <?php echo $product['product_name']; ?>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="text-primary">ราคา</td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="text-center border-start border-end">
                                        <?php printf('%s %s', number_format($product['product_price']), 'บาท'); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>

                            <tr>
                                <td class="text-primary">จำนวน</td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="text-center border-start border-end">
                                        <?php printf('%s %s', number_format($product['product_qty']), 'ชิ้น'); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>

                            <tr>
                                <td class="text-primary">รายละเอียด</td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="border-start border-end">
                                        <?php if (empty($product['product_subdetail'])) : ?>
                                            <div class="text-center">
                                                (ไม่ระบุ)
                                            </div>
                                        <?php else : ?>
                                            <p class="card-text item-description">
                                                <?php echo $product['product_subdetail']; ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>

                            <tr>
                                <td class="border-bottom-0">&nbsp;</td>
                                <?php foreach ($comparison_products as $idx => $product) : ?>
                                    <td class="border-bottom py-4 border-start border-top border-end">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <button class="btn btn-danger" onclick="delItem(<?php echo $product['product_id']; ?>);">
                                                    <i class="far fa-trash"></i>
                                                    <span>ลบออก</span>
                                                </button>
                                                <button class="btn btn-primary" onclick="addcart(<?php echo $product['product_id']; ?>);">
                                                    <i class="far fa-cart-plus"></i>
                                                    <span>หยิบใส่ตะกร้า</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- eof .row -->
</div>
<!-- eof .container -->
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
<br>
<br>
<br>
<br>
<script>
    function delItem(id) {
        $.ajax({
            type: "POST",
            url: 'Action/comparison.php',
            data: {
                action: 'delItem',
                id: id
            },
            success: function(response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบรายการเรียบร้อยแล้ว !'
                    })
                    setTimeout((e) => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })

                }
            }
        })
    }

    function addcart(id) {
        $.ajax({
            type: "POST",
            url: 'Action/cart.php?addcart',
            data: {
                countitem: 1,
                id: id
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

    $(function() {
        $("#product-type-selection").on('change', function() {
            $(this).parents('form:first').submit();
        })
    })
</script>