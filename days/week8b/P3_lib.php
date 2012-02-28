<?php

require_once ('Database.class.php');

function deleteCity() {
	$query = "delete from demo_zipcode where zip = ?";

	$vars = array("99999");
	$types = array("s");

	//get a singleton instance of the database class
	$db = Database::getInstance();

	$err = $db -> doQuery($query, $vars, $types);

	return $err;
}

function updateCity() {
	$query = "update demo_zipcode set county = ?, areacode = ? where zip = ?";

	$vars = array("Erie", "716", "99999");
	$types = array("s", "s", "s");

	//get a singleton instance of the database class
	$db = Database::getInstance();

	$err = $db -> doQuery($query, $vars, $types);

	return $err;
}

function insertCity() {
	// query:
	$sql = "insert into demo_zipcode values(?,?,?,?,?,?,?,?)";

	$vars = array("99999", "My City", "My County", "NY", "518", "40.81", "-73.04", "EST");

	$types = array("s", "s", "s", "s", "s", "s", "s", "s");

	//get a singleton instance of the database class
	$db = Database::getInstance();

	//execute query
	$err = $db -> doQuery($sql, $vars, $types);

	return $err;
}

function displayCityPageInfo($pageNum, $numItems) {
	$error = getCityInfo($pageNum, $numItems);
	if (empty($error)) {
		// display as table
		echo "<h2>Page $pageNum</h2>\n";

		//get a singleton instance of the database class
		$db = Database::getInstance();

		// display assoc array
		echo getHTMLTable($db -> fetch_all_array());
	}
}

function displayCityStatePageInfo($pageNum, $numItems) {
	$error = getCityStateInfo($pageNum, $numItems);
	if (empty($error)) {
		// display as table
		echo "<h2>Page $pageNum - using Join</h2>\n";

		//get a singleton instance of the database class
		$db = Database::getInstance();

		// display assoc array
		echo getHTMLTable($db -> fetch_all_array());
	}
}

/**
 * Expects an array of associative arrays, returns it as a table in HTML
 *
 */
function getHTMLTable($twoDarray) {
	$result = "";

	// setup the table
	$result .= "<table border='1'>\n";

	// setup the table headers
	$result .= "\t<tr>\n";

	// get the keys
	// by getting the first element, array
	// then get that arrays keys
	$keys = array_keys($twoDarray[0]);
	// cycle thru the keys
	foreach ($keys as $key) {
		$result .= "\t\t<th>$key</th>\n";
	}
	$result .= "\t</tr>\n";

	// fill the table
	foreach ($twoDarray as $assocArray) {
		// var_dump($assocArray);
		$result .= "\t<tr>\n";
		foreach ($assocArray as $elem) {
			$result .= "\t\t<td>$elem</td>\n";

			// var_dump($elem);
		}
		$result .= "\t</tr>\n";
	}

	// close the table
	$result .= "</table>\n";

	// return the result
	return $result;
}

function getCityStateInfo($pageNum, $numItems, $field = "statename", $from = "join demo_state on state=abbrev") {
	return getCityInfo($pageNum, $numItems, $field, $from);
}

function getCityInfo($pageNum, $numItems = 10, $field = "state", $from = "") {
	$result = "";

	// start offset
	$start = ($pageNum - 1) * $numItems;

	// write the query
	$query = "select city, county, $field, zip ";
	$query .= "from demo_zipcode $from ";
	$query .= "order by city ";
	$query .= "limit ?, ?";

	// setup the arrays vars for the query
	$vars = array($start, $numItems);
	$types = array("i", "i");

	//get a singleton instance of the database class
	$db = Database::getInstance();

	// run the query
	$result = $db -> doQuery($query, $vars, $types);

	return $result;
}

/**
 * Returns the html for an ordered list consisting of the column names of the table
 */
