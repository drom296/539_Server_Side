<?php
if (isset($_REQUEST['logout']) && $_REQUEST['logout']) {
	setcookie("username", "", time() - 3600);
	setcookie("password", "", time() - 3600);
	setcookie("username", "", time() - 3600, $path, $domain, $secure);
	setcookie("password", "", time() - 3600, $path, $domain, $secure);

	unset($_COOKIE['username']);
	unset($_COOKIE['password']);
	unset($_POST);
	
	header("Location:login.php");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Success!</title>
	</head>
	<body>
		<h1>Success!</h1>
		<h2>$_COOKIE</h2>
		<?php
		foreach ($_COOKIE as $k => $v)
			echo "$k=$v<br />";
		?>
		<a href="login.php">Back to login</a>
		<form action="" method="POST">
			<input type="submit" name="logout" value="logout"/>
			<br />
			<br />
		</form>
	</body>
</html>
