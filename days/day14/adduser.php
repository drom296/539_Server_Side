<?php
require_once ("LIB_db.php");

// accepts 4 inputs:
//   -area code
//   -phone number
//   -type of phone
//   -persond id

// use mysqli and prepared statements

if (arePostVarsGood(array("firstname", "lastname"))) {
	echo "In if";

	// get the fields
	$nickName = "";
	$firstName = $_GET['firstname'];
	$lastName = $_GET['lastname'];
	if(arePostVarsGood('nickname')){
		$nickName = $_GET['nickname'];
	}

	// add the person, get the id
	$pId = addPerson($firstName, $lastName, $nickName);
	
	echo "Person: $pId";

	if ($pid && arePostVarsGood(array("areacode", "phone", "type"))) {
		// get the fields
		$areaCode = $_POST['areacode'];
		$phone = $_POST['phone'];
		$type = $_POST['type'];

		// add the phone using the PersonID, get the id
		$phoneID = addPhone($pId, $areaCode, $phone, $type);
	}
	
	// if we received a valid PersonID
	if($pId){
		// redirect to the people listing
		header("Location: people.php?");
	}
}
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
				<input type="text" name="firstname" size="8" />
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