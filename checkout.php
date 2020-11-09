<html>
 <head>
  <title>Food delivery</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="FoodDel.css">
 </head>
 <?php
 include 'config/dbConection.php'; //Connect to Databse
 if($_SESSION['user'])  //checks if user is logged in
 {
 	$user = $_SESSION['user']; //assigns user value
 }
 else
 {
  	header("location:index.php?page=home"); // redirects if user is not logged in
 }
 ?>
 <body class="bg-dark">
 <div class='container'>
	<h2 class="text-light">Delivery</h2>
	<div class='mx-auto col-lg-9 col-md-12'>
	<div class='nav'>
	<?php 
		if ($_SERVER['REQUEST_METHOD'] === "GET")
	  	{
	  		if (isset($_GET['remove']))
	  		{
	  			array_splice($_SESSION['cartItem'], $_GET['remove'], 1);
	  			array_splice($_SESSION['itemQuan'], $_GET['remove'], 1);
	  			array_splice($_SESSION['itemPrice'], $_GET['remove'], 1);
	  		}
	  	}
	  	else if ($_SERVER['REQUEST_METHOD'] === "POST")
	  	{
	  		if (isset($_POST['placeOrder']))
	  		{
	  			$allOrders = "";
  				for ($i=0; $i < count($_SESSION['cartItem']); $i++) 
  				{ 
	  				$allOrders .= $_SESSION['cartItem'][$i]." x".$_SESSION['itemQuan'][$i]." Php".$_SESSION['itemPrice'][$i].". ";
  				}
	  			$placeOrderQ = "INSERT INTO `orders-list` (User, Orders, OrderDate, Amount, ChangeFor, Payment_Method, Cus_Note) VALUES ('".$user."','".$allOrders."','".date('Y-m-d')."',".$_SESSION['totalPrice'].",".$_POST['change'].",'".$_POST['payment']."','".$_POST['note']."')";
	  			
	  			$placeOrderR = mysqli_query($con, $placeOrderQ);
	  			if ($placeOrderR)
	  			{
	  				unset($_SESSION['cartItem']);
	  				unset($_SESSION['itemQuan']);
	  				unset($_SESSION['itemPrice']);
	  				header('Location: checkout.php');
	  			}
	  		}
	  	}
	  	
		if (isset($user))
		{
			if ($_SESSION['user'] == 'admin')
			{
		 		echo "<form action='admin.php' method='GET'><button name='page' value='home'><h3>".$user."</h3></button>";
			}
			else {
		 		echo "<form action='index.php' method='GET'><button name='page' value='home'><h3>".$user."</h3></button>";
			}
		}
		else {
			echo "<form action='index.php' method='GET'><button name='page' value='Home'><h3>Home</h3></button>";
		}
		echo "<button name='page' value='Products'><h3>Products</h3></button>
		<button name='page' value='Promo'><h3>Promo</h3></button>
		<button name='page' value='About'><h3>About</h3></button>
		<button name='page' value='Contact'><h3>Contact</h3></button>
		";
		if (isset($user)){
			echo"<button name='page' value='logout'><h3>Logout</h3></button>";
		}
		else {
			echo"<button name='page' value='login'><h3>Login</h3></button>
			<button name='page' value='register'><h3>Register</h3></button>";
		}
		?>
		</form>
	</div></div><br><br>
		  <h2 align="center" class="text-light">My Account</h2>
		  <?php

		  	if (isset($_SESSION['cartItem'][0]))
		  	{
		  		echo '<br><br><div class="col-lg-6 col-md-12 text-light text-center mx-auto"><form action="checkout.php" method="GET"><h4>Cart</h4>';
		  		for ($i=0; $i < count($_SESSION['cartItem']); $i++) 
		  		{ 
		  			echo '<div class="row"><div class="row mx-auto"><h5>'.$_SESSION['cartItem'][$i].'</h5><h5 class="mr-2 ml-2">x'.$_SESSION['itemQuan'][$i].'</h5><h5>Php'.$_SESSION['itemPrice'][$i].'</h5><button name="remove" class="btn btn-danger ml-lg-2" type="submit" value="'.$i.'">Remove</button></form></div></div><br>';
		  		}
		  		
		  		echo '<h5>'.$_SESSION['totalPrice'].'</h5>
		  			<form action="checkout.php" method="POST">
		  			<input type="radio" id="COD" name="payment" value="COD" onclick="ChangePayment()" checked="checked"/>
		  			<label for="COD">COD</label>

		  			<input type="radio" id="Card" name="payment" value="Card" onclick="ChangePayment()"/>
		  			<label for="Card">Card</label>

		  			<div id="codForm" style="display: block;">

		  			<label for="changeFor">Change for</label><br>
					<input type="number" name="change" id="changeFor" min="'.$_SESSION['totalPrice'].'" value="'.$_SESSION['totalPrice'].'" required/><br>

		  			<label for="note">Note (optional)</label><br>
		  			<textarea name="note" id="note" rows="5" maxlength="140"/></textarea><br></div><br>

		  			<div id="cardForm" style="display: none;">

		  			<label for="cardName">Card holder name</label><br>
					<input type="text" name="cardname" id="cardName"/><br>

		  			<label for="cardNum">Card Number</label><br>
		  			<input type="text" name="cardnum" id="cardNum"/><br>

		  			<label for="expDate">Expiry Date</label><br>
		  			<input type="date" name="expdate" id="expDate"/><br>

		  			<label for="secCode">Security Code</label><br>
					<input type="number" min="100" max="999" name="cardnum" id="secCode"/></div><br>

		  			<button name="placeOrder" class="btn ml-lg-2" type="submit" value="checkout" style="background-color: #fdcb9e;">Place Order</button></form></div>';
		  	}
		  	else
		  	{
		  		echo '<br><br><div class="col-lg-6 col-md-12 text-light text-center mx-auto"><h4>Cart is empty</h4></div>';
		  	}
		  ?>
  <script>
   function ChangePayment()
   {
   		var codRad = document.getElementById("COD");
   		if (codRad.checked)
   		{
   			document.getElementById("cardForm").style.display="none";
   			document.getElementById("cardName").required= true;
   			document.getElementById("cardNum").required= true;
   			document.getElementById("expDate").required= true;
   			document.getElementById("secCode").required= true;
   		}
   		else 
   		{
   			document.getElementById("cardForm").style.display="block";
   			document.getElementById("cardName").required= false;
   			document.getElementById("cardNum").required= false;
   			document.getElementById("expDate").required= false;
   			document.getElementById("secCode").required= false;
   		}
   }
  </script>
 </body>
</html>