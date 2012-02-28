<?php
require ("LIB_project1.php");

$styles = array("css/pedro.css", "css/nav.css", "css/form.css");

// create header tags
$output = html_header("Submit Your Ad Here", $styles);

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

////// CONTENT
$output .= startContentDiv();

// check if they submitted the form
var_dump($_GET);

// check if they have all the required fields
$reqFields = array("edition", "content", 'title');

if (isset($_GET['submit'])) {
	// check if they submitted everything
	if (arrayContainsVals($_GET, $reqFields)) {

		// start building the post array
		$post = array();
		foreach ($reqFields as $field) {
			$post[$field] = $_GET[$field];
		}

		echo '<br /><br />This is the post';
		var_dump($post);

		// make the request using MyCurl class
		$response = submitAd($post);

		// display the result
		$output .= '<div class="submitAdResponse">'.$response.'</div>'; 

	} else {
		// they did not pass

		$output .= '<div class="submitAdResponse submitError">Failed to submit ad. All fields are required.</div>';
	}
}

$output .= displaySubmitAdForm();

$output .= closeContentDiv();
///// FOOTER

// create footer
$output .= html_footer("");

echo $output;
?>