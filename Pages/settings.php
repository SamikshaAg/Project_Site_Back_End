<?php
	include '../Core/init.php' ;
	protect_page() ;
	if (empty($_POST) === false)
	{
		$user_name = secure($_POST['user_name']) ;
		$user_first_name = secure($_POST['first_name']) ;
		$user_last_name = secure($_POST['last_name']) ;
		$branch = secure($_POST['branch']) ;
		$email = secure($_POST['email']) ;
		$required_fields = array('user_name' , 'first_name' , 'email') ;
		foreach ($_POST as $key => $value)
		{
			if ((empty($value)) && (in_array($key , $required_fields) === true))
			{
				$errors[] = 'Fields marked with an * are  required!!' ;
				break ;
			}
		}
		if (empty($errors) === true)
		{
			if (user_exists($user_name))
			{
				$errors[] = 'The username \'' . $user_name . '\' is already taken!!' ;
			}
			if (preg_match("/\\s/" , $user_name) == true)
			{
				$errors[] = 'Username can not contain white spaces!!' ;
			}
			if (filter_var($email , FILTER_VALIDATE_EMAIL) === false)
			{
				$errors[] = 'Invalid email address!!' ;
			}
			if ((email_exists($email) === true) && ($user_data['user_email'] !== $_POST['email']))
			{
				$errors[] = 'The email \'' . $email . '\' is already taken!!' ;
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
			if ((isset($_GET['success']) === true) && (empty($_GET['success']) === true))
			{
				echo "Your details have been updated successfully!!" ;
			}
			else
			{
				if ((empty($_POST) === false) && (empty($errors) === true))
				{
					if ($_POST['allow_email'] == 'on')
					{
						$allow_email = 1 ;
					}
					else
					{
						$allow_email = 0 ;
					}
					echo $allow_email ;
					$update_data = array(
						'user_name' => $user_name ,
						'user_first_name' => $user_first_name ,
						'user_last_name' => $user_last_name ,
						'user_branch' => $branch ,
						'user_email' => $email ,
						'user_allow_email' => $allow_email
						) ;
					update_details($update_data , $session_user_id) ;
					header('Location: settings.php?success') ;
					exit() ;
				}
				elseif (empty($errors) === false)
				{
					echo output_errors($errors) ;
				}
				?>
				<FORM action = "" method = "POST" enctype = "multipart/form-data">
					<DIV>
						Username*:<BR /><BR />
						<INPUT type = "text" name = "user_name" value = "<?php echo $user_data['user_name']?>" /><BR /><BR />
					</DIV>
					<DIV>
						First Name*:<BR /><BR />
						<INPUT type = "text" name = "first_name" value = "<?php echo $user_data['user_first_name']?>" /><BR /><BR />
					</DIV>
					<DIV>
						Last Name:<BR /><BR />
						<INPUT type = "text" name = "last_name" value = "<?php echo $user_data['user_last_name']?>" /><BR /><BR />
					</DIV>
					<DIV>
						Profile Image:<BR /><BR />
						<INPUT type = "file" name = "profile"  /><BR /><BR />
					</DIV>
					<DIV>
						Branch:<BR /><BR />
						<INPUT type = "text" name = "branch" value = "<?php echo $user_data['user_branch']?>" /><BR /><BR />
					</DIV>
					<DIV>
						Email*:<BR /><BR />
						<INPUT type = "text" name = "email" value = "<?php echo $user_data['user_email']?>" /><BR /><BR />
					</DIV>
					<DIV>
						<INPUT type = "checkbox" name = "allow_email" <?php if($user_data['user_allow_email'] == 1) {echo 'checked="checked"' ;}?> />Would you like to recieve email from us<BR /><BR />
					</DIV>
					<DIV>
						<INPUT type = "submit" value = "Update" />
					</DIV>
				</FORM>
				<?php
			}
		?>
	</BODY>
</HTML>
