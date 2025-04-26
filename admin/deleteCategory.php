<?php 
require "includes/connection.php";
require "includes/functions.php";
if (isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) && $_GET['categoryID'] != "") {
	$categoryID = $_GET['categoryID'];

	$sql = "SELECT * FROM `tbl_categories` WHERE `category_id` = '$categoryID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
            	$categoryImage = $row['category_image'];

            	$sql2 = "DELETE FROM `tbl_categories` WHERE `category_id` = '$categoryID'";
            	$result2 = mysqli_query($conn,$sql2);
            	if ($result2) {
            		if($categoryImage != "" && file_exists($categoryImage)){
            			unlink($categoryImage);
            		}

            		$_SESSION['successMessage'] = "Category Deleted Successfully.";
            		header("location:viewAllCategories.php");
		            exit();
            	}
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllCategories.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllCategories.php");
        exit();
    }
}else{
	$_SESSION['errorMessage'] = "Access Denied....!";
	header("location:viewAllCategories.php");
	exit();
}

?>