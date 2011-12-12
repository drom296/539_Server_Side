<?php
    // display files in directory using php comamands
    if(is_dir('.')){
    	if($handle = opendir('.')){
    		while (false !== ($file = readdir($handle))){
    			echo "The file name is: $file<br />";
    		}
    	}
		closedir($handle);
    }
?>