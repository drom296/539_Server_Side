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
displayCityPageInfo($db, 3);

// display city info for page 10
displayCityPageInfo($db, 10);

function displayCityPageInfo($db, $pageNum) {
	$error = getCityInfo($pageNum);
	if (empty($error)) {
		// display as table
		echo "<h2>Page $pageNum</h2>\n";

		// display assoc array
		echo displayAssocArrayT($db -> fetch_all_array());
	}
}



echo Page::footer();
?>