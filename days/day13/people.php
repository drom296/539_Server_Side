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

// Select The Database to Use
$success = mysql_select_db("pjm8632");
if (!$success) {
	die('Can\'t use people : ' . mysql_error());
}

// Send a Query to the Selected Database
$query = "select * from people";
$result = mysql_query($query);
if (!$result) {
	die('Invalid query: ' . mysql_error());
}

// Retrieve The Results of the Query

// get row by row and build your table
echo "<table border='1'>\n";
// go thru the rows
while ($row = mysql_fetch_row($result)) {
	echo "\t<tr>\n";
	for ($i = 0, $len = count($row); $i < $len; $i++) {
		echo "\t\t<td>" . $row[$i] . "</td>\n";
	}
	echo "\t</tr>\n";
}
echo "<table>\n";
?>