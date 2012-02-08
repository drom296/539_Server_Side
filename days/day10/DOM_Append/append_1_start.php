<?php
	include('MyUtils.class.php');
	echo "<h3>Day 10 - Add a joke to jokes_1.xml and save it back to the hard drive.</h3>";
	$filename = "jokes_1.xml";
	// 1) Instantiate DOMDocument instance and load the XML file
	$dom = new DomDocument();
	$dom->load($filename);
	
	// 2) Create a new text node to hold the text of a joke

	
	// 3) Create a new <joke> element node
 
  
   	
   	// 4) append text node to joke node
   	// (then combine 2, 3 and 4 into a one-liner)
 
   	
   	// 5 set 'rating' attribute of joke node to some value

   	
   	// 6 get reference to root element and add joke to root element 
   	// (do this 3 different ways)

   
   	// 7 save back to hard drive
   
   	// 8 Echo out as XML
   	
   	// 9 Remove first element (don't forget to save again
  
   //	$dom->documentElement->removeChild($first);
   
   	// 10 remove last element
	
   		
   // 0) DO THIS FIRST - re-load file and echo it out to be sure that we were successful
   // Use the element->nodeValue shortcut
  
  	
	$dom2 = new DomDocument();
	$dom2->load($filename);
	$all_jokes = $dom->getElementsByTagName('joke');
	// echo out all jokes in a table
?>













