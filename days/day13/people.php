<?php
// TASKS:
// grab the people from the people table
// display in a table
$host = 'localhost';
$user = 'pjm8632';
$password = 'Bully296';
$database = "pjm8632";
$query = "select * from people";
printInfo($host, $user, $password, $database, $query);

function getInfo($host, $user, $password, $database, $query) {
	$records = array();

	// make sure we have parameters passed
	if (empty($host) || empty($host))

		// open a connection to MySQL

		// make the connection
		$dbLink = mysql_connect($host, $user, $password);
	if (!$dbLink) {
		die('DB Link Failed : ' . mysql_error());
	}

	// Select The Database to Use (your name b/c they dont allow u to create more db)
	$success = mysql_select_db($database);
	if (!$success) {
		die('Can\'t use people : ' . mysql_error());
	}

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

	// return the results
	return $records;
}

function printInfo($host, $user, $password, $database, $query) {
	// Retrieve The Results of the Query
	$records = getInfo($host, $user, $password, $database, $query);

	// start the table
	$result = "<table border='1'>";

	// loop through the people
	foreach ($records as $record) {
		$result .= "\t<tr>\n";
		foreach ($record as $field => $value) {
			$result .= "\t\t<td valign='top'>$value</td>\n";
		}
		$result .= "\t</tr>\n";
	}

	// end the table
	$result .= "</table>";

	// echo result
	echo $result;
}
?>