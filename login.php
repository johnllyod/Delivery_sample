<html>
    <head>
        <title>Home MadMeal</title>
        <meta charset="utf-8">
		<link rel="icon" href="img/Logo_Small.png">
		<meta name="viewport" content="width=device-width, initial-scale=1">
 	 	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
		<link rel="stylesheet" href="FoodDel.css">
    </head>
    <body>
    	<div class="bg-danger text-center" id="warningDiv" style="color:white; display: none;"><h5 id="textWarning">Failed</h5></div>
	<?php
		if (isset($_POST['loginBtn']))
	  	{
	  		include'checklogin.php';
	  	}
	?>
	<center>
		<div class="log mt-lg-5">
	        <h2>Login Page</h2>
	        <a href="index.php?page=Home">Click here to go back</a><br/><br/>
	        <form action="login.php" method="POST">
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
		        <input type="submit" name="loginBtn" value="Login" class="btn" style="background-color: #fdcb9e;" /><br/><br/>
				<a href="index.php?page=register">No Account? Register Here!</a>
	        </form>
    	</div>
    </td>
    </td>
	</center>
    </body>
</html>