<?php
require("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Pedro News - Home", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// add news and editorial
$numItems = getNumItemsHome();
$output .= addNewsContent(true, 0, $numItems);

// add link to user info
$output .= "<p id='userLink'><a href='about.php'>Your Browser info</a></p>";

// start content container
$output .= startContentDiv();

// add the news feeds
$output .= P2_Utils::addNewsFeeds(P2_Utils::$choosenWebFeeds);

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>