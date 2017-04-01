<?php 

 $con = mysqli_connect("localhost","root","","registration");

 if(mysqli_connect_errno()){

 	echo "Error occured while connecting with the database".mysqli_connect_errno();

 }

function formatDate($date){

	return date('g:i a',strtotime($date));

}

 session_start();
 
?>