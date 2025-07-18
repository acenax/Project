<?php
session_start();
error_reporting(1);
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'com_ecom');
$con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$con->set_charset("utf8");
date_default_timezone_set('Asia/Bangkok');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function alert_msg($status, $msg = null, $data = [])
{
    return json_encode(
        array(
            "status" => $status,
            "data" => $data,
            "msg" => $msg,
        ),
        JSON_UNESCAPED_UNICODE
    );
}

function uniqidReal($lenght)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}