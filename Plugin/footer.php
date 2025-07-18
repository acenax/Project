<?php
$row = $con->query("SELECT * FROM `tblsitepages` WHERE `page_name` = 'SITE_FOOTER' LIMIT 1;")->fetch_assoc();
?>
<footer>
    <?php if (!empty($row)): ?>
        <?php echo $row['page_content']; ?>
    <?php elseif (USER_LEVEL <= $_SESSION['user_level']): ?>
        <div class="container-fluid">
            <div class="col-12">
                <p class="text-center">
                    <a href="/admin/e-commerce/?settings">คลิกที่นี้</a> เพื่อเพิ่มข้อมูลในส่วนนี้
                </p>
            </div>
        </div>
    <?php else: ?>
    <?php endif; ?>
</footer>
</body>

</html>