<?php
	include("LIB_parse.php");
	
	$url = "http://www.rit.edu";
	
	// get web page
	$data = file_get_contents($url);
	
	// get the array of <meta> tags
	$meta_tag_array = parse_array($data, "<img ", ">");
	
	// echo out the src and alt values of all the images on rit.edu
	echo "<ul>\n";
	foreach ($meta_tag_array as $line) {
		$src = get_attribute($line, "src");
		$alt = get_attribute($line, "alt");
		echo "<li><b>src=</b>$src --- <b>alt=</b>$alt</li>\n";
	}
	echo "</ul>\n";
	
	// now create the image tags for all the images on rit.edu
	foreach ($meta_tag_array as $line) {
		$src = get_attribute($line, "src");
		$alt = get_attribute($line, "alt");
		echo "<img src='http://www.rit.edu$src' />\n";
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
