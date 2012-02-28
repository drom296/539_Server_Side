<?php
	$data = file_get_contents("http://www.cnn.com");
	
	echo "<h1>Here's your data!!<h1>\n" . $data;
?>