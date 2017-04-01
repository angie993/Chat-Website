<?php 
	include 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>ChatBox</title>
	<link rel="stylesheet" href="style.css" media="all"/>
	<script>
		function ajax(){
			var req = new XMLHttpRequest();
			req.onreadystatechange = function(){

				if(req.readyState == 4 && req.status == 200){

					document.getElementById('chat').innerHTML = req.responseText;

			}
			}

				req.open('GET','chat.php',true);
				req.send();
			}

			setInterval(function(){ajax()},1000)
	</script>
	
</head>
<body onload="ajax();">
	<div id="container">
		<div id="banner">
    	</div>
	    <nav id="navigation">
	      <ul id="nav">
	        <li><a href="pocetna.html">Home</a></li>
	        <li><a href="registrate.php">Reg & Log</a></li>
	        <li><a href="index.php">Chat room</a></li>
	        <li><a href="contact.html">Contact</a></li>
	      </ul>
	    </nav>
		<div id="chat_box">
			<div id="chat"></div>
		
		</div>
		<form method="post" action="index.php">
			<input type="text" name="name" placeholder="Enter name"/>
			<textarea name="msg" placeholder="Enter message.."></textarea>
			<input type="submit" name="submit" value="Send it"/>


		</form>

		<?php 

			if(isset($_POST['submit'])){

				$name = $_POST['name'];
				$msg = $_POST['msg'];

			$query = "INSERT INTO chatty (name,msg) values ('$name','$msg')";

			$run = $con->query($query);

				if($run){

					echo "<embed  loop='false' src='chat.WAV' hidden='true' autoplay='true'/>";
				}
			} 
		?>

		

	</div>
	
</body>
	
</html>