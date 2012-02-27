<?php

define('LOGO_PIC', 'img/logo.png');
define('DATE_TIME', 'm/d/y g:iA');
define('EDITORIAL_PIC', 'img/editor2.jpg');

require_once ("LIB_backend.php");

$totalNewsItems;
$pageNum;
$maxPages;
$numNewsItems;
$prefs;

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

function html_footer() {
	$string = <<<END
	</div> <!-- id=page -->
</body>
</html>
END;

	return $string;
}

// create the banner div
function addBanner() {
	// start div
	$string = "\t" . "\t" . '<div id="banner">' . "\n";

	// add logo
	$string .= "\t" . "\t" . "\t" . '<img src="' . LOGO_PIC . '" alt="logo" />' . "\n";

	// add banner ad
	$string .= "\t" . "\t" . "\t" . '<img src="' . getBannerAd() . '" id="ad" alt="ad"/>' . "\n";

	// end div
	$string .= "\t" . "\t" . '</div> <!-- id=banner -->' . "\n";

	return $string;
}

// TODO: gets the next banner to be displayed as a string
function getBannerAd() {
	return "";

	// need to actually get the Banner Ad from the server

	$result = "";

	// setup banner array
	$banners = getBanners();

	// sort the banners based on their display value (weight*count)
	usort($banners, "bannerSort");

	// choose the one with the smallest display value (first one)
	$result = $banners[0]['fileName'];
	// update count
	$banners[0]['count'] = $banners[0]['count'] + 1;

	// update banners file
	setBanners($banners);

	// prepend with image folder location
	$result = "img/banner/" . $result;

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

function addNewsContent($includeEditorial = false, $pageNum = 1, $numItems = 5, $includeNewsNav = false) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">' . "\n";

	// create the editorial
	if ($includeEditorial) {
		$result .= addEditorial();
	}

	// create the news items
	$result .= addNews($pageNum, $numItems);

	// create the news nav
	if ($includeNewsNav) {
		$result .= addNewsNav();
	}

	// close the container div
	$result .= "</div> <!-- id='content'-->" . "\n";

	// return the result
	return $result;
}

function addEditorial() {
	$result = "";
	// create the container div
	$result = '<div id="editorial" class="navHome">' . "\n";

	// create the heading
	$result .= '<h1>Editorial</h1>' . "\n";

	// add the editor's picture
	// probably thru an INI file
	$result .= '<img src="' . getEditorialPic() . '" alt="editor" />' . "\n";

	// get editorial
	$result .= getEditorial();

	// close div
	$result .= '</div> <!-- id="editorial -->' . "\n";

	// return the result
	return $result;
}

//TODO: grab from editorial.txt file
function getEditorial() {
	return "NEEDS TO GET FROM SERVER";

	return file_get_contents(EDITORIAL);
}

function addNews($pageNum, $numItems) {
	// setup container div
	$result = '<div id="news" class="roundBox">' . "\n";

	// add the heading
	$result .= "<h1>News</h1>" . "\n";

	// get X news items
	$newsItems = getXStories($pageNum, $numItems);

	// loop thru the stories
	foreach ($newsItems as $newsItem) {

		// set up the news item container
		$result .= '<div class="newsItem">' . "\n";

		// setup container
		$result .= "<p>" . "\n";

		// set up the subject
		$result .= '<span class="newsSubject">' . $newsItem['subject'] . '</span>' . "\n";

		// set up the date
		$result .= '<span class="newsDate">' . $newsItem['pubDate'] . '</span>' . "\n";

		// setup the editions
		$result .= '<p class="newsDate">Editions: ' . implode(",", $newsItem['editions']) . '</p>' . "\n";

		// close the container
		$result .= "</p>" . "\n";

		// set up the story
		$result .= "<p>" . $newsItem['content'] . "</p>" . "\n";

		// close the news item container
		$result .= '</div> <!-- class="newsItem" -->' . "\n";

	}

	// close container div
	$result .= '</div> <!-- id="news" class="roundBox" -->' . "\n";

	return $result;
}

