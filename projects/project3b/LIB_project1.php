<?php

define('LOGO_PIC', 'img/logo.png');
define('DATE_TIME', 'm/d/y g:iA');
define('EDITORIAL_PIC', 'img/editor2.jpg');

require_once ("LIB_backend.php");

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

// gets the next banner to be displayed as a string
function getBannerAd() {
	return "img/banner/" . getBannerFromBackend();
}

function addNav() {
	$result = file_get_contents("nav.html");

	if ($result) {
		return $result;
	} else {
		return "";
	}
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

// grab from editorial.txt file
function getEditorial() {
	return getEditorialFromBackend();
}

function addAdsContent($pageNum = 1, $numItems = 5, $includeNewsNav = false) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">' . "\n";

	// create the news items
	$result .= addAds($pageNum, $numItems, $includeNewsNav);

	// close the container div
	$result .= "</div> <!-- id='content'-->" . "\n";

	// return the result
	return $result;
}

function addNewsContent($includeEditorial = false, $pageNum = 1, $numItems = 5, $includeNewsNav = false) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">' . "\n";

	// create the editorial
	if ($includeEditorial) {
		$result .= addEditorial();
	}

	// create the news items
	$result .= addNews($pageNum, $numItems, $includeNewsNav);

	// close the container div
	$result .= "</div> <!-- id='content'-->" . "\n";

	// return the result
	return $result;
}

function displayItems($pageNum, $numItems, $includeNav = true, $type = "News") {
	// setup container div
	$result = '<div id="items" class="roundBox">' . "\n";

	// add the heading
	$result .= "<h1>$type</h1>" . "\n";

	$data = null;

	// get X news items
	if ($type == "News") {
		$data = getNewsInfo($pageNum, $numItems);
	} else if ($type == "Ads") {
		$data = getAdsInfo($pageNum, $numItems);
	}

	if ($data) {
		$items = $data['items'];
		// loop thru the stories
		foreach ($items as $item) {

			// set up the news item container
			$result .= '<div class="item">' . "\n";

			// setup container
			$result .= "<p class='itemData'>" . "\n";

			// set up the subject
			$result .= '<span class="itemSubject">' . $item['subject'] . '</span>' . "\n";

			// set up the date
			$result .= '<span class="itemDate">' . $item['pubDate'] . '</span>' . "\n";

			if (!empty($item['editions'])) {
				// setup the editions
				$result .= '<span class="edition"><span class="editionTitle">Editions</span>: ' . implode(",", $item['editions']) . '</span>' . "\n";
			}

			// close the container
			$result .= "</p>" . "\n";

			// set up the story
			$result .= "<p>" . $item['content'] . "</p>" . "\n";

			// close the news item container
			$result .= '</div> <!-- class="newsItem" -->' . "\n";

		}

		// close container div
		$result .= '</div> <!-- id="news" class="roundBox" -->' . "\n";

		// add the nav
		if ($includeNav) {
			$pageNum = $data['pageNumber'];
			$maxPages = $data['totalPages'];
			$numItems = $data['numberPerPage'];

			$result .= addItemNav($pageNum, $maxPages, $numItems);
		}
	}

	return $result;
}

function addNews($pageNum, $numItems, $includeNav = true) {
	return displayItems($pageNum, $numItems, $includeNav, "News");
}

function addAds($pageNum, $numItems, $includeNav = true) {
	return displayItems($pageNum, $numItems, $includeNav, "Ads");
}

function addItemNav($pageNum, $maxPages, $numItems) {
	// check if the page Nunber exceeds the max number of pages
	if ($pageNum > $maxPages) {
		$pageNum = $maxPages;
	}

	// setup result
	$result = "";

	// setup container div
	$result .= "<div>" . "\n";

	$end = $pageNum * $numItems;
	// $numNewsItems;
	$start = $end - $numItems + 1;

	// setup the items showing info
	$result .= "<span id='numItemsShowing'>Showing news items: $start - $end</span>" . "\n";

	// setup container
	$result .= "<span id='itemNav'>" . "\n";

	// setup the page links
	if ($pageNum > 1) {
		$result .= "<a href='news.php?page=1&count=$numItems'>&lt;&lt;</a> ";
		$result .= "<a href='news.php?page=" . ($pageNum - 1) . "&count=$numItems'>&lt;</a> ";
	}

	$result .= "<span id='curNewsPage'>[" . ($pageNum) . "]</span> ";

	if ($pageNum < $maxPages) {
		$result .= "<a href='news.php?page=" . ($pageNum + 1) . "&count=$numItems'>&gt;</a> ";
		$result .= "<a href='news.php?page=$maxPages&count=$numItems'>&gt;&gt;</a> ";
	}

	// setup container
	$result .= "</span> <!-- id='newsNav -->" . "\n";

	// close container div
	$result .= "</div>" . "\n";

	//return result
	return $result;
}

// Grab x number of items from the file, starting from the specific offset
function getXStories($pageNumber, $numItems, $getAll = false) {
	global $totalNewsItems, $pageNum, $maxPages, $numNewsItems;

	// associative array of info
	$data = getNews($pageNumber, $numItems);

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

/**
 * Creates a form to submit an ad. Includes a captcha
 */
function displaySubmitAdForm() {
	$result = "";

	// add the heading
	$result .= "<h1>Submit Your Ad</h1>" . "\n";

	$result .= '<form id="submitAdForm">';
	// ad has a title and content
	$result .= '<p>';
	$result .= '<label class="smallLabel" for="title">Title:</label>';
	$result .= '<input class="roundBox" type="text" name="title" />';
	$result .= '</p>';
	$result .= '<p>';
	$result .= '<label for="content">Ad Description:</label>';
	$result .= '<textarea name="content" class="roundBox" ></textarea>';
	$result .= '</p>';

	// as well as edition
	$result .= '<p>';
	$result .= '<label class="smallLabel" for="content">Edition:</label>';
	$result .= buildEditionsOptions();
	$result .= '</p>';

	// add submit and reset buttons
	$result .= '<p>';
	$result .= '<input type="submit" name="submit" value="Submit Your Ad" />';
	$result .= '<input type="reset" value="Reset Form" />';
	$result .= '</p>';

	$result .= '</form>';

	return $result;
}

function buildEditionsOptions() {
	// get the editions
	$editions = getEditions();

	// setup the result var
	$result = '<div id="editionsDiv">';

	// cycle thru the editions

	$i = 1;
	foreach ($editions as $id => $name) {
		$result .= '<input class="editionCheckbox" type="checkbox" name="edition[]" value="' . $id . '" /><span>' . $name . '</span>';

		if ($i % 2 == 0) {
			$result .= '<br />';
		}
		$i++;
	}

	$result .= '</div>';

	return $result;
}

/**
 * Make sure that the keys specified exist in the array and its value is not empty
 *
 * @param $array - associative array to check
 * @param keys - keys to look for in the array
 *
 * @return true if the keys exist and its value is not empty
 */
function arrayContainsVals($array, $keys) {
	$result = true;

	foreach ($keys as $key) {
		if (!isset($array[$key]) || empty($array[$key])) {
			$result = false;
			break;
		}
	}

	return $result;
}
?>