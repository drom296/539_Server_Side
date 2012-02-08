<?php
define('FILE_URL','data.xml');
check_submit_button_clicked();


function check_submit_button_clicked(){
	echo "DEBUG:: hit check_submit_button_clicked()<br />\n"; // delete this
	if (! array_key_exists('submit', $_GET)){
		// if the submit button was not clicked or if items are missing, re-direct back to form.html
		
	} else {
		// we're going to "echo_header()"
		echo_header();
	}
}


function echo_header(){ // 10 points
	echo "DEBUG:: hit echo_header()<br />\n"; // delete this
	$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>I like to blog!</title>
</head>
<body>
END;
	// our data structure
	$headerData = array('blogdata'=>array('blogtitle'=>'Blog O\'Wisdom', 'blogdescription'=>'A world-class blog, right here in 539!'));
	
	// concatenate blogtitle value from $headerData above in a <h1>
	
	
	// concatenate blogdescription value from $headerData in a <p>
	
	
	// echo the string we built
	
	// now we're going to "load_update_and_save_xml()"
	load_update_and_save_xml();
}



function load_update_and_save_xml(){ // 50 points
	echo "DEBUG:: hit load_update_and_save_xml()<br />\n"; // delete this

	// create a new DomDocument instance
	
	
	// load the XML file
	
	
	// get the values of the form variables that we are writing to the XML file
	
	// get the current date (done)
	date_default_timezone_set('America/New_York');
	$newDate = date('r');
	
	// create all of your elements and append them to the appropriate tags in your DomDocument instance
	// don't forget to do the final append to the root XML element
	
	
	// update the XML file by saving it to disk. 
	// Don't forget to set your permissions on "data.xml" to 666 or 777
	

	// now we're going to "display_blog()"
	display_blog();
}


function display_blog(){  // 40 points
	echo "DEBUG:: hit display_blog()<br />\n"; // delete this
	// create a new DomDocument instance
	
	// load the XML file
	
	// get all the <blogentry> elements from $dom and put them in a DomNodeList
	
	// loop through and build your table
	
	// echo it out

	// move on to echo_footer()
	echo_footer();
}

function echo_footer(){
	echo "DEBUG:: hit echo_footer()<br />\n"; // delete this
	echo <<<END
	<p><a href="form.html">Add a new Posting</a></p>
	</body>
	</html>
END;
}

?>