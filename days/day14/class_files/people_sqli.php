<?php
	$gHostName="localhost";
	$gUserName="acjvks"; // change to your nova id
	$gPassword="fr1end99"; // "fr1end" to start. After you change it, should the password really be here in this file?
	$gDBName="acjvks";
	
	// 1) ** Open a connection to a MySQL Server.
	// mysqli::__construct ([ string $host [, string $username [, string $passwd [, string $dbname [, int $port [, string $socket ]]]]]] )
	$mysqli= new mysqli($gHostName,$gUserName,$gPassword,$gDBName);
	
	/* check connection */
	if ($mysqli->connect_error) {
    	echo("Connect failed: " . mysqli_connect_error());
    	exit();
	}
	
	$queryString = "SELECT * FROM people";
	$resultSet = $mysqli->query($queryString);
	$numRows = $resultSet->num_rows;
	if ($numRows > 0){
		echo "<h2>Records found: $numRows</h2>";
		// now get the records
		$bigString = "<table border='1'>\n";
		$bigString .= "<tr><th>ID</th><th>First</th><th>Last</th><th>NickName</th></tr>\n";
		while ($row = $resultSet->fetch_assoc()){
			$id = $row['PersonID'];
			$first = $row['FirstName'];
			$last = $row['LastName'];
			$nick = $row['NickName'];
			$bigString .= "<tr><td><a href='phones.php?id=$id'>$id</a></td><td>$first</td><td>$last</td><td>$nick</td></tr>\n";
		}
		$bigString .= "</table>\n";
		echo $bigString;
	}	
	
	/* close connection */
	$mysqli->close();

?>