// Grab x number of items from the file, starting from the specific offset
function getXStories($pageNum, $numItems, $getAll = false) {
	global $totalNewsItems, $pageNum, $maxPages, $numNewsItems;

	// associative array of info
	$data = getNews($pageNum, $numItems);

	$pageNum = $data['pageNumber'];
	$maxPages = $data['totalPages'];
	$numNewsItems = $data['numberPerPage'];
	$totalNewsItems = $maxPages * $numNewsItems;

	// setup result
	$result = $data['items'];

	// if they want all stories
	if ($getAll) {

		// associative array of info
		$data = getNews(1, $totalNewsItems);
		$pageNum = $data['pageNumber'];
		$maxPages = $data['totalPages'];
		$numNewsItems = $data['numberPerPage'];
		$totalNewsItems = $maxPages * $numNewsItems;

		// setup result
		$result = $data['items'];
	}

	// return the result
	return $result;
}

function addNewsNav() {
	global $pageNum, $maxPages, $numNewsItems, $prefs;

	// check if the page Nunber exceeds the max number of pages
	if ($pageNum > $maxPages) {
		$pageNum = $maxPages;
	}

	// setup result
	$result = "";

	// setup container div
	$result .= "<div>" . "\n";

	$end = $pageNum * $numNewsItems;
	// $numNewsItems;
	$start = $end - $numNewsItems + 1;

	// TODO: fix bug with last page.
	$result .= "<span id='numItemsShowing'>Showing news items: $start - $end</span>" . "\n";

	// setup container
	$result .= "<span id='newsNav'>" . "\n";

	// setup the page links
	if ($pageNum > 1) {
		$result .= "<a href='news.php?page=1&count=$numNewsItems'>&lt;&lt;</a> ";
		$result .= "<a href='news.php?page=" . ($pageNum - 1) . "&count=$numNewsItems'>&lt;</a> ";
	}

	$result .= "<span id='curNewsPage'>[" . ($pageNum) . "]</span> ";

	if ($pageNum < $maxPages) {
		$result .= "<a href='news.php?page=" . ($pageNum + 1) . "&count=$numNewsItems'>&gt;</a> ";
		$result .= "<a href='news.php?page=$maxPages'&count=$numNewsItems>&gt;&gt;</a> ";
	}

	// setup container
	$result .= "</span> <!-- id='newsNav -->" . "\n";

	// close container div
	$result .= "</div>" . "\n";

	//return result
	return $result;
}

function getEditorialPic() {
	return EDITORIAL_PIC;
}

function addUserInfo() {
	$result = "";

	// setup container div
	$result .= "<div id='userInfo' class='roundBox'>" . "\n";

	// show heading
	$result .= "<h2>User Info</h2>";

	// setup vars
	$time = "NA";
	$ip = "NA";
	$referer = "NA";
	$user_agent = "NA";

	// get time accessed
	if (!empty($_SERVER['REQUEST_TIME']))
		$time = date(DATE_TIME, $_SERVER['REQUEST_TIME']);

	// get ip address
	if (!empty($_SERVER['REMOTE_ADDR']))
		$ip = $_SERVER['REMOTE_ADDR'];

	// referer
	if (!empty($_SERVER['HTTP_REFERER']))
		$referer = $_SERVER['HTTP_REFERER'];

	// get browser info
	if (!empty($_SERVER['HTTP_USER_AGENT']))
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

	// setup list
	$result .= "<ul>";

	// display gathered info
	$result .= "<li>Time Accessed: " . $time . "</li>" . "\n";
	$result .= "<li>Your IP: " . $ip . "</li>" . "\n";
	$result .= "<li>Referred by: " . $referer . "</li>" . "\n";
	$result .= "<li>Your browser: " . $user_agent . "</li>" . "\n";

	// close list
	$result .= "</ul>";

	// close container div
	$result .= "</div> <!-- id='userInfo' -->" . "\n";

	return $result;
}

function startContentDiv() {
	// setup container div
	return '<div id="content" class="noFloat roundBox">' . "\n";
}

function closeContentDiv() {
	// close container div
	return "</div> <!-- id='content'-->" . "\n";
}
?>