<?php
//load database configuration 
include 'db-config.php';
$email ="";
$fname = "";
$message = "";
$message_type = 0;
$hello = "";
//checks cookies
if(isset($_COOKIE[$email_cookie_key])){ 
	$email = $_COOKIE[$email_cookie_key]; 
	$pass = $_COOKIE[$password_cookie_key]; 
	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'")or die(mysqli_error($connection)); 

	$info = mysqli_fetch_array( $row );
	
	//check validation for saved password on cookie
	if ($pass != $info['password']){
		header("Location: login.php"); 
	}
	$fname = $info['fullname'];
	
	if (isset($_POST['updateuser'])) {
		if(!$_POST['fullname']){
			$message='Full name is required.';
		} else {
			if(isset($_POST['password'])){
				if (!isset($_POST['password2']))
					$message='Re-Password is required.';
				else if ($_POST['password']!=$_POST['password2'])
					$message='Password and Re-Password is not match.';
				else if ($_POST['password']==$_POST['password2']){
					$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
					$password = mysqli_real_escape_string($connection, $_POST['password']);
					
					if (strlen($fullname)==0||strlen($password)==0)
						$message="Input error! Please insert valid data.";
					else {
						$row = mysqli_query($connection, "UPDATE users set password = '".md5($password)."', fullname='".$fullname."' where email='".$email."'")or die(mysqli_error($connection));
						$message = "Updated successfuly";
						$message_type = 1;
					}
				}
			} else {
				$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
				$password = mysqli_real_escape_string($connection, $_POST['password']);
				
					
				if (strlen($fullname)==0||strlen($password)==0)
					$message="Input error! Please insert valid data.";
				else {
					$row = mysqli_query($connection, "UPDATE users set fullname='".$fullname."' where email='".$email."'")or die(mysqli_error($connection));
					$message = "Updated successfuly";
					$message_type = 1;
				}
			}
		}
	} else if (isset($_POST['adduser'])) {
		if(!$_POST['au_email']){
			$message='Email is required.';
		} else {
			$row = mysqli_query($connection,"SELECT email FROM users WHERE email = '".$_POST['au_email']."'") or die(mysqli_error($connection));
			$row2 = mysqli_num_rows($row);

			//if the name exists it gives an error
			if ($row2 != 0) {
				$message ='This email "'.$_POST['au_email'].'" already exists.';
			} else if(!$_POST['au_fullname']){
				$message='Full name is required.';
			} else if(isset($_POST['au_password'])){
				if (!isset($_POST['au_password2']))
					$message='Re-Password is required.';
				else if ($_POST['au_password']!=$_POST['au_password2'])
					$message='Password and Re-Password is not match.';
				else if ($_POST['au_password']==$_POST['au_password2']){
					$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
					$email = mysqli_real_escape_string($connection, $_POST['email']);
					$password = mysqli_real_escape_string($connection, $_POST['password']);
					
					if (strlen($fullname)==0||strlen($email)==0||strlen($password)==0)
						$message="Input error! Please insert valid data.";
					else {
						$row = mysqli_query($connection, "INSERT INTO users (fullname, email, password) VALUES ('".$fullname."', '".$email."', '".md5($password)."')")or die(mysqli_error($connection));
						$message = "New user added successfuly";
						$message_type = 1;
					}
				}
			}
		}
	}
	
	$row = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'")or die(mysqli_error()); 

	$info = mysqli_fetch_array( $row );
	if ($pass != $info['password']){
		header("Location: login.php"); 
	}
	$fname = $info['fullname'];
	$hello = 'Hi '.$info['fullname'].',';
	
} else {
	header("Location: login.php"); 
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
	<div class="hello"><?php echo $hello; ?></div> 
	<h2>User panel</h2> 
	<ul>
		<li><a href="logout.php">Logout</a></li>
	</ul>
	<br>
	
	<?php if (strlen($message)>0)
		if ($message_type==0) echo '<div class="message yellow">'.$message.'</div>';
		else echo '<div class="message green">'.$message.'</div>';
	?>
	<div class="updateprofilesection">
		<h3>Update profile</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
		<table border="0"> 
			<tr><td><input type="text" name="fullname" placeholder="Full name" value="<?php echo $fname; ?>" maxlength="50"></td></tr> 
			<tr><td><input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" maxlength="50" readonly></td></tr> 
			<tr><td><input type="password" name="password" placeholder="Password" maxlength="50"></td></tr> 
			<tr><td><input type="password" name="password2" placeholder="Re-Password" maxlength="50"></td></tr> 
			<tr><td colspan="2" align="right"> 
				<input type="submit" name="updateuser" value="Update"> 
			</td></tr> 
		</table> 
		</form> 
	</div>	
	<div class="addusersection">
		<h3>Add new user</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
		<table border="0"> 
			<tr><td><input type="text" name="au_fullname" placeholder="Full name" maxlength="50"></td></tr> 
			<tr><td><input type="email" name="au_email" placeholder="Email"  maxlength="50"></td></tr> 
			<tr><td><input type="password" name="au_password" placeholder="Password" maxlength="50"></td></tr> 
			<tr><td><input type="password" name="au_password2" placeholder="Re-Password" maxlength="50"></td></tr> 
			<tr><td colspan="2" align="right"> 
				<input type="submit" name="adduser" value="Add User"> 
			</td></tr> 
		</table> 
		</form> 
	</div>
	</div>
</body>
</html>
