<?php

require_once ("RSSFeed.class.php");

$title = "Pedro Test";
$link = "www.google.com";
$desc = "this is a test";

$items = array();
$items[] = array("subject" => "Pedro", "story" => "this is going to fail", "date" => "today");
$items[] = array("subject" => "Dario", "story" => "this is going to fail twice", "date" => "tomorrow");

P2_Utils::createRSS($title, $desc, $items);

class P2_Utils {
	private static $fileName = "project2.rss";
	private static $feedXMLName = "data/feeds.xml";

	public static function createRSS($title, $description, $items, $link = "http://people.rit.edu/pjm8632/539/project2/news.php") {
		// create the RSSFeed DOM
		$dom = RSSFeed::createRSSFeed($title, $link, $description, $items);

		// save the dom
		$dom -> save(self::$fileName);
	}

	public static function getFeeds() {
		// setup the dom
		$dom = new DOMDocument();
		$dom -> load(FEEDS);

		$feeds = array();

		// grab all the students
		$students = $dom -> getElementsByTagName('student');

		foreach ($students as $student) {
			// grab the first name
			$first = $student -> getElementsByTagName('first') -> item(0) -> nodeValue;

			// grab the last name
			$last = $student -> getElementsByTagName('last') -> item(0) -> nodeValue;

			// grab their link
			$link = $student -> getElementsByTagName('url') -> item(0) -> nodeValue;

			// push it to the feeds
			$feeds[] = array("name" => $first . " " . $last, "link" => $link);
		}

		return $feeds;
	}

	public static function addFeedForm() {
		// start the result
		$result = "";

		// start form
		$result .= "<form action='' method='post' class='feedForm'>" . "\n";

		// add label
		$result .= "<h3>Choose Feeds</h3>" . "\n";

		// add a div for the feeds
		$result .= "<div class='feeds'>";

		// get listing of feeds to choose from
		$feeds = self::getFeeds();
		
		// get listing of the choosen fields
		$choosenFeedLinks = self::getChoosenFeedLinks();

		// setup checkboxes for each of the feeds
		foreach ($feeds as $feed) {
			$result .= "<input type='checkbox' name='feeds[]' value='" . $feed['link'] . "'";
			
			// check if it was selected previously
			if(in_array($feed['link'], $choosenFeedLinks)){
				$result .= " checked='checked' ";
			}
			
			$result .=  "/>";
			$result .= $feed['name'] . "<br />";
		}

		// close a div for the feeds
		$result .= "</div>";

		// add password protection
		$result .= "<label for='adminPass'>Enter Admin Password</label>" . "\n";
		$result .= "<input type='text' name='adminPass' id='adminPass'/>" . "\n";
		$result .= "<br />" . "\n";

		// add reset button
		$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

		// add submit button
		$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

		// close form
		$result .= "</form>" . "\n";

		// return the result
		return $result;
	}

	/**
	 * Takes the feeds associative array and creates an xml document from it
	 *
	 * <students>
	 * 	<student>
	 * 		<name>Pedro</name>
	 * 		<url>www.google.com</url>
	 * 	</student>
	 * </students>
	 */
	public static function saveFeeds($feeds) {
		// create a dom
		$dom = new DOMDocument('1.0', 'utf-8');

		// setup the root node
		$feedXML = $dom -> createElement("feeds");

		// save the feed
		foreach ($feeds as $feed) {
			$feedItem = $dom -> createElement("url", $feed);
			$feedXML -> appendChild($feedItem);
		}

		// attach the students to the dom
		$dom -> appendChild($feedXML);
		// save the dom
		$dom -> save(self::$feedXMLName);
	}

	public static function getChoosenFeedLinks() {
		$feeds = null;

		// check if file exists and is readable
		if (file_exists(self::$feedXMLName) && is_readable(self::$feedXMLName)) {
			$fileName = self::$feedXMLName;
			$feeds = array();

			// load up the DOM
			$dom = new DOMDocument();
			$dom -> load($fileName);

			// get the feeds
			$urls = $dom -> getElementsByTagName('url');
			
			for($i=0, $len = $urls->length; $i<$len; $i++){
				$feeds[] = $urls->item($i)->nodeValue;
			}
		}

		return $feeds;
	}
	
	public static function addNewsFeeds(){
		$result = "";
			
		// the title
		$result .= "<h1>News Feeds</h1>";	
			
		return $result;
	}
}
?>