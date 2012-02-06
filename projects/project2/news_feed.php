<?php
require_once("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Edit Admin Values", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// start content container
$output .= startContentDiv();

// add the admin stuff
$output .= addAdminLinks();

// add the choose feeds form
$output .= addFeedForm();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>