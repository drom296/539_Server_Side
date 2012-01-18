<?php

class MyUtils{

	static function html_header($title="Untitled",$styles=""){
		$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>$title</title>
	<link href="$styles" type="text/css" rel="stylesheet" />
</head>
<body>\n
END;
	return $string;
}


	static function html_footer($text=""){
		$string ="\n$text\n</body>\n</html>";
		return $string;
	}

} // end class


?>