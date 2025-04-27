<?php
require 'includes/connection.php';
require 'includes/functions.php';

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
  $_SESSION['cart'] = array();
}

if (isset($_POST['productID']) && isset($_POST['productName']) && isset($_POST['productPrice']) && isset($_POST['productQty']) ){

  $productID = $_POST['productID'];
  $productName = $_POST['productName'];
  $productPrice = $_POST['productPrice'];
  $productQty = $_POST['productQty'];
  
  if (checkProdInCart($productID) == true) {
    echo "AE";
  }else{
    $b=array("productID"=>$productID,"productName"=>$productName,"productPrice"=>$productPrice,"productQty"=>$productQty);
    array_push($_SESSION['cart'],$b);
    echo "1";
  }
}
?>