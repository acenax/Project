<br><br><br>
<br><br><br>



<style>
    .card {
        box-shadow: 5px 5px #cecccc;
    }
</style>
<!-- banner Loging -->
<?php
$banlog = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANLOG' LIMIT 1;")->fetch_assoc();
if (!empty($banlog)) {
    $banlog = json_decode($banlog['setting_value']);
}
$site_title = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;")->fetch_assoc();
?>
<!-- end -->
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!--start update -->
                <div class="col-lg-8" title="<?php echo (!empty($site_title)) ? $site_title['setting_value'] : ''; ?>">
                    <?php if (!empty($banlog)) : ?>
                        <img src="data:<?php echo $banlog->mim_type; ?>;base64, <?php echo $banlog->raw_content; ?>" alt="banlog" width="100%" height="520" alt="">
                    <?php else : ?>
                        <span class="py-2">
                            <small class="bg-white text-dark text-center px-2 py-3 rounded-pill fs-6">BANLOG</small>
                        </span>
                    <?php endif; ?>
                    </a>
                </div>
                <!-- end -->
                <div class="col-lg-4">
                    <form id="login">
                        <input type="hidden" name="action" value="login_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 text-center" style="font-size: 80px;">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h5 class="text-center">ยินดีตอนรับสู่ร้านค้าออนไลน์</h5>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="">รหัสผู้ใช้งาน</label>
                                    <input type="text" class="form-control" autocomplete="off" name="username">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="password">รหัสผ่าน</label>
                                    <div class="input-group">
                                        <input type="password" id="password" class="form-control" autocomplete="off" name="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">แสดง/ซ่อนรหัสผ่าน</button>
                                        </div>
                                    </div>
                                    <!-- <div>
                                    <input type="checkbox" onclick="togglePasswordVisibility()">
                                    <label for="">แสดงรหัสผ่าน</label>
                                </div> -->
                                </div>

                                <!-- <script>
                                function togglePasswordVisibility() {
                                    var password = document.getElementById("password");

                                    if (password.type === "password") {
                                        password.type = "text";
                                    } else {
                                        password.type = "password";
                                    }
                                }
                            </script> -->
                                <!-- <div class="col-12">
                                <div class="mb-3 text-end">
                                    <button type="button" class="btn btn-link" onclick="window.location ='./?forgotpass'">
                                        ลืมรหัสผ่าน?
                                    </button>
                                </div>
                            </div> -->

                            </div>
                            <br>
                            <div class="col-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-dark btn-md w-100">
                                        <i class="fal fa-sign-out-alt"></i>
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 text-center">
                                    <span>หรือ</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary btn-md w-100" onclick="window.location = './?register'">
                                        <i class="fas fa-user-plus"></i>
                                        สมัครมาชิก
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

    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>
<script src="Assets/Js/mainLog.js?<?php echo date('Ymdhis') ?>"></script>