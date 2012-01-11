<?php
	$site1 = "http://www.rit.edu";
	$reSite = "http://www.angelfire.com/super/badwebs/";

	$ua = $_SERVER['HTTP_USER_AGENT'];
	
	if (stripos($ua, "Firefox")){
			$reSite = $site1;
	} 

	header("Location: " . $reSite);
?>