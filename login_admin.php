<html>
    <head>
        <title>Food delivery</title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
 	 	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
		<link rel="stylesheet" href="FoodDel.css">
    </head>
    <body class="bg-dark">
    	<div class="bg-danger text-center" id="warningDiv" style="display: none;"><h5 id="textWarning">Failed</h5></div>
	<?php
		if (isset($_POST['loginadminBtn'])) 
	  	{
	  		if ($_POST['username'] == "admin")
	  		{
		  		if ($_POST['password'] == "admin")
		  		{
		  			session_start();
		  			$_SESSION['user'] = "admin";
		  			header("Location: admin.php?page=home");
		  		}
	  		}
	  	}
	?>
	<center>
		<div class="log mt-lg-5">
	        <h2>Admin Page</h2>
	        <form action="login_admin.php" method="POST">
		        <table>
					<tr>
						<td><h5>Enter Username:</h5>
						<td><input type="text" name="username" required="required" />
					<tr>
					</tr>
						<td><h5>Enter Password:</h5>
						<td><input type="password" name="password" required="required" />
					</tr>
				</table><br>
		        <input type="submit" name="loginadminBtn" value="Login" class="btn" style="background-color: #fdcb9e;" /><br/><br/>
	        </form>
    	</div>
    </td>
    </td>
	</center>
    </body>
</html>