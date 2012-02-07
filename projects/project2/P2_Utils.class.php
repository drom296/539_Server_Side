<?php

require_once ("RSSFeed.class.php");

class P2_Utils {
	private static $fileName = "project2.rss";
	public static $feedXMLName = "data/feeds.xml";
	
	private static $feeds = 'http://www.ist.rit.edu/~bdf/539/project2/rss_class.xml';
	public static $webFeeds = 'data/webfeeds.xml';
	
	public static $choosenWebFeeds = 'data/choosenwebfeeds.xml'; 

	public static function createRSS($title, $description, $items, $link = "http://people.rit.edu/pjm8632/539/project2/news.php") {
		// create the RSSFeed DOM
		$dom = RSSFeed::createRSSFeed($title, $link, $description, $items);

		// save the dom
		$dom -> save(self::$fileName);
	}

	public static function getFeeds() {
		// setup the dom
		$dom = new DOMDocument();
		$dom -> load(self::$feeds);

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
		$choosenFeedLinks = self::getChoosenFeedLinks(self::$feedXMLName);

		// setup checkboxes for each of the feeds
		foreach ($feeds as $feed) {
			$result .= "<input type='checkbox' name='feeds[]' value='" . $feed['link'] . "'";

			// check if it was selected previously
			if (in_array($feed['link'], $choosenFeedLinks)) {
				$result .= " checked='checked' ";
			}

			$result .= "/>";
			$result .= $feed['name'] . "<br />";
		}

		// The web services
		// get the web services links
		$webFeeds = self::getWebFeeds();
		
		
		// ********************WEB FEEDS********************
		 
		$result .= "<h2>Web Feeds</h2>";
		
		// setup checkboxes for each of the feeds
		$choosenFeedLinks = self::getChoosenFeedLinks(self::$choosenWebFeeds);
		
		foreach ($webFeeds as $feed) {
			$result .= "<input type='checkbox' name='webfeeds[]' value='" . $feed['link'] . "'";

			// check if it was selected previously
			if (is_array($choosenFeedLinks) && in_array($feed['link'], $choosenFeedLinks)) {
				$result .= " checked='checked' ";
			}

			$result .= "/>";
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

	public static function getWebFeeds(){
		// setup the dom
		$dom = new DOMDocument();
		$dom -> load(self::$webFeeds);

		$feeds = array();

		// grab all the feeds
		$items = $dom -> getElementsByTagName('feed');

		foreach ($items as $item) {
			// grab the name
			$name = $item -> getElementsByTagName('name') -> item(0) -> nodeValue;

			// grab their link
			$link = $item -> getElementsByTagName('url') -> item(0) -> nodeValue;

			// push it to the feeds
			$feeds[] = array("name" => $name, "link" => $link);
		}

		return $feeds;
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
	public static function saveFeeds($fileName, $feeds) {
		
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
		$dom -> save($fileName);
	}

	public static function getChoosenFeedLinks($xml) {
		$feeds = null;

		// check if file exists and is readable
		if (file_exists($xml) && is_readable($xml)) {
			$fileName = $xml;
			$feeds = array();

			// load up the DOM
			$dom = new DOMDocument();
			$dom -> load($fileName);

			// get the feeds
			$urls = $dom -> getElementsByTagName('url');

			for ($i = 0, $len = $urls -> length; $i < $len; $i++) {
				$feeds[] = $urls -> item($i) -> nodeValue;
			}
		}

		return $feeds;
	}

	public static function addNewsFeeds($xml) {
		$result = "";

		// the title
		$result .= "<h1>News Feeds</h1>";

		// link to my RSS
		$result .= "<p class='rssFeed'><a href='project2.rss'>RSS Feed</a></p>";

		$result .= "<div id='feeds' class='roundBox'>";

		// grab all the URLS for the feeds
		$urls = self::getChoosenFeedLinks($xml);
		
		if(count($urls) == 0){
			$result .= "<p>No news feeds selected</p>";
		}

		foreach ($urls as $rss) {
			$result .= "<div class='feed roundBox'>";
			// check to see if its a valid link
			// check if the RSS passes validation
			if (self::validRSS($rss) || self::old_validRSS($rss)) {

				// setup the dom
				$dom = new DOMDocument();
				$dom -> load($rss);

				// grab the feeds name
				$feedName = $dom -> getElementsByTagName('title') -> item(0) -> nodeValue;

				// grab the description
				$feedDesc = $dom -> getElementsByTagName('description') -> item(0) -> nodeValue;

				// grab the feeds link
				$feedLink = $dom -> getElementsByTagName('link') -> item(0) -> nodeValue;

				$result .= "<h2><a href='$feedLink'>$feedName</a></h2>";
				$result .= "<p>$feedDesc</p>";

				// grab the items
				$items = $dom -> getElementsByTagName('item');

				$result .= "<div class='feedItems'>";
				// foreach ($items as $item) {
				for ($i = 0, $len = $items -> length; $i < 2; $i++) {
					$item = $items -> item($i);
					// show the items

					// get the subject
					$subject = $item -> getElementsByTagName('title') -> item(0) -> nodeValue;

					// get the link
					$link = $item -> getElementsByTagName('link') -> item(0) -> nodeValue;

					// get the date
					$date = $item -> getElementsByTagName('pubDate') -> item(0) -> nodeValue;

					// get the story
					$story = $item -> getElementsByTagName('description') -> item(0) -> nodeValue;

					// set up the news item container
					$result .= '<div class="newsItem">' . "\n";

					// setup container
					$result .= "<p>" . "\n";

					// set up the subject
					$result .= '<span class="newsSubject">' . $subject . '</span>' . "\n";

					// set up the date
					$result .= '<span class="newsDate">' . $date . '</span>' . "\n";

					// close the container
					$result .= "</p>" . "\n";

					// set up the story
					$result .= "<p>" . $story . "</p>" . "\n";

					// close the news item container
					$result .= '</div> <!-- class="newsItem" -->' . "\n";

				}
				$result .= "</div>";

			} else {
				$result .= "<p>$rss is an invalid RSS feed";
			}

			// add separator
			$result .= "</div>";
			// $result .= "<hr />";
		}

		$result .= "</div>";

		return $result;
	}

	public static function old_validRSS($rss) {
		$result = false;

		// setup url for validator service
		$validator = 'http://feedvalidator.org/check.cgi?url=';

		// get the result
		$valResult = @file_get_contents($validator . urlencode($rss));

		// if we have a result
		if ($valResult) {
			// create a dom doc from it
			$dom = new DOMDocument();
			$success = @$dom -> loadHTML($valResult);

			if ($success) {
				// grab the first h2
				$valResult = $dom -> getElementsByTagName('h2') -> item(0) -> nodeValue;

				// what to look for
				$validString = "Congratulations!";

				// check if we can find it
				if (stristr($valResult, $validString) != false) {
					$result = true;
				}
			}
		}
		return $result;
	}

	public static function validRSS($rss) {
		$result = false;

		// go the schema route
		$xml = new DOMDocument();
		$success = @$xml -> load($rss);

		if ($success) {
			// validate
			$result = @$xml -> schemaValidate("rss-2_0.xsd");
		}

		return $result;
	}

}

// $rss = "http://people.rit.edu/pjm8632/539/project2/project2.rss";
// $rss2 = "http://people.rit.edu/~dxc8808/539/project2/project2.rss";
// echo P2_Utils::old_validRSS($rss);
// echo P2_Utils::old_validRSS($rss2);
?>