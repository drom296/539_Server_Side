<?php
require ("LIB_project1.php");

// perform form verfication
$passed = false;

$adminField = "adminPass";

// check if submitted and has the correct password
if (isset($_POST['submit']) && isset($_POST[$adminField]) && isCorrectPassword($_POST[$adminField])) {
	// TODO: better form validation

	// check if set
	if ((isset($_POST['newsSubject']) && !empty($_POST['newsSubject'])) && 
			(isset($_POST['story']) && !empty($_POST['story']))) {
		// set the ini file
		$passed = addStory($_POST['newsSubject'], $_POST['story']);
	}
}

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

if (isset($_POST['submit'])) {
	// show acknowledgement div
	$output .= "<br /> <div id='fromAcknowledge'>";

	// if right password
	if ($passed) {
		$output .= "<p>Values successfully changed</p>";
	} else {
		// else show error
		$output .= "<p class='formFail'>you FAIL!</p>";
	}

	// close acknowledgement div
	$output .= "</div> <!-- id='fromAcknowledge' -->";
}

// add edit editorial form
$output .= addNewsAddForm();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>