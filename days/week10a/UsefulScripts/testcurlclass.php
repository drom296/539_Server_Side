<?php
	require_once "MyCurl.class.php";
	$cookies ="cookie1=value1; cookie2=value2";
	$results = MyCurl::sendCookies("http://people.rit.edu/bdfvks/539/day19/submit.php","testing.txt",$cookies);
	echo "<h2>Cookies only</h2>";
	echo $results['output'];
	echo "<hr />";
	foreach($results['info'] as $key=>$result) {
		echo $key." = ".$result."<br />";
	}
	echo "<hr />";
	
	$data = array(
    		'foo' => 'foo foo foo',
    		'bar' => 'bar bar bar',
   			'baz' => 'baz baz baz'
	);

	$results = MyCurl::sendPost("http://people.rit.edu/bdfvks/539/day19/submit.php",$data);
	echo "<h2>POST only</h2>";
	echo $results['output'];
	echo "<hr />";
	foreach($results['info'] as $key=>$result) {
		echo $key." = ".$result."<br />";
	}
	echo "<hr />";
	$results = MyCurl::sendPostWithCookies("http://people.rit.edu/bdfvks/539/day19/submit.php",$data,"testing.txt",$cookies);
	echo "<h2>POST with Cookies</h2>";
	echo $results['output'];
	echo "<hr />";
	foreach($results['info'] as $key=>$result) {
		echo $key." = ".$result."<br />";
	}
	

?>