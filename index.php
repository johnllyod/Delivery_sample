
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Home MadMeal</title>
</head>
<body>
    <?php
        include 'config/dbConection.php';
        $conn = OpenCon();
        echo "Connected Successfully";
        CloseCon($conn);
    ?>
    <p>Hello world</p>
</body>
</html>