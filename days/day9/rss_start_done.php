<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Day 9 - Parsing RSS Namespaces</title>
</head>
<body>
<h1>Day 9 - Parsing RSS Namespaces</h1>
<?php
ini_set('display_errors', 1);
$top_ten_url = "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/topsongs/limit=10/rss.xml";
$weather_url="http://weather.yahooapis.com/forecastrss?p=14450";

echo "<h2><u>Part 1 - Yahoo Weather RSS Feed</u></h2>";
// instantiate DOMDocument and load weather file
$dom = new DomDocument();
$dom->load($weather_url);

// get first title tag
$title = $dom->getElementsByTagName("title")->item(0)->nodeValue;
echo "<h3>$title</h3>";

// get yweather:astronomy
$yweather = "http://xml.weather.yahoo.com/ns/rss/1.0";
$astronomy = $dom->getElementsByTagNameNS($yweather,'astronomy')->item(0);
$sunrise = $astronomy->getAttribute('sunrise');
$sunset = $astronomy->getAttribute('sunset');

echo "<h3>sunrise=$sunrise</h3>";
echo "<h3>sunset=$sunset</h3>";

// get first item of feed
$item = $dom->getElementsByTagName('item')->item(0);
// get latitude and longitude
$geoNS = $dom->lookupNamespaceURI('geo');
$lat = $item->getElementsByTagNameNS($geoNS,'lat')->item(0)->nodeValue;
$long = $item->getElementsByTagNameNS($geoNS,'long')->item(0)->nodeValue;
echo "<h4>lat=$lat</h4>";
echo "<h4>long=$long</h4>";


// echo <description>
echo $item->getElementsByTagName('description')->item(0)->nodeValue;


/*
$dom = new DomDocument();
$data = file_get_contents2($weather_url);
$dom->loadXML($data);
//$dom->load($weather_url);

// echo <title> 3 ways
$title = $dom->getElementsByTagName("channel")->item(0)->getElementsByTagName("title")->item(0)->nodeValue;
echo "<h3>$title</h3>";
// echo <yweather:astrononmy sunrise> - first, define a variable to hold the 'yweather' namespace
$yweather = "http://xml.weather.yahoo.com/ns/rss/1.0";
$sunrise = $dom->getElementsByTagNameNS($yweather,'astronomy')->item(0)->getAttribute('sunrise');
$sunset = $dom->getElementsByTagNameNS($dom->lookupNamespaceURI('yweather'),'astronomy')->item(0)->getAttribute('sunset');
echo "<h4>sunrise - $sunrise</h4>\n";
echo "<h4>sunset - $sunset</h4>\n";

// echo <geo:lat> and <geo:long> - first, define a variable to hold the 'geo' namespace
$geo= "http://www.w3.org/2003/01/geo/wgs84_pos#";

// echo <description>
echo $dom->getElementsByTagName('item')->item(0)->getElementsByTagName('description')->item(0)->nodeValue;

*/

// Part 2 - You do this - Go ahead and parse an Apple Top 10 List
// print out each song <title> and <itms:album> in un-ordered list 
echo "<hr />";
echo "<h2><u>Part 2 - Apple Top 10 RSS Feed</u></h2>";
?>
</body>
</html>

<?php
function file_get_contents2( $url )
{
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle compressed
		CURLOPT_USERAGENT      => "spider", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $content;
}


?>