 <?php
	$servername = "sql6.freesqldatabase.com";
	$username = "sql6586678";
	$password = "y3ndKRqTMs";

	$con = new mysqli($servername, $username, $password);

	if ($con->connect_error) {
	  die("Connection failed: " . $con->connect_error);
	}
	else 
	{
		$db_select = mysqli_select_db($con, "sql6586678");
	}
?> 