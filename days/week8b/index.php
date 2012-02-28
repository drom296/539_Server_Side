<?php
require_once "P3_lib.php";

function __autoload($className) {
	require_once $className . '.class.php';
}

//get a singleton instance of the database class
$db = Database::getInstance();

echo Page::header("Database Class Usage");

//here is where you are going to call functions in P3_lib or Page to create your page
echo getStartInfo($db);

// get valid tables
// $tableNames = $db->getValidTableNames();

$tableNames = array("demo_state", "demo_zipcode");

// show the table's columns
foreach ($tableNames as $tableName) {
	echo displayColNames($tableName);
}

// show the table's column info
foreach ($tableNames as $tableName) {
	echo displayColInfo($tableName);
}

// display city info for page 3
displayCityPageInfo(3, 10);

// display city info for page 10
displayCityPageInfo(10, 10);

// display city state info for page 25
displayCityStatePageInfo(25, 15);

// insert record
$err = insertCity();

if(empty($err)){
	echo "<p><strong>Record was successfully added!</strong></p>";
} else{
	echo "<p>There was an error: $err</p>";
}

// update record
$err = updateCity();

if(empty($err)){
	echo "<p><strong>Record was successfully updated!</strong></p>";
} else{
	echo "<p>There was an error: $err</p>";
}

// delete record
$err = deleteCity();

if(empty($err)){
	echo "<p><strong>Record was successfully deleted!</strong></p>";
} else{
	echo "<p>There was an error: $err</p>";
}


echo Page::footer();
?>