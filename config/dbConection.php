<?php
$servername = "db4free.net"; // server site
$username = "personalsql2"; // server username
$password = "17jtheskull"; // server password

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
	$db_select = mysqli_select_db($con, "deliverydb2"); // selects database
}
?> 