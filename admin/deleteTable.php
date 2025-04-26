<?php 
require "includes/connection.php";
require "includes/functions.php";
if (isset($_GET['tableID']) && is_numeric($_GET['tableID']) && $_GET['tableID'] != "") {
	$tableID = $_GET['tableID'];

	$sql = "DELETE FROM `tbl_tables` WHERE `table_id` = '$tableID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        $_SESSION['successMessage'] = "Table Deleted Successfully.";
        header("location:viewAllTables.php");
        exit();
    }
}else{
	$_SESSION['errorMessage'] = "Access Denied....!";
	header("location:viewAllTables.php");
	exit();
}

?>