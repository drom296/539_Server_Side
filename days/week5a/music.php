<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Day 9 - Parsing RSS Namespaces</title>
	</head>
	<body>
		<h1>Day 9 - Parsing RSS Namespaces</h1>
		<?php

		// echo <description>
		// echo $item->getElementsByTagName('description')->item(0)->nodeValue;

		// Part 2 - You do this - Go ahead and parse an Apple Top 10 List
		// print out each song <title> and <itms:album> in un-ordered list
		echo "<h2><u>Part 2 - Apple Top 10 RSS Feed</u></h2>";
		echo "\n<h3>iTunes Top 10 Songs</h3>";

		$top_ten_url = "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/topsongs/limit=10/rss.xml";

		// instantiate DOMDocument and load weather file
		$dom = new DomDocument();
		$dom -> load($top_ten_url);

		// get the title
		// get all of the <joke> tags and put them in a DOMNodeList
		$all_items = $dom -> getElementsByTagName("item");

		// start list
		echo "\n<ul>";

		foreach ($all_items as $item) {
			// get the title
			$title = $item -> getElementsByTagName('title') -> item(0) -> nodeValue;

			// get the album from the itms namespace
			$geoNS = $dom -> lookupNamespaceURI('itms');
			$album = $item -> getElementsByTagNameNS($geoNS, 'album') -> item(0) -> nodeValue;

			echo "\n<li><h4>$title</h4><em>$album</em></li>";
		}
		
		echo "\n</ul>\n";
	?>
	</body>
</html>
<?php
function file_get_contents2($url) {
	$options = array(CURLOPT_RETURNTRANSFER => true, // return web page
		CURLOPT_HEADER => false, // don't return headers
		CURLOPT_FOLLOWLOCATION => true, // follow redirects
		CURLOPT_ENCODING => "", // handle compressed
		CURLOPT_USERAGENT => "spider", // who am i
		CURLOPT_AUTOREFERER => true, // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
		CURLOPT_TIMEOUT => 120, // timeout on response
		CURLOPT_MAXREDIRS => 10,        // stop after 10 redirects
	);

	$ch = curl_init($url);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);
	$header = curl_getinfo($ch);
	curl_close($ch);

	$header['errno'] = $err;
	$header['errmsg'] = $errmsg;
	$header['content'] = $content;
	return $content;
}
?>