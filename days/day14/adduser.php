<?php

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Add a Person</title>
		<meta name="description" content="" />
		<meta name="author" content="Pedro" />
	</head>
	<body>
		<form action="adduser.php" method="get">
			<p>
				First Name:
				<input type="text" name="firstname" size="3" />
			</p>
			<p>
				Last Name:
				<input type="text" name="lastname" size="8" />
			</p>
			<p>
				Nick Name:
				<input type="text" name="nickname" size="8"/>
			</p>
			<p>
				Area Code:
				<input type="text" name="areacode" value="###" size="8"/>
			</p>
			<p>
				Phone:
				<input type="text" name="phone" value="###-####" size="8"/>
			</p>
			<p>
				Type:
				<select name="type">
					<option value="cell">cell</option>
					<option value="home">home</option>
					<option value="work">work</option>
					<option value="other">other</option>
				</select>				
			</p>
			<p>
				<input type="submit" name="submit" value="Add Person"/>
			</p>
			<a href="people.php">View People</a>
		</form>
	</body>
</html>