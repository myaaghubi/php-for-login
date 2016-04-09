<?php 

//load database configuration 
include 'db-config.php';

//Is form submitted?
if (isset($_POST['submit'])) { 
	//check empty fields
	if (!$_POST['fullname'] | !$_POST['email'] | !$_POST['password'] | !$_POST['password2'] ) {
		die('Please fill all fields');
	}

	$usercheck = $_POST['email'];
	$row = mysql_query("SELECT email FROM users WHERE email = '$usercheck'") or die(mysql_error());
	$row2 = mysql_num_rows($row);

	//if the name exists it gives an error
	if ($row2 != 0) {
		die('This email "'.$_POST['email'].'" already exists.');
	}

	//both passwords must be match
	if ($_POST['password'] != $_POST['password2']) {
		die('Your passwords did not match. ');
	}

	$_POST['password'] = md5($_POST['password']);

	if (!get_magic_quotes_gpc()) {
		$_POST['password'] = addslashes($_POST['password']);
		$_POST['email'] = addslashes($_POST['email']);
	}

	$insert = "INSERT INTO users (fullname, email, password) VALUES ('".$_POST['fullname']."', '".$_POST['email']."', '".$_POST['password']."')";
	mysql_query($insert);
?>

<h1>New user "<?php echo $_POST['email']; ?>" added to database. <a href="user-panel.php">Return</a></h1>

<?php 
} else {	
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table border="0">
	<tr><td>Fullname:</td><td>
	<input type="text" name="fullname" maxlength="50">
	</td></tr>
	<tr><td>Email(username):</td><td>
	<input type="text" name="email" maxlength="50">
	</td></tr>
	<tr><td>Password:</td><td>
	<input type="password" name="password" maxlength="50">
	</td></tr>
	<tr><td>Confirm Password:</td><td>
	<input type="password" name="password2" maxlength="50">
	</td></tr>
	<tr><th colspan=2>
	<input type="submit" name="submit" value="Register">
	</th></tr>
	</table>
	</form>
<?php
}
?> 