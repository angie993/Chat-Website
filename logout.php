<?php

	session_start();

	session_destroy();

	//cookie expires
	setcookie("email","",time()-3600);

	header("location:login.php");
?>