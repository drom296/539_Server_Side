<?php
$username = "admin";
$password = "admin";

$expire = time() + 60 * 2;	// two minutes from now
$path = "/~pjm8632/";
$domain = "nova.it.rit.edu";
$secure = false;

// check cookies
if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
	if ($_COOKIE['username'] == $username && $_COOKIE['password'] == $password){
		header("Location:success.php");
	}
}

// check POST
if(isset($_POST['username']) && isset($_POST['password'])){
	
	if ($_POST['username'] == $username && $_POST['password'] == $password) {
		// set the cookies
		setcookie("username", $username, $expire, $path, $domain, $secure);
		setcookie("password", $password, $expire, $path, $domain, $secure);
	
		header("Location:success.php");
	} else {
		// header("Location:http://www.wizards.com");
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>Log In</title>
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<table border="0" cellpadding="5">
			<tr><th align="right">username:</th><td><input type="text" name="username"/></td></tr>
			<tr><th align="right">password:</th><td><input type="password" name="password"/><br/></td></tr>
			<tr><td></td><td><input type="submit" value="send it"/></td></tr>
		</table>
	</form>

</body>
</html>