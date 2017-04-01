<?php 

	include ("connect.php");
	include ("functions.php");

	if(logged_in())
	{
		header("location:profile.php");
		exit(); // da bi se ulogovali i ostali na strani profile.php a ne da se vraca na login.php -> ovo exit znaci da program ne cita ovaj kod ispod
	}

	$error="";

	if(isset($_POST['submit']))
	{

		
	    $email = mysqli_real_escape_string($con, $_POST['email']);
		$password =mysqli_real_escape_string($con, $_POST['password']);

		//if checkbox is chhecked -> use cookies(saves a value for a period of time,until cookie expires) and session(session expires when you log out)
		$checkBox = isset($_POST['keep']);







		//ckeck if the user exists

		if(email_exists($email, $con))
		{
			$result = mysqli_query($con, "SELECT password  FROM users WHERE email = '$email'");
			$retrievepassword = mysqli_fetch_assoc($result);

			//checking if the password matches the email

			if(md5($password) !== $retrievepassword['password'])
			{
				$error = "Password is incorrect!";

			}
			else
			{
				//signing in the user with sessions
				$_SESSION['email'] = $email;
				
				if($checkBox == "on")
				{
					setcookie("email",$email, time()+3600);
				}
				
				header("location: profile.php");




			}

			

			


		}


		
		else
		{
			$error = "Email does not exists.";
		}


	
	}

?>


<!DOCTYPE html>
<html>
	
	<head>
		<title>Login page</title>
		<link rel="stylesheet" href="login.css"/>
	</head>
	<body>
		<div id="error" style=" <?php  if($error !=""){ ?>  display:block; <?php } ?> "><?php echo $error; ?></div>
		<div id="wrapper">
			<div id="menu">
				<a href="registrate.php">Sign Up</a>
				<a href="login.php">Login</a>
			</div>

			<div id="formdiv">
				<form method="POST" action="login.php">

                    <label>Email:</label><br>
					<input type="text" name="email" class="inputFields"/><br><br>

					<label>Password:</label><br>
					<input type="password" name="password" class="inputFields"/><br><br>

					<input type="checkbox" name="keep" />
					<label>Keep me logged in</label><br /><br />
					

					<input type="submit" name="submit" class="theButtons" value="Login"/><br><br>
									
				</form>
				
			</div>
			
		</div>
		

	</body>
</html>