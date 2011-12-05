<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Simple Form Demo</title>
</head>
<body>

<form action = "" method="GET">
	<table>
		<tr>
			<td>First</td>
			<td><input type="text" name="first" size="50" /></td>
		</tr>
		<tr>
			<td>Last</td>
			<td><input type="text" name="last" size="50" /></td>
		</tr>
	</table>	
	<input type="reset" value="Reset Form" />
	<input type="submit" name="submit" value="Submit Form" />
		
</form>

<?php
	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
	$first="";
	$last="";
	if (isset($_GET['first'])) $first = $_GET['first'];
	if (isset($_GET['last'])) $last = $_GET['last'];
	
	// sanitize input?
	// $first = trim($first);
	// $first = htmlspecialchars($first);
	// $first = strip_tags($first);

	//echo "<p>" . $first . " " . $last . "</p>";
?>
		
</body>
</html>