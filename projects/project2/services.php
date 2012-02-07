<?php
require("LIB_project1.php");
require_once ("P2_Utils.class.php");

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("News", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// start content container
$output .= startContentDiv();

// add the news feeds
$output .= P2_Utils::addNewsFeeds(P2_Utils::$feedXMLName);

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>