<?php
	$gHostName="localhost";
	$gUserName="abc1234"; // change to your nova id
	$gPassword="fr1end"; // "fr1end" to start. After you change it, should the password really be here in this file?
	$gDBName="abc1234";
	
	// 1) ** Open a connection to a MySQL Server.
	// mysqli::__construct ([ string $host [, string $username [, string $passwd [, string $dbname [, int $port [, string $socket ]]]]]] )
	$mysqli= new mysqli($gHostName,$gUserName,$gPassword,$gDBName);
	
	/* check connection */
	if ($mysqli->connect_error) {
    	echo("Connect failed: " . mysqli_connect_error());
    	exit();
	}
	
	$queryString = "SELECT * FROM jokes";
	$resultSet = $mysqli->query($queryString);
	$numRows = $resultSet->num_rows;
	if ($numRows > 0){
		echo "<h2>Records found: $numRows</h2>";
		// get the field titles
		$bigString = "<table border='1'>\n<tr>";
		while ($fieldData = $resultSet->fetch_field()){
			$bigString .= "<td>";
			$bigString .=  $fieldData->name;
			$bigString .= "</td>";
		}
		$bigString .= "</tr>\n";
		
		// now get the records
		while ($row = $resultSet->fetch_assoc()){
			$bigString .= "<tr>";
			foreach ($row as $fieldValue){
				$bigString .= "<td>$fieldValue</td>"; 
			}
		$bigString .= "</tr>\n";
    	}
    	$bigString .= "</table>\n";
		echo $bigString;
	}
	
	/* close connection */
	$mysqli->close();

?>