<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข ประเภทสินค้า </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">เพิ่มชนิดสินค้า</button>
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
                            <th>ลำดับ</th>
                            <th>ชื่อชนิดสินค้า</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 0;
                        $get_type = $con->query("SELECT * FROM `tblproducttype`");
                        while ($rows_type = $get_type->fetch_assoc()) {
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $rows_type['Type_name'] ?></td>
                                <td>
                                    <?php
                                    if ($rows_type['Type_status'] == 0) {
                                        echo '<span class="text-success">เปิดใช้งาน</span>';
                                    } else {
                                        echo '<span class="text-danger">ปิดใช้งาน</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning rounded" onclick="getTypeProduct('<?= $rows_type['Type_id'] ?>')">
                                        <i class="far fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger rounded del_type" data-id="<?= $rows_type['Type_id'] ?>">
                                        <i class="far fa-trash-alt"></i>
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
                <form id="Addtype_product">
                    <input type="hidden" name="action" value="Addtype_product">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อชนิดสินค้า</label>
                                <input type="text" class="form-control" name="Type_name">
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
                <h5 class="modal-title" id="exampleModalLabel">แก้ไข ชนิดสินค้า : <span id="editname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edittype_product">
                    <input type="hidden" name="action" value="edittype_product">
                    <input type="hidden" name="id" id="TypeID">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อชนิดสินค้า</label>
                                <input type="text" class="form-control" name="Type_name" id="editType_name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อชนิดสินค้า</label>
                                <select class="form-control" name="Type_status" id="editType_status">
                                    <option value="0">เปิดใช้งาน</option>
                                    <option value="1">ปิดใช้งาน</option>
                                </select>
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
    $("#Addtype_product").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: "POST",
            url: 'Action/addtype.php',
            data: data,
            beforeSend: (e) => {
                wait();
            },
            success: (Response) => {
                let res = JSON.parse(Response);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มสำเร็จแล้ว !'
                    })
                    setTimeout((e) => {
                        window.location = './?ProductType'
                    }, 1500);
                } else {
                    if (res.status == "taken") {
                        Swal.fire({
                            icon: 'error',
                            title: 'มีชนิดสินค้านี้แล้ว !'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?ProductType'
                    }, 1500);
                }
            }
        })
    })

    function getTypeProduct(id) {
        $.ajax({
            type: "POST",
            url: "Action/addtype.php",
            data: {
                action: "getType",
                id: id,
            },
            success: function(response) {
                let res = JSON.parse(response);
                // $("#editType_name").val(res.msg.Type_name);
                $('#editType_status option[value="' + res.msg.Type_status + '"]').prop('selected', true);
                $("#editname").html(res.msg.Type_name);
                $("#TypeID").val(id);
                $("#editexampleModal").modal("show");
            }
        });
    }

    $("#edittype_product").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: "POST",
            url: 'Action/addtype.php',
            data: data,
            beforeSend: (e) => {
                wait();
            },
            success: (Response) => {
                let res = JSON.parse(Response);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขสำเร็จแล้ว !'
                    })
                    setTimeout((e) => {
                        window.location = './?ProductType'
                    }, 1500);
                } else {
                    if (res.status == "taken") {
                        Swal.fire({
                            icon: 'error',
                            title: 'มีชนิดสินค้านี้แล้ว !'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                        })
                    }
                    setTimeout((e) => {
                        window.location = './?ProductType'
                    }, 1500);
                }
            }
        })
    })

    $('.del_type').click(function(e) {
        var del_type = $(this).data('id')
        e.preventDefault();
        delete_type(del_type);
    })

    function delete_type(id) {
        var del_type = id
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
                        url: 'Action/addtype.php',
                        data: {
                            action: "del_type",
                            del_type: del_type,
                        },
                        success: function(response) {
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบสำเร็จ!'
                                })
                                setTimeout((e) => {
                                    window.location = './?ProductType'
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
                                    window.location = './?ProductType'
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