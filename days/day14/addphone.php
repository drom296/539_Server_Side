<?php
require_once ("LIB_db.php");

// accepts 4 inputs:
//   -area code
//   -phone number
//   -type of phone
//   -persond id

// use mysqli and prepared statements

if (areRequestVarsReady(array("areacode", "phonenum", "phonetype", "id"))) {
	echo "in if";

	// get the fields
	$areaCode = $_POST['areacode'];
	$phone = $_POST['phonenum'];
	$type = $_POST['phonetype'];
	$pId = $_POST['id'];

	// add the phone
	$success = addPhone($pId, $areaCode, $phone, $type);

	// if success,
	if ($success) {
		// clear $_GET, stops multiple adds
		echo "well done";

		// redirect to phones list
		header("Location: phones.php?" . ID_FIELD . "=$pId");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Add a Phone</title>
		<meta name="description" content="" />
		<meta name="author" content="Pedro" />
	</head>
	<body>
		<form action="addphone.php" method="post">
			<p>
				Area Code:
				<input type="text" name="areacode" value="###" size="3" />
			</p>
			<p>
				Phone:
				<input type="text" name="phonenum" value="###-####" size="8" />
			</p>
			<p>
				Type:
				<input type="text" name="phonetype" size="8"/>
			</p>
			<p>
				Person Id:
				<input type="text" name="id" size="8"/>
			</p>
			<p>
				<input type="submit" name="submit" value="Add Phone"/>
			</p>
			<a href="people.php">go back</a>
		</form>
	</body>
</html>