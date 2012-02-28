<?php
	//prepared statement example using a separate (non-generic) database class
	class PS_Database {
	
		private $server = "localhost";
		private $user = "xxxxx";
		private $pswd = "xxxxx";
		private $db = "xxxxx";
		private $limit = 15; //would need paging scheme to see more
		private $mysqli;
		private $error;
			
		public function __construct() {		
			$this->mysqli = new mysqli($this->server, $this->user, $this->pswd, $this->db);

			if (mysqli_connect_errno()) 
    			$this->error = "Connect failed: ".mysqli_connect_error();
    		else $this->error = "";
		} //construct
	
		function getError() { return $this->error;}
		
		function getCountryNames($_code) {
		
			$results = array();
			$this->error = "";
			/* prepare statement */
			if ($stmt = $this->mysqli->prepare("SELECT Code, Name FROM country WHERE Code LIKE ? LIMIT {$this->limit}")) {

					$stmt->bind_param("s", $_code);
		
					$stmt->execute();
					
					/* bind variables to prepared statement */
					$stmt->bind_result($code, $name);
		
					/* fetch values */
					while ($stmt->fetch()) {
						$row = array();
						$row['code']= $code;
						$row['name']=$name;
						$results[] = $row;
					}
		   
					/* close statement */
					$stmt->close();
		} // good statement
		else {
			$this->error = $this->mysqli->error;
		}
		return $results;
	} //get names
	
	public function close() {
		/* close connection */
		$this->mysqli->close();
	} //close
	
} //class
?>