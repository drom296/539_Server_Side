<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>ICE- Day 9 - Jokes</title>
</head>
<body>
<?php
// DOM Methods
$jokes_url = "http://people.rit.edu/bdfvks/539/day9/jokes_server.php?type=XML&num=5";
$title = "Great Jokes!";

$dom = new DomDocument();
$dom -> load($jokes_url);

// get all of the <joke> tags and put them in a DOMNodeList
$all_jokes = $dom -> getElementsByTagName("joke");

echo "<h1>$title</h1>";

foreach ($all_jokes as $joke) {
	// get the question
	$question = $joke -> getElementsByTagName('question') -> item(0) -> nodeValue;

	// get the answer
	$answer = $joke -> getElementsByTagName('answer') -> item(0) -> nodeValue;

	// get the rating
	$rating = $joke -> getElementsByTagName('rating') -> item(0) -> nodeValue;

	// display the question
	echo "\n<h2>$question</h2>";

	// display the answer
	echo "\n<p><em>$answer</em></p>";

	// display the rating
	echo "\n<p><small>rating = $rating</small></p>";

	// separate other1
	echo "\n<hr />\n\n";
}
?>

</body>
</html>
