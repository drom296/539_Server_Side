<?php

define('LOGO_PIC', 'img/logo.png');
define('EDITORIAL', 'data/editorial.txt');

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

function addContent($includeEditorial, $numItems) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">';

	// create the editorial
	//$result .= addEditorial();

	// create the news items
	$result .= addNews($numItems);

	// close the container div
	$result .= "</div> <!-- id='content'-->";

	// return the result
	return $result;
}

function addEditorial() {
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
	$result .= '</div> <!-- id="editorial -->"';

	// return the result
	return $result;
}

//TODO: grab from editorial.txt file
function getEditorial() {
	return file_get_contents(EDITORIAL);
}

// TODO: need to grab from an actual file
function addNews($numItems) {
	$times = $numItems;
	$string = "";
	for ($i = 0; $i < $times; $i++) {
		$string .= <<<END
<div class="newsItem">
<p>
<span class="newsSubject">Subject</span><span class="newsDate">1/12/2012</span>
</p>
<p>
This is a story, of a lovely lady. Who had more kids than a grown man can count.
</p>
</div>\n\t\t\t\t\t
END;
	}
	return $string;
}
?>

