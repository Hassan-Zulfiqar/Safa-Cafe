<?php
session_start();
date_default_timezone_set("Asia/Karachi");

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "safa_cafe_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($conn,$dbName);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>