<?php
 include 'config/dbConection.php'; //Connect to server //Connect to server
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
				 date_default_timezone_set('Asia/Taipei');
				 $productN = ($_POST['productN']);
				 $details = addslashes($_POST['details']);
				 $price = ($_POST['price']);
				 $imgUploadData = $_POST['imageUpload'];
				 $imgLink = $_POST['imgLink'];
				 $time = date('g:ia');//time
				 $date = date('Y-m-d', time());//date
				 $decision ="no";
				 $isSale = "no";
				 $sale_Price = 0;
				 
				 if (isset($_POST['public']))
				 {
					 foreach($_POST['public'] as $each_check) //gets the data from the checkbox, if its public then it will show up on the product tab of the site.
					 {
						if($each_check != null)
						{
							$decision = "yes";
						}
					 }
				 }

				 if (isset($_POST['sale']))
				 {
					 foreach($_POST['sale'] as $sale_check)
					 {
						if($sale_check != null)
						{
							$isSale = "yes";
							$sale_Price = $price-($price * ($_POST['saleprice']/100));
						}
					 }
				 }

				 if ($productN != "")
				 {
					mysqli_query($con, "INSERT INTO menu (product_name, details, price, date_posted, time_posted, sale_price, sale, public, image_upload, image_link) VALUES ('$productN','$details','$price','$date','$time', $sale_Price, '$isSale','$decision','$imgUploadData','$imgLink')"); //SQL query
				 }
				 header("location: admin.php");
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