<?php 
require "includes/connection.php";
require "includes/functions.php";
if (isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) && $_GET['categoryID'] != "" && isset($_GET['subCategoryID']) && is_numeric($_GET['subCategoryID']) && $_GET['subCategoryID'] != "") {
	$categoryID = $_GET['categoryID'];
    $subCategoryID= $_GET['subCategoryID'];

	$sql = "SELECT * FROM `tbl_subcategories` WHERE `subcategory_id` = '$subCategoryID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
            	$categoryImage = $row['subcategory_image'];

            	$sql2 = "DELETE FROM `tbl_subcategories` WHERE `subcategory_id` = '$subCategoryID'";
            	$result2 = mysqli_query($conn,$sql2);
            	if ($result2) {
            		if($categoryImage != "" && file_exists($categoryImage)){
            			unlink($categoryImage);
            		}

            		$_SESSION['successMessage'] = "Sub Category Deleted Successfully.";
            		header("location:viewAllSubCategories.php?categoryID=".$categoryID);
		            exit();
            	}
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllSubCategories.php?categoryID=".$categoryID);
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllSubCategories.php?categoryID=".$categoryID);
        exit();
    }
}else{
	$_SESSION['errorMessage'] = "Access Denied....!";
	header("location:viewAllCategories.php");
	exit();
}

?>