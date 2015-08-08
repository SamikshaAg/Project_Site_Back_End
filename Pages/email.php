<?php
	include '../Core/init.php' ;
	protect_page() ;
	protect_admin($user_data['user_id'] , 1) ;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>ISTE, KNIT Sultanpur</TITLE>
	</HEAD>
	<BODY>
		<A HREF="../index.php">&larr; Back</A><BR /><BR />
		<H1>Email all users</H1>
		<BR /><BR />
		<?php
			if ((isset($_GET['success'])) && (empty($_GET['success'])))
			{
				?>
				<P>Email has been sent!!</P>
				<?php
			}
			else
			{
				if (empty($_POST) === false)
				{
					$subject = secure($_POST['subject']) ;
					$body = secure($_POST['body']) ;
					if ((empty($subject) === true) && (empty($body) === true))
					{
						$errors[] = 'Both subject and body are required!!' ;
					}
					elseif (empty($subject))
					{
						$errors[] = 'Subject is required!!' ;
					}
					elseif (empty($body))
					{
						$errors[] = 'Body is required!!' ;
					}
					if (empty($errors) === false)
					{
						echo output_errors($errors) ;
					}
					else
					{
						mail_users($subject , $body) ;
						header('Location: email.php?success') ;
						exit() ;
					}
				}
				?>
				<FORM action = "" method = "POST">
					<DIV>
						Subject*:<BR /><BR /><BR /><BR />
						<INPUT type = "text" name = "subject" value = "<?php if(empty($subject) === false) {echo $subject ;}?>" placeholder = "Subject" autocomplete = "on" /><BR /><BR /><BR /><BR />
					</DIV>
					<DIV>
						Body*:<BR /><BR />
						<TEXTAREA name = "body">
							<?php
								if (empty($body) === false)
								{
									echo $body ;
								}
							?>
						</TEXTAREA><BR /><BR />
					</DIV>
					<DIV>
						<INPUT type = "submit" value = "Send!!" />
					</DIV>			
				</FORM>
				<?php
			}
		?>
	</BODY>
</HTML>
