<br><br><br>
<br><br><br>

<style>
    .card {
        box-shadow: 5px 5px #cecccc;
    }
</style>

<!-- banner register -->
<?php
$banres = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANRES' LIMIT 1;")->fetch_assoc();
if (!empty($banres)) {
    $banres = json_decode($banres['setting_value']);
}
$site_title = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;")->fetch_assoc();
?>
<!-- end -->
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8" title="<?php echo (!empty($site_title)) ? $site_title['setting_value'] : ''; ?>">
                    <?php if (!empty($banres)) : ?>
                        <img src="data:<?php echo $banres->mim_type; ?>;base64, <?php echo $banres->raw_content; ?>" alt="banres" width="100%" alt="">
                    <?php else : ?>
                        <span class="py-2">
                            <small class="bg-white text-dark text-center px-2 py-3 rounded-pill fs-6">BANRES</small>
                        </span>
                    <?php endif; ?>
                    </a>
                </div>
                <div class="col-lg-4">
                    <form id="register">
                        <input type="hidden" name="action" value="register_form">
                        <div class="row">
                            <div class="col-12">
                                <div class=" text-center" style="font-size: 60px;">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h5 class="text-center">สมัครสมาชิก</h5>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="">รหัสผู้ใช้งาน</label>
                                    <input type="text" class="form-control" autocomplete="off" name="username">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="password">รหัสผ่าน (8 ตัวอักษรขึ้นไป)</label>
                                    <input type="password" id="password" class="form-control" autocomplete="off" name="password" minlength="8" maxlength="15">
                                </div>
                                <div>
                                    <label for="Cpassword">ยืนยันรหัสผ่าน (8 ตัวอักษรขึ้นไป)</label>
                                    <input type="password" id="Cpassword" class="form-control" autocomplete="off" name="Cpassword" minlength="8" maxlength="15">
                                </div> 
                                <div>
                                    <input type="checkbox" onclick="togglePasswordVisibility()">
                                    <label for="">แสดงรหัสผ่าน</label>
                                </div>
                                <br>
                                <script>
                                    function togglePasswordVisibility() {
                                        var password = document.getElementById("password");
                                        var confirmPassword = document.getElementById("Cpassword");

                                        if (password.type === "password" && confirmPassword.type === "password") {
                                            password.type = "text";
                                            confirmPassword.type = "text";
                                        } else {
                                            password.type = "password";
                                            confirmPassword.type = "password";
                                        }
                                    }
                                </script>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-dark btn-md w-100">
                                        <i class="fas fa-user-plus"></i>
                                        สมัครมาชิก
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2 text-center">
                                    <span>หรือ</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-primary btn-md w-100" onclick="window.location = './?login'">
                                        <i class="fal fa-sign-out-alt"></i>
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php'; ?>
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
</script>
<script src="Assets/Js/mainLog.js?v=<?= rand(1, 10) ?>"></script>