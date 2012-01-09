<?php

	global $array;
	
	function html_header($title="Untitled", $styles=""){
		$string=<<<END
			<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http--equiv="content-type" content="text/html;charset=utf-8" />
				<title>$title</title>
				<link type="text/css" rel="stylesheet" href="$styles" />
			</head>
			<body>
			END;
	}
	
	function html_footer($text=""){}

	function show_form(){}

	function return_file_as_array($path){}
	
	function check_submit(){}
	
	function show_people(){}
?>

