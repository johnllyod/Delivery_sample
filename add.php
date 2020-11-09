<?php
if($_SERVER['REQUEST_METHOD'] == "POST") //Added an if to keep the page secured
{ 
	if (session_status() == PHP_SESSION_NONE) 
	{
    	session_start();
	}
	if (isset($_SESSION['user']))
	{
		if ($_SESSION['user'] == 'admin')
		{
			echo $_POST['addToList'];
			if (isset($_POST['addToList']))
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
				 foreach($_POST['public'] as $each_check) //gets the data from the checkbox
				 {
					if($each_check !=null )
					{
						$decision = "yes"; //sets the value
					}
				 }
				 foreach($_POST['sale'] as $sale_check)
				 {
					if($sale_check !=null )
					{
						$isSale = "yes";
						$sale_Price = $price-($price * ($_POST['saleprice']/100));
					}
				 }

				 if ($productN != "")
				 {
					mysqli_query($con, "INSERT INTO list (Product_name, details, Price, date_posted, time_posted, Sale_Price, Sale, public, Image_filename) VALUES ('$productN','$details','$price','$date','$time', $sale_Price, '$isSale','$decision','$img_Name')"); //SQL query 	
				 }
				header("location: admin.php");
			}
		}
		else 
		{
			if (isset($_POST['addCart']))
			{
				$_SESSION['cartItem'][] = $_POST['addCart'];
				$_SESSION['itemQuan'][] = $_POST['quantity'];
				$_SESSION['itemPrice'][] = $_POST['price'];
  				$_SESSION['totalPrice'] += $_POST['price'];
			}
		}
	}
	else 
	{
		if (isset($_POST['addCart']))
		{
			header('Location:login.php');
		}
	}
}
?>