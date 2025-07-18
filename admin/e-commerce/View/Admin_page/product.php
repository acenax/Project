<?php
$product_file_dir = sprintf('%s%s', '../', PRODUCT_FILE_DIR);

if (isset($_GET['add'])) {
    require_once('product/add.php');
} else if (isset($_GET['edit'])) {
    require_once('product/edit.php');
} else {
    require_once('product/home.php');
}