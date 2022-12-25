<?php
 session_start(); //starts the session
 if($_SESSION['user']){ //checks if user is logged in
	}
 else{
 header("location:index.php"); // redirects if user is not logged in
	}
 if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		 $con = mysqli_connect("localhost", "root", "", "deliverydb2") or die(mysqli_error()); //Connect to server
		 $id = $_GET['id'];
		 mysqli_query($con, "DELETE FROM list WHERE id='$id'");
		 header("location: home.php");
	}
?>