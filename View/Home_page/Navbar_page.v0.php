<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="./?home"><img src="./images/logo3.png" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
                        <a class="nav-link" href="./?shop">
                        <i class="far fa-home"></i>
                            ประชาสัมพันธ์
                        </a>
                    </li> -->

                <li class="nav-item">
                    <a class="nav-link" href="./?shop">
                        <i class="fas fa-boxes"></i>
                        สินค้าทั้งหมด
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-search"></i>
                        หมวดหมู่สินค้า
                    </a>

                    <ul class="dropdown-menu">
                        <?php
                        $type_navbar = $con->query("SELECT * FROM `tblproducttype`");
                        while ($row_tpye_nav = $type_navbar->fetch_assoc()) {
                            ?>
                            <li><a class="dropdown-item" href="./?gettype=<?= $row_tpye_nav['Type_id'] ?>">
                                    <?= $row_tpye_nav['Type_name'] ?></a></li>
                        <?php } ?>
                    </ul>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fal fa-money-check-alt"></i>
                        สถานะสินค้า
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="./?payment">
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

                <li class="nav-item">
                    <a class="nav-link" href="./?comparison">
                        <i class="fas fa-clone"></i>
                        เปรียบเทียบสินค้า
                    </a>
                </li>


            </ul>
            <style>
                @media screen and (max-width: 400px) {
                    .nav-mobile {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        justify-content: space-around;
                    }
                }
            </style>

            <ul class="navbar-nav mb-2 mb-lg-0 nav-mobile">
                <li class="nav-item">

                    <?php
                    $total_quantity = 0;
                    if (isset($_SESSION['cart'])) {

                        foreach ($_SESSION['cart']['product_id'] as $key => $val) {
                            $rowcartitem = $con->query("SELECT * FROM tblproduct WHERE product_id = ${key}")->fetch_assoc();
                            $total_quantity += $val;
                        }
                        ?>
                        <style>
                            .icon-cart {
                                margin-top: -5px;
                                margin-left: -10px;
                            }

                            .text-cart {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                background-color: red;
                                height: 19px;
                                width: 20px;
                                border-radius: 100%;
                                color: #fff;
                                font-family: Mitr;
                                margin-right: -40px;
                                margin-top: -13px;
                                z-index: 999;
                            }
                        </style>

                        <a class="nav-link" href="./?Cart_shop">
                            <span class="text-cart ps-1 pe-1">
                                <?= $total_quantity; ?>
                            </span>
                            <div class="icon-cart">
                                <i class="fas fa-shopping-cart" style="font-size:20px ;"> </i>
                            </div>
                        </a>

                    <?php } else { ?>
                        <a class="nav-link" href="./?Cart_shop">
                            <div class="icon-cart">
                                <i class="fas fa-shopping-cart" style="font-size:20px ;"> </i>
                            </div>
                        </a>
                    <?php } ?>
                </li>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./?Profile">
                            <i class="fas fa-user-circle"></i>
                            โปรไฟล์
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">|</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?logout">
                            <i class="fal fa-sign-out-alt"></i>
                            ออกจากระบบ
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./?register">
                            <i class="fas fa-user-plus"></i>
                            สมัครสมาชิก
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">|</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?login">
                            <i class="fal fa-sign-out-alt"></i>
                            เข้าสู่ระบบ
                        </a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</nav>