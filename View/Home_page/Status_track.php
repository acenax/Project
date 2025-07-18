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
        text-align: center;
        border-radius: 15px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-payment">
                <h3 class="text-center">ติดตามสถานะการสั่งซื้อ</h3>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-payment">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <h3 class="text-center">ค้นหาด้วยหมายเลขคำสั่งซื้อของคุณ</h3>
                            <input type="text" class="form-control" id="track_number">
                        </div>
                    </div>
                    <div class="col-lg-3"></div>

                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center mb-3">
                            <p>สามารถตรวจสอบหมายเลขได้จาก
                                <?php if (isset($_SESSION['login'])) { ?>
                                    <a href="./?history">
                                        ที่นี้
                                    </a>
                                <?php  } else { ?>
                                    <a href="#" onclick="loginale()">
                                        ที่นี้
                                    </a>
                                <?php  } ?>

                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center mb-3">
                            <button class="btn btn-dark" onclick="searchtrack()">
                                <i class="far fa-search"></i>
                                ค้นหาด้วยหมายเลขคำสั่งซื้อ
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>



                </div>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php';?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
    function loginale() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณา Login ก่อน'
        }).then(function() {
            window.location = './?login';
        }), setTimeout(function() {
            window.location = './?login';
        }, 5000);
    }

    function searchtrack() {
        var track_number = $("#track_number").val()
        $.ajax({
            type: "POST",
            url: "Action/search.php",
            data: {
                action: 'searchtrack',
                track_number:track_number
            },
            success: function(response) {
                let data = JSON.parse(response)
                if (data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'ค้นหาสำเร็จ !',
                    })
                    setTimeout((e) => {
                        window.location = './?check_status_order='+ data.msg.bill_trx
                    }, 1500);
                } else {
                   if(data.status == "notdata"){
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่พบหมายเลข หรือ ยังไม่ได้แจ้งชำระเงิน !'
                    })
                   } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })
                   }
                    setTimeout((e) => {
                        window.location = './?Status_track'
                    }, 1500);
                }
            }
        })
    }
</script>