<html>
 <head>
  <title>Food delivery</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="css/FoodDel.css">
 </head>
 <?php
 session_start();
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
 <body class='container'>
 	<div class="bg-success text-center" id="warningDiv" style="color:white; display: none;"><h5 id="textWarning">Failed</h5></div>
	<a href="index.php" class="mb-2"><img src="img/Logo.png"></a>
	<div class='mx-auto col-lg-9 col-md-12'>
	<div class='nav'>
	<div class='navBar btn row mx-auto form-inline'>
	<?php 
		if ($_SERVER['REQUEST_METHOD'] == "GET") // check if GET is requested.
	  	{
	  		if (isset($_GET['remove'])) // Remove the selected item in the cart.
	  		{
	  			$_SESSION['totalPrice'] -= $_SESSION['itemPrice'][$_GET['remove']];

				echo '<script type="text/javascript">
  					function DisplayNotif()
  					{
  						document.getElementById("warningDiv").style.display = "block";
  						document.getElementById("textWarning").innerHTML = "Item '.$_SESSION['cartItem'][$_GET['remove']].' is remove";
  					}

  					function RemoveNotif()
  					{
  						setTimeout(
  							function()
  							{
  								document.getElementById("warningDiv").style.display = "none";
  							}, 5000);
  					}
  				</script>
  				<script>DisplayNotif();</script>
  				<script>RemoveNotif();</script>';

	  			array_splice($_SESSION['cartItem'], $_GET['remove'], 1);
	  			array_splice($_SESSION['itemQuan'], $_GET['remove'], 1);
	  			array_splice($_SESSION['itemPrice'], $_GET['remove'], 1);
	  		}
	  	}
	  	else if ($_SERVER['REQUEST_METHOD'] == "POST")
	  	{
	  		if (isset($_POST['placeOrder']))
	  		{
	  			$allOrders = "";
  				for ($i=0; $i < count($_SESSION['cartItem']); $i++) 
  				{ 
	  				$allOrders .= $_SESSION['cartItem'][$i]." x".$_SESSION['itemQuan'][$i]." Php".$_SESSION['itemPrice'][$i].". ";
  				}
	  			$placeOrderQ = "INSERT INTO `orders-list` (user, orders, order_date, amount, change_for, payment_method, cus_note) VALUES ('".$user."','".$allOrders."','".date('Y-m-d')."',".$_SESSION['totalPrice'].",".$_POST['change'].",'".$_POST['payment']."','".$_POST['note']."')";
	  			
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
			$userAddQ = "SELECT address FROM users WHERE username = '".$user."'";
			$userAddRes = mysqli_query($con, $userAddQ);
			while ($row = mysqli_fetch_assoc($userAddRes)) 
			{
				$address = $row['address'];
			}

			if ($_SESSION['user'] == 'admin')
			{
        		header("Location:admin.php?page=home"); // If admin is login redirect to the admin page. 
			}
			else 
			{
		 		echo "<form action='index.php' method='GET'><button name='page' value='home'><h3>".$user."</h3></button>";
			}
		}
		else 
		{
        	header("Location:index.php?page=home"); // Redirect to index if no user is login.
		}

		echo "<button name='page' value='Product'><h3>Products</h3></button>
		<button name='page' value='Promo'><h3>Promo</h3></button>
		<button name='page' value='About'><h3>About</h3></button>
		<button name='page' value='Contact'><h3>Contact</h3></button>";

		if (isset($user))
		{
			echo"<button name='page' value='cart'><h3>Cart</h3></button>
			<button name='page' value='logout'><h3>Logout</h3></button>";
		}
		else 
		{
			echo"<button name='page' value='login'><h3>Login</h3></button>
			<button name='page' value='register'><h3>Register</h3></button>";
		}
		?>
		</form>
	</div></div></div>
		  <?php
		  	if (isset($_SESSION['cartItem'][0]))
		  	{
		  		echo '<br><br><div class="col-lg-6 col-md-12 text-center mx-auto"><form action="checkout.php" method="GET"><h3>CART</h3>';
		  		for ($i=0; $i < count($_SESSION['cartItem']); $i++) 
		  		{ 
		  			echo '<div class="row"><div class="row mx-auto"><h5>'.$_SESSION['cartItem'][$i].'</h5><h5 class="mr-2 ml-2">x'.$_SESSION['itemQuan'][$i].'</h5><h5>Php'.$_SESSION['itemPrice'][$i].'</h5><button name="remove" class="btn btn-danger ml-lg-2" type="submit" value="'.$i.'">Remove</button></form></div></div><br>';
		  		}
		  		
		  		if (empty($address))
		  		{
		  			echo '<a href="edit.php?id=address">You do not have an address yet.</a>';
		  		}
		  		else 
		  		{
		  			echo '<div class="row"><h5>'.$address.'</h5><a href="edit.php?id=address"> edit</a></div>';
		  		}

		  		echo '<h5>Php '.$_SESSION['totalPrice'].'</h5>
		  			<form action="checkout.php" method="POST">
		  			<input type="radio" id="COD" name="payment" value="COD" onclick="ChangePayment()" checked="checked"/>
		  			<label for="COD">COD</label>

		  			<input type="radio" id="Card" name="payment" value="Card" onclick="ChangePayment()"/>
		  			<label for="Card">Card</label>

		  			<div id="codForm" style="display: block;">

		  			<label for="changeFor" id="changeForLabel">Change for</label>
					<input type="number" class="mx-auto mb-3" name="change" id="changeFor" min="'.$_SESSION['totalPrice'].'" value="'.$_SESSION['totalPrice'].'" style="display: block;" required/>

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
					<input type="number" min="100" max="999" name="cardnum" id="secCode"/></div><br>';

		  		if (!empty($address))
		  		{
		  			echo '<button name="placeOrder" class="btn ml-lg-2" type="submit" value="checkout" style="background-color: #fdcb9e;">Place Order</button></form></div>';
		  		}
		  	}
		  	else
		  	{
		  		echo '<br><br><div class="col-lg-6 col-md-12 text-center mx-auto"><h4>Cart is empty</h4></div>';
		  	}
		  ?>
  <script>
   function ChangePayment()
   {
   		var codRad = document.getElementById("COD");
   		if (codRad.checked)
   		{
   			document.getElementById("cardForm").style.display="none";
   			document.getElementById("changeFor").style.display="block";
   			document.getElementById("changeForLabel").style.display="block";
   			document.getElementById("cardName").required= true;
   			document.getElementById("cardNum").required= true;
   			document.getElementById("expDate").required= true;
   			document.getElementById("secCode").required= true;
   		}
   		else 
   		{
   			document.getElementById("cardForm").style.display="block";
   			document.getElementById("changeFor").style.display="none";
   			document.getElementById("changeForLabel").style.display="none";
   			document.getElementById("cardName").required= false;
   			document.getElementById("cardNum").required= false;
   			document.getElementById("expDate").required= false;
   			document.getElementById("secCode").required= false;
   		}
   }
  </script>
 </body>
</html>