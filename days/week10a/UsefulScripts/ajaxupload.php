<?php
    function __autoload($class_name){
        require_once 'classes/'.$class_name.'.php';
    }    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="jquery-ui.css" type="text/css"></link>
        <title>File Upload/Download</title>
        <script type="text/JavaScript" src="jquery.min.js"></script>
        <script type="text/JavaScript" src="jquery-ui.min.js"></script>
        <script type="text/JavaScript" src="jquery.ajaxQueue.js"></script>
        <script type="text/JavaScript" src="ajaxfileupload.js"></script>
        <script type="text/JavaScript" src="addlfuncts.js"></script>
    </head>
    <body>
		<form method ="post" action=''> 
       		<fieldset>
        		<legend>Sample upload/download :</legend>
   					<input type='button' value='Download File' onclick="$.download('download.php','download_file=dummy.xls','get');"/>
                   	<img id="loading" src="loading.gif" style="display:none;">
                    <input type="hidden" class='hidden' name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="3500000" />
                    <label for="uploaded_file">Choose a file to upload:</label><input name="uploaded_file" id="uploaded_file" type="file" />
                    <input type="submit" id='uploadbtn' value="Upload"  onclick="javascript: form.action='upload.php'; form.enctype='multipart/form-data'; processUpload(); return false;" />
    </body>
</html>
