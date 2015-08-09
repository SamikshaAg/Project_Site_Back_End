<?php
	//user details
	$host = '127.0.0.1' ;
	$user = 'root' ;
	$password = '' ;
	$database= 'site_test' ;
	//generic connection error message
	$connection_error = 'Sorry can\'t connect to database' ;
	//connection to the database
	mysql_connect($host , $user , $password) or die($connection_error) ;
	mysql_select_db($database) ;
?>
