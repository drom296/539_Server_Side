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

// required fields
$reqFields = array("editions", "content", 'title');

// check if they submitted the form
if (isset($_GET['submit'])) {
	// check if they submitted everything
	if (arrayContainsVals($_GET, $reqFields)) {
		
		// implode the editions array
		$_GET['editions'] = implode(",", $_GET['editions']);
		
		// start building the post array
		$post = array();
		foreach ($reqFields as $field) {
			$post[$field] = $_GET[$field];
		}

		// make the request using MyCurl class
		$response = submitAd($post);
		
		// display the result
		$output .= '<div class="submitAdResponse">'.$response['output'].'</div>'; 

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