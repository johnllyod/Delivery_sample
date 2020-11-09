 <?php
$servername = "db4free.net";
$username = "personalsql2";
$password = "17jtheskull";

$con = new mysqli($servername, $username, $password);

if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
else 
{
	$db_select = mysqli_select_db($con, "deliverydb2");
}
?> 