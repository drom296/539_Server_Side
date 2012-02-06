<?php
$username = "admin";
$password = "admin";

$expire = time() + 60 * 2;
// two minutes from now
$path = "/~pjm8643/";
$domain = "nova.it.rit.edu";
$secure = false;

if ($_POST['username'] == $username && $_POST['password'] == $password) {
	// set the cookies
	setcookie("username", $_POST['username'], $expire, $path, $domain, $secure);
	
	setcookie("password", $_POST['password'], $expire, $path, $domain, $secure);

	header("Location:success.php");
} else {
	header("Location:http://www.wizards.com");
}
?>