<?php
	include '../Core/init.php' ;
	if ((isset($_GET['username']) === true) && (empty($_GET['username']) === false))
	{
		$username = secure($_GET['username']) ;
		if (user_exists($username) === true)
		{
			$user_id = (int) user_id_by_username($username) ;
			$profile_data = user_data($user_id , 'user_name' , 'user_first_name' , 'user_last_name' , 'user_branch' , 'user_roll_number' , 'user_email' , 'user_joining_date') ;
		}
		else
		{
			echo "Sorry that user doesn't exist!!" ;
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
		<A HREF="../index.php">&larr; Back</A><BR /><BR />
		<H1>
			<?php
				echo $profile_data['user_name'] ;
			?>'s Profile
		</H1>
		First Name:
		<?php
			echo $profile_data['user_first_name'] ;
		?><BR /><BR />
		Last Name:
		<?php
			echo $profile_data['user_last_name'] ;
		?><BR /><BR />
		Branch:
		<?php
			echo $profile_data['user_branch'] ;
		?><BR /><BR />
		Roll Number:
		<?php
			echo $profile_data['user_roll_number'] ;
		?><BR /><BR />
		Email:
		<?php
			echo $profile_data['user_email'] ;
		?><BR /><BR />
		Joining Date:
		<?php
			echo $profile_data['user_joining_date'] ;
		?><BR /><BR />
	</BODY>
</HTML>
