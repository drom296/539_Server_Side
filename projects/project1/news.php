<?php
require("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Pedro News - News", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// add news and editorial
$output .= addContent(false, 0, 5);

// add page navigation

// create footer
$output .= html_footer("");

echo $output;
?>