<?php

	define("BASE_URL", "http://nova.it.rit.edu/~pjm8632/539/project3/A/service/");
	define("NEWS_URL", BASE_URL."get_news.php");	
	define("ADS_URL", BASE_URL."get_ads.php");
	define("BANNER_URL", BASE_URL."get_banner.php");
	define("BANNER_URL", BASE_URL."get_editorial.php");
	
	
	echo "Testing the getItem function";
	$result = getItem(NEWS_URL);
	var_dump($result);
	
	
	function getItem($url){
		// TODO: add error checking if url exits
		
		// create a DOM object to parse the page
		$dom = new DOMDocument();
		$dom->load($url);
		
		// grab the page info
		$pageNumber = $dom->getElementsByTagName('page')->item(0)->getAttribute("pageNumber");
		$totalPages = $dom->getElementsByTagName('page')->item(0)->getAttribute("totalPages");
		$numberPerPage = $dom->getElementsByTagName('page')->item(0)->getAttribute("numberPerPage");	
		
				
		$result = array();
		$result['pageNumber'] = $pageNumber;
		$result['totalPages'] = $totalPages;	
		$result['numberPerPage'] = $numberPerPage;
		
		return $result;
	}
?>