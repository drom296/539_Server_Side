<?php
// echo html_header($title = 'HW-8', $styles = 'example_styles.css');

// setup the file name
$filename = "quiz_questions.xml";

// DOM Methods
$dom = new DomDocument();

// #5  load the file a different way
$data = file_get_contents($filename);
$dom -> loadXML($data);

// #6 get all of the <record> tags and put them in a DOMNodeList
$all_records = $dom -> getElementsByTagName("record");
// echo "<p>length=" . $all_jokes->length . "</p>";

// #7 get the title, the question, and the choices of the first record
// $record = $all_records -> item(0);
foreach ($all_records as $record) {
	$title = $record -> getElementsByTagName('title') -> item(0) -> nodeValue;
	$question = $record -> getElementsByTagName('question') -> item(0) -> nodeValue;
	// echo the title
	echo "<h2>Title = $title</h2>";
	// echo the question
	echo "\n<h3>Question = $question</h3>";

	// setup the list for the choices
	echo "\n<ol type='I'>";

	// loop thru the choices
	$choices = $record -> getElementsByTagName('choice');

	foreach ($choices as $choice) {
		// echo out the choice as a list item
		echo "\n<li>" . $choice -> nodeValue . "</li>";
	}

	// close the list
	echo "\n</ol>";

	// end the record
	echo "\n<br /><hr />";
}

// end the page
// echo html_footer();

