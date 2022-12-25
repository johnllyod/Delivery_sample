<?php

function OpenCon()
 {
 $dbhost = "containers-us-west-58.railway.app";
 $dbuser = "root";
 $dbpass = "jCTG3kIHO7Uc11FroTGW";
 $db = "railway";

 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>