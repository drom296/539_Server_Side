<?php
// initiate session
session_start();
// check that form has been submitted and that name is not empty
if ($_POST && !empty($_POST['name'])) {
	// set session variable
	$_SESSION['name'] = $_POST['name'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Session test 2</title>
	</head>
	<body>
		<?php
		// check session variable is set
		if (isset($_SESSION['name'])) {
			// if set, greet by name
			echo 'Hi, ' . $_SESSION['name'] . '. <a href="session03.php">Next</a>';
		} else {
			// if not set, send back to login
			echo 'Who are you? <a href="session01.php">Login</a>';
		}
		?>
	</body>
</html>
