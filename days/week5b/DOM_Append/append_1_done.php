<?php
	include('MyUtils.class.php');
	//echo "<h3>Day 10 - Add a joke to jokes_1.xml and save it back to the hard drive.</h3>";
	$filename = "jokes_1.xml";
	// 1) Instantiate DOMDocument instance and load the XML file
	$dom = new DomDocument();
	$dom->load($filename);
	
	// 2) Create a new text node to hold the text of a joke
	//$theTextNode = $dom->createTextNode('Why did the ...');
	
	// 3) Create a new <joke> element node
 	//$theJokeElement = $dom->createElement('joke');
  
   	// 4) append text node to joke node
   	//$theJokeElement->appendChild($theTextNode);
   	// (then combine 2, 3 and 4 into a one-liner)

   	$theJokeElement = $dom->createElement('joke','I can\'t think of a joke');
 
   	// 5 set 'rating' attribute of joke node to some value
	$theJokeElement->setAttribute('rating','XXX');
   	
   	// 6 get reference to root element and add joke to root element 
   	// (do this 3 different ways)
	//$dom->documentElement->appendChild($theJokeElement);
	//$dom->appendChild($theJokeElement); // DON"T DO!!!!
	$dom->getElementsByTagName('badjokes')->item(0)->appendChild($theJokeElement);
//	$dom->firstChild->appendChild($theJokeElement);

   	// 7 save back to hard drive
   $dom->save($filename);

   	// 8 Echo out as XML - saveXML dumps the dom into a string   	
//   	$myxml = $dom->saveXML();
//  	header('content-type:text/xml');
//  	echo $myxml;
   	
   	// 9 Remove first joke element (don't forget to save again)
//  	$alljokes = $dom->getElementsByTagName('joke');
//  	$first = $alljokes->item(0);
//  	$dom->documentElement->removeChild($first);
   
   	// 10 remove last element
//   	$last = $alljokes->item($alljokes->length-1);
//	$dom->documentElement->removeChild($last);
	
//   	$dom->save($filename);
   // 0) DO THIS FIRST - re-load file and echo it out to be sure that we were successful
   // Use the element->nodeValue shortcut
/*   	
	$dom2 = new DomDocument();
	$dom2->load($filename);
	// echo out all jokes in a table
	$all_jokes = $dom2->getElementsByTagName('joke');
	$bigString = MyUtils::html_header($title="PFW",$styles="");
	$bigString .= "<table border='1'>\n";
	$bigString .= "<tr><th>Joke</th><th>Rating</th></tr>\n";
	foreach($all_jokes as $joke){
		$joke_text = $joke->nodeValue;
		$rating = $joke->getAttribute('rating');
		$bigString .= "<tr><td>$joke_text</td><td>$rating </td></tr>\n";
	}
	$bigString .= "</table>\n";
	$bigString .= MyUtils::html_footer($text="PFW!!!!!!");

//somehow running this next line is adding one to the file after the script is done running?
echo $bigString;
*/   
?>























