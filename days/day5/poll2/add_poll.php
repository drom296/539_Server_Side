<?php
	// init array that will contain the available fields
	$fields = array('cat','question','choice1','choice2','choice3','choice4','choice5');
	// init a errors array
	$errors = array();
	// init the data array
	$dataArray = array();
	// store the method the form is submitted
	$submitMethod = "POST";
	// init submit array
	$submitArray = array();
	// init the passed variable for validation
	$passed = TRUE; // assumed true until proven false
	// init min length for fields
	$minLen = 1;
	// init password
	define('PASSWORD', 'Chuck');
	// init delimiter
	$delim = "|";
	// init filename
	$fileName = "poll_data.txt";
	// init var for submission
	$wasSubmitted = false;
	
	// check if the form was submitted
	// source: http://www.vbforums.com/showthread.php?t=562749
	if($_SERVER['REQUEST_METHOD'] == $submitMethod) {
		// set what the submit array will be	
		$sub = "_".$submitMethod;
		$submitArray = $$sub;
		
		$wasSubmitted = TRUE;
		
		// initialize a boolean to see if it passed validation
		// check if they entered the write password	
		$passed = validateForm();
		$passed = checkPassword() && $passed;
		// check password
		if ($passed){
			// good to go: proceed with submit
				pushData($submitArray);
		}
	}
	
	// Grabs the data from the submit array, adds the entries (minus the password)
	// to the data file 
	function pushData(){
		global $dataArray, $delim,$fileName, $submitArray;
		
		// echo "<br />Count: ". count($dataArray);
		// echo "<br />Count: ". count($submitArray);
		
		if (count($dataArray)>2){
			// implode the data array
			$topic = implode($delim, $dataArray);
			// check if file exists
			
			// write it to the file
			file_put_contents($fileName, "\n".$topic, FILE_APPEND);
			
			// TODO clear the submitArray
			$submitArray = array();
		}
	}
	
		// gets the value for the field stored in POST
	// if it DNE, return null;
	function getValue($fieldName){
		global $submitArray, $minLen;	
		$result = null;
		
		// echo "<br />Count: ". count($submitArray);
		// var_dump($submitArray);
		
		if(is_array($submitArray) && count($submitArray) > 0 &&
				array_key_exists($fieldName, $submitArray) && 
				isset($submitArray[$fieldName]) &&
				strlen($submitArray[$fieldName]) >= $minLen){
			
			$result = $submitArray[$fieldName];
		}
		
		return $result;
	}
	
	function checkPassword(){
		global $submitArray, $errors;
		
		// check if the passed in password matches ours
		$result = trim($submitArray['password']) == PASSWORD;
		
		if(!$result){
			$errors["password"] = "was not correct";
		}
		
		return $result;
	}
	
	function validateForm(){
		global $fields, $errors, $submitArray, $minLen, $dataArray;
		$pass = true;
		
		// check if the fields are set and are greater than 0 in length
		foreach ($fields as $field) {
			// check if the key exists
			$keyExists = array_key_exists($field, $submitArray); 
			// init values for other comparison variables
			$isSet = FALSE;
			$passLen = FALSE;
			
			if ($keyExists){				
				// check if it is set	
				$isSet = isset($submitArray[$field]);
				// check if it is of min length
				$passLen = strlen($submitArray[$field]) >= $minLen;
				
				// check if it passed, sanitize, check again
				if ($isSet && $passLen){
					// TODO sanitize data
					// sanitize the field
					// echo "<br />";
					// echo "Sanitizing $field: $submitArray[$field]";
					// echo "<br />";
					$submitArray[$field] = sanitizeString($submitArray[$field]);
					// echo "<br />";
					// echo "Sanitized $field: $submitArray[$field]";
					// echo "<br />";
					
					// check if it is set	
					$isSet = isset($submitArray[$field]);
					// check if it is of min length
					$passLen = strlen($submitArray[$field]) >= $minLen;
				}
			}
			// add it to the boolean result via ands
			$pass = $pass && $keyExists && $isSet && $passLen;
			
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
			} else {
				// push to data array
				$dataArray[$field] = $submitArray[$field];
			}
		}
		
		// return the result
		return $pass;
	}
	
	function sanitizeString($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = strip_tags($var);
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
			<td><input type="text" name="cat" size="10" 
				<?php echo ($val = getValue("cat")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		<tr>
			<td>Topic Question</td>
			<td><input type="text" name="question" size="50" 
				<?php echo ($val = getValue("question")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		
		<tr>
			<td>Choice 1</td>
			<td><input type="text" name="choice1" size="15" 
				<?php echo ($val = getValue("choice1")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		
		<tr>
			<td>Choice 2</td>
			<td><input type="text" name="choice2" size="15" 
				<?php echo ($val = getValue("choice2")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		
		<tr>
			<td>Choice 3</td>
			<td><input type="text" name="choice3" size="15" 
				<?php echo ($val = getValue("choice3")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		
		<tr>
			<td>Choice 4</td>
			<td><input type="text" name="choice4" size="15" 
				<?php echo ($val = getValue("choice4")) ? "value='$val'" : ""; ?> /></td>
		</tr>
		
		<tr>
			<td>Choice 5</td>
			<td><input type="text" name="choice5" size="15" 
				<?php echo ($val = getValue("choice5")) ? "value='$val'" : ""; ?> /></td>
		</tr>
	</table>	
	<hr />
	<strong>Your Password: </strong><input type="password" name="password" size="15" />
	<?php echo "<span style='font-size:.8em'>Password is: " . PASSWORD; ?>
	<br />
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
	} else if($wasSubmitted){
		echo "Submission Successful!";
	}
	// close list
	echo "</ul>";
?>
</p>
		<h3><a href="choose_a_poll.php">Choose a Poll</a></h3>
</body>
</html>