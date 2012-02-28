<?php
  // init the associative array array
  $polls = array();
  // set up the choices array
	$answers = array();
	
	// get contents of a file
	// test if the file exists
	$filename = 'poll_topics.txt';
	$delim = "|";
		
	// check to see if the poll variable was sent
	if (!isset($_GET['cat'])){
		header("location: choose_a_poll.php");
	}
	
	// decode what was passed in the url to determine the poll.
	$poll = urldecode($_GET['cat']);

	// fill the polls and answers array
	$filename = 'poll_data.txt';
	if(file_exists($filename) && is_readable($filename)){
		$file_lines = file($filename);
		
		foreach ($file_lines as $line) {
			// break into pieces
			$parts = explode($delim,$line);
			
			// the first part is the key for the inner array, grab it
			$topic = array_shift($parts);
			// the second part has the question
			$question = array_shift($parts);
			
			// add the question and topic to the $polls array
			$polls[$topic] = $question;
			
			// set up the inner array
			$answers[$topic] = array();
			
			// add to the array the inner array
			foreach ($parts as $choice) {
				array_push($answers[$topic], $choice);
			}
		}
	}
	
	// check if it exists in the $polls array
	if (!isset($polls[$poll])){
		header("location: choose_a_poll.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<title>Take a Poll</title>
		<meta name="description" content="" />
		<meta name="author" content="tuxedo" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<style type="text/css">
			ol{
				list-style-type:none;
				margin-left:0;
				padding-left:0;
			}
		</style>
	
	</head>
	<body>
		<h1>Take a Poll</h1>
		<h2><?php echo $polls[$poll] ?></h2>
		
		<form action='poll_results.php' method='GET'>
			<input type='hidden' name='cat' value= <?php echo urlencode($poll) ?> />
			<input type='hidden' name='question' value= <?php echo urlencode($polls[$poll]) ?> />
			<ol>
			<?php
				// generate the choices by looping over the array for it
				// check if the array has data
				if(count($answers)>0){
					foreach ($answers[$poll] as $value) {
						// setup the list item
						echo "<li>\n";
						// setup the input item
						echo "\t<input type='radio' name = 'choice' value='". urlencode($value) ."' />$value</li>\n";
					}
				} else{
					echo "<p><em>There was no options for the choosen poll</em></p>";
				}
			?>
			</ol>
			<input type="reset" value="Reset Form" />
			<input type="submit" name="submit" value="Submit Form" />
		</form>		
		
		
	</body>
</html>
