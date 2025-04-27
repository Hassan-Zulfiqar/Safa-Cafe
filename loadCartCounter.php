<?php
session_start(); 
if (isset($_SESSION['cart'])) {
	echo $cartCounter =  count($_SESSION['cart']);
}else if (isset($_SESSION['cd_cart'])) {
	echo $cartCounter =  count($_SESSION['cart']);
}
?>