<?php
 session_start();
 include 'config/dbConection.php';
 $username = $_POST['username'];
 $password = md5($_POST['password']);
 $query = "SELECT * from users WHERE username='$username'";
 $results = mysqli_query($con, $query); 
 if ($results)
 { 
	 $exists = mysqli_num_rows($results); 
	 $table_users = "";
	 $table_password = "";
	 if($results != "")
	 {
		while($row = mysqli_fetch_assoc($results))
		{
			$table_users = $row['username'];
			$table_password = $row['password'];
		}

		if(($username == $table_users))
		{
			if($password == $table_password)
			{

				 $_SESSION['user'] = $username;
				 $_SESSION['totalPrice'] = 0;
				 header("location: home.php");
			}
			else
			{
				echo '<script type="text/javascript">
				function ShowWarning()
				{
					document.getElementById("warningDiv").style.display="block";
					document.getElementById("textWarning").innerHTML = "Incorrect Username or Password!";
				}
				
				function HideWarning()
				{
					setTimeout(
						function()
						{
							document.getElementById("warningDiv").style.display="none";
						}, 5000);
				}
				</script>';
				echo "<script>ShowWarning();</script>";
				echo "<script>HideWarning();</script>";
			}
		}
		else
		{
			echo '<script type="text/javascript">function ShowWarning()
			{
				document.getElementById("warningDiv").style.display="block";
				document.getElementById("textWarning").innerHTML = "Incorrect Username or Password.";
			}

			function HideWarning()
			{
				setTimeout(
					function()
					{
						document.getElementById("warningDiv").style.display="none";
					}, 5000);
			}
			</script>';
			echo "<script>ShowWarning();</script>";
			echo "<script>HideWarning();</script>";
		}
	 }
	 else
	 {
		echo '<script type="text/javascript">function ShowWarning()
		{
			document.getElementById("warningDiv").style.display="block";
			document.getElementById("textWarning").innerHTML = "Incorrect Username!";
		}

		function HideWarning()
		{
			setTimeout(
				function()
				{
					document.getElementById("warningDiv").style.display="none";
				}, 5000);
		}
		</script>';
		echo "<script>ShowWarning();</script>";
		echo "<script>HideWarning();</script>";
	 }
 }
 else
 {
	echo '<script type="text/javascript">function ShowWarning()
	{
		document.getElementById("warningDiv").style.display="block";
		document.getElementById("textWarning").innerHTML = "Incorrect Username!";
	}

	function HideWarning()
	{
		setTimeout(
			function()
			{
				document.getElementById("warningDiv").style.display="none";
			}, 5000);
	}
	</script>';
	echo "<script>ShowWarning();</script>";
	echo "<script>HideWarning();</script>";
 }

?>