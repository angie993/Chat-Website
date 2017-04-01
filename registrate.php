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

		$firstName = mysqli_real_escape_string($con, $_POST['fname']);
		$lastName = mysqli_real_escape_string($con, $_POST['lname']);
	    $email = mysqli_real_escape_string($con, $_POST['email']);
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];

		$image = $_FILES['image']['name'];
		$tmp_image = $_FILES['image']['tmp_name'];
		$image_size = $_FILES['image']['size'];

		$conditions = isset($_POST["conditions"]);

		$date = date("F,d Y");

		if(strlen($firstName) < 3)
		{
			$error ="First name is too short.";
		}
		else if(strlen($lastName) < 3)
		{

			$error ="Last name is too short.";

		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{

			$error ="Please enter valid email address.";

		}
		else if(email_exists($email, $con))
		{
			$error = "Someone is alredy registered with this email.";


		}
		else if(strlen($password) < 8)
		{

			$error ="Password  must be longer then 8 charachters.";

		}
		else if( $password !== $passwordConfirm)
		{

			$error ="Password does not match.";

		}
		else if($image == "")
		{

			$error ="Please upload your image.";

		}
		else if($image_size > 1048576){
			$error = "Image size must be less then 1Mb.";

		}
		else if(!$conditions)
		{
			$error = "You must agree with the terms and conditions.";

		}
		else 
		{
			$password = md5($password); // encrypting the password

			$imageExt = explode(".",$image); //unique picture for every user
			$imageExtension = $imageExt[1];

			if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg")
			{


				$image = rand(0,100000).rand(0,100000).rand(0,100000).time().".".$imageExtension; 



				$insertQuery = "INSERT INTO users(firstName, lastName, email, password, image, date) VALUES ('$firstName','$lastName','$email','$password','$image','$date')";
						if(mysqli_query($con, $insertQuery))
						{
							if(move_uploaded_file($tmp_image,"images/$image"))
							{
								$error = "You are successfully registered";
							}
							else
							{
								$error = "Image is not uploaded";
							}
						}
			}
			else
			{
				$error = "File must be an image";
			}
		}
	}

?>


<!DOCTYPE html>
<html>
	
	<head>
		<title>Registration page</title>
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
				<form method="POST" action="registrate.php" enctype="multipart/form-data">

                    <label>First name:</label><br>
					<input type="text" name="fname" class="inputFields" required /><br><br>

					<label>Last name:</label><br>
					<input type="text" name="lname" class="inputFields" required /><br><br>

					<label>Email:</label><br>
					<input type="text" name="email" class="inputFields" required /><br><br>

					<label>Password:</label><br>
					<input type="password" name="password" class="inputFields" required/><br><br>

					<label>Re-enter Password:</label><br>
					<input type="password" name="passwordConfirm" class="inputFields"/><br><br>

					<label>Image:</label><br>
					<input type="file" name="image" id="imageupload" /><br><br>

					<input type="checkbox" name="conditions" />
					<label>I am agree with the terms and conditions.</label><br /><br />

					<input type="submit" name="submit" class="theButtons"/><br><br>
									
				</form>
				
			</div>
			
		</div>
		

	</body>
</html>