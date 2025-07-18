<?php
$shippings = [];

$rs = $con->query("SELECT * FROM `tblshipping`");
while ($row = $rs->fetch_assoc()) {
    $shippings[] = $row;
}

?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข ค่าจัดส่งสินค้า </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addShippingModal">เพิ่มรายการใหม่</button>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php if (empty($shippings)): ?>
                    <div class="text-center text-danger">ไม่พบข้อมูล</div>
                    <?php else: ?>
                    <table class="table" id="dataal">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>ชื่อขนส่ง</th>
                                <th width="10%">ค่าจัดส่ง</th>
                                <th width="10%">สถานะ</th>
                                <th width="20%">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shippings as $idx => $row): ?>
                            <tr>
                                <td>
                                    <?php echo ++$idx; ?>
                                </td>
                                <td>
                                    <?php echo $row['provider_name'] ?>
                                </td>

                                <td>
                                    <?php echo $row['shipping_rate'] ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'ACTIVE'): ?>
                                    <span class="text-success">เปิดใช้งาน</span>
                                    <?php else: ?>
                                    <span class="text-danger">ปิดใช้งาน</span>
                                    <?php endif; ?>

                                </td>
                                <td class="text-end">
                                    <button class="btn btn-warning rounded"
                                        onclick="getItem('<?php echo $row['shipping_id'] ?>')">
                                        <i class="far fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger rounded btn-del-item"
                                        data-id="<?php echo $row['shipping_id'] ?>">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>

            </div>


        </div> <!-- container -->
    </div> <!-- content -->
</div>

<div class="modal fade" id="addShippingModal" tabindex="-1" role="dialog" aria-labelledby="addShippingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addnew-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addShippingModalLabel">เพิ่มรายการค่าขนส่ง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="addnew-form">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="required">ชื่อผู้ขนส่ง</label>
                                <input type="text" value="" autocomplete="off" class="form-control" name="provider"
                                    required>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="required">ค่าขนส่ง</label>
                                <input type="number" name="price" value="" class="form-control text-center"
                                    placeholder="0.00" aria-label="0.00" aria-describedby="price" autocomplete="off"
                                    min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="addnew" />
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editShippingModal" tabindex="-1" role="dialog" aria-labelledby="editShippingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editShippingModalLabel">เพิ่มชนิดสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="required">ชื่อผู้ขนส่ง</label>
                                <input type="text" value="" autocomplete="off" class="form-control" name="provider"
                                    required>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="required">ค่าขนส่ง</label>
                                <input type="number" name="price" value="" class="form-control text-center"
                                    placeholder="0.00" aria-label="0.00" aria-describedby="price" autocomplete="off"
                                    min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="required">สถานะ</label>
                                <select class="form-control" name="status" required>
                                    <option value="ACTIVE">เปิดใช้งาน</option>
                                    <option value="INACTIVE">ปิดใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="">
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
$("#addnew-form").submit(function(e) {
    e.preventDefault();
    var form = $("#addnew-form")[0]
    var formdata = new FormData(form)

    $.ajax({
        type: "POST",
        url: 'Action/shipping.php',
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
                    title: res.msg
                })
                setTimeout((e) => {
                    window.location = './?shipping'
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg
                })
            }
        },
    });
});

function getItem(id) {
    const $dialog = $("#editShippingModal");
    $.ajax({
        type: "POST",
        url: 'Action/shipping.php',
        data: {
            action: "getItem",
            id: id,
        },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.status == "success") {
                $("input[name='provider']", $dialog).val(res.msg.provider_name);
                $("input[name='price']", $dialog).val(res.msg.shipping_rate);
                $("select[name='status']", $dialog).val(res.msg.status)
                $("input[name='id']", $dialog).val(res.msg.shipping_id);
                $dialog.modal("show");
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg
                })
            }
        }
    });
}

$("#edit-form").submit(function(e) {
    e.preventDefault();

    var form = $("#edit-form")[0]
    var formdata = new FormData(form)

    $.ajax({
        type: "POST",
        url: 'Action/shipping.php',
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
                    title: res.msg
                })
                setTimeout((e) => {
                    window.location = './?shipping'
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg
                })
            }
        },
    });
});

$('.btn-del-item').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id')
    deleteItem(id);
})

function deleteItem(id) {

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
                    url: 'Action/shipping.php',
                    data: {
                        action: "delete",
                        id: id,
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: res.msg
                            })
                            setTimeout((e) => {
                                window.location = './?shipping'
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: res.msg
                            })
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