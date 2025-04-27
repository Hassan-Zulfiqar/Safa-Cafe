<?php
include ("includes/connection.php");
 include ("includes/functions.php"); 

if (isset($_POST['productID']) && isset($_POST['indexNO']) && isset($_POST['productQty'])) {
	$productID = $_POST['productID'];
	$indexNO = $_POST['indexNO'];
	$productQty = $_POST['productQty'];
	$prodPrice = getProdPrice($productID);
	$pridDiscountPrice = cal_prod_discount($productID);
	$discountedPrice = $prodPrice - $pridDiscountPrice;
	$newProdPrice = $discountedPrice * $productQty;

	$_SESSION['cart'][$indexNO]['productQty'] = $productQty;
	echo "1";

	
}
?>