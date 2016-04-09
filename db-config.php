<?php
$db_address  = ""; // "127.0.0.1";
$db_name     = ""; // "test";
$db_username = ""; // "root";
$db_password = ""; // "";

$site_security_key = ""; //try to set strong key

$email_cookie_key   = $site_security_key . "_email";
$password_cookie_key= $site_security_key . "_password";

$connection = mysqli_connect($db_address, $db_username, $db_password, $db_name) or die(mysql_error()); 
mysql_select_db($db_name) or die(mysql_error()); 
?>
