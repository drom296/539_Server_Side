<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Add 'em up! Start</title>
</head>
<body>

<form action = "" method="GET">
	<table>
		<tr>
			<td>First Number</td>
			<td><input type="text" name="num1" size="30" /></td>
		</tr>
		<tr>
			<td>Second Number</td>
			<td><input type="text" name="num2" size="30" /></td>
		</tr>
	</table>	
	<input type="reset" value="Reset Form" />
	<input type="submit" name="submit" value="Submit Form" />
		
</form>
<?php
	echo "<h2>print_r() the Form Variables</h2>";
	print_r($_GET); // a handy debugging function
	
	if(array_key_exists('submit',$_GET)){
	
		// loop through $_GET and print out key=value pairs
		echo "<h2>foreach the Form Variables</h2>";
		
		foreach($_GET as $k=>$v){
		
			echo "<p>" . $k . " = " . $v . "</p>\n";
			//echo "<p>$k = $v</p>\n"; // another way
			
		} // end foreach
		
	} // end if

?>
		
</body>
</html>
