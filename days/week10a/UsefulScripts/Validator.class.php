<?php
    
class Validator
{


//1 = trim, 2 = stripslashes, 3=strip tags, 4=htmlentities
  static function sanitize($string,$opts=array(1,2,3,4)) {
      $string = in_array(1,$opts)? trim($string): $string;
		  $string = in_array(2,$opts)? stripslashes($string): $string;
		  $string = in_array(3,$opts)? strip_tags($string) : $string;
		  $string = in_array(4,$opts)? htmlentities($string): $string;
    return $string;
  }
    
//not an all inclusive list
static function contains_bad_str($str_to_test) {
      $bad_strings = array(
                    "content-type:"
                    ,"mime-version:"
                    ,"multipart/mixed"
    		,"Content-Transfer-Encoding:"
                    ,"bcc:"
    		,"cc:"
    		,"to:"
      );
      
      $valid = true;
      foreach($bad_strings as $bad_string) {
        if(eregi($bad_string, strtolower($str_to_test))) {
          $valid = false;
        }
      }
      return $valid;
    }
    
    static function contains_newlines($str_to_test) {
       $valid = true;
       if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
         $valid = false;
       }
       return $valid;
    } 
    
    static function alphaNumeric($value) {
            $reg= "/^[A-Za-z0-9]+$/";
            return preg_match($reg,$value);
    }

    static function alphaNumericSpace($value) {
            $reg = "/^[A-Za-z0-9 ]+$/";
            return preg_match($reg,$value);
    }

    static function alphaNumericSpacePunct($value) {
            $reg = "/^[A-Za-z0-9 \.\?,'!-:;]+$/";
            return preg_match($reg,$value);
    }

    static function address($value) {
            $reg = "/^[A-Za-z0-9 \.\/,]+$/";
            return preg_match($reg,$value);
    }

    static function numbers($value) {
            $reg = "/^[0-9]+$/";
            return preg_match($reg,$value);
    }

    static function numeric($value) {
            $reg = "/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/";
            return preg_match($reg,$value);
    }

    static function integer($value) {
            $reg = "/(^-?\d\d*$)/";
            return preg_match($reg,$value);
    }

    static function decimal($value) {
            $reg = "/^[0-9]?[0-9]?(\.[0-9]{1,2})?$/";
            return preg_match($reg,$value);
    }

    static function money($value) {
            if ($value == "") $value=0.00;
            $reg = "/^\d{1,3}(?:,?\d{3})*(?:\.\d{0,2})?$/";
            return preg_match($reg,$value);
    }

    static function alphabetic($value) {
            $reg = "/^[A-Za-z]+$/";
            return preg_match($reg,$value);
    }

    static function alphabeticSpace($value) {
            $reg = "/^[A-Za-z ]+$/";
            return preg_match($reg,$value);
    }

    static function alphabeticSpaceSlash($value) {
            $reg = "/^[A-Za-z \/]+$/";
            return preg_match($reg,$value);
    }

    static function alphabeticSpaceSlashDash($value) {
            $reg = "/^[A-Za-z \/-]+$/";
            return preg_match($reg,$value);
    }

    static function emailCheck($value) {
            $reg = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
            return preg_match($reg,$value);
    }

    static function ssNum($value) {
            $reg = "/^\d{3}\-?\d{2}\-?\d{4}$/";
            return preg_match($reg,$value);
    }

    static function dollarAmount($value) {
            $reg = "/^((\$\d*)|(\$\d*\.\d{2})|(\d*)|(\d*\.\d{2}))$/";
            return preg_match($reg,$value);
    }

    //Validates that a string a US zip code in 5 digit format or zip+4 format. 99999 or 99999-9999
    static function zipCode($value) {
            $reg = "/(^\d{5}$)|(^\d{5}-\d{4}$)/";
            if ('foreign' == strtolower($value))
            return true;
            else return preg_match($reg,$value);
    }

    //(999) 999-9999 or (999)999-9999
    static function phoneNum($value) {
            $reg = "/^\([1-9]\d{2}\)\s?\d{3}\-\d{4}$/";
            return preg_match($reg,$value);
    }

    static function html($value) {
            $reg = "/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)/?>/gim";
            return preg_match($reg,$value);
    }

    static function sqlMetaChars($value) {
            $reg = "/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(;))/i";
            return preg_match($reg,$value);
    }

    static function sqlInjection($value) {
            $reg = "/\w*((\%27)|(\'))((\%6F)|o|(\%4F))((\%72)|r|(\%52))/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionUnion($value) {
            $reg = "/((\%27)|(\'))union/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionSelect($value) {
            $reg = "/((\%27)|(\'));\s*select/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionInsert($value) {
            $reg = "/((\%27)|(\'));\s*insert/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionDelete($value) {
            $reg = "/((\%27)|(\'));\s*delete/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionDrop($value) {
            $reg = "/((\%27)|(\'));\s*drop/i";
            return preg_match($reg,$value);
    }

    static function sqlInjectionUpdate($value) {
            $reg = "/((\%27)|(\'));\s*update/i";
            return preg_match($reg,$value);
    }

    static function crossSiteScripting($value) {
            $reg = "/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/i";
            return preg_match($reg,$value);
    }

    static function crossSiteScriptingImg($value) {
            $reg = "/((\%3C)|<)((\%69)|i|(\%49))((\%6D)|m|(\%4D))((\%67)|g|(\%47))[^\n]+((\%3E)|>)/i";
            return preg_match($reg,$value);
    }

    static function crossSiteScriptingParanoid($value) {
            $reg = "/((\%3C)|<)[^\n]+((\%3E)|>)/i";
            return preg_match($reg,$value);
    }

    static function dateTime($value) {
          $d = trim(substr($value,0,strpos($value," ")));
          $t = trim(substr($value,strpos($value," ")+1));
          $validDate = $this->dateYYYYmmdd($d);
          $validTime = $this->time($t);
          if ($value == "" || ($validDate && $validTime))
            return true;
          else return false;
    }
    
    //date including leap years since 1900 mm and dd could have 1 or 2 digits with 4 digit year and / separator
    static function dateValidation($value) {
            $reg = "/^(((0?[1-9]|1[012])\/(0?[1-9]|1\d|2[0-8])|(0?[13456789]|1[012])\/(29|30)|(0?[13578]|1[02])\/31)\/(19|[2-9]\d)\d{2}|0?2\/29\/((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$/";
            return preg_match($reg,$value);
    }

    //Date with leap years. Accepts '.' '-' and '/' as separators d.m.yy to dd.mm.yyyy (or d.mm.yy, etc) 
    //Ex: dd-mm-yyyy d.mm/yy dd/m.yyyy etc etc Accept 00 years also.
    static function dateAlternate($value) {
        $reg = "/^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/";
        return preg_match($reg,$value);
    }
    //yyyy-mm-dd with leap year
    static function dateYYYYmmdd($value) {
        $reg = "/^(\d{4})-(0[13578]|1[02])-(0[1-9]|[12]\d|3[01])|(\d{4})-(0[469]|11)-(0[1-9]|[12]\d|30)|(\d\d[0248][048]|\d\d[13579][26])-(02)-(0[1-9]|1\d|2\d)|(\d\d[0248][1235679]|\d\d[13579][01345789])-(02)-(0[1-9]|1\d|2[0-8])$/";
        if ($value == "") return true;
        else return preg_match($reg,$value);
    }

    // mm/dd/yyyy format
    static function date1($value) { 
            $reg = "/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/";
            return preg_match($reg,$value);
    }

    // mm-dd-yyyy
    static function date2($value) {
            $reg = "/(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d/";
            return preg_match($reg,$value);
    }
    
    //24 hour time
    static function time($value) {
            $reg = "/^([0-1][0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$/";
            return preg_match($reg,$value);        
    }

    static function visa($value) {
        $reg = "/^4[0-9]{12}(?:[0-9]{3})?$/";
            return preg_match($reg,$value);
    }

    static function mc($value) {
        $reg = "/^5[1-5][0-9]{14}$/";
            return preg_match($reg,$value);
    }

    static function americanExpress($value) {
        $reg = "/^3[47][0-9]{13}$/";
            return preg_match($reg,$value);
    }

    static function dinersClub($value) {
        $reg = "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/";
            return preg_match($reg,$value);
    }

    static function discover($value) {
        $reg = "/^6(?:011|5[0-9]{2})[0-9]{12}$/";
            return preg_match($reg,$value);
    }

    static function creditCard($value) {
        $reg = "/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/";
            return preg_match($reg,$value);
    }
} //class
?>