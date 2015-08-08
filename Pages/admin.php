<?php
	include '../Core/init.php' ;
	protect_page() ;
	protect_admin($user_data['user_id'] , $user_data['user_type']) ;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>ISTE, KNIT Sultanpur</TITLE>
	</HEAD>
	<BODY>
		<A HREF="../index.php">&larr; Back</A><BR /><BR />
		This is an Admin page!!
	</BODY>
</HTML>
