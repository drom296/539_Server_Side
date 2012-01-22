<?php
require ("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Add a Story", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// start content container
$output .= startContentDiv();

// add the admin stuff
$output .= addAdminLinks();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>