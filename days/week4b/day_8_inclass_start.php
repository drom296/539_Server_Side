<?php

	echo "<h1>Day 8 in class</h1>";
	$filename = "jokes_1.xml";
	echo "<h2>Use the DOMDocument Class on jokes_1.xml</h2>";
	$dom = new DomDocument();
	$dom->load($filename);
	// #1 get all of the <joke> tags and put them in a DOMNodeList
	$all_jokes = $dom->getElementsByTagName("joke"); 
	echo "#2 - First Joke =" . "<br />";
	echo "<br />#3 - Rating =";
	echo "<h3>#4 - Echo All jokes from jokes_1.xml using a foreach loop</h3>";
	
	/////////////////////////////   PART 2    ////////////////////////////////////
	$filename = "jokes_2.xml";
// DOM Methods
	echo "<h2>Use the DOMDocument Class on jokes_2.xml</h2>";
	
	// #5  load the file a different way
	
	
	// #6 get all of the <joke> tags and put them in a DOMNodeList


	// #7 get the rating, the <question>, and the <answer> of the third joke
	
	
	echo "<h3>#8 - Echo All jokes from jokes_2.xml using a foreach loop</h3>";
   	
?>













