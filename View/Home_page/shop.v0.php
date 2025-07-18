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

    <?php
    $get_productType = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_status` = 0");
    while ($rows_productType = $get_productType->fetch_assoc()) { ?>
        <div class="box-shop">
            <br>
            <div class="head-box">
                <h3 class="text-center">สินค้า
                    <?= $rows_productType['Type_name'] ?>
                </h3>
            </div>
            <hr>
            <div class="body-box">
                <div class="row">
                    <?php
                    $get_product = $con->query("SELECT * FROM `tblproduct` WHERE product_typeID = '" . $rows_productType['Type_id'] . "' AND product_status = '0'");
                    while ($rows_product = $get_product->fetch_assoc()) {
                        ?>
                        <div class=" col-lg-3 col-md-12 col-sm-12 mb-3 box-product">
                            <div class="card " style="width: 18rem;">
                                <img src="./admin/assets/images/product/<?= $rows_product['product_picshow'] ?>" width="150px"
                                    height="300px" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $rows_product['product_name'] ?> 
                                    </h5>
                                    <p class="card-text">
                                        <?= $rows_product['product_subdetail'] ?>
                                    </p>
                                    <div class="float-right">ราคา
                                        <?php if ($rows_product['product_price']) {
                                            echo number_format($rows_product['product_price']);
                                        } ?> บาท
                                    </div><br>





                                    <button class="btn btn-dark btn-sm rounded w-100"
                                        onclick="window.location = './?product_detail=<?= $rows_product['product_id'] ?>'">
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
    <?php } ?>
</div>


<br>
<br>