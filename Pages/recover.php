<?php
	include '../Core/init.php' ;
	logged_in_redirect() ;
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
				echo '<P>Your details have been mailed to the email adress you provided!!</P>' ;
			}
			else
			{
				$mode = secure($_GET['mode']) ;
				$mode_allowed = array('username' , 'password') ;
				if ((isset($mode) === true) && (in_array($mode , $mode_allowed) === true))
				{
					if ((isset($_POST['email']) === true) && (empty($_POST['email']) === false))
					{
						$email = secure($_POST['email']) ;
						if (email_exists($email) === true)
						{
							recover($mode , $email) ;
							header('Location: recover.php?success') ;
							exit() ;
						}
						else
						{
							echo '<P>Invalid email address!!</P>' ;
						}
					}
					?>
					<FORM action = "" method = "POST">
						<DIV>
							Please enter your email address*:<BR /><BR />
							<INPUT type = "text" name = "email" placeholder = "Email ID" autocomplete = "on" /><BR /><BR />
						</DIV>
						<DIV>
							<INPUT type = "submit" value = "Recover!!" />
						</DIV>
					</FORM>
					<?php
				}
				else
				{
					header('Location: ../index.php') ;
					exit() ;
				}
			}
		?>
	</BODY>
</HTML>
