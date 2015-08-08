<?php
	function secure($data)
	{
		$result = mysql_real_escape_string($data) ;
		$result = strip_tags($result) ;
		$result = htmlentities($result) ;
		return $result ;
	}
	function output_errors($errors)
	{
		$output = array() ;
		foreach ($errors as $error)
		{
			$output[] = '<LI>' . $error . '</LI>' ;
		}
		$result = '<UL>' . implode('' , $output) . '</UL>' ;
		return $result ;
	}
	function secure_array(&$data)
	{
		$result = mysql_real_escape_string($data) ;
		$result = strip_tags($result) ;
		$result = htmlentities($result) ;
		return $result ;
	}
	function protect_page()
	{
		if (logged_in() === false)
		{
			header('Location: protected.php') ;
			exit() ;
		}
	}
	function logged_in_redirect()
	{
		if (logged_in() === true)
		{
			header('Location: ../index.php') ;
			exit() ;
		}
	}
	function send_email($to , $subject , $body)
	{
		$header = 'From: admin@iste.org' ;
		mail($to , $subject, $body , $header) ;
	}
	function protect_admin($id , $type)
	{
		if (has_access($id , $type) === false)
		{
			header('Location: ../index.php') ;
			exit() ;
		}
	}
?>
