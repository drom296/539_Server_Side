<?php
//wraps text at a number of characters and limits to a number of lines if desired.
// Original PHP code by Chirp Internet: www.chirp.com.au 
// Please acknowledge use of this code by including this header. 
//usage examples:
//echo nl2br(myWrap($description, 40)); # wrap at 40 chars 
//echo nl2br(myWrap($description, 40, 3)); # as above, but truncate after 3 lines
function myWrap($input, $chars, $lines = false) { 
	// the simple case - return wrapped words 
	if(!$lines) return wordwrap($input, $chars, "\n"); 
	
	// truncate to maximum possible number of characters 
	$retval = substr($input, 0, $chars * $lines); 
	// apply wrapping and return first $lines lines 
	$retval = wordwrap($retval, $chars, "\n"); 
	preg_match("/(.+\n?){0,$lines}/", $retval, $regs); 
	return $regs[0]; 
}

// Split text evenly into columns
// Original PHP code by Chirp Internet: www.chirp.com.au 
// Please acknowledge use of this code by including this header. 
// sample usage:
/* <table> 
		<tr> 
			<?php $cols = multiCol($description, 2); 
					   foreach($cols as $c) echo "<td>",htmlspecialchars($c),"</td>\n"; 
			?> 
		</tr> 
	</table>
*/
function multiCol($string, $numcols) { 
	$collength = ceil(strlen($string) / $numcols) + 3; 
	$retval = explode("\n", wordwrap(strrev($string), $collength)); 
	if(count($retval) > $numcols) { 
		$retval[$numcols-1] .= " " . $retval[$numcols]; 
		unset($retval[$numcols]); 
	} 
	$retval = array_map("strrev", $retval); 
	return array_reverse($retval); 
}

//get remote file using curl
function getRemoteFile($url) {
	if (function_exists('curl_init')) {
   		// initialize a new curl resource
   		$ch = curl_init();

   		// set the url to fetch
   		curl_setopt($ch, CURLOPT_URL, $url);
	
   		// don't give me the headers just the content
   		curl_setopt($ch, CURLOPT_HEADER, 0);

   		// return the value instead of printing the response to browser
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   		// use a user agent to mimic a browser
   		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

   		$content = curl_exec($ch);

   		// remember to always close the session and free all resources
   		curl_close($ch);
   		return $content;
	} else {
   		// curl library is not installed so we better use something else
   		return getRemoteFile2($url);
	} 
} //getRemoteFile

//get status code using curl
function getStatusCode($url) {
     			$ch = curl_init($url); 
				curl_setopt($ch, CURLOPT_NOBODY, true); 
				curl_exec($ch); 
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
				curl_close($ch); 
				//$status_code contains the HTTP status: 200, 404, etc. 
			return $status_code;		
} //getStatusCode     //use curl to get status code 404 to make sure file exists

//getRemoteFile using our own functions
function getRemoteFile2($url)
{
   // get the host name and url path
   $parsedUrl = parse_url($url);
   $host = $parsedUrl['host'];
   if (isset($parsedUrl['path'])) {
      $path = $parsedUrl['path'];
   } else {
      // the url is pointing to the host like http://www.mysite.com
      $path = '/';
   }

   if (isset($parsedUrl['query'])) {
      $path .= '?' . $parsedUrl['query'];
   }

   if (isset($parsedUrl['port'])) {
      $port = $parsedUrl['port'];
   } else {
      // most sites use port 80
      $port = '80';
   }

   $timeout = 10;
   $response = '';

   // connect to the remote server
   $fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

   if( !$fp ) {
      return "Cannot retrieve $url";
   } else {
      // send the necessary headers to get the file
      fputs($fp, "GET $path HTTP/1.0\r\n" .
                 "Host: $host\r\n" .
                 "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
                 "Accept: */*\r\n" .
                 "Accept-Language: en-us,en;q=0.5\r\n" .
                 "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
                 "Keep-Alive: 300\r\n" .
                 "Connection: keep-alive\r\n" .
                 "Referer: http://$host\r\n\r\n");

      // retrieve the response from the remote server
      while ( $line = fread( $fp, 4096 ) ) {
         $response .= $line;
      }

      fclose( $fp );

      // strip the headers
      $pos      = strpos($response, "\r\n\r\n");
      $response = substr($response, $pos + 4);
   }

   // return the file content
   return $response;
}

//strip out stuff from pasted Word content
function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br>')
    {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    }
    
    //check to see if a valid ip address exists
    function validip($ip) { 
			if (!empty($ip) && ip2long($ip)!=-1) {
			   $reserved_ips = array (
				   array('0.0.0.0','2.255.255.255'),
				   array('10.0.0.0','10.255.255.255'),
				   array('127.0.0.0','127.255.255.255'),
				   array('169.254.0.0','169.254.255.255'),
				   array('172.16.0.0','172.31.255.255'),
				   array('192.0.2.0','192.0.2.255'),
				   array('192.168.0.0','192.168.255.255'),
				   array('255.255.255.0','255.255.255.255')
			   );
	
			   foreach ($reserved_ips as $r) {
				   $min = ip2long($r[0]);
				   $max = ip2long($r[1]);
				   if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
			   }
	
			   return true;
	
			} else {
 
				return false;
 
			}
 } //valid ip	
 
//get the ip address for a request 
function getip() {
			if (isset($_SERVER["HTTP_CLIENT_IP"]) && validip($_SERVER["HTTP_CLIENT_IP"])) {
 				return $_SERVER["HTTP_CLIENT_IP"];
 			}
 
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))  {
				foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
					if (validip(trim($ip))) { 
						return $ip;
					}
				}
			}
 
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && validip($_SERVER["HTTP_X_FORWARDED"])) {
				return $_SERVER["HTTP_X_FORWARDED"];
			} elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]) && validip($_SERVER["HTTP_FORWARDED_FOR"])) {
 				return $_SERVER["HTTP_FORWARDED_FOR"];
 			} elseif (isset($_SERVER["HTTP_FORWARDED"]) && validip($_SERVER["HTTP_FORWARDED"])) {
				return $_SERVER["HTTP_FORWARDED"];
 			} elseif (isset($_SERVER["HTTP_X_FORWARDED"]) && validip($_SERVER["HTTP_X_FORWARDED"])) {
				return $_SERVER["HTTP_X_FORWARDED"];
			} else {
				return $_SERVER["REMOTE_ADDR"];
			}
 		} //getip

?>