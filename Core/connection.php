<?php
	//user details
	$host = '127.0.0.1' ;
	$user = 'root' ;
	$password = '' ;
	$database= 'site_test' ;
	//generic connection error message
	$connection_error = 'Sorry can\'t connect to database' ;
	//connection to the database
	$database_handler = new mysqli($host , $user , $password , $database) or die($connection_error) ;
?>
