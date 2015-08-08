<?php
	include '../Core/init.php' ;
	protect_page() ;
	if (empty($_POST) === false)
	{
		$current_password = trim($_POST['current_password']) ;
		$new_password = trim($_POST['new_password']) ;
		$new_password_again = trim($_POST['new_password_again']) ;
		$required_fields = array('current_password' , 'new_password' , 'new_password_again') ;
		foreach ($_POST as $key => $value)
		{
			if ((empty($value)) && (in_array($key , $required_fields) === true))
			{
				$errors[] = 'Fields marked with an * are  required!!' ;
				break ;
			}
		}
		if ($current_password !== $user_data['user_password'])
		{
			$errors[] = 'Your current password is incorrect!!' ;
		}
		elseif ($new_password !== $new_password_again)
		{
			$errors[] = 'Your new passwords do not match!!' ;
		}
		elseif ((strlen($new_password) < 6) || (strlen($new_password) > 32))
		{
			$errors[] = 'Password must be between 6 to 32 characters!!' ;
		}
	}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>ISTE, KNIT Sultanpur</TITLE>
	</HEAD>
	<BODY>
		<A HREF="../index.php">&larr; Back</A><BR /><BR />
		<?php
			if ((isset($_GET['success'])) && (empty($_GET['success'])))
			{
				echo "Your password has been successfully changed!!" ;
			}
			else
			{
				if ((isset($_GET['force'])) && (empty($_GET['force'])))
				{
					?>
					<P>Please change your password now or you may be vulnerable to security issues!!</P>
					<?php
				}
				if ((empty($_POST) === false) && (empty($errors) === true))
				{
					$user_id = $user_data['user_id'] ;
					change_password($user_id , $new_password) ;
					header('Location: change_password.php?success') ;
					exit() ;
				}
				elseif (empty($errors) === false)
				{
					echo output_errors($errors) ;
				}
				?>
				<FORM action = "" method = "POST">
					<DIV>
						Current Password*:<BR /><BR />
						<INPUT type = "password" name = "current_password" />
					</DIV>
					<DIV>
						New Password*:<BR /><BR />
						<INPUT type = "password" name = "new_password" />
					</DIV>
					<DIV>
						New Password Again*:<BR /><BR />
						<INPUT type = "password" name = "new_password_again" />
					</DIV>
					<DIV>
						<BR /><BR />
						<INPUT type = "submit" value = "Change Password!!" />
					</DIV>
				</FORM>
				<?php
			}
		?>
	</BODY>
</HTML>
