<?php
require_once("LIB_db.php");

// accepts 4 inputs:
//   -area code
//   -phone number
//   -type of phone
//   -persond id

// use mysqli and prepared statements

// get the fields
$areaCode = $_GET['areacode'];
$phone = $_GET['phonenum'];
$type = $_GET['type'];
$pId = $_GET['id'];

addPhone($pid, $areaCode, $phone, $type);

//
?>
<!-- <!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>html5_template</title>
		<meta name="description" content="" />
		<meta name="author" content="Pedro" />
	</head>
	<body>
		<form action="addphone.php" method="post">
			<p>
				Area Code:
				<input type="text" name="areacode" value="###" size="3" />
			</p>
			<p>
				Phone:
				<input type="text" name="phonenum" value="###-####" size="8" />
			</p>
			<p>
				Type:
				<select name="type">
					<option value="home">home</option><option value="office">office</option><option value="cell">cell</option><option value="other">other</option>
				</select>
			</p>
			<p>
				Person:
				<select name="id">
					<option value="1"  >Bryan French </option><option value="2"  >George Bush </option><option value="3"  >Elvis Presley </option><option value="4"  >Smith Susan </option><option value="5"  >Joseph Jones </option><option value="6"  >Willy Wonka </option><option value="7"  >Kanobi Obi Wan </option><option value="8"  >Skywalker Luke </option><option value="10"  >Lennon John </option><option value="11"  >McCartney Paul </option><option value="12"  >Tonya Roberts </option><option value="13"  >Sam Sneed </option><option value="14"  >Arnold Schwartzenager </option><option value="15"  >Smith Smithtown </option><option value="16"  >Bill JIm Joe Bob </option><option value="17"  >muumin mohamed </option><option value="18"  >muumin mohamed </option><option value="19"  >sindhu kadiyala </option><option value="20"  >ha haa </option><option value="21"  >muumin mohamed </option><option value="22"  >sindhu jhfjkfh </option><option value="23"  >sindhu kadiyala </option><option value="24"  >sss sss </option><option value="25"  >Johnson Marcus </option><option value="26"  >Johnson Marcus </option><option value="27"  >s s </option><option value="28"  >Mr. Moe </option><option value="29"  >bob Smith </option><option value="30"  >Nitin agotiya </option><option value="31"  >AAAAA BBBBBB </option>
				</select>
			</p>
			<p>
				<input type="submit" name="submit" value="Add Phone"/>
			</p>
			<a href="people.php">go back</a>
		</form>
	</body>
</html> -->