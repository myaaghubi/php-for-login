<?php
	//load database configuration 
	include 'db-config.php';
	
	//make expired time
	$expired_time = time() - 10; 
	
	//destroy saved cookies
	setcookie($email_cookie_key, "", $expired_time); 
	setcookie($password_cookie_key, "", $expired_time);	
	
	header("Location: login.php"); 
?> 
