<?php
// The steps to basic database access are:
// Open a Connection to MySQL
// Select The Database to Use
// Send a Query to the Selected Database
// Retrieve The Results of the Query
// Close the Connection to the Database

// TASKS:
// grab the people from the people table
// display in a table

function getPeopleInfo() {
	$records = array();
	
	// open a connection to MySQL
	// setup params
	$dbHost = 'localhost';
	$dbUser = 'pjm8632';
	$dbPass = 'Bully296';

	// make the connection
	$dbLink = mysql_connect($dbHost, $dbUser, $dbPass);
	if (!$dbLink) {
		die('DB Link Failed : ' . mysql_error());
	}

	// Select The Database to Use (your name b/c they dont allow u to create more db)
	$success = mysql_select_db("pjm8632");
	if (!$success) {
		die('Can\'t use people : ' . mysql_error());
	}

	// Send a Query to the Selected Database
	$query = "select * from people";
	$result = mysql_query($query);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	} else{
		// start building the array
		while($row = mysql_fetch_assoc($result)){
			$records[] = $row;
		}
	}
	
	// close the connection
	mysql_close($dbLink);
	
	// return the results
	return $records;
}

// Retrieve The Results of the Query
$records = getPeopleInfo();

// start the table
$result = "<table border='1'>";

// loop through the people
foreach($records as $record){
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

// // get row by row and build your table
// echo "<table border='1'>\n";
// // go thru the rows
// while ($row = mysql_fetch_row($result)) {
	// echo "\t<tr>\n";
	// for ($i = 0, $len = count($row); $i < $len; $i++) {
		// echo "\t\t<td>" . $row[$i] . "</td>\n";
	// }
	// echo "\t</tr>\n";
// }
// echo "<table>\n";
?>