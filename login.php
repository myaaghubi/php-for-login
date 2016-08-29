<?php 

//load database configuration 
include 'db-config.php';
$message = "";
//first check logined cookie
if(isset($_COOKIE[$email_cookie_key])){
	
	$email = $_COOKIE[$email_cookie_key]; 
	$password = $_COOKIE[$password_cookie_key];
	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'")or die(mysqli_error($connection));

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
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '".$email."'")or die(mysqli_error($connection));

	$row2 = mysqli_num_rows($row);
	if ($row2 == 0){
		$message='This email does not exist.';
	}
	while($info = mysqli_fetch_array( $row )){
		$password = md5($password);

		//check password validation
		if ($password != $info['password']){
			$message='Incorrect password!';
		} else{
			$week = time() + (7 * 3600); 
			setcookie($email_cookie_key, $email, $week); 
			setcookie($password_cookie_key, $password, $week);	 
			header("Location: user-panel.php"); 
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
	<div class="loginsection">
	<h2>Login</h2> 

	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
		<table border="0"> 
			<tr><td><input type="email" name="email" placeholder="Email" maxlength="50"></td></tr> 
			<tr><td><input type="password" name="password" placeholder="Password" maxlength="50"></td></tr> 
			<tr><td colspan="2" align="left"> 
				<?php echo '<span style="color:red">'.$message.'</span>'; ?>
				<input type="submit" name="submit" style="float:right" value="Login"> 
			</td></tr> 
		</table> 
	</form> 
	</div>
</body>
</html>
