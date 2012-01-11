<?php
	$ua = $_SERVER['HTTP_USER_AGENT'];
	
	ECHO "<p>Your user agent is: " . $ua . "</p>";
	
	// int stripos($haystack, $needle)
	// case insensitive string searching
	// returns index of first occurence of $needle in $haystack
	
	if (stripos($ua, "Firefox")){
		echo "<h2>You are surfing with Firefox!</h2>";
	} else{
		echo "<h2>Go download Firefox now!</h2>";
	}
	
	$mac = "Macintosh";
	$win = "Windows";
	$lin = "Linux";
	$os = "";
	
	if (stripos($ua, $mac)){
		$os = $mac;
	} else if (stripos($ua, $win)){
		$os = $win;
	} else if (stripos($ua, $lin)){
		$os = $lin;
	} else{
		$os = "UNKNOWN";
	}
	
	echo "<h2>Your operating system is $os</h2>"
?>