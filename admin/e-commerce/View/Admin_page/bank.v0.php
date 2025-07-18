<div id="wrapper">

    <div class="content-page">
        <div class="content">
            <div class="container">


                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">จัดการบัญชีธนาคาร </h4>
                        </div>
                    </div>
                </div>

                <?php
                $get_bank = $con->query("SELECT * FROM `tblbank`")->fetch_assoc();
                ?>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="p-6">
                            <div class="">
                                <form id="savebank">
                                    <input type="hidden" name="action" value="savebank">
                                    <div class="form-group m-b-20">
                                        <label for="exampleInputEmail1">ธนาคาร</label>
                                        <input type="text" class="form-control" name="bank"
                                            value="<?= $get_bank['bank_bank'] ?>" required>
                                    </div>
                                    <div class="form-group m-b-20">
                                        <label for="exampleInputEmail1">เลขบัญชีธนาคาร</label>
                                        <input type="text" class="form-control" name="banknumber"
                                            value="<?= $get_bank['bank_number'] ?>" required>
                                    </div>
                                    <div class="form-group m-b-20">
                                        <label for="exampleInputEmail1">ชื่อบัญชีธนาคาร</label>
                                        <input type="text" class="form-control" name="bankname"
                                            value="<?= $get_bank['bank_name'] ?>" required>
                                    </div>
                                    <button type="submit" name="submit"
                                        class="btn btn-success waves-effect waves-light">บันทึก</button>
                                </form>
                            </div>
                        </div> <!-- end p-20 -->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
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

        $.map(unindexed_array, function (n, i) {
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
    $("#savebank").submit(function (e) {
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
</script>