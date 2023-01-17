<html>
<head>
<meta charset="uft-8">
<title>Home MadMeal</title>
<!--CSS-->
<meta charset="utf-8">
<link rel="icon" href="img/Logo_Small.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
<link rel="stylesheet" href="css\FoodDel.css">
</head>

<body class="container">
<div class="bg-success text-center" id="warningDiv" style="color:white; display: none;"><h5 id="textWarning">Failed</h5></div>
<a href="index.php" class="mb-2"><img src="img/Logo.png"></a>
<?php
session_start();
include 'config/dbConection.php';
$query = mysqli_query($con, "Select * from menu");

if(isset($_SESSION['user']))  //checks if user is logged in
{
 	$user = $_SESSION['user']; //assigns user value
}
	echo "<div class='mx-auto col-lg-9 col-md-12'>
	<div class='nav'>
	<div class='navBar btn row mx-auto form-inline'>";
	if (isset($user)) // Checks if user is login
	{
		$userAddQ = "SELECT user_address FROM users WHERE username = '".$user."'";
		$userAddRes = mysqli_query($con, $userAddQ);
		while ($row = mysqli_fetch_assoc($userAddRes)) 
		{
			$address = $row['user_address'];
		}

		if ($_SESSION['user'] != 'admin')
		{
			echo "<form action='index.php' method='GET'><button name='page' value='home'><h3>".$user."</h3></button>";
		}
		else 
		{
			echo "<form action='admin.php' method='GET'><button name='page' value='home'><h3>".$user."</h3></button></form><form action='index.php' method='GET'>";
		}
	}
	else 
	{
		echo "<form action='index.php' method='GET'><button name='page' value='Home'><h3>Home</h3></button>";
	}
	echo "
	<button name='page' value='Product'><h3>Products</h3></button>
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
	echo '
		</form>
		</div>
		</div>
		</div>';
if (isset($_GET['page']))
{
	switch ($_GET['page']) // Checks what page to display
	{
		case'Product': // Display all product available.
			include 'add.php';
			echo
				"<br><br><div class='row'>";
			while($row = mysqli_fetch_array($query))
			{
				if ($row['public'] == "yes") // If a product is set as public then it will be displayed.
				{
					echo "
					<div class='items col-lg-3 col-md-6 m-auto'>
						<button class='btn' onclick='DisplayDesc(this)' name='Product' value='".$row['product_name']."' data-toggle='modal' data-target='#food_Desc'>";
					
						if ($row['image_upload'])
						{
							echo '<img src="data:image;base64,'.$row['image_upload'].'" class="col-10"></img>';
						}
						else 
						{
							echo "<img src='".$row['image_link']."' class='col-10'></img>";
						}

						echo "</button><h3>".$row['product_name']."</h3>";
					if ($row['sale'] == "no") // item is not on sale.
					{
						echo "<div class='row'><div class='row mx-auto'><h3>Php</h3><h3 id='price".$row['product_name']."'>".$row['price']."</h3></div></div>";
					}
					else 
					{
						echo "<div class='row'><div class='row mx-auto'><h5 style='text-decoration: line-through;'>Php".$row['price']."</h5><h3>Php</h3><h3 id='price".$row['product_name']."'>".$row['sale_price']."</h3></div></div>";
					}
					echo"<p id='foodDes".$row['product_name']."' hidden>".$row['details']."</p></div>";
				}
			}
			echo "</div>";
		break;
		case'Promo': // This page shows all item on sale.
			include 'add.php';
			echo
				"<br><br><div class='row'>";
			while($row = mysqli_fetch_array($query))
			{
				if ($row['sale'] == "yes")
				{
					if ($row['image_upload'])
					{
						$imageData = $row['image_upload'];
					}
					else 
					{
						$imageData = $row['image_link'];
					}

					echo "
					<div class='items col-lg-3 col-md-6 mb-5'><button class='btn' onclick='DisplayDesc(this)' name='Product' value='".$row['product_name']."' data-toggle='modal' data-target='#food_Desc'><img src='".$imageData."' class='col-10'></img>
					</button><h3>".$row['product_name']."</h3><div class='row'><div class='row mx-auto'><h5 style='text-decoration: line-through;'>Php".$row['price']."</h5><h3>Php</h3><h3 id='price".$row['product_name']."'>".$row['sale_price']."</h3></div></div>
					<p id='foodDes".$row['product_name']."' hidden>".$row['details']."</p></div>";
				}
			}
			echo "</div>";
		break;
		case'About': // Display information about Home MadMeal.
		echo
		"
			<div class='about'>
				<h3>Delivery hours </h3><h5>Mon - Sun 9:00 AM - 10:00 PM</h5>
			</div>
		";
		break;
		case'Contact': // Display contact page.
		echo 
		"
		<div class='contacts'>
			<h2>Call</h2>
			<h4>+63288353819</h4>
			<h3>Address</h3><h5>G/F Royal Palm Tower, Federal Bay Garden Club & Residences, Brgy. 76, Macapagal, Pasay, 1308 Metro Manila</h5><iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51958.44340259081!2d121.00078243597099!3d14.528474050310276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x64324804d3f0d1da!2sRobinsons%20Supermarket!5e0!3m2!1sen!2sph!4v1603033961624!5m2!1sen!2sph' width='600' height='450' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'></iframe>
		</div>
		";
		break;
		case 'login': // Redirect to the login page.
			header("Location: login.php");
		break;

		case 'cart': // Redirect to the checkout page.
			header("Location: checkout.php");
		break;

		case 'register': // Redirect to the register page.
			header("Location: register.php");
		break;
		
		case 'logout':
			header("Location: logout.php");
		break;
		
		case 'home': // Redirect to the home page.
			header("Location: home.php");
		break;
		
		default: // Display the main page.
		echo 
		"<br><div id='carouselSlide' class='carousel slide mb-5' data-ride='carousel'>
			<div class='carousel-inner'>
				<div class='carousel-item active'>
					<a href='index.php?page=Promo'><img class='d-block w-100' src='img/Promo1.png' alt='first img'></a>
				</div>
				<div class='carousel-item'>
					<a href='index.php?page=Promo'><img class='d-block w-100' src='img/Promo2.png' alt='first img'></a>
				</div>
			</div>
			<a class='carousel-control-prev' href='#carouselSlide' role='button' data-slide='prev'>
				<span class='carousel-control-prev-icon' aria-hidden='true'></span>
				<span class='sr-only'>Previous</span>
			</a>
			<a class='carousel-control-next' href='#carouselSlide' role='button' data-slide='next'>
				<span class='carousel-control-next-icon' aria-hidden='true'></span>
				<span class='sr-only'>Next</span>
			</a>
		</div>";
		break;
	}
}
else 
{
		echo 
		"<br><div id='carouselSlide' class='carousel slide mb-5' data-ride='carousel'>
			<div class='carousel-inner'>
				<div class='carousel-item active'>
					<a href='index.php?page=Promo'><img class='d-block w-100' src='img/Promo1.png' alt='first img'></a>
				</div>
				<div class='carousel-item'>
					<a href='index.php?page=Promo'><img class='d-block w-100' src='img/Promo2.png' alt='first img'></a>
				</div>
			</div>
			<a class='carousel-control-prev' href='#carouselSlide' role='button' data-slide='prev'>
				<span class='carousel-control-prev-icon' aria-hidden='true'></span>
				<span class='sr-only'>Previous</span>
			</a>
			<a class='carousel-control-next' href='#carouselSlide' role='button' data-slide='next'>
				<span class='carousel-control-next-icon' aria-hidden='true'></span>
				<span class='sr-only'>Next</span>
			</a>
		</div>";
}
?>

