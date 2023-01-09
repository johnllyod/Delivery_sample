<html>
 <head>
  <title>Home MadMeal</title>
  <!--CSS-->
  <meta charset="utf-8">
  <link rel="icon" href="img/Logo_Small.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css\FoodDel.css">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist\css\bootstrap.min.css">
 </head>
 <?php
 session_start(); //starts the session
 include 'config/dbConection.php'; //Connect to server //Connect to server
if (isset($_SESSION['user']))
{
    if($_SESSION['user'] != "admin") //checks if admin is logged in
    {
      header("location:index.php?page=home"); // redirect to the index if the user is not admin
    }
    else 
    {
      $user = $_SESSION['user']; //assigns admin
    }
} 
else 
{
  header("location: login_admin.php"); // redirect to the admin login page if admin is not login
}

if (isset($_GET['page'])) // check if page has a value
{
  if ($_GET['page'] == "logout") // logging out
  { 
    session_destroy(); // removes all session
    header("location: login_admin.php"); // redirect to the login page
  }
  else if ($_GET['page'] == "Product")
  { 
    header("location: index.php?page=Product"); // change the page to the product page
  }
}
 ?>
 <body class="bg-dark container text-light">
  <a href="admin.php?page=home" class="mb-2"><img src="img/Logo.png"></a>
    <div class=' row mx-auto col-lg-9 col-md-12'>
      <div class='nav mx-auto'>
    		<form action='admin.php' method='GET'> <!--navigation bar-->
          <button name='page' value='home'><h3>Menu</h3></button><button name='page' value='orders' type='submit'><h3>Orders</h3></button>
          <button name='page' value='Product' type='submit'><h3>Check Site</h3></button>
          <button name='page' value='logout' type='submit'><h3>Logout</h3></button>
    		</form>
    	</div>
    </div>
  <br><br>
  <h3>ADMIN</h3>
    <?php 
    if (isset($_GET['page']))
    {
      if ($_GET['page'] != 'orders') // if page is not equal to orders.
      {
        // Form for adding an item to the menu list.
        echo '<form action="add.php" method="POST">
        <div class="container">
            Add more to menu: <br><br>
            <div class="row">
                <div class="col-md-6">
                    Product name: <input type="text" name="productN" required/><br>
                    Details: <br><textarea id="detail" name="details" rows="5" cols="32" maxlength="500" required></textarea><br><br></div>';

                echo '<div class="col-md-6">
                    Price: <input type="number" name="price" required/><br>
                    On Sale? <input type="checkbox" name="sale[]" id="Sale" onclick="OnSale()" value="yes"/><br>
                    <span class="d-none" id="SalePrice">Sale Percent: <input type="number" name="saleprice" id="SaleInput" min="0" max="100"/>%<br></span>
                    Public Post? <input type="checkbox" name="public[]" value="yes"/><br>
                    Use image link <input type="checkbox" name="useimglink[]" id="CBImgLink" value="yes" onclick="UseImgLink()"/><br>
                    <span class="" id="UploadImage">Upload image <input type="file" name="imageUpload" id="UploadImageInput" required/></span>
                    <span class="d-none" id="LinkImage">Image link: <input type="text" name="imgLink" id="LinkImageInput"/></span><br><br>
                    <input type="submit" name="addToList" value="Add to menu"/></div>
            </div>
        </div>
        </form>';

        // Table that shows all the items in the menu, you can also edit and delete items here. 
        echo '<h2 align="center">Menu list</h2>
        <table border="1px" width="100%" class="text-light">
         <tr class="text-center">
          <th>Id</th>
          <th>Product name</th>
          <th>Details</th>
          <th>Price</th>
          <th>Sale</th>
          <th>Sale Price</th>
          <th>Public Post</th>
          <th>Post Time</th>
          <th>Edit Time</th>
          <th>Edit</th>
          <th>Delete</th>
         </tr>';

          $query = mysqli_query($con, "Select * from menu"); // SQL Query

          while($row = mysqli_fetch_array($query))
          {
            Print "<tr>";
            Print '<td align="center">'. $row['id'] . '</td>';
      	    Print '<td align="center">'. $row['product_name'] . "</td>";
            Print '<td align="center">'. $row['details'] . "</td>";
      	    Print '<td align="center">'. $row['price'] . "</td>";
            Print '<td align="center">'. $row['sale']. "</td>";
            Print '<td align="center">'. $row['sale_price']. "</td>";
            Print '<td align="center">'. $row['public']. "</td>";
            Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
            Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
            Print '<td align="center"><a href="edit.php?id='. $row['id'] .'">edit</a> </td>';
            Print '<td align="center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a> </td>';
            Print "</tr>";
          }
        echo '</table>';
      }
      else // if page is equal to orders
      {
        // this is a list of all orders
        echo '
        <h2 align="center">Order list</h2>
        <form action="admin.php?page=orders" method="POST">
          <div class="row form-inline">
            <label for="sort">Sort By</label>
            <Select id="sort" name="sort" onchange="ChangeSort()">
              <option value="OrderDate">Date</option>
              <option value="User">User</option>
              <option value="Payment_Method">Payment Method</option>
            </Select>

            <Select id="sortD" name="byOrderDate" style="display:block;">
              <option value="'.date('Y-m-d').'">Today</option>
              <option value="week">This week</option>
              <option value="'.date("Y-m").'">This month</option>
              <option value="'.date("Y").'">This year</option>
            </Select>

            <Select id="sortU" name="byUser" style="display:none;">
              <option value="ASC">Ascending</option>
              <option value="DESC ">Descending</option>
            </Select>

            <Select id="sortP" name="byPayment_Method" style="display:none;">
              <option value="COD">COD</option>
              <option value="Card">Card</option>
            </Select>
          <button type="submit" name="sortBy" value="SortBy" style="background-color:#fdcb9e; border: none;">Apply</button> 
          <a href="admin.php?page=orders" class="text-dark ml-2" style="background-color:#fdcb9e; text-decoration: none;">View all</a>
          </div>
        </form>
        <table border="1px" width="100%" class="text-light">
         <tr class="text-center">
          <th class="text-center">User</th>
          <th>Orders</th>
          <th>Order Date</th>
          <th>Total</th>
          <th>Payment Method</th>
          <th>Note</th>
         </tr>';

          if (isset($_POST['sortBy'])) // Checks if filter is used.
          {
            if ($_POST['sort'] == "OrderDate") // chacks if filter used is by Date
            {
              if ($_POST['byOrderDate'] == date('Y-m-d')) // Sort orders that are made only for today
              {
                echo $_POST['sort'].", "."Today";
                $sqlStr = "SELECT * FROM `orders-list` where ".$_POST['sort']."='".date('Y-m-d')."'";
              }
              else if ($_POST['byOrderDate'] == "week") // Sort orders that are made only for the whole week
              {
                echo $_POST['sort'].", "."This Week";
                $sqlStr = "SELECT * from `orders-list` WHERE OrderDate >= DATE_ADD(NOW(), INTERVAL -7 DAY) and OrderDate <= NOW()";
              }
              else
              {
                if ($_POST['byOrderDate'] == date("Y-m")) // Sort orders that are made only for the whole month
                {
                  echo $_POST['sort'].", This month";
                }
                else // Sort orders that are made only for the whole Year
                {
                  echo $_POST['sort'].", This year";
                }
                $sqlStr = "SELECT * from `orders-list` WHERE OrderDate LIKE '%".$_POST['byOrderDate']."%'";
              }
            }
            else if ($_POST['sort'] == "User") // Sort orders by who order the item(s).
            {
                $sqlStr = "SELECT * from `orders-list` order by User ".$_POST['byUser'].""; // the value of $_POST['byUser'] is either ASC or DESC
            }
            else if ($_POST['sort'] == "Payment_Method")
            {
                $sqlStr = "SELECT * from `orders-list` WHERE Payment_Method = '".$_POST['byPayment_Method']."'"; // the value of $_POST['byPayment_Method'] is either COD or Card
            }
            $query = mysqli_query($con, $sqlStr); // SQL Query
          }
          else 
          {
            $query = mysqli_query($con, "SELECT * FROM `orders-list`"); // SQL Query if there is no filter.
          }

          while($row = mysqli_fetch_array($query)) // get all data available depending on the condition above.
          {
            Print "<tr>";
            Print '<td align="center">'. $row['user'] . '</td>';
            Print '<td align="center">'. $row['orders'] . "</td>";
            Print '<td align="center">'. $row['order_date'] . "</td>";
            Print '<td align="center">'. $row['amount'] . "</td>";
            Print '<td align="center">'. $row['payment_method']. "</td>";
            Print '<td align="center">'. $row['cus_note']. "</td>";
            Print "</tr>";
          }
        echo '</table>';
      }
    }
    else 
    {
      header("Location:admin.php?page=home"); // page is null
    }
    ?>

  <script src="js/admin.js"></script>
 </body>
</html>