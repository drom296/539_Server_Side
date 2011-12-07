<?php
  $polls = array(
		array('topic'=>'Type of Gamer', 'link'=> 'take_a_poll.php?poll=game', "description"=>'What type of gamer are you?'),
		array('topic'=>'Food Places', 'link'=> 'take_a_poll.php?poll=food', "description"=>"What's your fav place to eat in Rochester?"),
	);
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
				foreach ($polls as $sPoll) {
					// start the list item
					echo "<li>";
					// setup the link
					echo "<a href='".$sPoll['link']."'>".$sPoll['topic']."</a>";
					// setup the link - description separator
					echo " - ";
					// setup the description
					echo $sPoll['description'];
					// end the list item
					echo "</li>";
				}
			?>
		</ul>
	</body>
</html>
