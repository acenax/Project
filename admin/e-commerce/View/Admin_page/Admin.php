<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / แก้ไข แอดมิน </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">เพิ่มสมาชิกใหม่</button>
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
                            <th>รหัสสมาชิก</th>
                            <th>ชื่อจริง</th>
                            <th>นามสกุล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>อีเมล</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 0;
                        $get_user = $con->query("SELECT * FROM `tbluser` WHERE user_type = 'admin'");
                        while ($rows_user = $get_user->fetch_assoc()) {
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $rows_user['user_username'] ?></td>
                                <td>
                                    <?php
                                    if ($rows_user['user_fname'] == null) {
                                        echo 'ยังไม่ได้มีบันทึก';
                                    } else {
                                        echo $rows_user['user_fname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows_user['user_lname'] == null) {
                                        echo 'ยังไม่ได้มีบันทึก';
                                    } else {
                                        echo $rows_user['user_lname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows_user['user_phone'] == null) {
                                        echo 'ยังไม่ได้มีบันทึก';
                                    } else {
                                        echo $rows_user['user_phone'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows_user['user_email'] == null) {
                                        echo 'ยังไม่ได้มีบันทึก';
                                    } else {
                                        echo $rows_user['user_email'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows_user['user_type'] == null) {
                                        echo 'ยังไม่ได้มีบันทึก';
                                    } else {
                                        echo $rows_user['user_type'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning rounded" onclick="getuser('<?= $rows_user['user_id'] ?>')">
                                        <i class="far fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger rounded del_user" data-id="<?= $rows_user['user_id'] ?>">
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
                <form id="Add_Users" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="Add_Users">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รหัสเข้าใช้งาน</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_username" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รหัสผ่าน</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_password" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อจริง</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_fname" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">นามสกุล</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_lname" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">เบอร์โทรศัพท์</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_phone" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">อีเมล</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_email" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">สถานะ</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_type" value="admin" readonly>
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
                <h5 class="modal-title" id="exampleModalLabel">แก้ไข้ข้อมูล : <span id="editname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="Edit_Users" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="Edit_Users">
                    <input type="hidden" name="id" id="UserID">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รหัสเข้าใช้งาน</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_username" id="edituser_username" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รหัสผ่าน</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_password" id="edituser_password" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อจริง</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_fname" id="edituser_fname" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">นามสกุล</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_lname" id="edituser_lname" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">เบอร์โทรศัพท์</label>
                                <input type="text" autocomplete="off" class="form-control" name="user_phone" id="edituser_phone" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">อีเมล</label>
                                <input type="email" autocomplete="off" class="form-control" name="user_email" id="edituser_email" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">สถานะ</label>
                                <select class="form-control" name="user_type" id="edituser_type">
                                    <option value="user">user</option>
                                    <option value="admin">admin</option>
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
    $("#Add_Users").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: 'POST',
            url: 'Action/actionuser.php',
            data: data,
            beforeSend: (e) => {
                wait();
            },
            success: (respons) => {
                let res = JSON.parse(respons);
                if (res.status == 'success') {
                    Toast.fire({
                        icon: 'success',
                        title: 'เพิ่มสมาชิกสำเร็จ !'
                    })
                    setTimeout(() => {
                        window.location = './?Admin'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด กรุณาลองใหม่ !'
                    })
                    setTimeout(() => {
                        window.location = './?Admin'
                    }, 1500);
                }
            }
        })
    })

    function getuser(data) {
        $.ajax({
            type: 'POST',
            url: 'Action/actionuser.php',
            data: {
                action: 'getuser',
                id: data,
            },
            success: (respons) => {
                let res = JSON.parse(respons)
                if (res.status == 'success') {
                    $("#edituser_username").val(res.msg.user_username)
                    $("#edituser_password").val(res.msg.user_password)
                    $("#edituser_fname").val(res.msg.user_fname)
                    $("#edituser_lname").val(res.msg.user_lname)
                    $("#edituser_phone").val(res.msg.user_phone)
                    $("#edituser_email").val(res.msg.user_email)
                    $('#edituser_type option[value="' + res.msg.user_type + '"]').prop('selected', true);
                    $("#UserID").val(data);
                    $("#editname").html(res.msg.user_username);
                    $("#editexampleModal").modal("show");


                }
            }
        })
    }

    $("#Edit_Users").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var datavalid = JSON.parse(getFormData($(this)));

        $.ajax({
            type: 'POST',
            url: 'Action/actionuser.php',
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
                        window.location = './?Admin'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด กรุณาลองใหม่ !'
                    })
                    setTimeout(() => {
                        window.location = './?Admin'
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