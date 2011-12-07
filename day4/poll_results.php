<?php
	$input_vars = array('cat','question','choice');
	
	// check input vars for constraints
	foreach ($input_vars as $value) {
		// check to see if the poll variable was sent
		if (!(array_key_exists($value, $_GET) && 
					// make sure that they are at least a certain length
					strlen($_GET[$value]) > 1 )){
			header("location: choose_a_poll.php");
			break;
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<title>Poll Results</title>
		<meta name="description" content="" />
		<meta name="author" content="tuxedo" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>
	<body>
		<h1>Results</h1>
		<h2>You chose the <em><?php echo urldecode($_GET['cat']) ?></em> category!</h2>
		<h2>The question was: <?php echo urldecode($_GET['question']) ?></h2>
		<h2>Your answer was: <em>"<?php echo urldecode($_GET['choice']) ?>"</em></h2>
		
		<p><a href="choose_a_poll.php">Take another poll?</a></p>
		<h2></h2>
	</body>
</html>
