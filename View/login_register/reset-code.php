<br><br><br>
<br><br><br>
<br>


<style>
    .card {
        box-shadow: 5px 5px #cecccc;
    }
</style>
<!-- banner Loging -->
<?php
require('../../Controller/connect.php');
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
                        <img src="data:<?php echo $banlog->mim_type; ?>;base64, <?php echo $banlog->raw_content; ?>" alt="banlog" width="100%" alt="">
                    <?php else : ?>
                        <span class="py-2">
                            <small class="bg-white text-dark text-center px-2 py-3 rounded-pill fs-6">BANLOG</small>
                        </span>
                    <?php endif; ?>
                    </a>
                </div>
                <!-- end -->
                <div class="col-lg-4">
                    <form action="reset-code.php" method="POST" autocomplete="off">
                        <input type="hidden" name="action" value="login_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 text-center" style="font-size: 80px;">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h5 class="text-center">รหัสที่ส่งไปในอีเมล</h5>
                                <?php
                                if (isset($_SESSION['info'])) {
                                ?>
                                    <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                                        <?php echo $_SESSION['info']; ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($errors) {
                                ?>
                                    <div class="alert alert-danger text-center">
                                        <?php
                                        foreach ($errors as $showerror) {
                                            echo $showerror;
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="">กรอกรหัส</label>
                                    <input type="text" class="form-control" autocomplete="off" name="email">
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-dark btn-md w-100">
                                    <i class="fal fa-sign-out-alt"></i>
                                    เข้าสู่ระบบ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
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
</script>
<!-- <script src="Assets/Js/mainLog.js?<?php echo date('Ymdhis') ?>"></script> -->