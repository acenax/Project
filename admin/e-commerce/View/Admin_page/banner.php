<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">เพิ่ม / ลบ / รูปแบบเนอร์ </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#exampleModal">เพิ่ม</button>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <table class="table" id="dataal">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รูป</th>
                                <th>จัดการรูป</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $baner = $con->query("SELECT * FROM `tblecombanner`");
                            while ($rows_baner = $baner->fetch_assoc()) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <img src="../assets/images/banner/<?= $rows_baner['Ecombanner_path'] ?>" width="250px" alt="">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" onclick="del_pic(<?= $rows_baner['Ecombanner_id'] ?>)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มแบนเนอร์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addbaner" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="addbaner">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">รูปแบบเนอร์</label>
                                <input type="file" autocomplete="off" class="form-control" name="preimg" id="preimg" accept="image/*" required>
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

<script>
    $("#addbaner").submit(function(e) {
        e.preventDefault();
        var form = $("#addbaner")[0]
        var formdata = new FormData(form)
        var inputfile = $("#preimg")[0].files[0]
        formdata.append('image', inputfile)
        $.ajax({
            type: "POST",
            url: 'Action/addbanner.php',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!'
                    })
                    setTimeout((e) => {
                        window.location = './?banner'
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
                        window.location = './?banner'
                    }, 1500);
                }
            },
        });
    });

    function del_pic(data) {
        $.ajax({
            type: "POST",
            url: 'Action/addbanner.php',
            data: {
                action: 'del_pic',
                id: data,
            },
            success: function(response) {
                let res = JSON.parse(response)
                if (res.status = 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ'
                    })
                    setTimeout(() => {
                        window.location = './?banner'
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด กรุณาลองใหม่'
                    })
                    setTimeout(() => {
                        window.location = './?banner'
                    }, 1500);
                }
            }
        })
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