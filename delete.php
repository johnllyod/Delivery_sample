<?php
 session_start(); //starts the session
 include 'config/dbConection.php'; //Connect to server //Connect to server
 if($_SESSION['user']){ //checks if user is logged in
    if($_SESSION['user'] != "admin") //checks if admin is logged in
    {
      echo '<script>window.location.href = "index.php?page=home"</script>'; // redirect to the index if the user is not admin
    }
}
else
{
    echo '<script>window.location.href = "index.php"</script>'; // redirects if user is not logged in
}
if($_SERVER['REQUEST_METHOD'] == "GET")
{
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM menu WHERE id='$id'");
    $resetQuery = 'ALTER TABLE menu AUTO_INCREMENT = 0';
    $resetResult = mysqli_query($conn, $resetQuery);
    echo '<script>window.location.href = "home.php"</script>';
}
?>