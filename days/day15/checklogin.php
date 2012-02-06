<?php
$username="admin";
$password="admin";
if($_POST['username'] == $username && $_POST['password'] == $password){
	header("Location:success.php");
} else {
	header("Location:http://www.wizards.com");
}

?>