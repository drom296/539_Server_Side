<?php
// append to document
$dom= new domdocument();
$dom->load('poll_data.xml');
$newRecord = $dom->createElement('record');
$newRecord->setAttribute('topic','Name');
$newQuestion = $dom->createElement('question','What is your name?');
$newChoices = $dom->createElement('choices');
// start appending
$newRecord->appendChild($newQuestion);
$newRecord->appendChild($newChoices);
// create and append choice elements
$choice_array = array('Bobby','Candy','Doug','Ed','Fartboy');
foreach ($choice_array as $text){
	$newChoices->appendChild($dom->createElement('choice',$text));
}
// append to root element
$dom->documentElement->appendChild($newRecord);
// save file  - don't forget to change permisions to 666
$dom->save('poll_data.xml');




// read document
$cat = "Movies"; // came from $_GET
$theQuestion; // the selected question
$theChoices; // DOMNodeList of choices;
$dom= new domdocument();
$dom->load('poll_data.xml');
$all_records = $dom->getElementsByTagName('record');
echo "num records = " . $all_records->length;

// echo everything
foreach ($all_records as $record){
	$topic = $record->getAttribute('topic');
	$question = $record->getElementsByTagName('question')->item(0)->nodeValue;
	$all_choices = $record->getElementsByTagName('choice');
	echo "<h3>$topic</h3>";
	echo "<em>$question</em>";
	echo "<h4>choices:</h4>";
	echo "<ul>";
	foreach ($all_choices as $choice){
		$text = $choice->nodeValue;
		echo "<li>$text</li>";
	}
	echo "</ul>";
	echo "<hr />";
}

// print selected question
echo "<h2>The selected category is $cat</h2>";
// loop through records
foreach ($all_records as $record){
	$topic = $record->getAttribute('topic');
	if ($topic == $cat){
		$theQuestion = $record->getElementsByTagName('question')->item(0)->nodeValue;
		$theChoices = $record->getElementsByTagName('choice');
		break;
	
	}
}

echo "<h3>$topic</h3>";
	echo "<em>$theQuestion</em>";
	echo "<h4>choices:</h4>";
	echo "<ul>";
	foreach ($theChoices as $choice){
		$text = $choice->nodeValue;
		echo "<li>$text</li>";
	}
	echo "</ul>";


?>