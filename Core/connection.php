<?php
	//server details
	$host = '127.0.0.1' ;
	$user = 'root' ;
	$password = '' ;
	$database= 'site_test' ;
	//databse connection through mysqli
	$database_handler = new mysqli($host , $user , $password , $database)or die("Could not connect to mysql".mysqli_error($database_handler)) ;
?>
