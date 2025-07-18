<script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
<script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
<link rel="stylesheet"
    href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
<script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
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
        <div class="col-12 mb-5">
            <div class="header-payment">
                <span style="font-size: 20px;" class="ms-3">
                    <i class="fas fa-user-circle" style="font-size: 30px;"></i>
                    ยินดีต้อนรับ ::.
                    <?= $rows_user['user_username'] ?>
                </span>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-payment">
                <?php include_once('sildeprofile.php'); ?>
                <div class="profile-content">
                    <div class="sub-content">
                        <div class="input-profile">
                            <div class="row">

                                <?php
                                $chkaddress = $con->query("SELECT * FROM `tbluseraddress` WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
                                if ($chkaddress->num_rows == 0) {
                                    ?>
                                    <div class="col-lg-12 mb-3">
                                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="far fa-plus"></i>
                                            เพิ่มที่อยู่
                                        </button>
                                    </div>
                                <?php } else { ?>
                                    <?php $rowsaddress = $chkaddress->fetch_assoc(); ?>
                                    <div class="col-lg-6 mb-3">
                                        <span>บ้านเลขที่</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_number'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>หมู่ที่</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_group'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>ซอย</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_alley'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>ถนน</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_separate'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>ตำบล / แขวง</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_district'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>อำเภอ / เขต</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_canton'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>จังหวัด</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_province'] ?>" disabled="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <span>รหัสไปรษณีย์</span>
                                        <input type="text" class="form-control"
                                            value="<?= $rowsaddress['userAddress_post'] ?>" disabled="">
                                    </div>
                                    <div class="text-danger mt-2">
                                        <button type="button" class="btn btn-primary"
                                            onclick="getAddress('<?= $rowsaddress['user_id'] ?>')">
                                            แก้ไขข้อมูล
                                        </button>
                                    </div>
                                <?php } ?>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="save_address">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มที่อยู่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="save_address">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">บ้านเลขที่</label>
                                <input type="text" class="form-control" name="userAddress_number">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" name="userAddress_group">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ซอย</label>
                                <input type="text" class="form-control" name="userAddress_alley">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ถนน</label>
                                <input type="text" class="form-control" name="userAddress_separate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ตำบล</label>
                                <input type="text" class="form-control" name="userAddress_district" id="district1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">อำเภอ</label>
                                <input type="text" class="form-control" name="userAddress_canton" id="amphoe1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">จังหวัด</label>
                                <input type="text" class="form-control" name="userAddress_province" id="province1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">รหัสไปรษณีย์</label>
                                <input type="text" class="form-control" name="userAddress_post" id="zipcode1">
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

<div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขที่อยู่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_address">
                    <input type="hidden" name="action" value="edit_address">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">บ้านเลขที่</label>
                                <input type="text" class="form-control" name="userAddress_number"
                                    id="edituserAddress_number">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" name="userAddress_group"
                                    id="edituserAddress_group">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">ซอย</label>
                                <input type="text" class="form-control" name="userAddress_alley"
                                    id="edituserAddress_alley">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="">แยก</label>
                                <input type="text" class="form-control" name="userAddress_separate"
                                    id="edituserAddress_separate">
                            </div>
                        </div>

                        <?php if ($rowsaddress['userAddress_district'] == null) { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">ตำบล</label>
                                    <input type="text" class="form-control" name="userAddress_district" id="district">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">ตำบล</label>
                                    <input type="text" class="form-control" name="userAddress_district" id="district"
                                        value="<?= $rowsaddress['userAddress_district'] ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($rowsaddress['userAddress_canton'] == null) { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">อำเภอ</label>
                                    <input type="text" class="form-control" name="userAddress_canton" id="amphoe">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">อำเภอ</label>
                                    <input type="text" class="form-control" name="userAddress_canton"
                                        value="<?= $rowsaddress['userAddress_canton'] ?>" id="amphoe">
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($rowsaddress['userAddress_province'] == null) { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">จังหวัด</label>
                                    <input type="text" class="form-control" name="userAddress_province" id="province">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">จังหวัด</label>
                                    <input type="text" class="form-control" name="userAddress_province" id="province"
                                        value="<?= $rowsaddress['userAddress_province'] ?>">
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($rowsaddress['userAddress_post'] == null) { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" name="userAddress_post" id="zipcode">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" name="userAddress_post" id="zipcode"
                                        value="<?= $rowsaddress['userAddress_post'] ?>">
                                </div>
                            </div>
                        <?php } ?>
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


<script>
    <?php if ($rowsaddress['userAddress_district'] != null) { ?>
        $.Thailand({
            $district: $('#district'), // input ของตำบล ของแก้ไขที่อยู่
            $amphoe: $('#amphoe'), // input ของอำเภอ ของแก้ไขที่อยู่
            $province: $('#province'), // input ของจังหวัด ของแก้ไขที่อยู่
            $zipcode: $('#zipcode'), // input ของรหัสไปรษณีย์ ของแก้ไขที่อยู่
        });
    <?php } else { ?>
        $.Thailand({
            $district: $('#district1'), // input ของตำบล  ของเพิ่มที่อยู่
            $amphoe: $('#amphoe1'), // input ของอำเภอ ของเพิ่มที่อยู่
            $province: $('#province1'), // input ของจังหวัด ของเพิ่มที่อยู่
            $zipcode: $('#zipcode1'), // input ของรหัสไปรษณีย์ ของเพิ่มที่อยู่
        });
<?php } ?>
</script>

<script>
    $(function () {
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

        $.map(unindexed_array, function (n, i) {
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
<script src="Assets/Js/mainJs.js"></script>