<?php

define('LOGO_PIC', 'img/logo.png');
define('EDITORIAL', 'data/editorial.txt');
define('NEWS', 'data/news.txt');
define('PREFS_DATA', 'data/setup.ini');
define('BANNER', 'data/banners.txt');
define('BANNER_PATH', 'img/banner/');
define('DATE_TIME', 'm/d/y g:iA');

$totalNewsItems;
$pageNum;
$maxPages;
$numNewsItems;
$prefs;

init();

function init() {
	global $prefs;
	// get the ini file
	$prefs = parse_ini_file(PREFS_DATA);
}

function writeINIFile() {
	global $prefs;
	// open file
	$file = fopen(PREFS_DATA, "w") or die("Cannot open　" . PREFS_DATA);

	$content = "";

	// create the data to write
	foreach ($prefs as $key => $data) {
		$content .= $key . ' = ' . $data . "\n";
	}

	// write only if it has data
	if (!empty($content)) {
		fwrite($file, $content);
	}

	// close file
	fclose($file);
}

// getter functions for init files

function getIniVal($key) {
	global $prefs;
	return $prefs[$key];
}

function getNumItems() {
	return getIniVal('numItems');
}

function getNumItemsHome() {
	return getIniVal('numItemsStart');
}

function getPassword() {
	return getIniVal('numItemsStart');
}

function getEditorialPic() {
	return getIniVal('editorialPic');
}

// setter functions for init files

function setIniVal($key, $val) {
	global $prefs;
	return $prefs[$key] = $val;
}

function setNumItems($val) {
	return setIniVal('numItems', $val);
}

function setNumItemsHome($val) {
	return setIniVal('numItemsStart', $val);
}

function setPassword($val) {
	return setIniVal('numItemsStart', $val);
}

function setEditorialPic($val) {
	return setIniVal('editorialPic', $val);
}

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
	$string .= "\t" . "\t" . "\t" . '<img src="' . getBannerAd() . '" id="ad" alt="ad"/>' . "\n";

	// end div
	$string .= "\t" . "\t" . '</div> <!-- id=banner -->' . "\n";

	return $string;
}

