<?php
//Some functions to start you out.  May or may not be useful

//return duplicate values in an array as an array with the values that appear >  1 time
//if an associative array, will return the key for the last element that has the same value.
function array_not_unique( $a = array() )
{
  return array_diff_key( $a , array_unique( $a ) );
}

function find_na($var)
{
    // returns whether the value passed in is = "na"
    return($var == "na");
}

//is an array an associative array or not
//an alternative: return  array_values($arr) === $arr; //true if yes

function isIndexedArray($array){
    return  ctype_digit( implode('', array_keys($array) ) );
}

//remove an item from an array
function remove_item_by_value($array, $val = '', $preserve_keys = true) {
    if (empty($array) || !is_array($array)) return false;
    if (!in_array($val, $array)) return $array;
 
    foreach($array as $key => $value) {
        if ($value == $val) unset($array[$key]);
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


?>