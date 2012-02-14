<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Session test 3</title>
	</head>
	<body>
		<?php
		// check whether session variable is set
		if (isset($_SESSION['name'])) {
			// if set, greet by name
			echo 'Hi, ' . $_SESSION['name'] . '. See, I remembered your name!<br />';
			// unset session variable
			unset($_SESSION['name']);
			// invalidate the session cookie
			if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time() - 86400, '/');
			}
			ob_end_flush();
			// end session
			session_destroy();
			echo '<a href="session02.php">Page 2</a>';
		} else {
			// display if not recognized
			echo 'Sorry, I don\'t know you.<br />';
			echo '<a href="session01.php">Login</a>';
		}
	?>
	</body>
</html>
