<?php

require_once("RSSFeed.class.php");

$title = "Pedro Test";
$link = "www.google.com";
$desc = "this is a test";

$items = array();
$items[] = array("subject" => "Pedro", "story" => "this is going to fail", "date" => "today");
$items[] = array("subject" => "Dario", "story" => "this is going to fail twice", "date" => "tomorrow");

P2_Utils::createRSS($title, $desc, $items);

class P2_Utils {
	private static $fileName = "project2.rss";

	public static function createRSS($title, $description, $items, $link="http://people.rit.edu/pjm8632/539/project2/news.php") {
		// create the RSSFeed DOM
		$dom = RSSFeed::createRSSFeed($title, $link, $description, $items);
		
		// save the dom
		$dom->save(self::$fileName);
	}

}
?>