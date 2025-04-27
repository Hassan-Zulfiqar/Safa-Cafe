<?php 
session_start(); 
if (isset($_POST['prod_id']) && isset($_POST['indexNO'])) {
	$prod_id = $_POST['prod_id'];
	$indexNO = $_POST['indexNO'];
	unset($_SESSION['cart'][$indexNO]);
	$_SESSION['cart'] = array_values($_SESSION['cart']);
}
?>