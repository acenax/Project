<?php
$nologo_file = '../assets/images/no-image.png';

// SITE LOGO
$no_image = (object) [
    'mim_type' => mime_content_type($nologo_file),
    'raw_content' => base64_encode(file_get_contents($nologo_file)),
];


// $sql = "INSERT INTO `tblsettings` (`setting_key`, `setting_value`) VALUES ('SITE_LOGO', '" . json_encode($site_logo) . "')";
// $con->query($sql);

$site_logo = null;
$sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_LOGO' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $data = json_decode($row['setting_value']);
    if (false !== $data) {
        $site_logo = $data;
    }
}

if (empty($site_logo)) {
    $site_logo = $no_image;
}

// $sql = "INSERT INTO `tblsettings` (`setting_key`, `setting_value`) VALUES ('SITE_LOGO', '" . json_encode($site_logo) . "')";
// $con->query($sql);

$site_banhow = null;
$sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANHOW' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $data = json_decode($row['setting_value']);
    if (false !== $data) {
        $site_banhow = $data;
    }
}

if (empty($site_logo)) {
    $site_logo = $no_image;
}

// banner Loging
// $sql = "INSERT INTO `tblsettings` (`setting_key`, `setting_value`) VALUES ('SITE_LOGO', '" . json_encode($site_banlog) . "')";
// $con->query($sql);

$site_banlog = null;
$sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANLOG' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $data = json_decode($row['setting_value']);
    if (false !== $data) {
        $site_banlog = $data;
    }
}

if (empty($site_banlog)) {
    $site_banlog = $no_image;
}

// banner Loging
// $sql = "INSERT INTO `tblsettings` (`setting_key`, `setting_value`) VALUES ('SITE_LOGO', '" . json_encode($site_banlog) . "')";
// $con->query($sql);

$site_banres = null;
$sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANRES' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $data = json_decode($row['setting_value']);
    if (false !== $data) {
        $site_banres = $data;
    }
}

if (empty($site_banres)) {
    $site_banres = $no_image;
}

// Site title
// $sql = "INSERT INTO `tblsitesettings` (`setting_key`, `setting_value`) VALUES ('SITE_TITLE', 'Untitled')";
// $con->query($sql);

$site_title = '';
$sql = "SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $site_title = $row['setting_value'];
}


// page footer 
$page_footer_content = '';
$sql = "SELECT * FROM `tblsitepages` WHERE `page_name` = 'SITE_FOOTER' LIMIT 1;";
$rs = $con->query($sql);
if ($rs) {
    $row = $rs->fetch_assoc();
    $page_footer_content = $row['page_content'];
}

?>
<style>
    .content-page {
        margin-top: 2em;
    }

    .tab-pane {
        padding: 1em;
    }
</style>
<div class="content-page">
    <div class="content">
        <div class="container">
            <h1 class="page-title">ตั้งค่าเว็บไซต์</h1>
            <hr>
            <div class="row">
                <div class="col-md-12">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#site-settings" aria-controls="site-settings" role="tab" data-toggle="tab">อัตลักษณ์ของเว็บไซต์</a></li>
                        <li role="presentation"><a href="#page-settings" aria-controls="page-settings" role="tab" data-toggle="tab">ส่วนประกอบของเว็บไซต์</a></li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="site-settings">
                            <form id="form-update-settings" class="form-horizontal" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <div class="form-group text-center">
                                                    <label class="col-md-12" style="font-size: 24px; font-weight: bold;">ชื่อเว็บไซต์</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="site_title" value="<?php echo $site_title; ?>" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- eof .row -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="thumbnail" style="background-color: #444">
                                                    <img src="data:<?php echo $site_logo->mim_type; ?>;base64, <?php echo $site_logo->raw_content; ?>" alt="logo" width="250" height="250">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="col-md-12" style="font-size: 24px; font-weight: bold;">โลโก้</label>
                                                    <div class="col-md-12">
                                                        <input type="file" name="logo" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- eof .row -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="thumbnail">
                                                    <img src="data:<?php echo $site_banlog->mim_type; ?>;base64, <?php echo $site_banlog->raw_content; ?>" alt="banlog" width="250" height="250">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="col-md-12" style="font-size: 24px; font-weight: bold;">แบนเนอร์ล็อคอิน</label>
                                                    <div class="col-md-12">
                                                        <input type="file" name="banlog" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- eof .row -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="thumbnail">
                                                    <img src="data:<?php echo $site_banres->mim_type; ?>;base64, <?php echo $site_banres->raw_content; ?>" alt="banres" width="250" height="250">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="col-md-12" style="font-size: 24px; font-weight: bold;">แบนเนอร์สมัครสมาชิก</label>
                                                    <div class="col-md-12">
                                                        <input type="file" name="banres" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="reset" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                    <span>ยกเลิก</span>
                                                </button>
                                                <button type="button" class="btn btn-primary" id="btn-update-settings">
                                                    <i class="fa fa-save"></i>
                                                    <span>บันทึก</span>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- eof .row -->
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="thumbnail">
                                                    <img src="data:<?php echo $site_banhow->mim_type; ?>;base64, <?php echo $site_banhow->raw_content; ?>" alt="banlog" width="250" height="250">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="col-md-12" style="font-size: 24px; font-weight: bold;">รูปวิธีการชำระเงิน</label>
                                                    <div class="col-md-12">
                                                        <input type="file" name="banhow" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                    </div>
                                </div>


                                <input type="hidden" name="action" value="update_settings">
                            </form>
                        </div>
                        <!-- eof .tab-pane -->
                        <div role="tabpanel" class="tab-pane" id="page-settings">
                            <form id="form-update-pages" class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="col-md-12">ส่วนท้ายของเว็บไซต์ (Footer)</label>
                                            <div class="col-md-12">
                                                <textarea name="footer_content" class="form-control summernote"><?php echo $page_footer_content; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- eof .row -->
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="reset" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                            <span>ยกเลิก</span>
                                        </button>
                                        <button type="button" class="btn btn-primary" id="btn-update-pages">
                                            <i class="fa fa-save"></i>
                                            <span>บันทึก</span>
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="action" value="update_pages">
                            </form>
                        </div>
                        <!-- eof .tab-pane -->
                    </div>

                    <!-- eof .tab-content -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $("#btn-update-settings").on('click', function() {
        const $form = $("#form-update-settings");
        const $form_data = new FormData($form[0]);

        $.ajax({
            type: "POST",
            url: 'Action/sitesettings.php',
            data: $form_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (e) => {},
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setTimeout((e) => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            },
        });
    });

    $("#btn-update-pages").on('click', function() {
        const $form = $("#form-update-pages");
        const $form_data = new FormData($form[0]);

        $.ajax({
            type: "POST",
            url: 'Action/sitesettings.php',
            data: $form_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (e) => {},
            success: (resp) => {
                let res = JSON.parse(resp);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setTimeout((e) => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.msg
                    })
                }
            },
        });
    });
</script>