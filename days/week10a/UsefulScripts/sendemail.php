<?php

    function __autoload($class_name){
        require_once 'classes/'.$class_name.'.php';
    }
    
    function contains_bad_str($str_to_test) {
      	$bad_strings = array(
                "content-type:"
                ,"mime-version:"
                ,"multipart/mixed"
		            ,"Content-Transfer-Encoding:"
                ,"bcc:"
		            ,"cc:"
		            ,"to:"
      	);
      	$error = false;
      	foreach($bad_strings as $bad_string) {
        	if(($bad_string == "to:" && !eregi("mailto:",strtolower($str_to_test)) && eregi($bad_string, strtolower($str_to_test))) ||
             	(eregi($bad_string, strtolower($str_to_test)) && $bad_string != "to:")) {
//          	echo "$bad_string found. Suspected injection attempt - mail not being sent.";
 //         	exit;
            	return true;
       		}
      	}
      	return false;
    } //contains_bad_str

    function contains_newlines($str_to_test) {
        if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
 //         echo "newline found in $str_to_test. Suspected injection attempt - mail not being sent.";
 //         exit;
 			return true;
	    }
	    else return false;
    } //contains_newlines

     $errmsg="";
    if (isset($_POST['send'])) {
//action s/be create, then action (post/get) send, then change action to create with msg = sent to how many and what group
          	  $errmsg = "";
              if (!isset($_POST['_to']))
              {
                $errmsg = '*** TO is required<br />'; 
              }
              if (!isset($_POST['_subject']) || $_POST['_subject'] == '')
              {
                $errmsg = '*** Subject is required<br />'; 
              }
              if (!isset($_POST['_body']) || $_POST['_body'] == '<br>' || $_POST['_body'] == '' )
              {
                $errmsg = $errmsg.'*** Body is required<br />'; 
              }

              if (isset($_POST['_to']) && contains_bad_str($_POST['_to']) &&
              		contains_newlines($_POST['_subject']))
              {
                	$errmsg = "***** Problem with subject ****** <br />";
              }
              if (isset($_POST['_subject']) && contains_bad_str($_POST['_subject']) &&
              		contains_newlines($_POST['_subject']))
              {
                	$errmsg = "***** Problem with subject ****** <br />";
              }
              if (isset($_POST['_plain']) &&  contains_bad_str($_POST['_plain']))
              {
              		$errmsg = "***** Problem with plain ****** <br />"; ;
              }
              if (isset($_POST['_body']) && contains_bad_str($_POST['_body']))
              {
              		$errmsg = "***** Problem with body ****** <br />"; ;
              }              
            
              if ($errmsg == "")
              {
                //send multipart message to handle people who don't have html turned on
                $to=$_POST['_to'];
                $from= "bdfvks@rit.edu";
                $headers  = "From: $from\r\n";
                if (!isset($_POST['_plain']) || $_POST['_plain'] == '')
                {
                    $headers .= "Content-type: text/html\r\n";
                    $message = $_POST['_body'];
                }
                else {
                  //create a boundary string. It must be unique
                  //so we use the MD5 algorithm to generate a random hash
                  $random_hash = md5(date('r', time()));
                  //add boundary string and mime type specification
                  $headers .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
                  //define the body of the message.
                  ob_start(); //Turn on output buffering
                  ?>
--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<?php echo $_POST['_plain'];?>

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<?php echo $_POST['_body'];?>

--PHP-alt-<?php echo $random_hash; ?>--
<?php
//copy current buffer contents into $message variable and delete current output buffer
                  $message = ob_get_clean();
                } //mulitpart
				
				//send email
                if(mail($to,$_POST['_subject'],$message,$headers))
                      $errmsg = "Email message sent to $to<br />";
                }
                unset($_POST);         
//********* now email a file
				$myfileName = "dummy.xls";
				$filename = $myfileName;
                $from = "bdfvks@rit.edu";
                $subject = "Here is the file you requested";
                $headers  = "From: $from\r\n";
                $random_hash = md5(date('r', time()));
                //add boundary string and mime type specification
                $headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
                //read the atachment file contents into a string,
                //encode it with MIME base64,  and split it into smaller chunks
                $attachment = chunk_split(base64_encode(file_get_contents($myfileName)));
                //define the body of the message.
                ob_start(); //Turn on output buffering
              ?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

Here is the file you requested.

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<b>Here is the file you requested.</b>

--PHP-alt-<?php echo $random_hash; ?>--
<?php //Content-Type has to match the mime type of the file being sent, in this case xls ?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: application/xls; name="<?php echo $filename; ?>" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>--

<?php
            //copy current buffer contents into $message variable and delete current output buffer
            $message = ob_get_clean();
            //send the email
            $mail_sent = @mail( $to, $subject, $message, $headers );
            //if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
            $errmsg .= $mail_sent ? " File sent<br />" : " File sending failed<br />";

        }//send                
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Test email</title>
    </head>
    <body>
        <form method="post" action='sendemail.php'> 
        <fieldset>
        <legend>Email:</legend>
<?php
		if (isset($errmsg)){
            echo '<p>'.$errmsg.'</p>';
        }
?>
        <div>To: <input type='text' id='_to' name='_to' size='80'  /></div><br />
        <div>Subject: <input type='text' id='_subject' name='_subject' size='80'  /></div><br />
        <div>Non HTML:<input type ='text' id='_plain' name='_plain' size='80' /></div><br />
        <div>Body:<br /><textarea id='_body' name='_body' rows='10' cols='80'></textarea></div><br />
        <div><input type="submit" id="send" name="send" value="Send" /></div>
        </fieldset>
        </form>
    </body>
</html>



