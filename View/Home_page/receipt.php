<br><br><br>

<style>
.body-payment {
    border: 5px solid #212529;
    border-radius: 10px;
    background-color: #fff;
    padding: 25px 40px;
    box-shadow: 5px 5px #cecccc;
}

.bank-payment {
    background-color: #ddd;
    padding: 5px 10px;
    text-align: center;
    border-radius: 15px;
}

.product-image {
    max-height: 120px;
    overflow: hidden;
}

.btn-browse img.alpha {
    opacity: 0.15;
}
</style>

<?php
$bill_no = (!empty($_GET['receipt'])) ? $_GET['receipt'] : '';

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
    WHERE `user_id` = '{$_SESSION['user_id']}' 
    AND bill_trx = '{$bill_no}';";

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

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <h3 class="text-center">บันทึกรับสินค้า</h3>

            <div class="body-payment">
                <form action="<?php echo site_url('Action/receipt.php'); ?>" id="add-receipt-form" enctype="multipart/form-data">
                    <?php if (empty($records)) : ?>
                    <div class="text-center text-danger">ไม่พบข้อมูลการสั่งซื้อ</div>
                    <?php else : ?>
                    <h4>ข้อมูลการสั่งซื้อ</h4>
                    <hr>
                    <div class="row my-2">
                        <div class="col-4 col-sm-3 col-lg-2">เลขที่ใบสั่งซื้อ </div>
                        <div class="col-8 col-sm-3 col-lg-2">: <?php echo $records[0]['bill_trx']; ?></div>
                        <div class="col-4 col-sm-3 col-lg-2">วันที่สั่งซื้อ </div>
                        <div class="col-8 col-sm-3 col-lg-2"> :
                            <?php echo ThaiDatetime::to_human_date($records[0]['created']); ?>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4 col-sm-3 col-lg-2">ผู้ขนส่ง </div>
                        <div class="col-8 col-sm-6 col-lg-3">: <?php echo $records[0]['record_address_post']; ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4 col-sm-3 col-lg-2">ที่อยู่จัดส่ง </div>
                        <div class="col-8 col-sm-9 col-lg-10"><?php echo nl2br($address); ?></div>
                    </div>
                    <h4 class="mt-4">รายการสินค้า</h4>
                    <hr>
                    <?php foreach ($records as $i => $rec) : ?>
                    <?php echo (0 < $i) ? '<hr>' : ''; ?>
                    <div class="row">
                        <div class="col-2">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <?php if (is_file(sprintf('%s/%s/%s', 'admin', PRODUCT_FILE_DIR, $products[$rec['product_id']]['product_picshow']))) : ?>
                                <img src="<?php printf('%s/%s/%s', 'admin', PRODUCT_FILE_DIR, $products[$rec['product_id']]['product_picshow']); ?>"
                                    alt="<?php echo $products[$rec['product_id']]['product_name']; ?>"
                                    class="h-100 w-100">
                                <?php else : ?>
                                <img src="<?php printf('%s/%s/%s', 'admin', dirname(PRODUCT_FILE_DIR), 'product-image.png'); ?>"
                                    alt="<?php echo $products[$rec['product_id']]['product_name']; ?>"
                                    class="h-100 w-100">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <label><?php echo $products[$rec['product_id']]['product_name']; ?></label> <br>
                            <small
                                class="text-warning"><?php printf('%s %s %s', 'ราคา', number_format($rec['price'], 2), 'บาท'); ?></small>
                        </div>
                        <div class="col-2 text-end"><?php printf('x %s %s', number_format($rec['counts']), 'ชิ้น'); ?>
                        </div>
                        <div class="col-2 text-end">
                            <?php printf('%s %s %s', '', number_format((float) $rec['counts'] * (float)$rec['price'], 2), 'บาท'); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <br>
                    <h4 class="mt-4">ผลการตรวจรับสินค้า</h4>
                    <hr>
                    <div class="row">
                        <div class="col-12 py-3 text-danger">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="acception" value="yes"
                                    id="acception" required>
                                <label class="form-check-label"
                                    for="acception">ข้าพเจ้าได้รับสินค้าตามรายการข้างต้นครบถ้วน สมบูรณ์ แล้ว</label>
                            </div>

                        </div>
                    </div>
                    <h4 class="mt-4">แนบรูปภาพ</h4>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6 col-lg-3 mt-4 image-wrapper">
                            <div class="d-flex flex-column border rounded p-2">
                                <a href="javascript:;" class="btn-browse d-flex justify-content-center"
                                    title="คลิกเพื่อเพิ่มรูปภาพ">
                                    <img src="<?php echo site_url('admin/assets/images/plus-icon.png'); ?>" class="w-100 alpha" alt="ไฟล์แนบ">
                                </a>
                                <div class="tools d-flex justify-content-end mt-1 d-none">
                                    <a href="javascript:;" class="text-danger btn-delete-file" data-id="0">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <input type="file" name="file[]" accept="image/*" class="d-none">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h4 class="mt-4">คะแนนความพึงพอใจ</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 my-2">
                            <div class="form-group row">
                                <label class="col-4 col-md-3 col-form-label text-end">คุณภาพสินค้า</label>
                                <div class="col-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;" class="score-vote text-muted"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>

                                    <input type="hidden" class="form-control" name="product_score" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 my-2">
                            <div class="form-group row">
                                <label class="col-4 col-md-3 col-form-label text-end">การบริการ</label>
                                <div class="col-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;" class="score-vote text-muted"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>
                                    <input type="hidden" class="form-control" name="service_score" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 my-2">
                            <div class="form-group row">
                                <label class="col-4 col-md-3 col-form-label text-end">การขนส่ง</label>
                                <div class="col-8 col-md-6 pt-2">
                                    <?php for ($score = 1; $score <= 5; $score++) : ?>
                                    <a href="javascript:;" class="score-vote text-muted"
                                        data-score="<?php echo $score; ?>"><i class="fa fa-star fa-lg"></i></a>
                                    <?php endfor; ?>
                                    <input type="hidden" class="form-control" name="shipping_score" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 my-2">
                            <div class="form-group row">
                                <label
                                    class="col-12 col-md-3 col-form-label text-start text-md-end">ความเห็นเพิ่มเติม</label>
                                <div class="col-12 col-md-6 pt-2">
                                    <textarea name="comment" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="btn-group">
                                <a href="./?history" class="btn btn-danger">
                                    <i class="fa fa-reply"></i>
                                    <span>ยกเลิก</span>
                                </a>
                                <button type="submit" class="btn btn-success" id="btn-submit">
                                    <i class="fa fa-save"></i>
                                    <span>บันทึก</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $records[0]['bill_trx']; ?>">
                    <input type="hidden" name="action" value="addnew">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(".score-vote").on('click', function() {
    const $self = $(this);
    $("input[type='hidden']", $self.parents(".form-group")).val($self.data('score'));

    $(".score-vote", $self.parents('.form-group')).each(function() {
        let $a = $(this);
        if ($a.data('score') <= $self.data('score')) {
            $a.removeClass('text-muted')
            $a.addClass('text-warning')
        } else {
            $a.removeClass('text-warning')
            $a.addClass('text-muted')
        }
    });
});

