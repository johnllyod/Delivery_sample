<?php
$servername = "containers-us-west-58.railway.app"; // server site
$username = "root"; // server username
$password = "jCTG3kIHO7Uc11FroTGW"; // server password

//For local host
/*$servername = "localhost"; // server site
$username = "root"; // server username
$password = ""; // server password*/

$con = new mysqli($servername, $username, $password); // connect to server

if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error); // Check if failed to connect to the server
}
else 
{
	$db_select = mysqli_select_db($con, "railway"); // selects database
}
?> 