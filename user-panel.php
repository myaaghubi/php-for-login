<?php
//load database configuration 
include 'db-config.php';

//checks cookies
if(isset($_COOKIE[$email_cookie_key])){ 
	$email = $_COOKIE[$email_cookie_key]; 
	$pass = $_COOKIE[$password_cookie_key]; 
	$row = mysql_query("SELECT * FROM users WHERE email = '$email'")or die(mysql_error()); 

	$info = mysql_fetch_array( $row );
	
	//check validation for saved password on cookie
	if ($pass != $info['password']){
		header("Location: login.php"); 
	}
	echo 'Hi '.$info['fullname'].',';
} else {
	header("Location: login.php"); 
}
?>
<br>
<ul>
<li><a href="new-user.php">Add new user</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
