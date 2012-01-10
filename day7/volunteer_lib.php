<?php

global $array, $phrases;

$phrases = array('knows all the answers!', 'is thrilled to be a volunteer!', 'desires to be called on everytime!', 'loves being the volunteer!', 'would like to be the sole volunteer for the rest of the quarter!');

function html_header($title = "Untitled", $styles = "") {
	$string = <<<END
			<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http--equiv="content-type" content="text/html;charset=utf-8" />
				<title>$title</title>
				<link type="text/css" rel="stylesheet" href="$styles" />
			</head>
			<body>
END;

	return $string;
}

function html_footer($text = "") {
	$string = <<<END
			<p><em>$text</em></p>
			</body>
			</html>
END;

	return $string;
}

function show_form() {
	$string = <<<END
	
	<form action="" method="POST">
		<input type="submit" name="submit" value="Get a volunteer!" />
	</form>
	
END;
	return $string;
}

function return_file_as_array($path) {
	if (file_exists($path) && is_readable($path)) {
		return @file($path);
	} else {
		die("<strong>Problem loading file at #path!</strong>");
	}
}

/*
 *Initializes the array of people, by first grabbing the data from a file, then
 * formatting each of the values to match the desired format
 */
function init_data() {
	global $array;

	// load the data file & place in the $array global
	$array = return_file_as_array($path = DATA_URL);

	// Current data: lastName, firstName
	// format to: firstName lastName
	foreach ($array as $key => $fullName) {
		$array[$key] = firstLastName(@$fullName);
	}

}

/*
 * Expects that the $fullName is in this format:
 * 		lastName, firstname
 *
 * Then converts it to firstName lastName
 */
function firstLastName($fullName) {
	// echo $fullName."<br />";

	$result = '';

	$pieces = explode(',', $fullName);

	$result = $pieces[1] . " " . $pieces[0];

	// echo $result."<br />";

	return $result;
}

function check_submit() {
	global $array, $phrases;

	// check if submit was pressed, using $_POST and submit
	if (array_key_exists("submit", $_POST)) {
		// pick a random person
		$person = $array[array_rand($array)];

		// pick a random phrase
		$phrase = $phrases[array_rand($phrases)];

		$string = <<<END

		<p><strong>$person $phrase</p></strong>
		
END;

		return $string;
	}
}

function show_people() {
	global $array;

	$string = '';
	$string .= '<ul>';

	// loop through people
	foreach ($array as $person) {
		$string .= "<li>$person</li>";
	}

	$string .= '</ul>';

	return $string;
}
?>

