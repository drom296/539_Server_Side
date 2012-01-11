<?php
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
	echo "<h3>Question = $question</h3>";
	
	// setup the list for the choices
	
	// loop thru the choices
	
	// echo out the choice as a list item
	
	// end the record
	echo "<br /><hr />";
}

// echo "<h3>#8 - Echo All jokes from jokes_2.xml using a foreach loop</h3>";
// echo "<h3>#8 - Echo All jokes from jokes_2.xml using a foreach loop</h3>";
// foreach ($all_records as $joke) {
// $question = $joke -> getElementsByTagName("question") -> item(0) -> nodeValue;
// $answer = $joke -> getElementsByTagName("answer") -> item(0) -> nodeValue;
// $rating = $joke -> getAttribute("rating");
// echo "<p>Question=$question, Answer=$answer, rating=$rating</p>";
// }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>html5_template</title>
<meta name="description" content="" />
<meta name="author" content="Pedro" />
</head>
<body>

</body>
</html> -->
