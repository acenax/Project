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

<?php
$banhow = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_BANHOW' LIMIT 1;")->fetch_assoc();
if (!empty($banhow)) {
    $banhow = json_decode($banhow['setting_value']);
}
$site_title = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;")->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="body-payment">
            <div class="col-lg-8" title="<?php echo (!empty($site_title)) ? $site_title['setting_value'] : ''; ?>">
                    <?php if (!empty($banhow)) : ?>
                        <img src="data:<?php echo $banhow->mim_type; ?>;base64, <?php echo $banhow->raw_content; ?>" alt="banhow" width="150%"  alt="">
                    <?php else : ?>
                        <span class="py-2">
                            <small class="bg-white text-dark text-center px-2 py-3 rounded-pill fs-6">BANHOW</small>
                        </span>
                    <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './Action/message.php';?>