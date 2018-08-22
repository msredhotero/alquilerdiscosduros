<?php

date_default_timezone_set('America/Buenos_Aires');

class appconfig {

function conexion() {
		
		$hostname = "localhost";
		$database = "alquilerdiscosrigidos";
		$username = "root";
		$password = "";
		
		/*
		$hostname = "localhost";
		$database = "u235498999_recla";
		$username = "u235498999_recla";
		$password = "rhcp7575";
		*/
		//u235498999_kike usuario
		
		
		$conexion = array("hostname" => $hostname,
						  "database" => $database,
						  "username" => $username,
						  "password" => $password);
						  
		return $conexion;
}

}




?>