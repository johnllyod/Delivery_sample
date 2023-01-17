<html>
	<head>
	  <title>My Food Delivery Store</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
	  <link rel="stylesheet" href="css\FoodDel.css">
	</head>
 <?php
 session_start();
 include 'config/dbConection.php'; //Connect to Databse
 if($_SESSION['user'])  //checks if user is logged in
 {
	if ($_SESSION['user'] != 'admin')
	{
 		$user = $_SESSION['user']; //assigns user value
	}
 }
 else
 {
  	header("location:index.php?page=home"); // redirects if user is not logged in
 }
 $id_exists = false;
 ?>
<body class='container'>
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
	  			$placeOrderQ = "INSERT INTO `orders_list` (User, Orders, OrderDate, Amount, ChangeFor, Payment_Method, Cus_Note) VALUES ('".$user."','".$allOrders."','".date('Y-m-d')."',".$_SESSION['totalPrice'].",".$_POST['change'].",'".$_POST['payment']."','".$_POST['note']."')";
	  			
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
	</div></div></div><br><br>
		
 <?php
 if(!empty($_GET['id']))
{
	if ($_SESSION['user'] == 'admin')
	{
		echo 
		'
		<table border="1px" width="100%">
			<tr>
			<th>Id</th>
			<th>Product name</th>
			<th>Details</th>
			<th>Price</th>
			<th>Public Post</th>    
			<th>Sale</th>
			<th>Sale Price</th>
			<th>Post Time</th>
			<th>Edit Time</th>
			</tr>
		';
		
		 $id = $_GET['id'];
		 $_SESSION['id'] = $id;
		 $id_exists = true;
		 $sql = "Select * from menu Where id='$id'";
		 $query = mysqli_query($con, $sql); // SQL Query
		 $count = mysqli_num_rows($query);
		 if($count > 0)
		{
			 while($row = mysqli_fetch_array($query))
			{
				 Print "<tr>";
				 Print '<td align="center">'. $row['id'] . "</td>";
				 Print '<td align="center">'. $row['product_name'] . "</td>";
				 Print '<td align="center">'. $row['details'] . "</td>";
				 Print '<td align="center">'. $row['price'] . "</td>";
				 Print '<td align="center">'. $row['public']. "</td>";
				 Print '<td align="center">'. $row['sale']. "</td>";
				 Print '<td align="center">'. $row['sale_price']. "</td>";
				 Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
				 Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
				 Print "</tr></table><br/>";
				 
				 if ($row['sale_price'] > 0):
				 $sale_Price = (1-($row['sale_price'] / $price))*100;
				 else:
				 $sale_Price = 0;
				 endif;

				 $product_Name = $row['product_name'];
				 $details = $row['details'];
				 $price = $row['price'];
				 $public = $row['public'];
				 $sale = $row['sale'];
				 $imagelink = $row['image_link'];
			 }
		}
		 else
		{
			$id_exists = false;
		}
	}
	else 
	{
		$id_exists = true;
		echo '<center><form action="edit.php?id='.$_SESSION['user'].'" method="POST">';
		if ($_GET['id'] == $_SESSION['user'])
		{
			echo '<h2 align="center">Update username</h2>Username: <input type="text" name="username" value="'.$_SESSION['user'].'"/>
			<input type="submit" name="update" value="Update user" style="background-color: #fdcb9e; border-color: #fdcb9e;"/>';
		}
		else if ($_GET['id'] == 'address') 
		{
			echo '<h2 align="center">Update address</h2><h5>House Block & Lot/Unit & Floor</h5><input type="text" name="houseNum" maxlength="20" size="20" required/><h5 class="mt-2">Subdivision/Building name</h5><input type="text" name="sub_build" maxlength="20" size="20" required/><h5 class="mt-2">Street</h5><input type="text" name="street" maxlength="20" size="20" required/><h5 class="mt-2">Barangay</h5><input type="text" name="barangay" maxlength="20" size="20" required/><h5 class="mt-2">City</h5><input type="text" name="city" maxlength="20" size="20" required/><br><br><input type="submit" name="update" value="Update address" style="background-color: #fdcb9e; border-color: #fdcb9e;"/>';
		}
		echo '</form></center>';
	}
}

