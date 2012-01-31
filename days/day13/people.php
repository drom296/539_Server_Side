<?php
require_once ('LIB_db.php');

// TASKS:
// grab the people from the people table
// display in a table
$host = 'localhost';
$user = 'pjm8632';
$password = 'Bully296';
$database = "pjm8632";
$query = "select * from people";
printInfo($host, $user, $password, $database, $query);
?>