// gets the next banner to be displayed as a string
function getBannerAd() {
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

function getBanners() {
	// setup banner array
	$banners = array();

	// get all the lines
	$lines = return_file_as_array(BANNER);

	// find the lowest display value
	foreach ($lines as $line) {
		// explode each line, getting the filename, weight, and count
		list($fileName, $weight, $count) = explode("|", $line);
		// $displayVal = ($weight * $count);

		// push to associative array
		array_push($banners, array("fileName" => $fileName, "weight" => intval($weight), "count" => intval($count)));
	}

	return $banners;
}

function setBanners($banners) {
	// open file
	$file = fopen(BANNER, "w") or die("Cannot open　" . BANNER);

	$content = "";

	// create the data to write
	foreach ($banners as $banner) {
		$content .= $banner['fileName'] . "|";
		$content .= $banner['weight'] . "|";
		$content .= $banner['count'] . "\n";
	}

	// write only if it has data
	if (!empty($content)) {
		$result = fwrite($file, $content) > 0;
	}

	// close file
	fclose($file);
}

function bannerSort($a, $b) {
	// compare their display value
	$one = $a['weight'] * $a['count'];
	$two = $b['weight'] * $b['count'];
	$result = $one - $two;

	if ($result == 0) {
		// compare their weight
		$one = $a['weight'];
		$two = $b['weight'];
		$result = $one - $two;
	}

	if ($result == 0) {
		// compare their count
		$one = $a['count'];
		$two = $b['count'];
		$result = $one - $two;
	}

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

function addNewsContent($includeEditorial = false, $offset = 0, $numItems, $includeNewsNav = false) {
	// create container div
	$result = '<div id="content" class="noFloat roundBox">' . "\n";

	// create the editorial
	if ($includeEditorial) {
		$result .= addEditorial();
	}

	// create the news items
	$result .= addNews($offset, $numItems);

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
	$result .= '<img src="img/' . getEditorialPic() . '" alt="editor" />' . "\n";

	// get editorial
	$result .= getEditorial();

	// close div
	$result .= '</div> <!-- id="editorial -->' . "\n";

	// return the result
	return $result;
}

// grab from editorial.txt file
function getEditorial() {
	return file_get_contents(EDITORIAL);
}

function setEditorial($content) {
	$result = false;
	// open file
	$file = fopen(EDITORIAL, "w") or die("Cannot open　" . EDITORIAL);

	// write only if it has data
	if (!empty($content)) {
		$result = fwrite($file, $content) > 0;
	}

	// close file
	fclose($file);

	return $result;
}

function addNews($offset, $numItems) {
	// setup container div
	$result = '<div id="news" class="roundBox">' . "\n";

	// add the heading
	$result .= "<h1>News</h1>" . "\n";

	// get X news items
	$newsItems = getXStories($offset, $numItems);

	// loop thru the stories
	foreach ($newsItems as $newsItem) {

		// set up the news item container
		$result .= '<div class="newsItem">' . "\n";

		// setup container
		$result .= "<p>" . "\n";

		// set up the subject
		$result .= '<span class="newsSubject">' . $newsItem['subject'] . '</span>' . "\n";

		// set up the date
		$result .= '<span class="newsDate">' . $newsItem['date'] . '</span>' . "\n";

		// close the container
		$result .= "</p>" . "\n";

		// set up the story
		$result .= "<p>" . $newsItem['story'] . "</p>" . "\n";

		// close the news item container
		$result .= '</div> <!-- class="newsItem" -->' . "\n";

	}

	// close container div
	$result .= '</div> <!-- id="news" class="roundBox" -->' . "\n";

	return $result;
}

// Grab x number of items from the file, starting from the specific offset
function getXStories($offset, $numItems, $getAll = false) {
	global $totalNewsItems, $pageNum, $maxPages, $numNewsItems;

	// setup result
	$result = array();

	// TODO: Read file in a more optimistic way
	// instead of getting the entire contents of the file, just get what you need

	// non-optimistic way

	// get file contents as array
	$news = return_file_as_array(NEWS);

	// print_r($news);
	// get how many news items there are
	$newsLength = count($news);

	// set global variable
	$totalNewsItems = $newsLength;
	// set the max number of pages
	$maxPages = intval($newsLength / $numItems);

	if ($offset < 0) {
		$offset = 0;
	} else if ($offset > $newsLength) {
		$offset = $newsLength - $numItems + 2;
		//+2 to handle zero based pages
	}

	// set the page num
	$pageNum = intval($offset / $numItems);

	// check if we are starting from outside our range
	if ($offset < $newsLength) {
		// check if we exceed our range
		if ($offset + $numItems > $newsLength) {
			$numItems = $newsLength - $offset;
		}

		$numNewsItems = $numItems;

		// if they want all stories
		if ($getAll) {
			$offset = 0;
			$numItems = $newsLength;
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

function addNewsNav() {
	global $pageNum, $maxPages, $numNewsItems, $prefs;

	// do this to avoid zero based page confusion
	$pageNum = $pageNum + 1;
	$maxPages = $maxPages + 1;

	if ($pageNum > $maxPages) {
		$pageNum = $maxPages;
	}

	// setup result
	$result = "";

	// setup container div
	$result .= "<div>" . "\n";

	$end = $pageNum * $prefs["numItems"];
	// $numNewsItems;
	$start = $end - $numNewsItems + 1;

	// TODO: fix bug with last page.
	$result .= "<span id='numItemsShowing'>Showing news items: $start - $end</span>" . "\n";

	// setup container
	$result .= "<span id='newsNav'>" . "\n";

	// setup the page links
	if ($pageNum > 1) {
		$result .= "<a href='news.php?page=1'>&lt;&lt;</a> ";
		$result .= "<a href='news.php?page=" . ($pageNum - 1) . "'>&lt;</a> ";
	}

	$result .= "<span id='curNewsPage'>[" . ($pageNum) . "]</span> ";

	if ($pageNum < $maxPages) {
		$result .= "<a href='news.php?page=" . ($pageNum + 1) . "'>&gt;</a> ";
		$result .= "<a href='news.php?page=$maxPages'>&gt;&gt;</a> ";
	}

	// setup container
	$result .= "</span> <!-- id='newsNav -->" . "\n";

	// close container div
	$result .= "</div>" . "\n";

	//return result
	return $result;
}

function addStory($subject, $story) {
	$result = false;

	if (!empty($subject) && !empty($story)) {

		// get the date
		$date = date(DATE_TIME);

		// get the stories
		$stories = getXStories(0, 1, true);

		// add new story
		array_unshift($stories, array('date' => $date, 'subject' => $subject, 'story' => $story));

		// write stories back to file

		// open file
		$file = fopen(NEWS, "w") or die("Cannot open　" . NEWS);

		$content = "";

		// create the data to write
		foreach ($stories as $story) {
			$content .= $story['date'] . "|";
			$content .= $story['subject'] . "|";
			$content .= $story['story'] . "\n";
		}

		// write only if it has data
		if (!empty($content)) {
			$result = fwrite($file, $content) > 0;
		}

		// close file
		fclose($file);
	}
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

function addAdminLinks() {
	$result = "";

	// add links
	$result .= "<div id='adminLinksDiv'>" . "\n";
	$result .= "\t" . "<ul id='adminLinks'>" . "\n";
	$result .= "\t" . "\t" . "<li><a href='edit_ini.php'>Change Admin values</a>" . "\n";
	$result .= "\t" . "\t" . "<li><a href='edit_editorial.php'>Edit the Editorial</a>" . "\n";
	$result .= "\t" . "\t" . "<li><a href='add_story.php'>Add a story</a>" . "\n";
	$result .= "\t" . "\t" . "<li><a href='edit_ads.php'>Edit Ad Info</a>" . "\n";
	$result .= "\t" . "</ul> <!-- id='adminLinks' -->" . "\n";
	$result .= "\t" . "<br />" . "\n";
	$result .= "</div> <!-- id='adminLinksDiv' -->" . "\n";

	// return the result
	return $result;
}

function addINIEditForm() {
	global $prefs;

	// start result
	$result = "";

	// start form
	$result .= "<form action='' method='post'>" . "\n";

	$result .= "<fieldset>" . "\n";
	$result .= "<legend>Change Admin Values:</legend>" . "\n";

	// display inputs for the file
	foreach ($prefs as $key => $val) {
		$displayVal = $val;

		if ($key == "password") {
			$displayVal = "";
		}

		$result .= "<label for='$key'>$key</label>" . "\n";
		$result .= "<input type='text' name='$key' id='$key' value='$displayVal' />" . "\n";
		$result .= "<br />" . "\n";
	}

	$result .= "</fieldset>" . "\n";

	// add password protection
	$result .= "<label for='adminPass'>Enter Admin Password</label>" . "\n";
	$result .= "<input type='text' name='adminPass' id='adminPass'/>" . "\n";
	$result .= "<br />" . "\n";

	// add reset button
	$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

	// add submit button
	$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

	// close form
	$result .= "</form>" . "\n";

	// return result
	return $result;
}

function verifyKey($key, $val) {
	global $prefs;
	return $prefs[$key] == $val;
}

function isCorrectPassword($pass) {
	return verifyKey('password', $pass);
}

function addEditorialEditForm() {
	// start result
	$result = "";

	// start form
	$result .= "<form action='' method='post' >" . "\n";

	// add label
	$result .= "<h3>Edit Your Editorial</h3>" . "\n";

	// add text area for editorial
	$result .= "<textarea name='editorial' class='roundBox'>" . htmlspecialchars(getEditorial()) . "</textarea>" . "\n";
	$result .= "<br />" . "\n";

	// add password protection
	$result .= "<label for='adminPass'>Enter Admin Password</label>" . "\n";
	$result .= "<input type='text' name='adminPass' id='adminPass'/>" . "\n";
	$result .= "<br />" . "\n";

	// add reset button
	$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

	// add submit button
	$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

	// close form
	$result .= "</form>" . "\n";

	// return result
	return $result;
}

function addNewsAddForm() {
	// start result
	$result = "";

	// start form
	$result .= "<form action='' method='post'>" . "\n";

	$result .= "<h3>Add News Posting</h3>" . "\n";

	// display inputs
	$result .= "<input type='text' name='newsSubject' value='Subject or Title' />" . "\n";
	$result .= "<br />" . "\n";

	$result .= "<textarea name='story' class='roundBox'>Enter your news item here...</textarea>" . "\n";
	$result .= "<br />" . "\n";

	// add password protection
	$result .= "<label for='adminPass'>Enter Admin Password</label>" . "\n";
	$result .= "<input type='text' name='adminPass' id='adminPass' />" . "\n";
	$result .= "<br />" . "\n";

	// add reset button
	$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

	// add submit button
	$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

	// close form
	$result .= "</form>" . "\n";

	// return result
	return $result;
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

function addEditAdForm() {
	$result = "";

	// get the banners
	$banners = getBanners();

	// setup container
	//$result = "<div class='midBox'>";

	// start form
	$result .= "<form action='' method='post'>" . "\n";

	$result .= "<h3>Edit Banner Info</h3>" . "\n";

	$result .= "<fieldset>";

	// $result .= "<p class='ad_Label' style='margin-left: 6em;'>Count <span style='margin-left: 1em;'>Weight</span></p>";
	$result .= "<p class='ad_Label' >Count <span>Weight</span></p>";

	// display inputs
	foreach ($banners as $banner) {
		$result .= "<img alt='" . $banner['fileName'] . "' src='" . BANNER_PATH . $banner['fileName'] . "' />" . "\n";
		$result .= "<input class='adInput' type='hidden' name='" . urlencode($banner['fileName']) . "' value='" . urlencode($banner['fileName']) . "'/>" . "\n";

		$result .= "<input class='adInput' type='text' name='" . urlencode($banner['fileName']) . "_weight' value='" . $banner['weight'] . "'/>" . "\n";

		$result .= "<input class='adInput' type='text' name='" . urlencode($banner['fileName']) . "_count' value='" . $banner['count'] . "'/>" . "\n";

		$result .= "<br />" . "\n";
	}

	$result .= "<input type='hidden' name='test.test.test.png' value='test.test.test.png' />";

	$result .= "</fieldset>";

	// add password protection
	$result .= "<label for='adminPass'>Enter Admin Password</label>" . "\n";
	$result .= "<input type='text' name='adminPass' id='adminPass' />" . "\n";
	$result .= "<br />" . "\n";

	// add reset button
	$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

	// add submit button
	$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

	// close form
	$result .= "</form>" . "\n";

	// setup container
	//$result .= "<div> <!-- class='midbox' -->";

	return $result;
}
?>