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
                                <a href="./?Product&add=1" class="btn btn-info" type="button"
                                    class="btn btn-primary">เพิ่มสินค้า</a>
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
                            <th>ชื่อสินค้า</th>
                            <th>ชื่อชนิดสินค้า</th>
                            <th>จน. จัดเก็บขั้นต่ำ</th>
                            <th>จน. คงเหลือ</th>
                            <th>ราคาต่อชิ้น</th>
                            <th>สถานะ</th>
                            <th width="15%" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $get_product = $con->query("SELECT * FROM `tblproduct`");
                        while ($rows_product = $get_product->fetch_assoc()) {
                        ?>
                        <tr
                            <?php echo ((float)$rows_product['product_min'] >= (float)$rows_product['product_qty']) ? 'class="text-danger"' : ''; ?>>
                            <td>
                                <img src="<?php printf('%s%s', $product_file_dir, $rows_product['product_picshow']); ?>"
                                    width="60px" alt="">
                            </td>
                            <td>
                                <?php echo $rows_product['product_name'] ?>
                            </td>
                            <td>
                                <?php
                                    $get_typeShow = $con->query("SELECT * FROM `tblproducttype` WHERE `Type_id` = '" . $rows_product['product_typeID'] . "'")->fetch_assoc();
                                    echo $get_typeShow['Type_name'];
                                    ?>
                            </td>
                            <td class="text-center">
                                <?php echo number_format((float) $rows_product['product_min']); ?>
                            </td>
                            <td class="text-center">
                                <?php echo number_format((float) $rows_product['product_qty']); ?>
                            </td>
                            <td class="text-end">
                                <?php echo number_format((float) $rows_product['product_price'], 2) ?>
                            </td>
                            <td>
                                <?php
                                    if ($rows_product['product_status'] == 0) {
                                        echo '<span class="text-success">เปิดใช้งาน</span>';
                                    } else {
                                        echo '<span class="text-danger">ปิดใช้งาน</span>';
                                    }
                                    ?>
                            </td>
                            <td class="text-end">
                                <a href="./?Product&edit=<?php echo $rows_product['product_id']; ?>"
                                    class="btn btn-warning rounded">
                                    <i class="far fa-pen"></i>
                                </a>
                                <button class="btn btn-danger rounded del_product"
                                    data-id="<?php echo $rows_product['product_id'] ?>">
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
                        id: del_product,
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: res.msg
                            })
                            setTimeout((e) => {
                                window.location.reload()
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