$("input[type='file']").on('change', function(evt) {
    if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
        alert('The File APIs are not fully supported in this browser.');
        return;
    }
    const $self = $(this);
    const $parent = $self.parents(".image-wrapper:first")
    const files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (let i = 0, f; f = files[i]; i++) {
        // Only process image files.
        if (!f.type.match('image.*')) {
            continue;
        }

        const reader = new FileReader();

        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                const $img = $("<img>");
                $img.attr("src", e.target.result);
                $img.addClass('w-100');

                const $new = $parent.clone(true);
                $("img:first", $new).replaceWith($img);
                $(".tools", $new).removeClass('d-none');
                $new.insertBefore($parent);

                $self.val('');
            };
        })(f);

        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
})

$(".btn-browse").on('click', function() {
    const $pane = $(this).parents(".image-wrapper:first")
    if (0 < $("input[type='file']", $pane).length) {
        $("input[type='file']", $pane).click();
    }
});

$(".btn-delete-file").on('click', function() {
    if (0 == $(this).data('id')) {
        $(this).parents(".image-wrapper:first").remove();
        return;
    }

    let $self = $(this);

    $.ajax({
        type: "POST",
        url: 'Action/addproduct.php',
        data: {
            action: "delfile",
            id: $self.data('id'),
        },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: res.msg
                });

                $self.parents(".image-wrapper:first").remove();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg
                })
            }
        }
    });
});

$("#add-receipt-form").on('submit', function(e) {
    e.preventDefault();

    var form = $(this)
    var formdata = new FormData(form[0])
    // var inputfile = $("input[type='file']").files
    // formdata.append('image', inputfile)

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: (e) => {},
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
                    title: res.msg,
                })
            }
        }
    });
});
</script>