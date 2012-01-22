<?php
require ("LIB_project1.php");

// perform form verfication
$passed = false;

$fields = array('password', 'numItems', 'numItemsStart', 'editorialPic');

$adminField = "adminPass";

// check if submitted and has the correct password
if (isset($_POST['submit']) && isset($_POST[$adminField]) && isCorrectPassword($_POST[$adminField])) {

	// they passed!
	$passed = true;

// TODO: better form validation
// make sure the numItems values make sense and are numbers

	$changed = false;
	// for each of the fields we are looking
	foreach ($fields as $field) {
		// check if set
		if (isset($_POST[$field]) && !empty($_POST[$field])) {
			// set the ini file
			setIniVal($field, $_POST[$field]);
			$changed = true;
		}
	}
	// if changed
	if ($changed) {
		// update the ini file
		writeINIFile();
	}
}

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Pedro News - Home", $styles);

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

// add the edit ini form
$output .= addINIEditForm();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>