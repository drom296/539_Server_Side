<?php

define('LOGO_PIC', 'img/logo.png');
define('EDITORIAL', 'data/editorial.txt');
define('NEWS', 'data/news.txt');

function html_header($title = "Untitled", $styles = null, $scripts = null) {
	$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>$title</title>
END;

	if (is_array($styles)) {
		foreach ($styles as $style) {
			$string .= "<link type='text/css' rel='stylesheet' href='$style' />\n";
		}
	} else if (is_string($styles)) {
		$string .= "<link type='text/css' rel='stylesheet' href='$styles' />\n";
	}

	if (is_array($scripts)) {
		foreach ($scripts as $script) {
			$string .= "<script type='text/javascript' src='$script'></script>\n";
		}
	} else if (is_string($scripts)) {
		$string .= "<script type='text/javascript' src='$scripts'></script>\n";
	}

	$string .= <<<END
</head>
<body>\n
	<div id="page">\n
END;

	return $string;
}

function html_footer($text = "") {
	$string = <<<END
		<p><em>$text</em></p>
	</div> <!-- id=page -->
</body>
</html>
END;

	return $string;
}

function return_file_as_array($path) {
	if (file_exists($path) && is_readable($path)) {
		return @file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	} else {
		die("<strong>Problem loading file at #path!</strong>");
	}
}

// create the banner div
function addBanner() {
	// start div
	$string = "\t" . "\t" . '<div id="banner">' . "\n";

	// add logo
	$string .= "\t" . "\t" . "\t" . '<img src="' . LOGO_PIC . '" alt="logo" />' . "\n";

	// add banner ad
	$string .= "\t" . "\t" . "\t" . '<img src="' . getBannerAd() . '" id="ad" alt="ad" />' . "\n";

	// end div
	$string .= "\t" . "\t" . '</div> <!-- id=banner -->' . "\n";

	return $string;
}

// gets the next banner to be displayed as a string
function getBannerAd() {
	$result = LOGO_PIC;

	return $result;
}

function addNav() {
	$result = file_get_contents("nav.html");

	if ($result) {
		return $result;
	} else {
		return "";
	}
}

function addContent($includeEditorial, $offset, $numItems) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">';

	// create the editorial
	$result .= addEditorial();

	// create the news items
	$result .= addNews($offset, $numItems);

	// close the container div
	$result .= "</div> <!-- id='content'-->";

	// return the result
	return $result;
}

function addEditorial() {
	$result = "";
	// create the container div
	$result = '<div id="editorial" class="navHome">';

	// create the heading
	$result .= '<h1>Editorial</h1>';

	// add the editor's picture
	// TODO: make dynamic by allowing them to choose
	// probably thru an INI file
	$result .= '<img src="img/editor2.jpg" alt="editor" />';

	// get editorial
	$result .= getEditorial();

	// close div
	$result .= '</div> <!-- id="editorial -->';

	// return the result
	return $result;
}

// grab from editorial.txt file
function getEditorial() {
	return file_get_contents(EDITORIAL);
}

// TODO: need to grab from an actual file
function addNews($offset, $numItems) {
	// setup container div
	$result = '<div id="news" class="roundBox">';
	
	// add the heading
	$result .= "<h1>News</h1>";

	// get X news items
	$newsItems = getXStories($offset, $numItems);

	// loop thru the stories
	foreach ($newsItems as $newsItem) {

		// set up the news item container
		$result .= '<div class="newsItem">';

		// setup container
		$result .= "<p>";

		// set up the subject
		$result .= '<span class="newsSubject">' . $newsItem['subject'] . '</span>';

		// set up the date
		$result .= '<span class="newsDate">' . $newsItem['date'] . '</span>';

		// close the container
		$result .= "</p>";

		// set up the story
		$result .= "<p>" . $newsItem['story'] . "</p>";

		// close the news item container
		$result .= '</div> <!-- class="newsItem" -->';

	}
	
	// close container div
	$result .= '</div> <!-- id="news" class="roundBox" -->';

	return $result;
}

// Grab x number of items from the file, starting from the specific offset
function getXStories($offset, $numItems) {
	// setup result
	$result = array();

	// TODO: do in a more optimistic way
	// instead of getting the entire contents of the file, just get what you need

	// non-optimistic way

	// get file contents as array
	$news = return_file_as_array(NEWS);

	// print_r($news);
	// get how many news items there are
	$newsLength = count($news);

	// check if we are starting from outside our range
	if ($offset < $newsLength) {
		// check if we exceed our range
		if ($offset + $numItems > $newsLength) {
			$numItems = $newsLength - $offset;
		}

		// get only the desired ones, starting from offset to the right below $numItems
		for ($i = 0, $index = $offset; $i < $numItems; $i++, $index++) {
			
			list($date, $subject, $story) = explode("|", $news[$index]);

			array_push($result, array('date' => $date, 'subject' => $subject, 'story' => $story));
		}
	}

	// return the result
	return $result;
}
?>

