<?php
    $url="http://www.rit.edu/";
	// get the enitre home page as text
	$data = file_get_contents($url);
	
	// store teh index of first instance of <h1> in the string
	$start_index = stripos($data, "<h1 ");
	
	// store the index of the first instance of </h1> in the string
	$end_index = stripos($data, "</h1>");
	
	// extract the <h1>...</h1> from the string
	$h1 = substr($data, $start_index, ($end_index-$start_index) +5);
	
	// echo it out
	echo($h1);
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
