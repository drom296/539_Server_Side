<?php
	include("LIB_parse.php");
	
	$url = "http://www.foxnews.com/";
	
	// Get web page
	$data = file_get_contents($url);
	
	// parse the tiel of the web page, inclusive of the the <title> tags
	$title_incl = return_between($data, "<title>", "</title>", INCL);
	
	// parse the tiel of the web page, inclusive of the the <title> tags
	$title_excl = return_between($data, "<title>", "</title>", EXCL);
	
	// display the parsed text
	echo "title_incl = $title_incl";
	echo "<br />\n";
	echo "title_excl = $title_excl";
	echo "<br />\n";
?>