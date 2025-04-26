<?php 
session_start();

unset($_SESSION['userID']);
unset($_SESSION['userFullName']);
unset($_SESSION['userEmail']);
unset($_SESSION['userType']);
unset($_SESSION['userImage']);


header("location:login.php");
exit();


?>