function displayColNames($tableName) {
	$result = "";

	//get a singleton instance of the database class
	$db = Database::getInstance();

	// get the column names
	$colNames = $db -> getColNames($tableName);

	// display the header
	$result .= "<h2>Column Names for: $tableName </h2>\n";

	// build the ul
	$result .= "<ul>\n";
	foreach ($colNames as $col) {
		$result .= "\t<li>$col</li>\n";
	}
	$result .= "</ul>\n";

	return $result;
}

/**
 * Returns the html for a table consisting of the column info for the specified table
 */
function displayColInfo($tableName) {
	$result = "";

	//get a singleton instance of the database class
	$db = Database::getInstance();

	$colsInfo = $db -> getColInfo($tableName);

	if (!$colsInfo) {
		return "No Column Info was returned: " . $db -> getError();
	}

	$result .= "<h2>Column Info for: $tableName</h2>\n";

	// setup the table
	$result .= "<table border='1'>\n";

	// setup the table headers
	$result .= "\t<tr>\n";
	$result .= "\t\t<th>Column</th>\n";

	// var_dump(array_pop(array_slice($colsInfo,0,1)));

	// get the keys
	// by getting the first element, array
	// then get that arrays keys
	$keys = array_keys(array_pop(array_slice($colsInfo, 0, 1)));

	foreach ($keys as $key) {
		$result .= "\t\t<th>$key</th>\n";
	}

	// this way is probably quicker
	// $result .= "\t\t<th>Type</th>\n";
	// $result .= "\t\t<th>Null</th>\n";
	// $result .= "\t\t<th>Key</th>\n";
	// $result .= "\t\t<th>Default</th>\n";
	// $result .= "\t\t<th>Extra</th>\n";

	$result .= "\t</tr>\n";

	// fill the table
	foreach ($colsInfo as $field => $colInfo) {
		$result .= "\t<tr>\n";
		$result .= "\t\t<td>$field</th>\n";
		foreach ($colInfo as $col) {
			$result .= "\t\t<td>" . $col . "</td>\n";
		}
		// $result .= "\t\t<td>" . $colInfo["Type"] . "</td>\n";
		// $result .= "\t\t<td>" . $colInfo["Null"] . "</td>\n";
		// $result .= "\t\t<td>" . $colInfo["Key"] . "</td>\n";
		// $result .= "\t\t<td>" . $colInfo["Default"] . "</td>\n";
		// $result .= "\t\t<td>" . $colInfo["Extra"] . "</td>\n";
		$result .= "\t</tr>\n";
	}

	// setup the table
	$result .= "</table>\n";

	return $result;
}

//return duplicate values in an array as an array with the values that appear >  1 time
//if an associative array, will return the key for the last element that has the same value.
function array_not_unique($a = array()) {
	return array_diff_key($a, array_unique($a));
}

function find_na($var) {
	// returns whether the value passed in is = "na"
	return ($var == "na");
}

//is an array an associative array or not
//an alternative: return  array_values($arr) === $arr; //true if yes

function isIndexedArray($array) {
	return ctype_digit(implode('', array_keys($array)));
}

//remove an item from an array
function remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array))
		return false;
	if (!in_array($val, $array))
		return $array;

	foreach ($array as $key => $value) {
		if ($value == $val)
			unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

//allows some tags
function sanitize($val) {
	$val = trim($val);
	$val = strip_tags($val, "<h1><h2><h3><p><img><a><strong><em><ol><ul><li>");
	//$val = htmlentities($val);
	$val = stripslashes($val);
	return $val;
}

function getStartInfo($db) {
	$str = "<h2>Tables:</h2>\n<ul>\n";
	$table_names = $db -> getValidTableNames("demo_%");
	foreach ($table_names as $table) {
		$numRecs = $db -> getNumRecords($table);
		$pk = implode(" , ", $db -> getPrimaryKey($table));
		$str .= "<li>$table has $numRecs rows. The primary key(s) is '$pk'</li>\n";
	}
	$str .= "</ul>\n";

	return $str;
}
?>