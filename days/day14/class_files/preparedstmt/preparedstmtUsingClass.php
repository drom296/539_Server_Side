<?php

function __autoload($class) {
	require_once $class . ".class.php";
}

$db = new PS_Database();

if ($db -> getError() != "") {
	printf("Connect failed: %s\n", $db -> getError());
	exit();
}

$code = "C%";

$rows = $db -> getCountryNames($code);

/* fetch values */
foreach ($rows as $row) {
	printf("%s %s<br />\n", $row['code'], $row['name']);
}

/* close connection */
$db -> close();
?> 