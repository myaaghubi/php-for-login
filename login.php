<?php 

require('base-class.php');

$message = "";

if (isset($_POST['submit'])) {
	$saveStatus = $_POST['save'];
	if(!isset($_POST['email']))
		$message='Email is required.';
	else if(!isset($_POST['password']))
		$message='Password is required.';
	else {
		$login = $phpforlogin->doLogin($_POST['email'], $_POST['password'], $saveStatus);
		if ($login!="" && $login['status']) {
			header('location:user-panel.php');
			exit;
		} else {
			$message = $login['msg'];
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
			<tr><td><input type="checkbox" id="save" name="save"><label for="save"> Remember you login</label></td></tr> 
			<tr><td colspan="2" align="left"> 
				<?php 
				if ($message!='')
					echo '<span style="color:red">'.$message.'</span><br>'; 
				?>
				<input type="submit" name="submit" style="float:right" value="Login"> 
			</td></tr> 
		</table> 
	</form> 
	</div>
</body>
</html>
