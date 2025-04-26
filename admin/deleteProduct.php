<?php 
require "includes/connection.php";
require "includes/functions.php";
if (isset($_GET['productID']) && is_numeric($_GET['productID']) && $_GET['productID'] != "") {
	$productID = $_GET['productID'];

	$sql = "SELECT * FROM `tbl_products` WHERE `product_id` = '$productID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
            	$categoryImage = $row['product_image'];

            	$sql2 = "DELETE FROM `tbl_products` WHERE `product_id` = '$productID'";
            	$result2 = mysqli_query($conn,$sql2);
            	if ($result2) {
            		if($categoryImage != "" && file_exists($categoryImage)){
            			unlink($categoryImage);
            		}

            		$_SESSION['successMessage'] = "Product Deleted Successfully.";
            		header("location:viewAllProducts.php");
		            exit();
            	}
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllProducts.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllProducts.php");
        exit();
    }
}else{
	$_SESSION['errorMessage'] = "Access Denied....!";
	header("location:viewAllProducts.php");
	exit();
}

?>