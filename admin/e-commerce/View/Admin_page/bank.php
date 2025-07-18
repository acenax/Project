<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข บัญชีธนาคาร </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addBankModal">เพิ่มบัญชีธนาคาร</button>
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
                            <th>ธนาคาร</th>
                            <th>เลขบัญชีธนาคาร</th>
                            <th>ชื่อบัญชีธนาคาร</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $rs = $con->query("SELECT * FROM `tblbank`;");
                        while ($row = $rs->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo ++$i ?>
                            </td>
                            <td>
                                <?php echo $row['bank_bank'] ?>
                            </td>
                            <td>
                                <?php echo $row['bank_number']; ?>
                            </td>
                            <td>
                                <?php echo $row['bank_name']; ?>
                            </td>

                            <td>
                                <button class="btn btn-warning rounded"
                                    onclick="getBank('<?php echo $row['bank_id'] ?>')">
                                    <i class="far fa-pen"></i>
                                </button>
                                <button class="btn btn-danger rounded del_user" data-id="<?php echo $row['bank_id'] ?>">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>

<div class="modal fade" id="addBankModal" tabindex="-1" role="dialog" aria-labelledby="addBankModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addbank" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBankModalLabel">เพิ่มบัญชีธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="bank" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">เลขบัญชีธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="banknumber" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อบัญชีธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="bankname" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="addbank">
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBankModal" tabindex="-1" role="dialog" aria-labelledby="editBankModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="Edit_Bank" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBankModalLabel">แก้ไข้ข้อมูล : <span id="editname"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="bank" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">เลขบัญชีธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="banknumber" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อบัญชีธนาคาร</label>
                                <input type="text" autocomplete="off" class="form-control" name="bankname" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="editbank">
                    <input type="hidden" name="id">
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
$("#addbank").submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var datavalid = JSON.parse(getFormData($(this)));
    $.ajax({
        type: "POST",
        url: 'Action/bank.php',
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
                    window.location = './?bank'
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!'
                    })
                }
                setTimeout((e) => {
                    window.location = './?bank'
                }, 1500);
            }
        },
    });
});

function getBank(data) {
    $.ajax({
        type: 'POST',
        url: 'Action/bank.php',
        data: {
            action: 'getbank',
            id: data,
        },
        success: (respons) => {
            let res = JSON.parse(respons)
            if (res.status == 'success') {
                $edit_form = $("#editBankModal");

                $("input[name='bank']", $edit_form).val(res.msg.bank_bank)
                $("input[name='banknumber']", $edit_form).val(res.msg.bank_number)
                $("input[name='bankname']", $edit_form).val(res.msg.bank_name)
                $("input[name='id']", $edit_form).val(res.msg.bank_id);
                $edit_form.modal("show");


            }
        }
    })
}

$("#Edit_Bank").submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var datavalid = JSON.parse(getFormData($(this)));

    $.ajax({
        type: 'POST',
        url: 'Action/bank.php',
        data: data,
        beforeSend: (e) => {
            wait();
        },
        success: (respons) => {
            let res = JSON.parse(respons);
            if (res.status == 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ !'
                })
                setTimeout(() => {
                    window.location = './?bank'
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด กรุณาลองใหม่ !'
                })
                setTimeout(() => {
                    window.location = './?bank'
                }, 1500);
            }
        }
    })
})

$('.del_user').click(function(e) {
    var del_user = $(this).data('id')
    e.preventDefault();
    delete_user(del_user);
})

function delete_user(id) {
    var del_user = id
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
                    url: 'Action/actionuser.php',
                    data: {
                        action: "del_user",
                        del_user: del_user,
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == "success") {
                            Toast.fire({
                                icon: 'success',
                                title: 'ลบสำเร็จ!'
                            })
                            setTimeout((e) => {
                                window.location = './?Admin'
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
                                window.location = './?Admin'
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