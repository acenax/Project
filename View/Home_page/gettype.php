<?php
if ($_GET['gettype'] == '' || $_GET['gettype'] == null) {
    echo "<script>window.location = './?shop'</script>";
} else {
    $chk_type = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '" . $_GET['gettype'] . "' ");
    if ($chk_type->num_rows == 0) {
        echo "<script>window.location = './?shop'</script>";
    } else {
        $rows_type = $chk_type->fetch_assoc();
    }
}
?>

<br>
<div class="container">
    <style>
        @media screen and (max-width: 400px) {
            .box-product {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>

    <div class="box-shop">
        <br>
        <div class="head-box">
            <h3 class="text-center">สินค้า <?= $rows_type['Type_name'] ?> </h3>
        </div>
        <hr>
        <div class="body-box">
            <div class="row">
                <?php
                $chk_product = $con->query("SELECT * FROM `tblproduct` WHERE product_typeID = '" . $rows_type['Type_id'] . "'");
                while ($rows_product = $chk_product->fetch_assoc()) {
                ?>
                    <div class="col-lg-3 col-sm-12 mb-3 box-product" >
                        <div class="card" style="width: 18rem;">
                            <img src="admin/assets/images/product/<?= $rows_product['product_picshow'] ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?= $rows_product['product_name'] ?></h5>
                                <p class="card-text"><?= $rows_product['product_subdetail'] ?></p>
                                <button class="btn btn-dark btn-sm rounded w-100" onclick="window.location = './?product_detail=<?= $rows_product['product_id'] ?>'">
                                    <i class="far fa-shopping-cart"></i>
                                    ดูรายละเอียดสินค้า
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>



<br>
<br>