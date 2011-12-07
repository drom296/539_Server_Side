<?php
  $polls = array(
		'Gamer' => 'What type of gamer are you?',
		'Food Choice' => "What's your fav place to eat in Rochester?" 
	);
	
	$poll_page = "take_a_poll.php";
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Choose a Poll</title>
		<meta name="description" content="" />
		<meta name="author" content="tuxedo" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>
	<body>
		<h1>Choose a Poll</h1>
		
		<ul>
			<?php
				$result = "";
				foreach ($polls as $topic => $desc) {
					// start the list item
					echo "<li>\n";
					// setup the link
					echo "<a href=$poll_page?cat=".urlencode($topic).">$topic</a>";
					// setup the link - description separator
					echo " - ";
					// setup the description
					echo $desc;
					// end the list item
					echo "</li>\n";
				}
			?>
		</ul>
	</body>
</html>