if($id_exists)
{
	if ($_SESSION['user'] == 'admin')
	{
		Print '<form method="POST" enctype="multipart/form-data" action="edit.php">
		Update <b>'.$product_Name.'</b>: <br><br>
		Product name: <input type="text" name="product_Name" value="'.$product_Name.'" required/><br><br>
		Details: <br><textarea type="text" name="details" required>'.$details.'</textarea><br><br>
		Price: <input type="number" name="price" value="'.$price.'" required/><br><br>';
		if ($sale == "yes")
		{
			print 'Sale: <input type="checkbox" name="sale[]" value="'.$sale.'" checked/><br><br>';
		}
		else 
		{
			print 'Sale: <input type="checkbox" name="sale[]" value="'.$sale.'"/><br><br>';
		}
		print'Sale Amount: <input type="number" name="saleprice" value="'.$sale_Price.'" min="0" max="100"/>%<br><br>';
		if($public == "yes") 
		{
			Print 'Public Post? <input type="checkbox" name="public[]" checked/><br><br>';
		}
		else 
		{
			Print 'Public Post? <input type="checkbox" name="public[]"/><br><br>';
		}
		if(empty($imagelink)):
			Print'Use image link <input type="checkbox" name="useimglink[]" id="CBImgLink" value="yes" onclick="UseImgLink()"/><br>
			<span class="" id="UploadImage">Upload image <input type="file" name="imageUpload" id="UploadImageInput" required/></span>
			<span class="d-none" id="LinkImage">Image link: <input type="text" name="imgLink" id="LinkImageInput"/></span><br><br>';
		else:
			Print'Use image link <input type="checkbox" name="useimglink[]" id="CBImgLink" value="yes" onclick="UseImgLink()" checked/><br>
			<span class="d-none" id="UploadImage">Upload image <input type="file" name="imageUpload" id="UploadImageInput"/></span>
			<span class="" id="LinkImage">Image link: <input type="text" name="imgLink" value="'.$imagelink.'" id="LinkImageInput" required/></span><br><br>';
		endif;

		Print'<input type="submit" name="update" value="Update Menu"/></form>
		<a href="admin.php?page=home" class="btn btn-success">Cancel</a>';
	}
}
else
{
	Print '<h2 align="center">There is no data to be edited.</h2>';
	header("location: home.php");
}
 ?>
	</body>
	<script src="js/admin.js"></script>
</html>

<?php
 if(isset($_POST['update']))
 {
	if ($_POST['update'] == "Update Menu")
	{
		$productN = ($_POST['product_Name']);
		$details = addslashes($_POST['details']);
		$pPrice = ($_POST['price']);
		$public = "no";
		$sale = "no";
		$sale_Price = 0;
		$id = $_SESSION['id'];
		$time = date('g:ia');//time
		$date = date('Y-m-d', time());//date
		if (isset($_POST['public']))
		{
			foreach($_POST['public'] as $list)
			{
				if($list != null)
				{
					$public = "yes";
				}
			}
		}

		if (isset($_POST['sale']))
		{
			foreach($_POST['sale'] as $list)
			{
				if($list != null)
				{
					$sale = "yes";
					$sale_Price = $pPrice-($pPrice * ($_POST['saleprice']/100));
				}
			}
		}
		if (isset($_POST['useimglink']))
		{
			$imgData = $_POST['imgLink'];
			$updateCon = "UPDATE menu SET product_name='$productN', details='$details', price=$pPrice, public='$public', date_edited='$date', time_edited='$time', sale_price=$sale_Price, sale='$sale', image_upload=null, image_link='$imgData' WHERE id='$id'";
			mysqli_query($con, $updateCon);
		}
		else 
		{
			$imgUploadData = $_FILES['imageUpload']['tmp_name'];
			$imgUploadData = base64_encode(file_get_contents(addslashes($imgUploadData)));
			$updateCon = "UPDATE menu SET product_name='$productN', details='$details', price=$pPrice, public='$public', date_edited='$date', time_edited='$time', sale_price=$sale_Price, sale='$sale', image_upload='$imgUploadData', image_link=null WHERE id='$id'";
			mysqli_query($con, $updateCon);
		}
		header("location: admin.php?page=home");
	}
	else if ($_POST['update'] == "Update user")
	{
		$newUsername = $_POST['username'];
		mysqli_query($con, "UPDATE users SET username='$newUsername' where username = '".$_SESSION['user']."'");
		$_SESSION['user'] = $newUsername;
		header("location: home.php");
	}
	else if ($_POST['update'] == "Update address")
	{
		mysqli_query($con, "UPDATE users SET user_address='".$_POST['houseNum'].", ".$_POST['sub_build'].", ".$_POST['street']." street, Brgy. ".$_POST['barangay'].", ".$_POST['city']."' where username = '".$_SESSION['user']."'");
		//echo "UPDATE users SET user_address='".$_POST['houseNum'].", ".$_POST['sub_build'].", ".$_POST['street']." street, Brgy. ".$_POST['barangay'].", ".$_POST['city']."' where username = '".$_SESSION['user']."'";
		header("location: home.php");
	}
 }
?>