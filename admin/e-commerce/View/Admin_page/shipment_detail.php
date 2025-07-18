<style>
.product-image {
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-wrapper {
    margin-top: 24px;
}

.image-wrapper img,
.product-image img {
    width: 100%;
}
</style>

<?php
$bill_no = (!empty($_GET['shipmentdetail'])) ? $_GET['shipmentdetail'] : '';

$receipt = $con->query("SELECT * FROM `tblreceipts` WHERE bill_trx = '{$bill_no}' ORDER BY created DESC  LIMIT 1")->fetch_assoc();

$files = [];
if (!empty($receipt)) {
    $rs = $con->query("SELECT * FROM `tblreceipt_files` WHERE receipt_id = '{$receipt['receipt_id']}'");
    while ($row = $rs->fetch_assoc()) {
        $files[] = $row;
    }
}

$address = '';
$row = $con->query("SELECT * FROM `tblrecord` WHERE bill_trx = '{$bill_no}'")->fetch_assoc();
if (!empty($row)) {
    $address .= sprintf('คุณ%s %s', $row['fname'], $row['lname']);

    if (!empty($row['userAddress_number'])) {
        $address .= "\n" . sprintf('%s %s', 'บ้านเลขที่', $row['userAddress_number']);
    }

    if (!empty($row['userAddress_group'])) {
        $address .= sprintf(' %s %s', 'หมู่ที่', $row['userAddress_group']);
    }

    if (!empty($row['userAddress_alley'])) {
        $address .= sprintf(' %s %s', 'ซอย', $row['userAddress_alley']);
    }

    if (!empty($row['userAddress_separate'])) {
        $address .= sprintf(' %s %s', 'แยก', $row['userAddress_separate']);
    }

    if (!empty($row['userAddress_district'])) {
        $address .= sprintf(' %s %s', 'ตำบล/แขวง', $row['userAddress_district']);
    }

    if (!empty($row['userAddress_canton'])) {
        $address .= sprintf(' %s %s', 'อำเภอ/เขต', $row['userAddress_canton']);
    }

    if (!empty($row['userAddress_province'])) {
        $address .= "\n" . sprintf(' %s %s', 'จังหวัด', $row['userAddress_province']);
    }

    if (!empty($row['userAddress_num_post'])) {
        $address .= sprintf(' %s %s', 'รหัสไปรษณีย์', $row['userAddress_num_post']);
    }

    if (!empty($row['phone'])) {
        $address .= "\n" . sprintf(' %s %s', 'หมายเลขโทรศัพท์', $row['phone']);
    }
}

$sql = "SELECT *
    FROM `tblrecord` 
    WHERE bill_trx = '{$bill_no}';";

$product_ids = [];
$records = [];
$rs = $con->query($sql);
while ($row = $rs->fetch_assoc()) {
    $product_ids[] = $row['product_id'];
    $records[] = $row;
}

$sql = "SELECT * FROM `tblproduct` WHERE product_id IN ('" . implode("','", $product_ids) . "');";
$products = [];
$rs = $con->query($sql);
while ($row = $rs->fetch_assoc()) {
    $products[$row['product_id']] = $row;
}

?>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">รายละเอียดการรับสินค้า </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (empty($receipt) || empty($records)) : ?>
                    <div class="text-center text-danger">ไม่พบข้อมูลการสั่งซื้อ</div>
                    <?php else : ?>
                    <h4>ข้อมูลการสั่งซื้อ</h4>
                    <hr>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-lg-2">เลขที่ใบสั่งซื้อ </div>
                        <div class="col-xs-8 col-sm-3 col-lg-2">: <?php echo $records[0]['bill_trx']; ?></div>
                        <div class="col-xs-4 col-sm-3 col-lg-2">วันที่สั่งซื้อ </div>
                        <div class="col-xs-8 col-sm-3 col-lg-2"> :
                            <?php echo ThaiDatetime::to_human_date($records[0]['created']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-lg-2">ผู้ขนส่ง </div>
                        <div class="col-xs-8 col-sm-6 col-lg-3">: <?php echo $records[0]['record_address_post']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-lg-2">ที่อยู่จัดส่ง </div>
                        <div class="col-xs-8 col-sm-9 col-lg-10"><?php echo nl2br($address); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-lg-2">วันที่บันทึกตรวจรับ </div>
                        <div class="col-xs-8 col-sm-6 col-lg-3">:
                            <?php echo ThaiDatetime::to_human_date($receipt['created']); ?></div>
                    </div>
                    <br><br> <br>
                    <h3 class="page-title">รายการสินค้า</h3>
                    <hr>
                    <?php foreach ($records as $i => $rec) : ?>
                    <?php echo (0 < $i) ? '<hr>' : ''; ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2">
                            <div class="product-image">
                                <?php if (is_file(sprintf('%s/%s/%s', '..', PRODUCT_FILE_DIR, $products[$rec['product_id']]['product_picshow']))) : ?>
                                <img src="<?php printf('%s/%s/%s', '..', PRODUCT_FILE_DIR, $products[$rec['product_id']]['product_picshow']); ?>"
                                    alt="<?php echo $products[$rec['product_id']]['product_name']; ?>">
                                <?php else : ?>
                                <img src="<?php printf('%s/%s/%s', '..', dirname(PRODUCT_FILE_DIR), 'product-image.png'); ?>"
                                    alt="<?php echo $products[$rec['product_id']]['product_name']; ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label><?php echo $products[$rec['product_id']]['product_name']; ?></label> <br>
                            <small
                                class="text-warning"><?php printf('%s %s %s', 'ราคา', number_format($rec['price'], 2), 'บาท'); ?></small>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <?php printf('x %s %s', number_format($rec['counts']), 'ชิ้น'); ?>
                        </div>
                        <div class="col-xs-6 col-sm-2 text-right">
                            <?php printf('%s %s %s', '', number_format((float) $rec['counts'] * (float)$rec['price'], 2), 'บาท'); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <br>
                    <br> <br> <br>
                    <h3 class="page-title">แนบรูปภาพ</h3>
                    <hr>
                    <?php if (empty($files)) : ?>
                    <div class="row">
                        <div class="col-12 text-center">(ไม่มีไฟล์แนบ)</div>
                    </div>
                    <?php else : ?>
                    <div class="row mt-3">
                        <?php foreach ($files as $file) : ?>
                        <div class="col-sm-12 col-md-6 col-lg-4 mt-4">
                            <div class="image-wrapper">
                                <img src="<?php echo implode('/', ['..', dirname(PRODUCT_FILE_DIR), 'receipts', $file['file_path']]) ?>"
                                    alt="<?php echo $file['file_name']; ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <br> <br> <br>
                    <h3 class="page-title">คะแนนความพึงพอใจ</h3>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-xs-4 col-md-3">คุณภาพสินค้า</label>
                                <div class="col-xs-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;"
                                        class="score-vote <?php echo ($score <= (int)$receipt['product_score']) ? 'text-warning' : 'text-muted'; ?>"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-xs-4 col-md-3">การบริการ</label>
                                <div class="col-xs-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;"
                                        class="score-vote <?php echo ($score <= (int)$receipt['service_score']) ? 'text-warning' : 'text-muted'; ?>"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-xs-4 col-md-3">การขนส่ง</label>
                                <div class="col-xs-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;"
                                        class="score-vote <?php echo ($score <= (int)$receipt['shipping_score']) ? 'text-warning' : 'text-muted'; ?>"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3 text-start text-md-end">ความเห็นเพิ่มเติม</label>
                                <div class="col-xs-12 col-md-6 pt-2">
                                    <?php echo (!empty($receipt['commont'])) ? $receipt['commont'] : sprintf('(%s)', 'ไม่มี'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>