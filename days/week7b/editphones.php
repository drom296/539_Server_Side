<?php
// TASKS:
// grab the people from the people table
// display in a table

// bring in the helper
require_once ('LIB_db.php');

// start name
$name = "";

// check if they passed a first name
if (isset($_GET[FIRST_NAME_FIELD]) && !empty($_GET[ID_FIELD])) {
	$name .= $_GET[FIRST_NAME_FIELD];
}

// check if they passed a last name
if (isset($_GET[LAST_NAME_FIELD]) && !empty($_GET[LAST_NAME_FIELD])) {
	if (!empty($name)) {
		$name .= " ";
	}
	$name .= $_GET[LAST_NAME_FIELD];
}

// check if they passed a nick name
if (isset($_GET[NICK_NAME_FIELD]) && !empty($_GET[NICK_NAME_FIELD])) {
	if (!empty($name)) {
		$name .= " AKA ";
	}
	$name .= $_GET[NICK_NAME_FIELD];
}

// print the name
echo "<h1>$name</h1>";

// print the phone records
// start where clause
$where = "";

// check if they passed an ID
if (isset($_GET[ID_FIELD]) && !empty($_GET[ID_FIELD])) {
	// use id for where clause
	$where = "where " . ID_FIELD . "='" . $_GET[ID_FIELD] . "'";
}
// query
$query = "select * from phonenumbers $where";
// print
printInfo($query);
// link back to people
echo "<a href='people.php'>Go Back to People Listing</a>";
?>