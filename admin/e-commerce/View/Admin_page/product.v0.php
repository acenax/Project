<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข สินค้า </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">เพิ่มสินค้า</button>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="">
                <table class="table" id="dataal">
                    <thead>
                        <tr>
                            <th>รูป</th>
                            <!-- <th>รหัสสินค้า</th> -->
                            <th>ชื่อสินค้า</th>
                            <th>ชื่อชนิดสินค้า</th>
                            <th>รายละเอียดย่อย</th>
                            <th>จำนวน</th>
                            <th>ราคาต่อชิ้น</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $get_product = $con->query("SELECT * FROM `tblproduct`");
                        while ($rows_product = $get_product->fetch_assoc()) {
                        ?>
                            <tr>
                                <td>
                                    <img src="../assets/images/product/<?= $rows_product['product_picshow'] ?>" width="60px" alt="">
                                </td>
                                <!-- <td><?= $rows_product['product_code'] ?></td> -->
                                <td><?= $rows_product['product_name'] ?></td>
                                <td>
                                    <?php
                                    $get_typeShow = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '" . $rows_product['product_typeID'] . "'")->fetch_assoc();
                                    echo $get_typeShow['Type_name'];
                                    ?>
                                </td>
                                <td><?= $rows_product['product_subdetail'] ?></td>
                                <td><?= $rows_product['product_qty'] ?></td>
                                <td><?= $rows_product['product_price'] ?></td>
                                <td>
                                    <?php
                                    if ($rows_product['product_status'] == 0) {
                                        echo '<span class="text-success">เปิดใช้งาน</span>';
                                    } else {
                                        echo '<span class="text-danger">ปิดใช้งาน</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning rounded" onclick="getProduct('<?= $rows_product['product_id'] ?>')">
                                        <i class="far fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger rounded del_product" data-id="<?= $rows_product['product_id'] ?>">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-info rounded" title="เพิ่มรายละเอียดสินค้า" onclick="window.location='./?DetailProduct=<?= $rows_product['product_id'] ?>'">
                                        <i class="far fa-plus-square"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มชนิดสินค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="Add_product" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="Add_product">
                    <div class="row">
                        <div class="col-12">
                            <!-- <div class="mb-3">
                                <label for="">รหัสสินค้า</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_code" required>
                            </div> -->
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อสินค้า</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_name" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชนิดสินค้า</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="product_typeID" required>
                                    <?php
                                    $get_type = $con->query("SELECT * FROM `tblproducttype`");
                                    while ($rows_type = $get_type->fetch_assoc()) { ?>
                                        <option value="<?= $rows_type['Type_id'] ?>"><?= $rows_type['Type_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รายละเอียดย่อย</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_subdetail" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">จำนวน</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_qty" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ราคาต่อชิ้น</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_price" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รูปสินค้า</label>
                                <div class="container text-center mb-1">
                                    <img id="showpic" src="https://media.discordapp.net/attachments/701876169334587443/821515777324744754/1024px-No_image_available.png" class="rounded" onclick="document.getElementById('preimg').click();" width="50%" style="cursor: pointer;">
                                </div>
                                <div class="text-center">
                                    <input type="file" class="sr-only" id="preimg" name="preimg" required accept="image/*" onchange="readURL(this);">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">เพิ่ม</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editexampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มชนิดสินค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_product" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="edit_product">
                    <input type="hidden" name="id" id="productID">
                    <div class="row">
                        <div class="col-12">
                            <!-- <div class="mb-3">
                                <label for="">รหัสสินค้า</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_code" id="editproduct_code" required>
                            </div> -->
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อสินค้า</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_name" id="editproduct_name" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชนิดสินค้า</label>
                                <select class="form-control" name="product_typeID" id="editproduct_typeID" required>
                                    <?php
                                    $get_type = $con->query("SELECT * FROM `tblproducttype`");
                                    while ($rows_type = $get_type->fetch_assoc()) { ?>
                                        <option value="<?= $rows_type['Type_id'] ?>"><?= $rows_type['Type_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รายละเอียดย่อย</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_subdetail" id="editproduct_subdetail" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">จำนวน</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_qty" id="editproduct_qty" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ราคาต่อชิ้น</label>
                                <input type="text" autocomplete="off" class="form-control" name="product_price" id="editproduct_price" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">ชนิดสินค้า</label>
                            <select class="form-control" name="product_status" id="editproduct_status" required>
                                <option value="0">เปิดใช้งาน</option>
                                <option value="1">ปิดใช้งาน</option>
                            </select>
                        </div>
                        <div class="col-12" style="margin-top: 20px;">
                            <div class="mb-3">
                                <input type="file" class="form-control" name="preimg2" id="preimg2">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3" style="margin-top: 20px;">
                                <img src="" id="image_id" class="mt-2" alt="">
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showpic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

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
    $("#Add_product").submit(function(e) {
        e.preventDefault();
        var form = $("#Add_product")[0]
        var formdata = new FormData(form)
        var inputfile = $("#preimg")[0].files[0]
        formdata.append('image', inputfile)
        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
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
                        window.location = './?Product'
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
                    } else if (res.msg == "status") {
                        Swal.fire({
                            icon: 'error',
                            title: 'สินค้านี้ชำระเงินแล้ว!',
                        })
                    } else if (res.msg == "notpic") {
                        Swal.fire({
                            icon: 'error',
                            title: 'กรุณาแนบแค่ไฟล์รูปภาพ!',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?Product'
                    }, 1500);
                }
            },
        });
    });

    function getProduct(id) {
        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
            data: {
                action: "getProduct",
                id: id,
            },
            success: function(response) {
                let res = JSON.parse(response);
                $("#editproduct_code").val(res.msg.product_code);
                $("#editproduct_name").val(res.msg.product_name);
                $("#editproduct_qty").val(res.msg.product_qty);
                $("#editproduct_subdetail").val(res.msg.product_subdetail);
                $("#editproduct_price").val(res.msg.product_price);
                $('#editproduct_typeID option[value="' + res.msg.product_typeID + '"]').prop('selected', true);
                $('#editproduct_status option[value="' + res.msg.product_status + '"]').prop('selected', true);
                $("#editname").html(res.msg.product_name);
                var img = $('#image_id');
                img.attr({
                    'src': '../assets/images/product/' + res.msg.product_picshow,
                    'width': '100%'
                });
                $("#productID").val(id);
                $("#editexampleModal").modal("show");
            }
        });
    }

    $("#edit_product").submit(function(e) {
        e.preventDefault();
        var form = $("#edit_product")[0]
        var formdata = new FormData(form)
        var inputfile = $("#preimg2")[0].files[0]
        formdata.append('image', inputfile)

        $.ajax({
            type: "POST",
            url: 'Action/addproduct.php',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
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
                        window.location = './?Product'
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
                    } else if (res.msg == "status") {
                        Swal.fire({
                            icon: 'error',
                            title: 'สินค้านี้ชำระเงินแล้ว!',
                        })
                    } else if (res.msg == "notpic") {
                        Swal.fire({
                            icon: 'error',
                            title: 'กรุณาแนบแค่ไฟล์รูปภาพ!',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?Product'
                    }, 1500);
                }
            },
        });
    });

    $('.del_product').click(function(e) {
        var del_product = $(this).data('id')
        e.preventDefault();
        delete_product(del_product);
    })

    function delete_product(id) {
        var del_product = id
        Swal.fire({
            title: 'คุณแน่ใจใช่ไหม ?',
            text: "คุณจะไม่สามารถย้อนกลับได้นะ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        type: "POST",
                        url: 'Action/addproduct.php',
                        data: {
                            action: "del_product",
                            del_product: del_product,
                        },
                        success: function(response) {
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบสำเร็จ!'
                                })
                                setTimeout((e) => {
                                    window.location = './?Product'
                                }, 1500);
                            } else {
                                if (res.msg == "wrong") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'เกิดข้อผิดพลาด!'
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'เกิดข้อผิดพลาด!'
                                    })
                                }

                                setTimeout((e) => {
                                    window.location = './?Product'
                                }, 1500);
                            }
                        }
                    });
                });
            },
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#dataal').DataTable({
            "oLanguage": {
                "sLengthMenu": "แสดงรายการ _MENU_ รายการ ต่อหน้า",
                "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                "sInfo": "จำนวน _START_ ถึง _END_ ใน _TOTAL_ รายการทั้งหมด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการทั้งหมด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา :",
                "aaSorting": [
                    [0, 'desc']
                ],
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
            },
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>