<?php
require('base-class.php');

$user = $phpforlogin->getLoggedUser();
if (!$user) {
	header("location: login.php");
	exit;
}


$message="";
if (isset($_POST['submit'])) {
	if ($_POST['action']=="update") { // update user
		if(!isset($_POST['fullname']) || $_POST['fullname']=="")
			$message=array("color"=>"yellow", "msg"=>'Full Name is required!');
		else if(!isset($_POST['pass']) || $_POST['pass']=="")
			$message=array("color"=>"yellow", "msg"=>'Current Password is required!');
		else if(!isset($_POST['email']) || $_POST['email']=="")
			$message=array("color"=>"yellow", "msg"=>'Email address is required!');
		else if(!isset($_POST['npass1']) || $_POST['npass1']=="")
			$message=array("color"=>"yellow", "msg"=>'New Password is required!');
		else if($_POST['npass2'] != $_POST['npass1'])
			$message=array("color"=>"yellow", "msg"=>'New Passwords is not match!');
		else {
			$message = $phpforlogin->updateUser($_POST['fullname'], $user['email'], $_POST['email'], $_POST['pass'], $_POST['npass1']);
			if ($message["status"]) {
				$user['fullname'] = $_POST['fullname'];
				$user['email'] = $_POST['email'];
			}
		}
	} else if ($_POST['action']=="add") { // add new user
		if(!isset($_POST['fullname']) || $_POST['fullname']=="")
			$message=array("color"=>"yellow", "msg"=>'Full Name is required!');
		else if(!isset($_POST['email']) || $_POST['email']=="")
			$message=array("color"=>"yellow", "msg"=>'Email address is required!');
		else if(!isset($_POST['npass1']) || $_POST['npass1']=="")
			$message=array("color"=>"yellow", "msg"=>'New Password is required!');
		else if($_POST['npass2'] != $_POST['npass1'])
			$message=array("color"=>"yellow", "msg"=>'New Passwords is not match!');
		else 
			$message = $phpforlogin->addUser($_POST['fullname'], $_POST['email'], $_POST['npass1']);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User panel</title>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
	<div class="usersection">
	<div class="hello">hi <?php echo $user['fullname']; ?>,</div> 
	<h2>User panel</h2> 
	<ul>
		<li><a href="logout.php">Logout</a></li>
	</ul>
	<br>
	
	<?php 
		if ($message!="")
			echo '<div class="message '.$message["color"].'">'.$message["msg"].'</div>';
	?>
	<div class="updateprofilesection">
		<h3>Update profile</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<input type="hidden" name="action" value="update">
			<table border="0"> 
				<tr><td><input type="text" name="fullname" placeholder="Full name" value="<?php echo $user['fullname']; ?>" maxlength="50" required></td></tr> 
				<tr><td><input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" maxlength="50" required></td></tr> 
				<tr><td><input type="password" name="pass" placeholder="Current Password" pattern=".{6,}" title="6 characters minimum" maxlength="50" required></td></tr> 
				<tr><td><input type="password" name="npass1" placeholder="New Password" pattern=".{6,}" title="6 characters minimum" maxlength="50" required></td></tr> 
				<tr><td><input type="password" name="npass2" placeholder="Re-New Password" pattern=".{6,}" title="6 characters minimum" maxlength="50" required></td></tr> 
				<tr><td colspan="2" align="right"> 
					<input type="submit" name="submit" value="Update"> 
				</td></tr> 
			</table> 
		</form> 
	</div>	
	<div class="addusersection">
		<h3>Add new user</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="action" value="add">
			<table border="0"> 
				<tr><td><input type="text" name="fullname" placeholder="Full Name" maxlength="50" required></td></tr> 
				<tr><td><input type="email" name="email" placeholder="Email"  maxlength="50" required></td></tr> 
				<tr><td><input type="password" name="npass1" placeholder="Password" pattern=".{6,}" title="6 characters minimum" maxlength="50" required></td></tr> 
				<tr><td><input type="password" name="npass2" placeholder="Re-Password" pattern=".{6,}" title="6 characters minimum" maxlength="50" required></td></tr> 
				<tr><td colspan="2" align="right"> 
					<input type="submit" name="submit" value="Add User"> 
				</td></tr> 
			</table> 
		</form> 
	</div>
	</div>
</body>
</html>
