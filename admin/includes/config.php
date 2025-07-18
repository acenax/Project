<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME','ecom');
$con = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$con -> set_charset("utf8");

if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>