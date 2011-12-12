<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>html5_template</title>
		<meta name="description" content="" />
		<meta name="author" content="Pedro" />
	</head>
	<body>
		
		<?php
			// start the buffer
			ob_start();
			
			echo "<p>This content is captured by the output buffer.</p>";
			
			//get the contents of the buffer
			//close the buffer
			// out the contents of the buffer
			echo ob_get_clean();
			
		?>
	
	</body>
</html>
