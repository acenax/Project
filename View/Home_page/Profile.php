<br><br><br>
<style>
    .body-payment {
        display: flex;
        width: 100%;
        height: auto;
        border: 4px solid #212529;
        border-radius: 15px;
        margin-bottom: 100px;
        box-shadow: 5px 5px #cecccc;
        background-color: #fff;

    }

    .bank-payment {
        background-color: #ddd;
        padding: 5px 10px;
        text-align: center;
        border-radius: 15px;
    }

    .header-payment {
        border: 5px solid #212529;
        border-radius: 10px;
        background-color: #fff;
        padding: 10px;
        box-shadow: 5px 5px #cecccc;
    }


    .body-payment .sidebarprofile {
        top: 0;
        left: 0;
        width: 400px;
        margin: 25px 0;
        border-right: 1px solid #000;
    }

    .sidebarprofile-header {
        text-align: center;
        margin-top: 15px;
        border-bottom: 1px solid #000;
        width: 80%;
        margin-left: 35px;
    }

    .ulbodyprofile {
        display: block;
        width: 80%;
        margin-left: 80px;
    }

    .ulbodyprofile a {
        display: flex;
        font-size: 20px;
        font-style: normal;
        list-style-type: none;
        margin-top: 30px;
        width: 100%;
        color: #212529;
        text-decoration: none;
    }

    .profile-content {
        margin-left: 50px;
        margin-top: 50px;
        font-size: 16px;
        width: 800px;
    }

    @media screen and (max-width: 400px) {
        .body-payment {
            display: flex;
            flex-direction: column;
        }

        .profile-content {
            padding: 0 50px;
            margin: 0 !important;
            width: 100%;
        }
    }
</style>

<?php
$rows_user = $con->query("SELECT * FROM `tbluser` WHERE `user_id` ='" . $_SESSION['user_id'] . "'")->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="header-payment">
                <span style="font-size: 20px;" class="ms-3">
                    <i class="fas fa-user-circle" style="font-size: 30px;"></i>
                    ยินดีต้อนรับ : <?= $rows_user['user_username'] ?>
                </span>
            </div>
        </div>
        <div class="col-lg-12 mb-3">
            <div class="body-payment">
                <?php include_once('sildeprofile.php'); ?>
                <div class="profile-content">
                    <div class="sub-content">
                        <div class="input-profile">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <span>ชื่อ</span>
                                    <input type="text" class="form-control" value="<?php if ($rows_user['user_fname'] == null) {
                                                                                        echo 'ยังไม่ได้ระบุ';
                                                                                    } else {
                                                                                        echo $rows_user['user_fname'];
                                                                                    } ?>" disabled="">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <span>นามสกุล</span>
                                    <input type="text" class="form-control" value="<?php if ($rows_user['user_lname'] == null) {
                                                                                        echo 'ยังไม่ได้ระบุ';
                                                                                    } else {
                                                                                        echo $rows_user['user_lname'];
                                                                                    } ?>" disabled="">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <span>เบอร์โทรศัพท์</span>
                                    <input type="text" class="form-control" value="<?php if ($rows_user['user_phone'] == null) {
                                                                                        echo 'ยังไม่ได้ระบุ';
                                                                                    } else {
                                                                                        echo $rows_user['user_phone'];
                                                                                    } ?>" disabled="">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <span>อีเมล</span>
                                    <input type="text" class="form-control" value="<?php if ($rows_user['user_email'] == null) {
                                                                                        echo 'ยังไม่ได้ระบุ';
                                                                                    } else {
                                                                                        echo $rows_user['user_email'];
                                                                                    } ?>" disabled="">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <span>รหัสผ่าน</span>
                                    <input type="password" class="form-control" value="<?php if ($rows_user['user_Real_password'] == null) {
                                                                                            echo 'ยังไม่ได้ระบุ';
                                                                                        } else {
                                                                                            echo $rows_user['user_Real_password'];
                                                                                        } ?>" disabled="">
                                </div>
                            </div>
                        </div>

                        <div class="text-danger mt-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                แก้ไขข้อมูล
                            </button>
                            <div class="d-flex justify-content-end text-danger mt-2">
                                <!-- Add your comment here -->
                                <span class="text-danger font-weight-bold"> #กรุณาระบุข้อมูลส่วนตัวและที่อยู่ เมื่อเข้าใช้งานครั้งแรก</span>
                            </div>
                        </div>

                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลส่วนตัว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="save_profile">
                    <input type="hidden" name="action" value="save_profile">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="">ชื่อจริง</label>
                                <input type="text" class="form-control" name="fname" id="" value="<?php if ($rows_user['user_fname'] == null) {
                                                                                                        echo '';
                                                                                                    } else {
                                                                                                        echo $rows_user['user_fname'];
                                                                                                    } ?>" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="">นามสกุล</label>
                                <input type="text" class="form-control" name="lname" value="<?php if ($rows_user['user_lname'] == null) {
                                                                                                echo '';
                                                                                            } else {
                                                                                                echo $rows_user['user_lname'];
                                                                                            } ?>" id="" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" name="phone" value="<?php if ($rows_user['user_phone'] == null) {
                                                                                                echo '';
                                                                                            } else {
                                                                                                echo $rows_user['user_phone'];
                                                                                            } ?>" id="" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="">อีเมล</label>
                                <input type="email" class="form-control" name="email" value="<?php if ($rows_user['user_email'] == null) {
                                                                                                    echo '';
                                                                                                } else {
                                                                                                    echo $rows_user['user_email'];
                                                                                                } ?>" id="" autocomplete="off">
                            </div>

                            <!-- Password field -->
                            <div class="mb-3">
                                <label for="">รหัสผ่าน</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="กรอกรหัสผ่านใหม่" minlength="8" maxlength="15">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">แสดง/ซ่อนรหัสผ่าน</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm password field -->
                            <div class="mb-3">
                                <label for="">ยืนยันรหัสผ่าน</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="off" placeholder="กรอกยืนยันรหัสผ่าน" minlength="8" maxlength="15">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">แสดง/ซ่อนรหัสผ่าน</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end text-danger mt-2">
                                <!-- Add your comment here -->
                                <span class="text-danger font-weight-bold"> #หากท่านไม่ต้องการแก้ไขรหัสผ่านให้กดบันทึกได้เลย</span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
            </form>

        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
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


    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');

    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    toggleConfirmPassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        // toggle the eye icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>
<script src="Assets/Js/mainJs.js"></script>