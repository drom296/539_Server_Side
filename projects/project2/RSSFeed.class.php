<?php

class RSSFeed {
	private $rssDom;
	public $link;
	public $title;
	public $desc;
	public $lang;

	public function _construct($title, $link, $description, $language = "en-us") {
		$this -> link = $link;
		$this -> title = $title;
		$this -> desc = $description;
		$this -> lang = $language;
		$this -> rssDom = new DOMDocument('1.0', 'utf-8');

	}

	public function getRSSDOM() {
		return $this -> rssDom;
	}

	public function setupRSSDOM($title, $link, $description, $lang = "en-us") {
		$dom = new DOMDocument('1.0', 'utf-8');

		// create the RSS tag and append
		$rss = $dom -> createElement("rss");
		$rss -> setAttribute("version", "2.0");

		// create the channel tag and append to the rss
		$channel = $dom -> createElement("channel");

		// create and add the title to the channel
		$channel -> appendChild($dom -> createElement("title", $title));

		// create and add the link
		$channel -> appendChild($dom -> createElement("link", $link));

		// create and add the description
		$channel -> appendChild($dom -> createElement("description", $description));

		// create and add the description
		$channel -> appendChild($dom -> createElement("language", $lang));

		// append the channel to the rss
		$rss -> appendChild($channel);

		// append the rss to the doc
		$dom -> appendChild($rss);

		return $dom;

		// example
		// <title>The title of my RSS 2.0 Feed</title>
		// <link>http://www.example.com/</link>
		// <description>This is my rss 2 feed description</description>
		// <lastBuildDate>Mon, 12 Sep 2005 18:37:00 GMT</lastBuildDate>
		// <language>en-us</language>
	}

	public function _destruct() {
		$dom -> close();
	}

	/**
	 * Creates an rss field from the items. Was trying to modularize this massive
	 * function, but for some reason my variables werent being set in the contructor.
	 * So I moved on
	 *
	 * @param $items -> 2 dimensional array with the second dimension being the item
	 * 		contained in an associated array
	 *
	 * @param $titleName -> the key for the title
	 * @param $descName -> the key for the description
	 * @param $dateName -> the key for the date
	 */
	public static function createRSSFeed($title, $link, $description, $items, $lang = "en-us", $titleName = "subject", $descName = "story", $dateName = "date") {

		$dom = new DOMDocument('1.0', 'utf-8');

		// create the RSS tag and append
		$rss = $dom -> createElement("rss");
		$rss -> setAttribute("version", "2.0");

		// create the channel tag and append to the rss
		$channel = $dom -> createElement("channel");

		// create and add the title to the channel
		$channel -> appendChild($dom -> createElement("title", $title));

		// create and add the link
		$channel -> appendChild($dom -> createElement("link", $link));

		// create and add the description
		$channel -> appendChild($dom -> createElement("description", $description));

		// create and add the description
		$channel -> appendChild($dom -> createElement("language", $lang));

		foreach ($items as $item) {
			// create the RSS item
			$rssItem = self::createItem($dom, $item[$titleName], $link, $item[$dateName], $item[$descName]);
			// add it to the doc
			$channel -> appendChild($rssItem);
		}

		// append the channel to the rss
		$rss -> appendChild($channel);

		// append the rss to the doc
		$dom -> appendChild($rss);

		return $dom;
	}

	public static function createItem($dom, $title, $link, $date, $desc) {
		// create the item tag
		$item = $dom -> createElement("item");

		// create and add the title
		$item -> appendChild($dom -> createElement("title", $title));

		// create and add the link
		$item -> appendChild($dom -> createElement("link", $link));

		// create and add the date
		// format the date
		$dt = new DateTime($date, new DateTimeZone('GMT'));

		// $date = $dt -> format("D, d M Y G:i:s e");
		$date = $dt -> format("D, d M Y G:i:s");
		// TODO: This is wrong and should be fixed
		$date .= " GMT";

		$item -> appendChild($dom -> createElement("pubDate", $date));

		// In CFML the DateFormat mask would be ddd, dd mmm yyyy and the
		// TimeFormat would be HH:mm:ss. Dates should be offset to GMT.

		// create and add the description
		$descNode = $dom -> createElement("description");
		$descNode -> appendChild($dom -> createCDATASection($desc));
		$item -> appendChild($descNode);

		return $item;

		// example
		// <item>
		// <title>Title of an item</title>
		// <link>http://example.com/item/123</link>
		// <pubDate>Mon, 12 Sep 2005 18:37:00 GMT</pubDate>
		// <description>[CDATA[ This is the description. ]]</description>
		// </item>
		// <!-- put more items here -->
	}
}
?>