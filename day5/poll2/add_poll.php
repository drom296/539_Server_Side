<?php
	// init array that will contain the available fields
	$fields = array('cat','question','choice1','choice2','choice3','choice4','choice5');
	// init a errors array
	$errors = array();
	// store the method the form is submitted
	$submitMethod = "POST";
	// init the passed variable for validation
	$passed = TRUE; // assumed true until proven false
	
	// check if the form was submitted
	// source: http://www.vbforums.com/showthread.php?t=562749
	if($_SERVER['REQUEST_METHOD'] == $submitMethod) {
		// initialize a boolean to see if it passed validation	
		$passed = validateForm();
	} else{
		// TODO figure out way to print errors out
		// echo "Form did not pass validation";
	}
	
	function validateForm(){
		global $fields;
		$pass = true;
		$minLen = 1;
		
		// check if the fields are set and are greater than 0 in length
		foreach ($fields as $field) {
			// check if the key exists
			$keyExists = array_key_exists($field, $_POST); 
			// init values for other comparison variables
			$isSet = FALSE;
			$passLen = FALSE;
			
			if ($keyExists){
				// key exists, lets assume other comparison is true until proven false
				$isSet = false;
				$keyExists = false;
				
				// check if it is set	
				$isSet = isset($_POST[$field]);
				// check if it is of min length
				$passLen = strlen($_POST[$field]) >= $minLen;
			}
			// add it to the boolean result via ands
			$pass = $pass && $keyExists && $isSet && $passLen;
			
			echo "<br />$field passed? :";
			echo " exists? -> ".($keyExists?'True':'False');
			echo ", isSet? -> ".($isSet?'True':'False');
			echo ", passLen? -> ".($passLen?'True':'False');
			
			// if we failed, init an inner array for $errors
			if(!$pass){
				// add errors specfic to the problem
				if (!$keyExists){
					$errors[$field] = "input field was not passed";
				} else if (!$isSet){
					$errors[$field] = "was not set";
				} else if (!$passLen){
					$errors[$field] = "did not meet the minimum length of $minLen";
				}
			}
			
		}
		
		echo "<br /><br /><br />";
		print_r($errors);
		
		// return the result
		return $pass;
	}
	
	function sanitizeString($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		
		return $var; 
	}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Add a poll</title>
</head>
<body>
<h1>Add a Poll</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<table>
		<tr>
			<td>Topic Category</td>
			<td><input type="text" name="cat" size="10" /></td>
		</tr>
		<tr>
			<td>Topic Question</td>
			<td><input type="text" name="question" size="50" /></td>
		</tr>
		
		<tr>
			<td>Choice 1</td>
			<td><input type="text" name="choice1" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 2</td>
			<td><input type="text" name="choice2" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 3</td>
			<td><input type="text" name="choice3" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 4</td>
			<td><input type="text" name="choice4" size="15" /></td>
		</tr>
		
		<tr>
			<td>Choice 5</td>
			<td><input type="text" name="choice5" size="15" /></td>
		</tr>
	</table>	
	<hr />
	<strong>Your Password: </strong><input type="password" name="password" size="15" /><br />
	<input type="reset" value="Reset Form" />
	<input type="submit" name="submit" value="Submit Form" />
		
</form>

<p id="errors">
<?php
	if (!$passed){
		// TODO display error message
		// display error message
		echo "Did not pass validation for the following reasons";
		
		// display errors
		// start list
		echo "<ul>";
	
		global $errors;	
	
		echo "<br />Test2<br />";
		print_r($GLOBALS['errors']);
	
		foreach ($GLOBALS['errors'] as $field => $message) {
			// start list item
			echo "<li>";
			// display error field
			echo $field;
			// display separator
			echo ": ";
			// display error message
			echo $message;				
			// close list item
			echo "</li>";
		}
	}
	// close list
	echo "</ul>";
?>
</p>
		<h3><a href="choose_a_poll.php">Choose a Poll</a></h3>
</body>
</html>
