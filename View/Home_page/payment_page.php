<br><br><br>

<style>
    .body-payment {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 60px 40px;
        box-shadow: 5px 5px #cecccc;
    }

    .bank-payment {
        background-color: #ddd;
        padding: 5px 10px;
        border-radius: 15px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-payment">
                <h3 class="text-center">แจ้งการชำระเงิน</h3>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-payment">
                <form id="confirmPayment" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h5 class="">ข้อมูลการสั่งซื้อ</h5>
                            <hr>
                            <div class="row mt-4">

                                <div class="col-md-12">
                                    <label for="">เลขที่ใบสั่งซื้อ</label>
                                    <input type="text" class="form-control" id="paymentid" name="paymentid" autocomplete="off">
                                    <small class="ms-2" id="text-status"></small>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">ชื่อจริง</label>
                                        <input type="text" class="form-control" name="fname" id="fname" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">นามสกุล</label>
                                        <input type="text" class="form-control" name="lname" id="lname" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" name="phone" id="phone" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">จำนวนเงิน</label>
                                        <input type="text" class="form-control" name="price" id="price" readonly>
                                    </div>
                                </div>

                            </div>
                            <!-- eof .row -->

                            <h5 class="mt-4">วิธีการชำระเงิน</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">โอนผ่านบัญชีธนาคาร</button>
                                        </li>

                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active pt-4 px-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <?php $rs = $con->query("SELECT * FROM `tblbank`"); ?>
                                                    <?php $i = 0; ?>
                                                    <?php while ($row = $rs->fetch_assoc()) : ?>
                                                        <div class="mb-3 form-check">
                                                            <input type="radio" name="bankaccountid" value="<?php echo $row['bank_id']; ?>" class="
                                                                                                                            form-check-input" id="bk<?php echo $i; ?>" required>
                                                            <label class="form-check-label" for="bk<?php echo $i++; ?>">
                                                                <span class="fw-bold text-success">
                                                                    <?php echo $row['bank_bank']; ?>
                                                                </span> <br>
                                                                <span>เลขที่บัญชี</span>
                                                                <span>
                                                                    <?php echo $row['bank_number']; ?>
                                                                </span>,
                                                                <span>ชื่อบัญชี</span>
                                                                <span>
                                                                    <?php echo $row['bank_name']; ?>
                                                                </span>

                                                            </label>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="mb-3">
                                                        <label for="">วันที่ชำระ</label>
                                                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control text-center">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="mb-3">
                                                        <label for="">เวลาชำระ</label>
                                                        <input type="time" name="time" value="<?php echo date('H:i'); ?>" class="form-control text-center">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="">หลักฐานการชำระเงิน </label>
                                                        <input type="file" class="form-control" name="preimg" id="preimg">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="">หมายเหตุ</label>
                                                        <textarea class="form-control" name="note" id="note" cols="10" rows="5" placeholder="ระบุ หรือ ไม่ระบุ ก็ได้"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- eof .row -->
                                        </div>
                                        <!-- eof .tap-pane -->
                                    </div>
                                    <!-- eof .tab-content -->
                                </div>
                            </div>
                            <!-- .eof .row -->

                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <p class="text-danger">#โปรดชำระเงินภายใน 5 วันทำการไม่งั้นสินค้าของท่านจะถูกยกเลิก</p>
                                    <p class="text-danger">#อย่าลืมตรวจสอบข้อมูลก่อน</p>
                                    <p class="text-danger">
                                        #สินค้าที่แจ้งชำระไปแล้วจะไม่สามารถเปลี่ยนข้อมูลได้ทีหลังได้</p>

                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-dark" id="conbtn" disabled>
                                        <i class="far fa-check"></i>
                                        แจ้งการชำระเงิน
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <!-- eof .row -->
                    <input type="hidden" name="action" value="confirmPayment">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
<script>
    function wait() {
        swal.fire({
            html: '<h5>กรุณารอซักครู่...</h5>',
            showConfirmButton: false,
        });
    }

    var paymentid = false;
    $(document).ready(function() {
        var paymentid = $('#paymentid').val();
        console.log(paymentid);
        var paymentid = $('#paymentid').val();
        if (paymentid == '') {
            payment_state = false;
            return;
        }
        $.ajax({
            url: 'Action/payment.php',
            type: 'POST',
            data: {
                'payment_chk': 1,
                'paymentid': paymentid
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == "success") {
                    $("#fname").val(res.msg.fname)
                    $("#lname").val(res.msg.lname)
                    $("#phone").val(res.msg.phone)
                    $("#price").val(formatPrice(res.msg.totalprice));

                    function formatPrice(price) {
                        var formattedValue = '';
                        var priceValue = parseFloat(price);
                        if (!isNaN(priceValue)) {
                            formattedValue = priceValue.toLocaleString('th-TH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' บาท';
                        } else {
                            formattedValue = '0.00 baht';
                        }
                        return formattedValue;
                    }
                    $("#text-status").html('<span class="text-success">มีหมายเลขนี้</span>')
                    $("#paymentid").removeClass('border border-danger')
                    $("#paymentid").removeClass('border border-warning')
                    $("#paymentid").addClass('border border-success')
                    $("#conbtn").removeAttr('disabled')
                } else {
                    if (res.status == "notpayment") {
                        $("#text-status").html(
                            '<span class="text-warning">หมายเลขนี้แจ้งชำระเงินแล้ว</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-danger')
                        $("#paymentid").addClass('border border-warning')
                        $("#conbtn").attr('disabled', true)
                    } else
                    if (res.status == "notdata") {
                        $("#text-status").html('<span class="text-danger">ไม่มีหมายเลขนี้</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-warning')
                        $("#paymentid").addClass('border border-danger')
                        $("#conbtn").attr('disabled', true)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                        })
                    }
                }
            }
        })
    });
    $(document).ready(function() {
        // $('#paymentid').on('blur', function() {
        var paymentid = $('#paymentid').val();
        if (paymentid == '') {
            payment_state = false;
            return;
        }
        $.ajax({
            url: 'Action/payment.php',
            type: 'POST',
            data: {
                'payment_chk': 1,
                'paymentid': paymentid
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == "success") {
                    $("#fname").val(res.msg.fname)
                    $("#lname").val(res.msg.lname)
                    $("#phone").val(res.msg.phone)
                    $("#price").val(formatPrice(res.msg.totalprice));

                    function formatPrice(price) {
                        var formattedValue = '';
                        var priceValue = parseFloat(price);
                        if (!isNaN(priceValue)) {
                            formattedValue = priceValue.toLocaleString('th-TH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' บาท';
                        } else {
                            formattedValue = '0.00 baht';
                        }
                        return formattedValue;
                    }
                    $("#text-status").html('<span class="text-success">มีหมายเลขนี้</span>')
                    $("#paymentid").removeClass('border border-danger')
                    $("#paymentid").removeClass('border border-warning')
                    $("#paymentid").addClass('border border-success')
                    $("#conbtn").removeAttr('disabled')
                } else {
                    if (res.status == "notpayment") {
                        $("#text-status").html(
                            '<span class="text-warning">หมายเลขนี้แจ้งชำระเงินแล้ว</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-danger')
                        $("#paymentid").addClass('border border-warning')
                        $("#conbtn").attr('disabled', true)
                    } else
                    if (res.status == "notdata") {
                        $("#text-status").html('<span class="text-danger">ไม่มีหมายเลขนี้</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-warning')
                        $("#paymentid").addClass('border border-danger')
                        $("#conbtn").attr('disabled', true)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                        })
                    }
                }
            }
        })
    });

    $('#paymentid').on('blur', function() {
        var paymentid = $('#paymentid').val();
        if (paymentid == '') {
            payment_state = false;
            return;
        }
        $.ajax({
            url: 'Action/payment.php',
            type: 'POST',
            data: {
                'payment_chk': 1,
                'paymentid': paymentid
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == "success") {
                    $("#fname").val(res.msg.fname)
                    $("#lname").val(res.msg.lname)
                    $("#phone").val(res.msg.phone)
                    $("#price").val(formatPrice(res.msg.totalprice));

                    function formatPrice(price) {
                        var formattedValue = '';
                        var priceValue = parseFloat(price);
                        if (!isNaN(priceValue)) {
                            formattedValue = priceValue.toLocaleString('th-TH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' บาท';
                        } else {
                            formattedValue = '0.00 baht';
                        }
                        return formattedValue;
                    }
                    $("#text-status").html('<span class="text-success">มีหมายเลขนี้</span>')
                    $("#paymentid").removeClass('border border-danger')
                    $("#paymentid").removeClass('border border-warning')
                    $("#paymentid").addClass('border border-success')
                    $("#conbtn").removeAttr('disabled')
                } else {
                    if (res.status == "notpayment") {
                        $("#text-status").html(
                            '<span class="text-warning">หมายเลขนี้แจ้งชำระเงินแล้ว</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-danger')
                        $("#paymentid").addClass('border border-warning')
                        $("#conbtn").attr('disabled', true)
                    } else
                    if (res.status == "notdata") {
                        $("#text-status").html('<span class="text-danger">ไม่มีหมายเลขนี้</span>')
                        $("#paymentid").removeClass('border border-success')
                        $("#paymentid").removeClass('border border-warning')
                        $("#paymentid").addClass('border border-danger')
                        $("#conbtn").attr('disabled', true)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                        })
                    }
                }
            }
        })
    });

    $("#confirmPayment").submit(function(e) {
        e.preventDefault();
        var form = $("#confirmPayment")[0]
        var formdata = new FormData(form)
        var inputfile = $("#preimg")[0].files[0]
        formdata.append('image', inputfile)
        $.ajax({
            type: "POST",
            url: "Action/payment.php",
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
                        window.location = './?history'
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
                            title: 'กรุณาแนบเฉพาะไฟล์ภาพ!',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!'
                        })
                    }

                    setTimeout((e) => {
                        window.location = './?payment'
                    }, 1500);
                }
            },
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var billTrx = sessionStorage.getItem('billtrx');
        var paymentIdField = document.getElementById('paymentid');
        var displayElement = document.getElementById('displayBillTrx');

        if (billTrx && paymentIdField) {
            paymentIdField.value = billTrx;
        }

        if (billTrx && displayElement) {
            displayElement.innerHTML = 'Received value: ' + billTrx;
        }
    });
</script>