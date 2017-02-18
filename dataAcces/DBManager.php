<?php

class DBManager {
	//Conexion a una bd
	function conectarDB(){
		

		/*
		$hostname = "localhost";
		$username = "root";
		$password = "";
		$db = "photocloud"; 
		 */
		date_default_timezone_set('Europe/Madrid');
		$con = mysqli_connect($hostname,$username,$password,$db);
		
		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		  
		return $con;
	}
	
	
	
	//Cierra la conexion dada
	function cerrarDB($valor){
		mysqli_close($valor);
	}
}

?>