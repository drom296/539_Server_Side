<?php
	

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Add a poll</title>
</head>
<body>
<h1>Add a Poll</h1>
<form action = "/~bdfvks/539/day5/add_a_poll.php" method="POST">
	<table>
		<tr>
			<td>Topic Category</td>
			<td><input type="text" name="cat" size="10" /></td>
		</tr>
		<tr>
			<td>Topic Question</td>
			<td><input type="text" name="question" size="50" /></td>
		</tr>
		
		<tr>
			<td>Choice 1</td>
			<td><input type="text" name="choice1" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 2</td>
			<td><input type="text" name="choice2" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 3</td>
			<td><input type="text" name="choice3" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 4</td>
			<td><input type="text" name="choice4" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 5</td>
			<td><input type="text" name="choice5" size="15" /></td>
		</tr>
	</table>	
	<hr />
	<strong>Your Password: </strong><input type="password" name="password" size="15" /><br />
	<input type="reset" value="Reset Form" />
	<input type="submit" name="submit" value="Submit Form" />
		
</form>

<p>
	</p>
		<h3><a href="choose_a_poll.php">Choose a Poll</a></h3>
</body>
</html>
