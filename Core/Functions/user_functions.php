<?php
	function user_exists($username)
	{
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username'") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function user_active($username)
	{
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username' AND `user_active_status` = 1") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function user_id_by_username($username)
	{
		$query = mysql_query("SELECT `user_id` FROM `users` WHERE `user_name` = '$username'") ;
		$result = mysql_result($query , 0 , 'user_id') ;
		return $result ;
	}
	function login($username , $password)
	{
		$user_id = user_id_by_username($username) ;
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username' AND `user_password` = '$password'") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			return $user_id ;
		}
		else
		{
			return false ;
		}
	}
	function logged_in()
	{
		if (isset($_SESSION['user_id']))
		{
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function user_data($user_id)
	{
		$data = array() ;
		$user_id = (int) $user_id ;
		$number_of_arguments = func_num_args() ;
		$list_of_arguments = func_get_args() ;
		if ($number_of_arguments > 1)
		{
			unset($list_of_arguments[0]) ;
			$fields = '`' . implode('` , `' , $list_of_arguments) . '`' ;
			$query = mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id") ;
			$data = mysql_fetch_assoc($query) ;
			return $data ;
		}
	}
	function user_count()
	{
		$query = mysql_query("SELECT  COUNT(`user_id`) FROM `users` WHERE `user_active_status` = 1") ;
		$result = mysql_result($query , 0) ;
		return $result ;
	}
	function email_exists($email)
	{
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_email` = '$email'") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function register_user($registration_data)
	{
		array_walk($registration_data , 'secure_array') ;
		$fields = '`' . implode('` , `' , array_keys($registration_data)) . '`' ;
		$data = '\'' . implode('\' , \'' , $registration_data) . '\'' ;
		mysql_query("INSERT INTO `users` ($fields) VALUES ($data)") ;
		$to = $registration_data['email'] ;
		$subject = 'Account activation' ;
		$body = "Hello " . $registration_data['user_first_name'] . " " . $registration_data['user_last_name'] . ",\n\nYou need to activate your account by either clicking on this link or copying and pasting this link in another tab\n\nhttp://localhost/Project_Site_Back_End/Pages/activate.php?email=" . $registration_data['user_email'] . "&email_code=" . $registration_data['user_email_code'] . "\n\n-ISTE" ;
		send_email($to , $subject , $body) ;
	}
	function change_password($user_id , $new_password)
	{
		mysql_query("UPDATE `users` SET `user_password` = '$new_password' , `user_password_recovered` = 0 WHERE `user_id` = $user_id") ;
	}
	function activate($user_email , $user_email_code)
	{
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_email` = '$user_email' AND `user_email_code` = '$user_email_code' AND `user_active_status` = 0") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			mysql_query("UPDATE `users` SET `user_active_status` = 1 WHERE `user_email` = '$user_email'") ;
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function update_details($update_data , $id)
	{
		$user_id = $id ;
		$update = array() ;
		array_walk($update_data , 'secure_array') ;
		foreach ($update_data as $field => $data)
		{
			$update[] = '`' . $field . '` = \'' . $data . '\'' ;
		}
		mysql_query("UPDATE `users` SET " . implode(' , ', $update) . " WHERE `user_id` = $user_id") ;
	}
	function user_id_by_email($email)
	{
		$query = mysql_query("SELECT `user_id` FROM `users` WHERE `user_email` = '$email'") ;
		$result = mysql_result($query , 0 , 'user_id') ;
		return $result ;
	}
	function recover($mode , $email)
	{
		$id = user_id_by_email($email) ;
		$user_data = user_data($id , 'user_id' , 'user_first_name' , 'user_last_name' , 'user_name') ;
		$to = $email ;
		if ($mode == 'username')
		{
			$subject = "Username recovery" ;
			$body = "Hello " . $user_data['user_first_name'] . " " . $user_data['user_last_name'] . "\n\nYour username is\n\n" . $user_data['user_name'] . "\n\n-ISTE" ;
		}
		elseif ($mode == 'password')
		{
			$generated_password = substr(md5(rand(999 , 999999)) , 0 , 15) ;
			change_password($user_data['user_id'] , $generated_password) ;
			update_details(array('user_password_recovered' => 1) , $user_data['user_id']) ;
			$subject = "Password recovery" ;
			$body = "Hello " . $user_data['user_first_name'] . " " . $user_data['user_last_name'] . "\n\nYour new password is\n\n" . $generated_password . "\n\n-ISTE" ;
		}
		send_email($to , $subject , $body) ;
	}
	function has_access($user_id , $type)
	{
		$user_id = (int) $user_id ;
		$type = (int) $type ;
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `user_type` = $type") ;
		$result = mysql_result($query , 0) ;
		if ($result == 1)
		{
			return true ;
		}
		else
		{
			return false ;
		}
	}
	function mail_users($subject , $body)
	{
		$query = mysql_query("SELECT `user_email` , `user_first_name` , `user_last_name` FROM `users` WHERE `user_allow_email` = 1") ;
		while (($row = mysql_fetch_assoc($query)) !== false)
		{
			$to = $row['user_email'] ;

			$message = "Hello " . $row['user_first_name'] . " " . $row['user_last_name'] . ",\n\n" . $body . "\n\n-ISTE" ;
			send_email($to , $subject , $message) ;
		}
	}
	function change_profile_image($user_id , $address , $extension)
	{
		$user_id = (int) $user_id ;
		$file_path = 'Images/Profile/' . substr(md5(time()) , 0 , 10) . '.' . $extension ;
		move_uploaded_file($address , $file_path) ;
		mysql_query("UPDATE `users` SET `user_display_image` = '" . $file_path . "' WHERE `user_id` = " . $user_id) ;
	}
?>
