<?php
$logo = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_LOGO' LIMIT 1;")->fetch_assoc();
if (!empty($logo)) {
    $logo = json_decode($logo['setting_value']);
}
$site_title = $con->query("SELECT * FROM `tblsitesettings` WHERE `setting_key` = 'SITE_TITLE' LIMIT 1;")->fetch_assoc();

$cart_item_qty = 0;
if (!empty($_SESSION['cart']['product_id'])) {
    foreach ($_SESSION['cart']['product_id'] as $id => $qty) {
        $cart_item_qty += $qty;
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="./?home" title="<?php echo (!empty($site_title)) ? $site_title['setting_value'] : ''; ?>">
            <?php if (!empty($logo)) : ?>
                <img src="data:<?php echo $logo->mim_type; ?>;base64, <?php echo $logo->raw_content; ?>" alt="logo" height="50">
            <?php else : ?>
                <span class="py-2">
                    <small class="bg-white text-dark text-center px-2 py-3 rounded-pill fs-6">LOGO</small>
                </span>
            <?php endif; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                <li class="nav-item">
                    <a class="nav-link" href="./?shop">
                        <i class="fas fa-boxes"></i>
                        สินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./?comparison">
                        <?php if (!empty($_SESSION['comparison'])) : ?>
                            <span class="position-relative">
                                <i class="fas fa-clone"></i>
                                <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo sizeof($_SESSION['comparison']); ?>
                                </span>
                            </span>
                        <?php else : ?>
                            <i class="fas fa-clone"></i>
                        <?php endif; ?>
                        <span>เปรียบเทียบสินค้า</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fal fa-money-check-alt"></i>
                        สถานะสินค้า
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="./?payment" target="_blank">
                                แจ้งชำระเงิน
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./?Status_track">
                                ติดตามสถานะสินค้า
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./?howtopayment">
                        <i class="far fa-question-circle"></i>
                        วิธีชำระเงิน
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./?Cart_shop">
                        <?php if (!empty($_SESSION['cart']['product_id'])) : ?>
                            <span class="position-relative">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo $cart_item_qty; ?>
                                </span>
                            </span>
                        <?php else : ?>
                            <i class="fas fa-shopping-cart"></i>
                        <?php endif; ?>

                        <span>ตะกร้าสินค้า</span>

                    </a>
                </li>

                <?php if (isset($_SESSION['login'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            <?php echo (!empty($_SESSION['user_fullname'])) ? $_SESSION['user_fullname'] : 'โปรไฟล์'; ?>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="./?Profile">
                                    โปรไฟล์
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./?logout">
                                    ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            เข้าสู่ระบบ
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="./?login">
                                    เข้าสู่ระบบ
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./?register">
                                    สมัครสมาชิก
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>