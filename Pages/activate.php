<?php
	include '../Core/init.php' ;
	logged_in_redirect() ;
	if ((isset($_GET['email'])) && (isset($_GET['email_code'])))
	{
		$user_email = secure(trim($_GET['email'])) ;
		$user_email_code = secure(trim($_GET['email_code'])) ;
		if (email_exists($user_email) === false)
		{
			$errors[] = 'We could not find that email address!!' ;
		}
		elseif (activate($user_email , $user_email_code) === false)
		{
			$errors[] = 'We had problem activating your account!!' ;
		}
	}
	else
	{
		header('Location: ../index.php') ;
		exit() ;
	}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>ISTE, KNIT Sultanpur</TITLE>
	</HEAD>
	<BODY>
		<?php
			if ((isset($_GET['success'])) && (empty($_GET['success'])))
			{
				echo "Your account has been activated!!" ;
			}
			else
			{
				if (empty($errors) === false)
				{
					?>
					We tried activating your account but....
					<?php
					echo output_errors($errors) ;
				}
				else
				{
					header('Location: activate.php?success') ;
					exit() ;
				}
			}
		?>
	</BODY>
</HTML>
