<?php
	$str = "<h2>Post:</h2><ul>";
	foreach($_POST as $k=>$v) {
		$str.="<li>$k - $v</li>";
	}
	$str.="</ul>";
	echo $str;
	$str = "<h2>Cookie:</h2><ul>";
	foreach($_COOKIE as $k=>$v) {
		$str.="<li>$k - $v</li>";
	}
	$str.="</ul>";
	setcookie("test3",time());
	echo $str;
    if (isset($_SERVER['HTTP_USER_AGENT']) ) echo $_SERVER['HTTP_USER_AGENT'];
?>