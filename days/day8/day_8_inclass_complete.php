<?php

	echo "<h1>Day 8 in class section 02</h1>";
	$filename = "jokes_1.xml";
	echo "<h2>Use the DOMDocument Class on jokes_1.xml</h2>";
	$dom = new DomDocument();
	$dom->load($filename);
	// #1 get all of the <joke> tags and put them in a DOMNodeList
	$all_jokes = $dom->getElementsByTagName("joke"); 
	$first_joke = $all_jokes->item(0);
	echo "#2 - First Joke =" . $first_joke->nodeValue . "<br />";
	echo "<br />#3 - Rating =" . $first_joke->getAttribute('rating');
	echo "<h3>#4 - Echo All jokes from jokes_1.xml using a foreach loop</h3>";
	foreach($all_jokes as $joke){
		echo "<p>Rating=" . $joke->getAttribute("rating") . " " .
		$joke->nodeValue . "</p>";
	}
	/////////////////////////////   PART 2    ////////////////////////////////////
	$filename = "jokes_2.xml";
// DOM Methods
	echo "<h2>Use the DOMDocument Class on jokes_2.xml</h2>";
	$dom = new DomDocument();
	
	// #5  load the file a different way
	$data = file_get_contents($filename);
	$dom->loadXML($data);
	
	// #6 get all of the <joke> tags and put them in a DOMNodeList
	$all_jokes = $dom->getElementsByTagName("joke"); 
	echo "<p>length=" . $all_jokes->length . "</p>";

	// #7 get the rating, the <question>, and the <answer> of the third joke
	$third_joke = $all_jokes->item(2);
	$rating = $third_joke->getAttribute('rating');
	$question = $third_joke->getElementsByTagName('question')->item(0)->nodeValue;
	$answer = $third_joke->getElementsByTagName('answer')->item(0)->nodeValue;
	
	echo "<p>rating=$rating, question = $question, answer=$answer</p>";
	
	echo "<h3>#8 - Echo All jokes from jokes_2.xml using a foreach loop</h3>";
	echo "<h3>#8 - Echo All jokes from jokes_2.xml using a foreach loop</h3>";
	foreach($all_jokes as $joke){
		$question = $joke->getElementsByTagName("question")->item(0)->nodeValue;
		$answer = $joke->getElementsByTagName("answer")->item(0)->nodeValue;
		$rating = $joke->getAttribute("rating");
		echo "<p>Question=$question, Answer=$answer, rating=$rating</p>";
	}
   	
?>