<?php
	include '../Core/init.php' ;
	logged_in_redirect() ;
	if (empty($_POST) === false)
	{
		$username = secure($_POST['username']) ;
		$password = $_POST['password'] ;
		if ((empty($username) === true) && (empty($password) === true))
		{
			$errors[] = 'You need to enter a username and a password!!' ;
		}
		elseif ((empty($username) === true) && (empty($password) === false))
		{
			$errors[] = 'You need to enter a username!!' ;
		}
		elseif ((empty($username) === false) && (empty($password) === true))
		{
			$errors[] = 'You need to enter a password!!' ;
		}
		elseif (user_exists($username) === false)
		{
			$errors[] = 'Username does not exists!!' ;
		}
		elseif (user_active($username) === false)
		{
			$errors[] = 'Your account is not active!!' ;
		}
		else
		{
			if (strlen($password) > 32)
			{
				$errors[] = 'Too long password!!' ;
			}
			$login_status = login($username , $password) ;
			if ($login_status === false)
			{
				$errors[] = 'That username/password combination is incorrect!!' ;
			}
			else
			{
				$_SESSION['user_id'] = $login_status ;
				header('Location: ../index.php') ;
				exit() ;
			}
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
			if (empty($errors) === false)
			{
				?>
				<H2>We tried to log you in but..</H2>
				<?php
				echo output_errors($errors) ;
			}
		?>
		<FORM action = "" method = "POST">
			<DIV>
				Username *:<BR /><BR />
				<INPUT type = "text" name = "username" autocomplete = "on" placeholder = "Username" /><BR /><BR />
			</DIV>
			<DIV>
				Password *:<BR /><BR />
				<INPUT type = "password" name = "password" placeholder = "Password" /><BR /><BR />
			</DIV>
			<DIV>
				<INPUT type = "submit" value = "Log In!!" />
			</DIV>
		</FORM>
	</BODY>
</HTML>
