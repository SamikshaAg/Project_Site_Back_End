<?php
	include 'Core/init.php' ;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>ISTE, KNIT Sultanpur</TITLE>
	</HEAD>
	<BODY>
		<UL>
			<LI>
				<A HREF="Pages/private.php">Private page</A>
			</LI>
			<LI>
				<A HREF="Pages/public.php">Public page</A>
			</LI>
		</UL>
		<?php
			if (logged_in())
			{
				?>
				Hello ,
				<?php
					echo $user_data['user_name'] , '<BR /><BR />' ;
					?>
					<DIV>
						<?php
							if (isset($_FILES['profile']))
							{
								if (empty($_FILES['profile']['name']))
								{
									?>
									Please choose a file!!<BR /><BR />
									<?php
								}
								else
								{
									$allowed = array('png' , 'tif' , 'tiff' , 'gif' , 'jpg' , 'jpeg' , 'jpe' , 'jfif') ;
									$file_name = $_FILES['profile']['name'] ;
									$file_extension = explode('.' , $file_name) ;
									$file_extension = strtolower(end($file_extension)) ;
									$file_temp = $_FILES['profile']['tmp_name'] ;
									if (in_array($file_extension , $allowed) === true)
									{
										change_profile_image($session_user_id , $file_temp , $file_extension) ;
										header('Location: index.php') ;
										exit() ;
									}
									else
									{
										?>
										Incorrect File type , Only following file types are allowed!!<BR /><BR />
										<?php
										$output = implode(' , ', $allowed_file_types) ;
										echo $output , '<BR /><BR />' ;
									}
								}
							}
							if (empty($user_data['user_display_image']) === false)
							{
								?>
								<IMG src = "<?php echo $user_data['user_display_image'] ;?>" alt = "alpha" /><BR /><BR />
								<?php
							}
						?>
						<FORM action = "" method = "POST" enctype = "multipart/form-data">
							<INPUT type = "file" name = "profile"  /><BR /><BR />
							<INPUT type = "submit" value = "Upload!!" /><BR /><BR />
						</FORM>
					</DIV>
					<?php
						if (has_access($session_user_id , 1) === true)
						{
							echo "You are an administrator!!<BR /><BR />";
							?>
							<A HREF="Pages/email.php">Email users!!</A><BR /><BR />
							<?php
						}
						elseif (has_access($session_user_id , 2) === true)
						{
							echo "You are a moderator!!<BR /><BR />" ;
							?>
							<?php
						}
				?>
				<A HREF="Pages/logout.php">Log Out!!</A><BR /><BR />
				<A HREF="Pages/change_password.php">Change Password!!</A><BR /><BR />
				<A HREF="Pages/settings.php">Settings!!</A><BR /><BR />
				<A HREF="Pages/<?php echo $user_data['user_name'] ; ?>">Profile!!</A><BR /><BR />
				<A HREF="PAges/blog.php">Wall</A><BR /><BR />
				We currently have 
				<?php
					$active_users = user_count() ;
					if ($active_users != 1)
					{
						$suffix = 's' ;
					}
					else
					{
						$suffix = '' ;
					}
					echo user_count() ;
				?> registered user<?php echo $suffix ; ?>!!
				<?php
			}
			else
			{
				?>
				You need to 
				<A HREF="Pages/login.php">login</A> or 
				<A HREF="Pages/register.php">register</A><BR /><BR />
				Forgotten your <A HREF="Pages/recover.php?mode=username">username</A> or <A HREF="Pages/recover.php?mode=password">password</A><BR /><BR />
				<?php
			}
		?>
	</BODY>
</HTML>
