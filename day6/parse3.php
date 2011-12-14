<?php
	include("LIB_parse.php");
	
	$url = "http://www.fbi.gov";
	
	// get web page
	$data = file_get_contents($url);
	
	// get the array of <meta> tags
	$meta_tag_array = parse_array($data, "<meta ", ">");
	
	// loop through the array
	foreach ($meta_tag_array as $line) {
		echo "<h3>" .return_between($line, "<meta","/>", EXCL)."</h3>\n";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>html5_template</title>
		<meta name="description" content="" />
		<meta name="author" content="Pedro" />
	</head>
	<body>
	
	</body>
</html>
