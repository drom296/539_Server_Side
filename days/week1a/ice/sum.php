<?php
	$num1 = $_GET['num1'];
	$num2 = $_GET['num2'];
	$sum = $num1 + $num2;
	
	header("Content-type: text/plain");
	
	echo $sum;
?>