<?php
    
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Day3: Feelings</title>
 	<style type="text/css">
 		form div
 		{
 			margin: 1em;
 		}
 		form div label
 		{
 			float: left;
 			width: 10%;
 		}
 		form div.radio {
 			float: left;
 		}
 		.clearfix {
 			clear: both;
 		}
 	</style>
</head>
<body>
	<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div>
			<label for="fname">First Name:</label>
			<input type="text" name="fname" size="30" />
		</div>
		<div>
			<label for="lname">Last Name:</label>
			<input type="text" name="lname" size="30" />
		</div>
		<div>
			<label for="date">Date:</label>
			<input type="text" name="date" size="30" />
		</div>
		<div>
			<label for="comments">Comments:</label>
			<textarea name="comments" rows="3" cols="30"></textarea>
		</div>
		<div>
			<label for="mood">Mood:</label>
			<div class="radio">
				<input type="radio" name="mood" value="happy" />Happy<br />
				<input type="radio" name="mood" value="mad" />Mad<br />
				<input type="radio" name="mood" value="indifferent" />Indifferent<br />
			</div>
		</div>
		<div class="clearfix">
			<input type="reset" value="Reset Form" />
			<input type="submit" name="submit" value="Submit Form" />
		</div>	
	</form>
	
	<?php
		if(array_key_exists('submit',$_POST)){
			// display the date	
			echo "Today is ".date("m/d/Y");
			
			// Greet the person.
			echo "<p>Hello ".$_POST['fname']." ".$_POST['lname'].".";
			
			$feelings = array("happy"=>"glad", 
												"mad"=>"scared", 
												"indifferent"=>"meh");
			
			// acknowledge mood
			echo " I'm ".$feelings[$_POST['mood']]." that you are in a ".
								$_POST['mood']. " today</p>";
			
			// echo comments
			echo "<p>Your Comments: ".$_POST['comments']."</p>";
		}	
	?>

</body>
</html>
