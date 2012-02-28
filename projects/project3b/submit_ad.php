<?php
require ("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css", "css/form.css");

// create header tags
$output = html_header("Ads", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

////// CONTENT
$output .= startContentDiv();

// check if they submitted the form

// check if they have all the required fields

// make the request using MyCurl class

// display the result

// else display the form

// add the form for submitting an ad

$output .= displaySubmitAdForm();


$output .= closeContentDiv();
///// FOOTER

// create footer
$output .= html_footer("");

echo $output;
?>