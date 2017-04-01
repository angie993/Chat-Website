<?php

	include ("connect.php");
	include ("functions.php");

	if(logged_in())
	{
		
		?>
		<a href="changepassword.php">Change password</a>

		<a href="logout.php" style="float:right; padding:10px; margin-right:40px; background-color:#eee;color:#333; text-decoration: none; ">Log out</a>





		<?php


	}
	else
	{
		//kada nismo ulogovani, da nas vraca na login stranicu
		header("location:login.php");
		exit();
	}


?>