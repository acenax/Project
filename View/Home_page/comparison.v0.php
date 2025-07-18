<br><br><br>

<style>
.body-comparison {
    border: 5px solid #212529;
    border-radius: 10px;
    background-color: #fff;
    padding: 60px 40px;
    box-shadow: 5px 5px #cecccc;
}

.bank-comparison {
    background-color: #ddd;
    padding: 5px 10px;
    text-align: center;
    border-radius: 15px;
}
</style>
<!-- เริ่ม -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="header-comparison">
                <h3 class="text-center">เปรียบเทียบ</h3>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="body-comparison">
                <div class="row">
                    <div class="container py-5">
                        <div class="body-comparision">
                            <form action="./?compairision" method="get">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-left">เปรียบเทียบสินค้า</h4>
                                    </div>
                                    <div class="col-lg-6 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">เปรียบเทียบ<i
                                                class="fas fa-arrow-alt-right ml-1"></i></button>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                </div>
                                <!-- เริ่ม -->
                                <!-- เริ่ม -->
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_1">เลือกสินค้าชิ้นแรก</label>
                                            <select name="product_1" id="product_1" class="form-control" required>
                                                <option disabled selected value="">เลือก</option>
                                                <?php
                                                $sql = "SELECT * FROM tblproduct";
                                                $query = mysqli_query($con, $sql);
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                <option value="<?= $row['product_id'] ?>">
                                                    <?php echo $row['product_name'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_2">เลือกสินค้าชิ้นที่สอง</label>
                                            <select name="product_2" id="product_2" class="form-control" required>
                                                <option disabled selected value="">เลือก</option>
                                                <?php
                                                $sql = "SELECT * FROM tblproduct";
                                                $query = mysqli_query($con, $sql);
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                <option value="<?= $row['product_id'] ?>">
                                                    <?php echo $row['product_name'] ?>
                                                </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="comparison" value="1">
                                <div class="row">
                                    <?php
                                    if (isset($_GET['product_1'])) { ?>
                                    <?php
                                        $product_id = $_GET['product_1'];
                                        $sql = "SELECT * FROM tblproduct as pd join tblproduct_detail as pddd 
                                        WHERE pd.product_id = '$product_id' AND pddd.product_id = '$product_id'";
                                        $query = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                    <div class="col-md-6 text-center">
                                        <img src="admin/assets/images/product/<?= $row['product_picshow'] ?>"
                                            style="width: 400px; height: 350px;" class="mb-3 " alt="">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ชื่อสินค้า</th>
                                                    <td>
                                                        <?= $row['product_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ราคา</th>
                                                    <td>
                                                        <?= $row['product_price'] ?> บาท
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">จำนวน</th>
                                                    <td>
                                                        <?= $row['product_qty'] ?> ชื้น
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">รายละเอียด</th>
                                                    <td>
                                                        <?= $row['product_subdetail'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php
                                    if (isset($_GET['product_2'])) { ?>
                                    <?php
                                        $product_id = $_GET['product_2'];
                                        $sql = "SELECT * FROM tblproduct as pd join tblproduct_detail as pddd 
                                        WHERE pd.product_id = '$product_id' AND pddd.product_id = '$product_id'";
                                        $query = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                    <div class="col-md-6 text-center">
                                        <img src="admin/assets/images/product/<?= $row['product_picshow'] ?>"
                                            style="width: 400px; height: 350px;" class="mb-3 " alt="">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ชื่อสินค้า</th>
                                                    <td>
                                                        <?= $row['product_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ราคา</th>
                                                    <td>
                                                        <?= $row['product_price'] ?> บาท
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">จำนวน
                                                    </th>
                                                    <td>
                                                        <?= $row['product_qty'] ?> ชื้น
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">รายละเอียด</th>
                                                    <td>
                                                        <?= $row['product_detail'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                    </body>

                                    </html>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- eof .row -->
</form>