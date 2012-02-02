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

/**
 * Checks to see if the fieldNames passed in the fields array is set and is not
 * empty in the POST array
 *
 * @param $fields - array of fields to check (i.e. array("submit", "id"))
 */
function arePostVarsGood($fields) {
	$result = true;

	foreach ($fields as $field) {
		if (!isset($_POST[$field]) || empty($_POST[$field])) {
			$result = false;
			break;
		}
	}

	return $result;
}

/**
 * Checks to see if the fieldNames passed in the fields array is set and is not
 * empty in the GET array
 *
 * @param $fields - array of fields to check (i.e. array("submit", "id"))
 */
function areGetVarsGood($fields) {
	$result = true;

	foreach ($fields as $field) {
		if (!isset($_GET[$field]) || empty($_GET[$field])) {
			$result = false;
			break;
		}
	}

	return $result;
}

/**
 * Adds a person to the db, using mySQLI and paramterized query
 *
 * @param $firstName - Required field
 * @param $lastName - Required field
 * @param $nickName - optional field
 */
function addPerson($firstName, $lastName, $nickName) {
	$result = false;

	// perform validation
	// check if they passed in names
	if (empty($firstName) && empty($lastName)) {
		return false;
	}

	// make a connection
	$mysqli = openConnectI();

	// check if connection successful
	if ($mysqli) {
		// sanitize data
		sanitize($firstName);
		sanitize($lastName);
		sanitize($nickName);

		// prepare statment
		if ($stmt = $mysqli -> prepare("insert into people(FirstName, LastName, NickName) values (?,?,?) ")) {
			// bind variables
			$stmt -> bind_param('sss', $firstName, $lastName, $nickName);
			// execute statement
			$stmt -> execute();

			// display the results
			/* store result */
			$stmt -> store_result();

			// set the result to the ID for the inserted record
			$result = $stmt -> insert_id;

			/* free result */
			$stmt -> free_result();

			// close statement
			$stmt -> close();
		}

		// close the link
		$mysqli -> close();
	}

	return $result;
}

/**
 * Adds the phone number to the DB using mySQLI and a parameterized query. All
 * fields are required
 *
 * @param $pid - The person id the phone number is tied to
 * @param $areaCode - 3 digit number
 * @param $phone - 8 digit string, (ie ###-####)
 * @param $type - string depicting the type of phone
 *
 */
function addPhone($pid, $areaCode, $phone, $type) {
	$result = false;
	// validate
	// check if any are empty
	if (empty($pid) && empty($areaCode) && empty($phone) && empty($type)) {
		echo "None of the fields may be empty";
		return false;
	}

	// make sure that parameters are of the expected type
	if(intval($pid)==0 || intval($areaCode)==0){
		return false;
	}
	
	// check lengths 
	if(strlen($areaCode)!= 3 || strlen($phone) != 8){
		return false;
	}
	
	// make sure the phone matches our pattern
	// ###-####
	// the # at either end are delimeters required by PHP for regex
	$pattern = '#[0-9]{3}[-][0-9]{4}#';
	if(!preg_match($pattern, $phone)){
		return false;
	}
	
	// remove the dash from the number
	$phone = str_replace("-", "", $phone);
	
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
		if ($stmt = $mysqli -> prepare("insert into phonenumbers(PersonID, PhoneType, PhoneNum, AreaCode) values (?,?,?,?) ")) {
			// bind variables
			$stmt -> bind_param('isss', $pid, $type, $phone, $areaCode);

			$stmt -> execute();

			// display the results
			/* store result */
			$stmt -> store_result();

			$result = $stmt -> insert_id;

			/* free result */
			$stmt -> free_result();

			// close statement
			$stmt -> close();

		}

		// close the link
		$mysqli -> close();
	}

	return $result;
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
	if ($mysqli = openConnectI()) {
		// Send a Query to the Selected Database
		$result = $mysqli -> query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			// start building the array
			while ($row = $result -> fetch_assoc()) {
				$records[] = $row;
			}
		}

		// close the connection
		$mysqli -> close();
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