<?php
	include '../Core/init.php' ;
	logged_in_redirect() ;
	if (empty($_POST) === false)
	{
		$user_name = secure($_POST['user_name']) ;
		$password = $_POST['password'] ;
		$password_again = $_POST['password_again'] ;
		$first_name = secure($_POST['first_name']) ;
		$last_name = secure($_POST['last_name']) ;
		$branch = secure($_POST['branch']) ;
		$email = secure($_POST['email']) ;
		$roll_no = (int) $_POST['roll_no'] ;
		$required_fields = array('user_name' , 'password' , 'password_again' , 'first_name' , 'roll_no' , 'email') ;
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
			if ((strlen($password) < 6) || (strlen($password) > 32))
			{
				$errors[] = 'Password must be between 6 to 32 characters!!' ;
			}
			if ($password !== $password_again)
			{
				$errors[] = 'Your passwords need to match!!' ;
			}
			if (filter_var($email , FILTER_VALIDATE_EMAIL) === false)
			{
				$errors[] = 'Invalid email address!!' ;
			}
			if (email_exists($email) === true)
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
			if ((isset($_GET['success'])) && (empty($_GET['success'])))
			{
				echo "You have been successfully registered!!<BR /><BR />" ;
				echo "Please check your email for account activation related information!!";
			}
			else
			{
				if ((empty($errors) === true) && (empty($_POST) === false))
				{
					$registration_data = array(
						'user_name' => $user_name ,
						'user_password' => $password ,
						'user_first_name' => $first_name ,
						'user_last_name' => $last_name ,
						'user_branch' => $branch ,
						'user_roll_number' => $roll_no ,
						'user_email' => $email ,
						'user_email_code' => md5($user_name + microtime()) ,
						'user_joining_date' => date('Y-m-d H:i:s')
						) ;
					register_user($registration_data) ;
					header('Location: register.php?success') ;
					exit() ;
				}
				elseif (empty($errors) === false)
				{
					echo output_errors($errors) , '<BR /><BR />' ;
				}
				?>
				<FORM action = "" method = "POST">
					<DIV>
						Username *:<BR /><BR />
						<INPUT type = "text" name = "user_name" autocomplete = "on" placeholder = "Username" /><BR /><BR />
					</DIV>
					<DIV>
						Password *:<BR /><BR />
						<INPUT type = "password" name = "password" placeholder = "Password" /><BR /><BR />
					</DIV>
					<DIV>
						Password Again *:<BR /><BR />
						<INPUT type = "password" name = "password_again" placeholder = "Password" /><BR /><BR />
					</DIV>
					<DIV>
						First Name *:<BR /><BR />
						<INPUT type = "text" name = "first_name" autocomplete = "on" placeholder = "First Name" /><BR /><BR />
					</DIV>
					<DIV>
						Last Name :<BR /><BR />
						<INPUT type = "text" name = "last_name" autocomplete = "on" placeholder = "Last Name" /><BR /><BR />
					</DIV>
					<DIV>
						Branch :<BR /><BR />
						<SELECT name = "branch">
							<OPTION value = "CE">Civil Engineering</OPTION>
							<OPTION value = "CSE">Computer Science and Engineering</OPTION>
							<OPTION value = "EE">Electrical Engineering</OPTION>
							<OPTION value = "EL">Electronics Engineering</OPTION>
							<OPTION value = "ME">Mechanical Engineering</OPTION>
							<OPTION value = "IT">Informatin Technology</OPTION>
							<OPTION value = "MCA">Master of Computer Application</OPTION>
						</SELECT><BR /><BR />
					</DIV>
					<DIV>
						Roll Number *:<BR /><BR />
						<INPUT type = "text" name = "roll_no" autocomplete = "on" placeholder = "Roll Number" /><BR /><BR />
					</DIV>
					<DIV>
						Email *:<BR /><BR />
						<INPUT type = "text" name = "email" autocomplete = "on" placeholder = "Email" /><BR /><BR />
					</DIV>
					<DIV>
						<INPUT type = "submit" value = "Register!!" /><BR /><BR />
					</DIV>
				</FORM>
				<?php
			}
		?>
	</BODY>
</HTML>
