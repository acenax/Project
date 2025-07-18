<?php
$product_types = [];
$sql = "SELECT * FROM `tblproducttype` WHERE (`Type_status` = '0');";
$rs = $con->query($sql);
while ($row = $rs->fetch_assoc()) {
    $product_types[] = $row;
}

?>

<style>
    .btn-browse img.alpha {
        opacity: 0.15;
    }

    .image-wrapper {
        max-height: 200px;
        overflow-y: auto;
    }
</style>
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="addnew-form" class="form-horizontal" enctype="multipart/form-data">
                        <br>
                        <h5 class="page-title">เพิ่มข้อมูลสินค้า</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-7">

                                <h5 class="page-title">ข้อมูลสินค้า</h5>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">ชื่อสินค้า</label>
                                            <div class="col-md-12">
                                                <input type="text" autocomplete="off" class="form-control" name="product_name" value="" id="editproduct_name" required>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">ชนิดสินค้า</label>
                                            <div class="col-md-12">
                                                <select class="form-control" name="product_typeID" id="editproduct_typeID" required>
                                                    <?php foreach ($product_types as $tpe) : ?>
                                                        <option value="<?php echo $tpe['Type_id'] ?>">
                                                            <?php echo $tpe['Type_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">รายละเอียดย่อย</label>
                                            <div class="col-md-12">

                                                <textarea autocomplete="off" class="form-control summernote" name="product_subdetail" id="editproduct_subdetail" required></textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="page-title">รูปภาพประกอบ</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-danger">* รองรับเฉพาะไฟล์รูปภาพเท่านั้น</sp>
                                    </div>
                                </div>
                                <br>
                                <div class="row" id="product-images">
                                    <div class=" col-md-4 image-wrapper">
                                        <div class="thumbnail">
                                            <a href="javascript:;" class="btn-browse" title="คลิกเพื่อเพิ่มรูปภาพ">
                                                <img src="Assets/images/plus-icon.png" class="alpha" alt="รูปสินค้า">
                                            </a>
                                            <div class="caption hide">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="javascript:;" class="btn-profile-toggle text-muted" title="ตั้งเป็นรูปโปรไฟล์ของสินค้า" data-id="0">
                                                            <i class="fa fa-lg fa-toggle-off"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <a href="javascript:;" class="text-danger btn-delete-file" data-id="0">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="profile[]" value="0">
                                                <input type="file" name="file[]" accept="image/*" class="hide">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- eof .row -->
                            </div>
                        </div>
                        <!-- eof .row -->
                        <br>
                        <br>
                        <h5 class="page-title">รายละเอียดของสินค้า</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control summernote" name="product_detail" id="editproduct_detail" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-md-12">ราคาต่อชิ้น</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" autocomplete="off" class="form-control text-center" placeholder="0.00" min="0" step="0.01" name="product_price" value="" id="editproduct_price" required>
                                            <span class="input-group-addon">บาท</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-md-12">จำนวนจัดเก็บขั้นต่ำ</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="number" autocomplete="off" class="form-control text-center" placeholder="0" name="product_min" value="" id="editproduct_min" required min="0">
                                            <span class="input-group-addon">ชิ้น</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-md-12">จำนวนคงเหลือ</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="number" autocomplete="off" class="form-control text-center" placeholder="0" name="product_qty" value="" id="editproduct_qty" required min="0">
                                            <span class="input-group-addon">ชิ้น</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-md-12">สถานะการใช้งาน</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="product_status" id="editproduct_status" required>
                                            <option value="0">เปิดใช้งาน</option>
                                            <option value="1">ปิดใช้งาน</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="btn-group">
                                    <a href="./?Product" class="btn btn-danger">
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

                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="action" value="addnew">
                    </form>
                </div>
                <!-- eof .row -->
            </div>
        </div>
    </div>
</div>

<script>
    const $images_area = $("#product-images");

    $(".btn-browse", $images_area).on('click', function() {
        const $pane = $(this).parents(".thumbnail:first")
        if (0 < $("input[type='file']", $pane).length) {
            $("input[type='file']", $pane).click();
        }
    });

    $(".btn-delete-file", $images_area).on('click', function() {
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
    })

    $(".btn-profile-toggle", $images_area).on('click', function() {
        let $self = $(this);
        let $val = $("input[name^='profile']", $self.parents('.caption:first')).val();
        // reset all to disabled
        $("input[name^='profile']", $images_area).val(0);

        $(".fa-toggle-on", $images_area).each(function() {
            $(this).removeClass('fa-toggle-on');
            $(this).addClass('fa-toggle-off');

            $(this).parent().removeClass('text-success');
            $(this).parent().addClass('text-muted');
        });

        // set myselft
        if (0 == $val) {
            $("input[name^='profile']", $self.parents('.caption:first')).val(1);
            $("i", $self).removeClass('fa-toggle-off')
            $("i", $self).addClass('fa-toggle-on')
            $self.removeClass('text-muted');
            $self.addClass('text-success');
        }

        if (0 == $self.data('id')) {
            return;
        }

        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
            data: {
                action: "setdefault",
                id: $self.data('id'),
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == "success") {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: res.msg
                    // });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            }
        });
    })

    $("input[type='file']", $images_area).on('change', function(evt) {
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

                    const $new = $parent.clone(true);
                    $("img:first", $new).replaceWith($img);
                    // $("img:first", $new).removeClass('alpha')
                    $(".caption", $new).removeClass('hide');
                    $new.insertBefore($parent);

                    $self.val('');
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    })

    $("#addnew-form").on('submit', function(e) {
        e.preventDefault();

        var form = $(this)
        var formdata = new FormData(form[0])
        // var inputfile = $("input[type='file']").files
        // formdata.append('image', inputfile)

        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
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
                        window.location = './?Product'
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