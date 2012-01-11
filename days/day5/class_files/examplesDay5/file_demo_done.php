<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>File Demo</title>
</head>
<body>

<?php
// part 0 - Utilize our web service
// load file
echo "<h2>part 0 - Utilize a math web service</h2>";
$A = 1000;
$B = 2000;
$data = @file_get_contents("http://people.rit.edu/bdfvks/539/day1/sum.php?num1=$A&num2=$B");
echo "<p>$A + $B = $data</p>";

// part I - load one string
// load file
echo "<h2>Part I - load one string.</h2>";
$filename ="joke.txt";
if (file_exists($filename) && is_readable($filename)){
	$data = file_get_contents($filename);
	echo "<p>$data</p>";
} else {
	echo "<p>Problem!!!</p>";
}


// part II - load multiple records and put in an indexed array
echo "<h2>Part II - load multiple records and put in an array.</h2>";
$data = file('jokes.txt');
/*
echo "<pre>";
print_r($data);
echo "</pre>";
*/
foreach($data as $line){
	echo "<p>$line</p>";
}


// part II.V - load a text friendly web service and echo out the results
echo "<h2>Part II.V - load a text friendly web service and echo out the results</h2>";
echo "<h3><a href='http://words.bighugelabs.com/api.php'>words.bighugelabs.com</a></h3>";
$url = "http://words.bighugelabs.com/api/2/3991f963b247256461da4b394efcb34f/stupid/";
$data=file($url);

foreach($data as $line){
	$arr = explode('|',$line);
	if ($arr[1]=='sim' || $arr[1] == 'syn' || $arr[1] == 'rel'){
		echo "<p>$arr[1] = $arr[2]</p>";
	}
}


// part III - load multiple records and put in a nested indexed array
echo "<h2>Part III - load multiple records and put in a nested indexed array.</h2>";
$data = file("jokes.txt"); // load file
$jokes = array(); // init associative array
foreach ($data as $line){
	$jokes[]= explode("|",$line);
}

echo "<pre>";
print_r($jokes);
echo "</pre>";

// part IV - load multiple records and put in a nested associative array
echo "<h2>Part III - load multiple records and put in a nested associative array.</h2>";
$data = file("jokes.txt"); // load file
$jokes = array();

foreach($data as $v){
	//list($question,$answer) = explode("|",$v);
	$temp_array = explode("|",$v);
	$question = $temp_array[0];
	$answer = $temp_array[1];
	
	$jokes[] = array('question' => $question, 'answer' => $answer);
}

echo "<pre>";
print_r($jokes);
echo "</pre>";


// part V - load Cellular_subscribers_per_100_population.txt
echo "<h2>Part V - load a file that contains data with multiple records</h2>\n";
$data = file("Cellular_subscribers_per_100_population.txt");
// get rid of first record
array_shift($data);
echo "<pre>";
print_r($data);
echo "</pre>";


?>


</body>
</html>