<?php
require_once ("LIB_project1.php");
require_once ("P2_Utils.class.php");

// perform form verfication
$passed = false;
$errors = "";

$adminField = "adminPass";

// check if submitted and has the correct password
if (isset($_POST['submit']) && isset($_POST[$adminField]) && isCorrectPassword($_POST[$adminField])) {
	// TODO: better form validation

	// setup feeds
	$feeds = array();

	// check if set
	if ((isset($_POST['feeds'])) && is_array($_POST['feeds'])) {
		// get fields
		$feeds = $_POST['feeds'];
	}

	$feedCount = count($feeds);

	$min = 0;
	$max = 10;

	// check if the amount selected falls in the range
	if ($feedCount >= $min && $feedCount <= $max) {
		P2_Utils::saveFeeds(P2_Utils::$feedXMLName, $feeds);
		$passed = true;
	} else {
		$errors .= "<p>You can only select $min to $max feeds. <br />You selected: " . $feedCount . " feeds.</p>";
	}

	// reset the feeds
	$feeds = array();

	// check if set
	if ((isset($_POST['webfeeds'])) && is_array($_POST['webfeeds'])) {
		// set the ini file
		$feeds = $_POST['webfeeds'];
	}
	$feedCount = count($feeds);

	$min = 0;
	$max = 3;

	// check if the amount selected falls in the range
	if ($feedCount >= $min && $feedCount <= $max) {
		P2_Utils::saveFeeds(P2_Utils::$choosenWebFeeds, $feeds);
		$passed = true;
	} else {
		$errors .= "<p>You can only select $min to $max feeds. <br />You selected: " . $feedCount . " feeds.</p>";
	}

}

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

if (isset($_POST['submit'])) {
	// show acknowledgement div
	$output .= "<br /> <div id='fromAcknowledge'>";

	// if right password
	if ($passed) {
		$output .= "<p>Values successfully changed</p>";
	} else {
		// else show error
		$output .= "<p class='formFail'>you FAIL!</p>";
		$output .= $errors;
	}

	// close acknowledgement div
	$output .= "</div> <!-- id='fromAcknowledge' -->";
}

// add the choose feeds form
$output .= P2_Utils::addFeedForm();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>