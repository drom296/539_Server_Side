<?php
  // setup the array for the description to the various polls
  $polls = array(
		'Gamer' => 'What type of gamer are you?',
		'Food Choice' => "What's your fav place to eat in Rochester?" 
	);
	
	// check to see if the poll variable was sent
	if (!array_key_exists('cat', $_GET)){
		header("location: choose_a_poll.php");
	}
		
	
	// decode what was passed in the url to determine the poll.
	$poll = urldecode($_GET['cat']);
	
	// set up the choices array
	$answers = array(
		// gamer choices
		'Gamer' => array('Casual', 'Hardcore'),
		// food choices
		'Food Choice' => array('Dinosaur BBQ','Open Face',"John's Tex-Mex Eatery","Ming's","Other/Fast Food"),
	);
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
			<input type='hidden' name='cat' value=<?php echo urlencode($poll) ?> />
			<input type='hidden' name='question' value=<?php echo urlencode($polls[$poll]) ?>/>
			<ol>
			<?php
				// generate the choices by looping over the array for it
				
				foreach ($answers[$poll] as $value) {
					// setup the list item
					echo "<li>\n";
					// setup the input item
					echo "\t<input type='radio' name = 'choice' value='". urlencode($value) ."' />$value</li>\n";
				}
			?>
			</ol>
			<input type="reset" value="Reset Form" />
			<input type="submit" name="submit" value="Submit Form" />
		</form>		
		
		
	</body>
</html>
