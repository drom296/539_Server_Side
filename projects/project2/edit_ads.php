<?php
require ("LIB_project1.php");

// perform form verfication
$passed = false;

$adminField = "adminPass";

// check if submitted and has the correct password
if (isset($_POST['submit']) && isset($_POST[$adminField]) && isCorrectPassword($_POST[$adminField])) {

	// they passed!
	$passed = true;

	// TODO: better form validation
	// make sure the numItems values make sense and are numbers

	$changed = false;

	// get the banners
	$banners = getBanners();

	// for each of the fields we are looking
	foreach ($banners as &$banner) {
		$something = str_replace(".", "_", $banner['fileName']);

		$weight = $_POST[$something . "_weight"];
		$count = $_POST[$something . "_count"];

		// check if weight and count is set
		if (isset($weight) && !empty($weight) && isset($count) && !empty($count)) {
			$banner['weight'] = $weight;
			$banner['count'] = $count;
			$changed = true;
		}
	}
	
	// if changed
	if ($changed) {
		// update the banners file
		setBanners($banners);
	}
}

$styles = array("css/pedro.css", "css/nav.css");

// create header tags
$output = html_header("Edit Ad info", $styles);

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

// add ad edit form
$output .= addEditAdForm();

// close content container
$output .= closeContentDiv();

// create footer
$output .= html_footer("");

echo $output;
?>