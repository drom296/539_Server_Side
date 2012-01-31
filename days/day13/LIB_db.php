<?php
// The steps to basic database access are:
// Open a Connection to MySQL
// Select The Database to Use
// Send a Query to the Selected Database
// Retrieve The Results of the Query
// Close the Connection to the Database

function getPeopleInfo($host, $user, $password, $database, $query) {
	$records = array();

	// make sure we have parameters passed
	if (empty($host) || empty($user) || empty($password) || empty($database) || empty($query)) {
		return false;
	}

	// open a connection to MySQL

	// make the connection
	$dbLink = mysql_connect($host, $user, $password);
	if (!$dbLink) {
		die('DB Link Failed : ' . mysql_error());
	}

	// Select The Database to Use (your name b/c they dont allow u to create more db)
	$success = mysql_select_db($database);
	if (!$success) {
		die("Can't use $database : " . mysql_error());
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
	// make sure we have parameters passed
	if (empty($host) || empty($user) || empty($password) || empty($database) || empty($query)) {
		return false;
	}

	// Retrieve The Results of the Query
	$records = getPeopleInfo($host, $user, $password, $database, $query);

	// start the table
	$result = "<table border='1'>";

	// get the header info by geting the fields
	if (is_array($records) && !empty($records)) {
		$fields = array_keys($records[0]);
		$result .= "\t<tr>\n";
		foreach ($fields as $field) {
			$result .= "\t\t<th valign='top'>$field</th>\n";
		}
		$result .= "\t</tr>\n";
	}

	// loop through the people
	foreach ($records as $record) {
		$result .= "\t<tr>\n";

		foreach ($record as $field => $value) {
			$result .= "\t\t<td valign='top'>$value</td>\n";
		}

		// commence the row

		$result .= "\t</tr>\n";
	}

	// end the table
	$result .= "</table>";

	// echo result
	echo $result;
}
?>