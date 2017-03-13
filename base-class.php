<?php

require('config.php');

session_start(); 

class php_for_login {
	var $db = "";


	var $s_key = "";
	var $email_cookie_key	= "";
	var $uid_cookie_key	= "";
	var $pss_cookie_key	= "";

	function __construct() {
		global $config;

		$this->s_key= $config["s_key"];
		$this->email_cookie_key	= $this->s_key . "_email";
		$this->uid_cookie_key	= $this->s_key . "_userid";
		$this->pss_cookie_key	= $this->s_key . "_password";

		$this->db = mysqli_connect($config['db_address'], $config['db_username'], $config['db_password'], $config['db_name']) or die(mysql_error()); 

		if (mysqli_connect_errno()) {
			die("Connect failed: ".mysqli_connect_error());
		}
	}

	function getLoggedUser() {
		global $config;

		if (isset($_SESSION['uid']) && $_SESSION['uid'] >0 && isset($_SESSION['pss']) && $_SESSION['timeout']+$config['session_ex'] > time()) {
			$sql = 'Select * from users where id='.$_SESSION['uid'].' and password="'.$_SESSION['pss'].'"';
		} else if (isset($_COOKIE[$this->uid_cookie_key]) && $_COOKIE[$this->uid_cookie_key] >0 && isset($_COOKIE[$this->pss_cookie_key])) {
			$sql = 'Select * from users where id='.$_COOKIE[$this->uid_cookie_key].' and password="'.$_COOKIE[$this->pss_cookie_key].'"';
		} else
			return false;

		$query = mysqli_query($this->db, $sql);
		if (mysqli_num_rows($query)>0)
			return mysqli_fetch_assoc($query);
		return false;
	}

	function doLogin($user, $pass, $save) {
		global $config;

		$email = mysqli_real_escape_string($this->db, $user); // mysqli_real_escape_string is useful but not enough! is not necessary in this case
		$password = mysqli_real_escape_string($this->db, $pass); // mysqli_real_escape_string is useful but not enough! is not necessary in this case

		$pss = md5($password);
		$query = mysqli_query($this->db, "SELECT id FROM users WHERE email='$email' and password='$pss'") or die(mysqli_error($this->db));

		if (mysqli_num_rows($query) <= 0) {
			$result=array("status"=>false, "msg"=>"Your Email or Password is not valid.");
			session_destroy();
		} else {
			$result=array("status"=>true, "msg"=>"Ok.");

			list($uid) = mysqli_fetch_array($query);
			

			$_SESSION['uid'] = $uid;
			$_SESSION['pss'] = $pss;
			$_SESSION['email'] = $email;
			$_SESSION['timeout'] = time();

			if ($save>0) {
				$exTime = time() + $config['cookie_ex']; 
				setcookie($this->email_cookie_key, $email, $exTime); 
				setcookie($this->uid_cookie_key, $uid."", $exTime); 
				setcookie($this->pss_cookie_key, $pss, $exTime);	
			} else {
				//destroy saved cookies
				setcookie($this->email_cookie_key, $email, time() - 10); 
				setcookie($this->uid_cookie_key, $uid."", time() - 10); 
				setcookie($this->pss_cookie_key, $pss, time() - 10);
			}
		}

		return $result;
	}

	function updateUser($fullname="", $email, $nemail, $pass, $npass) {
		global $config;

		// mysqli_real_escape_string is useful but not enough! is not necessary in this case
		$fullname = mysqli_real_escape_string($this->db, $fullname);
		$email = mysqli_real_escape_string($this->db, $email); 
		$nemail = mysqli_real_escape_string($this->db, $nemail); 
		$pass = mysqli_real_escape_string($this->db, $pass); 
		$pass = md5($pass);
		$npass = mysqli_real_escape_string($this->db, $npass); 
		$npass = md5($npass);
		

		$query = mysqli_query($this->db, "update users set fullname='$fullname', email='$nemail', password='$npass' WHERE email='$email' and password='$pass'") or die(mysqli_error($this->db));

		if (mysqli_affected_rows($this->db)>0) {
			$message = array("status"=>true, "color"=>"green", "msg"=>"Your account has been updated successfully!");
		} else {
			$message = array("status"=>false, "color"=>"yellow", "msg"=>"Your entered Current Password is not valid!");
		}

		return $message;
	}

	function addUser($fullname="", $email, $pass) {
		global $config;

		// mysqli_real_escape_string is useful but not enough! is not necessary in this case
		$fullname = mysqli_real_escape_string($this->db, $fullname);
		$email = mysqli_real_escape_string($this->db, $email); 
		$pass = mysqli_real_escape_string($this->db, $pass); 
		$pass = md5($pass);

		$query = mysqli_query($this->db, "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$pass')") or die(mysqli_error($this->db));

		if (mysqli_affected_rows($this->db)>0) {
			$message = array("color"=>"green", "msg"=>"New account has been added!");
		} else {
			$message = array("color"=>"yellow", "msg"=>"Database Error! Please try again later.");
		}

		return $message;
	}

	function doLogout() {

		session_destroy();

		//destroy saved cookies
		setcookie($this->email_cookie_key, $email, time() - 10); 
		setcookie($this->uid_cookie_key, $uid."", time() - 10); 
		setcookie($this->pss_cookie_key, $pss, time() - 10);
		
		header("Location: login.php"); 
	}
}

$phpforlogin = new php_for_login();

?>