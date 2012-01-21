<?php

function html_header($title = "Untitled", $styles = "") {
	$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>$title</title>
	<link type="text/css" rel="stylesheet" href="$styles" />
</head>
<body>\n
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

function return_file_as_array($path) {
	if (file_exists($path) && is_readable($path)) {
		return @file($path, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
	} else {
		die("<strong>Problem loading file at #path!</strong>");
	}
}
?>

