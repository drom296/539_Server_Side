<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Add 'em up! Start</title>
</head>
<body>

<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
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
		
		foreach($_GET as $key=>$value){
		
			echo "<p>" . $key . " = " . $value . "</p>\n";
			//echo "<p>$k = $v</p>\n"; // another way
			
		} // end foreach
	
		// Calculate and display the sum
		echo "<h1>The sum of ".$_GET['num1']." and ".$_GET['num2']." is ".($_GET['num1'] + $_GET['num2'])."</h1>";
		
	} // end if
	
	
	

?>
		
</body>
</html>
