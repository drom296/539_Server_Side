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
		foreach($tableNames as $tableName){
			echo displayColNames($tableName);
		}
		
		// show the table's column info
		foreach($tableNames as $tableName){
			echo displayColInfo($tableName);
		}

		echo Page::footer();

?>