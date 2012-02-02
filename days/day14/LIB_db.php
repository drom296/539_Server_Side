<?php
// The steps to basic database access are:
// Open a Connection to MySQL
// Select The Database to Use
// Send a Query to the Selected Database
// Retrieve The Results of the Query
// Close the Connection to the Database
define("ID_FIELD", "PersonID");
define("FIRST_NAME_FIELD", "FirstName");
define("LAST_NAME_FIELD", "LastName");
define("NICK_NAME_FIELD", "NickName");

$host = 'localhost';
$user = 'pjm8632';
$password = 'Bully296';
$database = "pjm8632";

function addPhone($pid, $areaCode, $phone, $type) {
	if (empty($pid) && empty($areaCode) && empty($phone) && empty($type)) {
		echo "None of the fields may be empty";
		return false;
	}

	// make a connection
	$mysqli = openConnectI();
	
	// check if connection successful
	if ($mysqli) {
		// sanitize data
		sanitize($pid);
		sanitize($areacode);
		sanitize($phone);
		sanitize($type);

		// prepare statment
		$stmt = $mysqli -> prepare("insert into phonenumbers (PersonID, PhoneType, PhoneNum, AreaCode) values (?,?,?,?) ");
		// bind variables
		// var_dump($stmt, $mysqli->error);
		$stmt -> bind_param('isss', $id, $type, $phone, $areaCode);
		
		var_dump($stmt);

		// $stmt -> bind_param('isii', $PersonId, $PhoneType, $PhoneNum, $Code);
		// $PersonId = $pid;
		// $PhoneType = $type;s
		// $PhoneNum = $phone;
		// $Code = $areaCode;
		// execute statement
		$stmt -> execute();

		var_dump($stmt);
		
		// display the results
		/* store result */
		$stmt -> store_result();

		printf("Number of rows: %d.\n", $stmt -> num_rows);

		/* free result */
		$stmt -> free_result();

		// close statement
		$stmt -> close();

		// close the link
		$mysqli -> close();
	}
}

function sanitize(&$str) {
	$str = trim($str);
	$str = stripslashes($str);
	$str = strip_tags($str);
	return $str;
}

function openConnectI() {
	global $host, $user, $password, $database;
	$mysqli = new mysqli($host, $user, $password, $database);
	if ($mysqli -> connect_error) {
		$mysqli = false;
	}
	return $mysqli;
}

function openConnect() {
	global $host, $user, $password, $database;
	// make the connection
	$dbLink = mysql_connect($host, $user, $password);
	if (!$dbLink) {
		return false;
		// die('DB Link Failed : ' . mysql_error());
	}

	// Select The Database to Use (your name b/c they dont allow u to create more db)
	$success = mysql_select_db($database);
	if (!$success) {
		return FALSE;
		// die("Can't use $database : " . mysql_error());
	}

	return $dbLink;
}

function closeConnect($dbLink) {
	// close the connection
	mysql_close($dbLink);
}

function getPeopleInfo($query) {
	$records = array();

	// make sure we have parameters passed
	if (empty($query)) {
		return false;
	}

	// open a connection to MySQL
	if ($dbLink = openConnect()) {

		// Send a Query to the Selected Database
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			// start building the array
			while ($row = mysql_fetch_assoc($result)) {
				$records[] = $row;
			}
		}

		// close the connection
		mysql_close($dbLink);
	}

	// return the results
	return $records;
}

function printInfo($query, $forPeople = false) {
	// make sure we have parameters passed
	if (empty($query)) {
		return false;
	}

	// Retrieve The Results of the Query
	$records = getPeopleInfo($query);

	$result = "<h1>" . count($records) . " records found!</h1>\n";

	// get the header info by geting the fields
	if (is_array($records) && !empty($records)) {
		// start the table
		$result .= "<table border='1'>\n";

		//grab the fields
		$fields = array_keys($records[0]);
		$result .= "\t<tr>\n";
		// display the fields
		foreach ($fields as $field) {
			$result .= "\t\t<th valign='top'>$field</th>\n";
		}
		$result .= "\t</tr>\n";

		// loop through the people
		foreach ($records as $record) {
			$result .= "\t<tr>\n";

			// check if they want a link for people
			if ($forPeople) {
				$result .= getLink($record);
			} else {
				// just loop thru each of the fields
				foreach ($record as $field => $value) {
					$result .= "\t\t<td valign='top'>$value</td>\n";
				}
			}

			// commence the row
			$result .= "\t</tr>\n";
		}

		// end the table
		$result .= "</table>\n";
	}

	// echo result
	echo $result;
}

function getLink($record) {
	$result = "";

	// get the id
	$id = $record['PersonID'];

	// get the first name
	$lName = $record['LastName'];

	// get the last name
	$fName = $record['FirstName'];

	// get the nickname
	$nName = $record['NickName'];

	// start data
	$result .= "\t\t<td><a href='phones.php?" . ID_FIELD . "=$id&" . FIRST_NAME_FIELD . "=$fName&" . LAST_NAME_FIELD . "=$lName'>$id</a></td>\n";
	$result .= "\t\t<td>$lName</td>\n";
	$result .= "\t\t<td>$fName</td>\n";
	$result .= "\t\t<td>$nName</td>\n";

	// return the result
	return $result;
}
?>