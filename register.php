<html>
    <head>
        <title>Home MadMeal</title>        
        <meta charset="utf-8">
		<link rel="icon" href="img/Logo_Small.png">
		<meta name="viewport" content="width=device-width, initial-scale=1">
 	 	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
		<link rel="stylesheet" href="css\FoodDel.css">
    </head>
    <body>
	<center>
		<div class="log mt-lg-5">
	        <h2>Registration Page</h2>
	        <a href="index.php?page=Home">Click here to go back</a><br/><br/>
	        <form action="register.php" method="POST">
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
	        <input type="submit" value="Register" class="btn" style="background-color: #fdcb9e;"/><br/><br/>
			<a href="index.php?page=login">Have an Account? Login Here!</a>
		</div>
	</center>
    </body>
</html>

<?php
 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
 	include 'config/dbConection.php';
	$username = ($_POST['username']);
	$password = md5($_POST['password']);
	$bool = true;
	$query = "SELECT * from users";
	$results = mysqli_query($con, $query); //Query the users table
	while($row = mysqli_fetch_array($results)) //display all rows from query
	{
		$table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
		if($username == $table_users) // checks if there are any matching fields
		{
			$bool = false; // sets bool to false which means a username is already exist
			Print '<script>alert("Username has been taken!");</script>'; //Prompts the user
			Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
		}
	}
	if($bool) // checks if bool is true
	{
		mysqli_query($con, "INSERT INTO users (username, password) VALUES ('$username','$password')"); //Inserts the value to table users
		Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
		Print '<script>window.location.assign("login.php");</script>'; // redirects to register.php
	}
 }
?>