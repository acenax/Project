<?php
if ($_GET['DetailProduct'] == '' || $_GET['DetailProduct'] == null) {
    echo "<script>window.location = './?Product' </script>";
} else {
    $chk_product = $con->query("SELECT * FROM `tblproduct` WHERE product_id = '" . $_GET['DetailProduct'] . "'");
    if ($chk_product->num_rows == 0) {
        echo "<script>window.location = './?Product' </script>";
    } else {
        $rows_product = $chk_product->fetch_assoc();
        $get_detail = $con->query("SELECT * FROM `tblproduct_detail` WHERE product_id = '" . $_GET['DetailProduct'] . "'")->fetch_assoc();
    }
}
?>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข รายละเอียดสินค้า : <?= $rows_product['product_name'] ?> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button">ดูหน้าสินค้า</button>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="p-6">
                        <form id="addDetailProduct" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="addDetailProduct">
                            <input type="hidden" name="id" value="<?= $_GET['DetailProduct'] ?>">
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 15px;">
                                    <label for="">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" disabled value="<?= $rows_product['product_name'] ?>">
                                </div>
                                <div class="col-12" style="margin-bottom: 15px;">
                                    <label for="">รายละเอียดสินค้า</label>
                                    
                                    <textarea class="form-control" name="product_detail" id="editor1" required>
                                        <?= $get_detail['product_detail'] ?>
                                    </textarea>
                                </div><br>
                                <div class="col-12 text-center">
                                    <button class="btn btn-success btn-lg">บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>

<script>
    $(function() {
        $(".modal").removeAttr("tabindex");
    });
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

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return JSON.stringify(indexed_array);
    }

    function wait() {
        swal.fire({
            html: '<h5>กรุณารอซักครู่...</h5>',
            showConfirmButton: false,
        });
    }
</script>

<script>
    $("#addDetailProduct").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var product_detail = CKEDITOR.instances.editor1.getData();
        data = data + "&product_detail=" + product_detail
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
            data: data,
            beforeSend: (e) => {
                wait();
            },
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!'
                    })
                    setTimeout((e) => {
                        window.location = './?DetailProduct=<?= $_GET['DetailProduct'] ?>'
                    }, 1500);
                } else {
                    if (res.msg == "wrong") {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!'
                        })
                    } else if (res.msg == "nopermission") {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่ได้รับอนุญาต!',
                        })
                    } else if (res.msg == "notnum") {
                        Swal.fire({
                            icon: 'error',
                            title: 'ข้อมูลไม่ถูกต้อง!',
                        })
                    } else if (res.msg == "empty") {
                        Swal.fire({
                            icon: 'error',
                            title: 'ห้ามปล่อยว่าง!',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?DetailProduct=<?= $_GET['DetailProduct'] ?>'
                    }, 1500);
                }
            },
        });
    });
</script>

