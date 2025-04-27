<?php 
session_start();

unset($_SESSION['customerID']);
unset($_SESSION['customerFullName']);
unset($_SESSION['customerEmail']);
unset($_SESSION['customerType']);
unset($_SESSION['customerImage']);


header("location:login.php");
exit();


?>