<?php 
/* Database DSN */ 
define('DB_DSN', 'pgsql:host=103.20.189.26;port=4111;dbname=db_genesys;user=postgres;password=admin123'); 

/* Base URL */ 
try{
	// create a PostgreSQL database connection
	$conn = new PDO(DB_DSN);
 
	// display a message if connected to the PostgreSQL successfully
	if($conn){
		// echo "Connected to the database successfully!";
		$result = $conn->query("select * from a_domain");
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if (!$row){
			echo "Domain name <strong>$http_host</strong> is not exist in table [a_domain] !";
			exit();
		} 
		$conn = null;
		
		var_dump($row);
	}
}catch (PDOException $e){
	// report error message
	echo $e->getMessage();
	exit();
}

?>