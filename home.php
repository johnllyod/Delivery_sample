<html>
 <head>
  <title>Home MadMeal</title>
  <meta charset="utf-8">
  <link rel="icon" href="img/Logo_Small.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="css/FoodDel.css">
 </head>
 <?php
 session_start();
 include 'config/dbConection.php'; //Connect to Databse
 if(isset($_SESSION['user']))  //checks if user is logged in
 {
 	$user = $_SESSION['user']; //assigns user value
 }
 else
 {
  	header("location:index.php?page=home"); // redirects if user is not logged in
 }
 ?>
 <body>
 <div class='container'>
 	<div class="bg-success text-center" id="warningDiv" style="color:white; display: none;"><h5 id="textWarning">Failed</h5></div>
	<a href="index.php" class="mb-2"><img src="img/Logo.png"></a>
	<div class='mx-auto col-lg-9 col-md-12'>
	<div class='nav'>
	<div class='navBar btn row mx-auto form-inline'>
	<?php 
		if ($_SERVER['REQUEST_METHOD'] = "GET") // check if GET is requested.
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
	  	
		if (isset($user))
		{
			$userAddQ = "SELECT user_address FROM users WHERE username = '".$user."'";
			$userAddRes = mysqli_query($con, $userAddQ);
			while ($row = mysqli_fetch_assoc($userAddRes)) 
			{
				$address = $row['user_address'];
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
		<button name='page' value='Contact'><h3>Contact</h3></button>
		";

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
	</div></div></div><br><br>
		  
			<!-- user details -->
			<?php echo '<div class="row"><div class="col-lg-6 col-md-12"><div class="myAccount rounded"><h2 class="text-center">My Account</h2><div class="row mx-auto"><div class="row mx-auto"><h3 class="mx-auto">Username: '.$user.'</h3><a href="edit.php?id='. $user .'"> edit</a></div></div>
			<div class="row mx-auto"><div class="row mx-auto"><h3 class="mx-auto">Address:</h3><h5>';
			if (isset($address)){ echo $address; }
			echo '</h5><a href="edit.php?id=address"> edit</a></div></div></div>';

		  	// List of past orders.
		  	echo '
		  	<div class="myAccount rounded mt-5"><h4 class="text-center">Order History</h4>';

			$orderHisQ = "SELECT * FROM `orders_list` WHERE username = '".$user."'";
			$orderHisRes = mysqli_query($con, $orderHisQ);
			$numHisRow = mysqli_num_rows($orderHisRes);

			if ($orderHisRes)
			{
				if ($numHisRow > 0)
				{
					echo '<textarea class="txtArea" rows="5" cols="70" readonly>';
					while ($row = mysqli_fetch_assoc($orderHisRes)) // Get all past orders of the user.
					{
						$orderItem = $row['orders'];
						$orderDate = $row['order_date'];
						$orderPrice = $row['amount'];
						$orderPayMet = $row['payment_method'];
						$orderNote = $row['cus_note'];

						if ($orderNote != "") // Checks if a note is blank.
						{
							echo $row['orders'].' | Total Php'.$row['amount'].' | Date ordered: '.$row['order_date'].'Payment method: '.$orderPayMet.'Note: '.$orderNote;
						}
						else 
						{
							echo $row['orders'].' | Total Php'.$row['amount'].' | Date ordered: '.$row['order_date'].' | Payment method: '.$orderPayMet.'&#013';	
						}
					}
					echo '</textarea>';
				}
				else 
				{
					echo '<h5>No order(s) yet.</h5>';
				}
			}
			else 
			{
				echo '<h5>No order(s) yet.</h5>';
			}

		  	echo '</div></div>';

		  	echo '<br><br><div class="col-lg-6 col-md-12 text-center myAccount"><form action="home.php" method="GET"><h4>Cart</h4>';

		  	// Cart list
		  	if (isset($_SESSION['cartItem'][0])) // Checks if cart has an item.
		  	{
		  		for ($i=0; $i < count($_SESSION['cartItem']); $i++) // Dsplay all items on the cart.
		  		{ 
		  			echo '<div class="row"><div class="row mx-auto"><h5>'.$_SESSION['cartItem'][$i].'</h5><h5 class="mr-2 ml-2">x'.$_SESSION['itemQuan'][$i].'</h5><h5>Php'.$_SESSION['itemPrice'][$i].'</h5><button name="remove" class="btn btn-danger ml-lg-2" type="submit" value="'.$i.'">Remove</button></div></div><br>';
		  		}
		  		
		  		echo '</form><h5>Total: Php'.$_SESSION['totalPrice'].'</h5><a href="checkout.php" class="btn ml-lg-2" type="submit" style="background-color: #af6b58;">Checkout</a></div>';
		  	}
		  	else
		  	{
		  		echo '<br><br><div class="col-lg-6 col-md-12 mx-auto"><h4>Cart is empty</h4></div>';
		  	}
		  ?>
		  </div>
			<div class="footer mt-5"><h3>For educational purposes only</h3><?php echo date(' F d, Y'); ?></div>
		  </div>
 </body>
</html>