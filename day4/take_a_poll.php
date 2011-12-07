<?php
  // setup the array for the description to the various polls
  $polls = array(
		'Gamer' => 'What type of gamer are you?',
		'Food Choice' => "What's your fav place to eat in Rochester?" 
	);
	
	if (!array_key_exists('poll', $_GET)){
		header("location: choose_a_poll.php");
	}
		
	
	// decode what was passed in the url to determine the poll.
	$poll = urldecode($_GET['poll']);
	
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
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Take a Poll</title>
		<meta name="description" content="" />
		<meta name="author" content="tuxedo" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>
	<body>
		<h1>Take a Poll</h1>
		<h2><?php echo $polls[$poll] ?></h2>
		
		
	</body>
</html>
