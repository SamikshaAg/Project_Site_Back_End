<?php
	session_start() ;
	//off for development level
	//error_reporting(0) ;
	//required files
	require 'connection.php' ;
	require 'Functions/user_functions.php' ;
	require 'Functions/general_functions.php' ;
	$current_file = explode('/' , $_SERVER['SCRIPT_NAME']) ;
	$current_file = end($current_file) ;
	if (logged_in() === true)
	{
		$session_user_id = $_SESSION['user_id'] ;
		$user_data = user_data($session_user_id , 'user_id' , 'user_name' , 'user_password' , 'user_password_recovered' , 'user_first_name' , 'user_last_name' , 'user_display_image' , 'user_branch' , 'user_roll_number' , 'user_email' , 'user_allow_email' , 'user_type') ;
		if (user_active($user_data['user_name']) === false)
		{
			session_destroy() ;
			header('Location: index.php') ;
			exit() ;
		}
		if (($current_file !== 'logout.php') && ($current_file !== 'change_password.php') && ($user_data['user_password_recovered'] == 1))
		{
			header('Location: Pages/change_password.php?force') ;
			exit() ;
		}
	}
	$errors = array() ;
?>
