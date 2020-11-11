<?php
if($_SERVER['REQUEST_METHOD'] == "POST") //Check if GET Method is requested.
{ 
	if (session_status() == PHP_SESSION_NONE) // Check if session was already started
	{
    	session_start();
	}
	if (isset($_SESSION['user']))
	{
		if ($_SESSION['user'] == 'admin') // User is admin
		{
			if (isset($_POST['addToList'])) // admin adding menu item
			{
				 $productN = ($_POST['productN']);
				 $details = ($_POST['details']);
				 $price = ($_POST['price']);
				 $img_Name = $_POST['image_file'];
				 $time = strftime("%X");//time
				 $date = strftime("%B %d, %Y");//date
				 $decision ="no";
				 $isSale = "no";
				 $sale_Price = 0;
				 $con = mysqli_connect("localhost", "root", "", "deliverydb2") or die(mysqli_error()); //Connect to server
				 foreach($_POST['public'] as $each_check) //gets the data from the checkbox, if its public then it will show up on the product tab of the site.
				 {
					if($each_check != null)
					{
						$decision = "yes";
					}
				 }
				 foreach($_POST['sale'] as $sale_check)
				 {
					if($sale_check != null)
					{
						$isSale = "yes";
						$sale_Price = $price-($price * ($_POST['saleprice']/100));
					}
				 }

				 if ($productN != "")
				 {
					mysqli_query($con, "INSERT INTO list (Product_name, details, Price, date_posted, time_posted, Sale_Price, Sale, public, Image_filename) VALUES ('$productN','$details','$price','$date','$time', $sale_Price, '$isSale','$decision','$img_Name')"); //SQL query 	
				 }
				//header("location: admin.php");
			}
		}
		else 
		{
			if (isset($_POST['addCart'])) // Save item on a session
			{
				$_SESSION['cartItem'][] = $_POST['addCart'];
				$_SESSION['itemQuan'][] = $_POST['quantity'];
				$_SESSION['itemPrice'][] = $_POST['price'];
  				$_SESSION['totalPrice'] += $_POST['price'];

  				echo '<script type="text/javascript">
  					function DisplayNotif()
  					{
  						document.getElementById("warningDiv").style.display = "block";
  						document.getElementById("textWarning").innerHTML = "Item '.$_POST['addCart'].' is added";
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
			}
		}
	}
	else 
	{
		if (isset($_POST['addCart'])) // If not yet login
		{
			header('Location:login.php');
		}
	}
}
?>