<?php 

//load database configuration 
include 'db-config.php';

//first check logined cookie
if(isset($_COOKIE[$email_cookie_key])){
	
	$email = $_COOKIE[$email_cookie_key]; 
	$password = $_COOKIE[$password_cookie_key];
	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'")or die(mysql_error());

	while($info = mysqli_fetch_array( $row )){
		if ($password != $info['password']){}
		else{
			header("Location: user-panel.php");
		}
	}
}

//login form is submitted ?
if (isset($_POST['submit'])) {
	if(!$_POST['email']){
		die('Email is required.');
	}
	if(!$_POST['password']){
		die('Password is required.');
	}

	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '".$_POST['email']."'")or die(mysql_error());

	$row2 = mysqli_num_rows($row);
	if ($row2 == 0){
		die('The user "'.$_POST['email'].'" is invalid. <a href="login.php">try again</a>.');
	}
	while($info = mysqli_fetch_array( $row )){
		$_POST['password'] = stripslashes($_POST['password']);
		$info['password'] = stripslashes($info['password']);
		$_POST['password'] = md5($_POST['password']);

		//check password validation
		if ($_POST['password'] != $info['password']){
			die('Incorrect password! <a href="login.php">try again</a>.');
		} else{
			$_POST['email'] = stripslashes($_POST['email']); 
			$week = time() + (7 * 3600); 
			setcookie($email_cookie_key, $_POST['email'], $week); 
			setcookie($password_cookie_key, $_POST['password'], $week);	 
			header("Location: user-panel.php"); 
		}
	}
}
else {
?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
	<table border="0"> 
	<tr><td colspan=2><h1>Login</h1></td></tr> 
	<tr><td>Email:</td><td> 
	<input type="email" name="email" maxlength="50"> 
	</td></tr> 
	<tr><td>Password:</td><td> 
	<input type="password" name="password" maxlength="50"> 
	</td></tr> 
	<tr><td colspan="2" align="right"> 
	<input type="submit" name="submit" value="Login"> 
	</td></tr> 
	</table> 
	</form> 
<?php 
}
?> 
