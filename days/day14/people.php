<?php

// bring in the helper
require_once ('LIB_db.php');

// TASKS:
// grab the people from the people table
// display in a table
$query = "select * from people";
printInfo($query, true);
?>