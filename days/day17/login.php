<?php
//start the session

//include any required libraries/classes

//check to see if already logged in, if so, re-direct to admin.php

//check form submission and if valid, check login credentials in Database
//don't forget to sha1(inputted password) when building your parameterized query

//if valid login credentials, create appropriate session variables and cookies, then
//redirect to admin.php

//if invalid login credentials, create error message

//if missing information, create error message

echo Page::header("Login");

//display any messages

//create and display form

echo Page::footer();
?>