<?php 
	function StartsWith($Haystack, $Needle){
    	// Recommended version, using strpos
    	return strpos($Haystack, $Needle) === 0;
	}
	
	function EndsWith($Haystack, $Needle){
    	// Recommended version, using strpos
    	return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
	}

	$data = file_get_contents("countries.txt");
	$data = preg_replace("[\n\r\t]"," ",$data);
	$info = preg_split("/[\s]+/",$data);
	$db = mysql_connect("localhost","bdf4584","fr1end");
	mysql_select_db("bdf4584");
	$count = 0;
	$number = 0;
	while ($count < count($info)-1) {
		$code = $info[$count];
		$name = $info[++$count];

		if (StartsWith($name,"{") && !EndsWith($name,"}"))
		{
			while (!EndsWith($name.=" ".$info[++$count],"}")) {}
		}
echo "$code $name<br />";
		$query = "Insert into country (code,name) values (\"$code\",\"$name\")";
		$result = mysql_query($query);
		if ($result) $number++;
		$count++;
	}
	
	echo "$number of countries inserted.";
?>