<!--MODAL for adding items to the cart-->
<div class="modal fade" id="food_Desc" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="ModalLabel">Title</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
			</div>
			<div class="modal-body">
				<h4 id="food Descript"></h4>
			</div>
			<div class="modal-footer">
				<form action="index.php?page=<?php echo $_GET['page'] ?>" method="POST">
					<div class="row"><h5>Php<input type="text" name="price" id="foodPrice" style="width: 100px; border: none; color: #af6b58;" readonly></h5></input>
					<input type="number" name="quantity" id="foodQuan" min="1" max="10" value="1" style="border-color: #fdcb9e; width: 45px;" onchange="PriceChange()">Quantity</input>
        			<button type="submit" name="addCart" class="btn mr-2 ml-2" id="addtocart" style="background-color: #af6b58; color: #f2efea;">Add to Cart</button>
				</form>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
			</div>
		</div>
	</div>
</div>

<div class="footer"><h3>For educational purposes only</h3><?php echo date(' F d, Y'); ?></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript">
	function DisplayDesc(msg) // Change modal info according to the item that the user click.
	{
		var str1 = "foodDes";
		var str2 = msg.value;
		var strP1 = "price";
		var strP2 = msg.value;
		var finalDesId = str1.concat(str2);
		var finalPrcId = strP1.concat(strP2);
		var des = document.getElementById(finalDesId).innerHTML;
		document.getElementById("ModalLabel").innerHTML = msg.value;
		document.getElementById("food Descript").innerHTML = des;
		document.getElementById("addtocart").value = msg.value;
		document.getElementById("foodPrice").value = document.getElementById(finalPrcId).innerHTML;
	}

	function PriceChange() // Change the price according to the quantity
	{
		var str1 = "price";
		var str2 = document.getElementById("ModalLabel").innerHTML;
		var finalPrcId = str1.concat(str2);
		var total = document.getElementById(finalPrcId).innerHTML * document.getElementById("foodQuan").value;
		document.getElementById("foodPrice").value = total;
	}
</script>
</body>
</html>