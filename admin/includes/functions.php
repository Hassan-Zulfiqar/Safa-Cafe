<?php 
function checkLogin(){
	if(isset($_SESSION['userID']) && $_SESSION['userID'] != "" && isset($_SESSION['userFullName']) && $_SESSION['userFullName'] != "" && isset($_SESSION['userType']) && $_SESSION['userType'] != "" && isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "" ){
	    return true;
	}else{
	  return false;
	}
}



function checkUserEmailExist($email,$userID="")
{
	global $conn;
	$sql = "SELECT count(`user_email`) as `totalEmails` FROM `tbl_users` WHERE `user_email` = '$email' AND `user_id` != '$userID'";
	$result = mysqli_query($conn,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['totalEmails'];
		}
	}
}


function checkCategoryExist($categoryName,$categoryID="")
{
	global $conn;
	$sql = "SELECT count(`category_name`) as `totalCategories` FROM `tbl_categories` WHERE `category_name` = '$categoryName' AND `category_id` != '$categoryID'";
	$result = mysqli_query($conn,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['totalCategories'];
		}
	}
}


function checkSubCategoryExist($subCategoryName,$categoryID,$subCategoryID="")
{
	global $conn;
	$sql = "SELECT count(`subcategory_name`) as `totalSubCategories` FROM `tbl_subcategories` WHERE `subcategory_name` = '$subCategoryName' AND `subcategory_categoryID` = '$categoryID' AND `subcategory_id` != '$subCategoryID'";
	$result = mysqli_query($conn,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['totalSubCategories'];
		}
	}
}


function getUserType(){
	return $_SESSION['userType'];
}


function getCurrentPageName(){
    
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
  return $curPageName;
}

function getPageTitle(){
  $curPageName = getCurrentPageName();
  $pageTitle = "Safa Cafe  ";
  if ($curPageName == "index.php") {
        $pageTitle .= " | Dashboard";
  }else if($curPageName == "login.php"){
        $pageTitle .= " | Admin Login ";
  }else if($curPageName == "addNewProduct.php"){
        $pageTitle .= " | Add New Product Details ";
  }else if($curPageName == "viewAllProducts.php"){
        $pageTitle .= " | View All Products List ";
  }else if($curPageName == "editProduct.php"){
    $pageTitle .= " | Update Product Details";
  }else if($curPageName == "addNewCategory.php"){
        $pageTitle .= " | Add New Category Details ";
  }else if($curPageName == "viewAllCategories.php"){
        $pageTitle .= " | View All Categories List ";
  }else if($curPageName == "editCategories.php"){
    $pageTitle .= " | Update Categories Details";
  }else if($curPageName == "addNewSubCategories.php"){
        $pageTitle .= " | Add New Sub Category Details ";
  }else if($curPageName == "viewAllSubCategories.php"){
        $pageTitle .= " | View All Sub Categories List ";
  }else if($curPageName == "editSubCategories.php"){
    $pageTitle .= " | Update Sub Categories Details";
  }else if($curPageName == "addNewUser.php"){
        $pageTitle .= " | Add New User Details ";
  }else if($curPageName == "viewAllUsers.php"){
        $pageTitle .= " | View All Users List ";
  }else if($curPageName == "editUsers.php"){
    $pageTitle .= " | Update Users Details";
  }else if($curPageName == "changePassword.php"){
    $pageTitle .= "| Change Password ";
  }else if ($curPageName == "myProfile.php") {
    $pageTitle .= "| My Profile ";
  }else if($curPageName == "addNewTable.php"){
    $pageTitle .= " | Add New Table Details";
  }else if($curPageName == "viewAllTables.php"){
    $pageTitle .= " | View All Table Details";
  }else if($curPageName == "editTable.php"){
    $pageTitle .= " | Update Table Details";
  }else if($curPageName == "viewAllOrders.php"){
    $pageTitle .= " | All Customers Orders";
  }else if($curPageName == "orderDetails.php"){
    $pageTitle .= " | Customer Order Details";
  }
  return $pageTitle;
}



function getStatusTitle($status){
    if($status == 'P'){
      return "Pending";
    }else if($status == 'A' ){
      return "Active";
    }else if($status == 'R'){
      return "Rejected";
    }else if($status == 'B'){
      return "Blocked";
    }else if($status == 'C' ){
      return "Cancled";
    }else{
      return "N/A";
    }   
  }

function checkOldPassword($password){
  global $conn;
  $password = md5($password);
  $userID= $_SESSION['userID'];
 
  $sql = "SELECT * FROM `tbl_users` WHERE `user_password` = '$password' AND `user_id` = '$userID'";
  
  $result = mysqli_query($conn,$sql);
  if ($result) {
      if(mysqli_num_rows($result) == 1){
        return true;
      }else{
        return false;
      }
  }
}



function checkTableExist($tableTitle,$tableID="")
{
  global $conn;
  $sql = "SELECT count(`table_title`) as `totalTables` FROM `tbl_tables` WHERE `table_title` = '$tableTitle' AND `table_id` != '$tableID'";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if ($row = mysqli_fetch_array($result)) {
      return $row['totalTables'];
    }
  }
}

function getOrderStatus($status){
  if ($status == "P") {
    return "Pending";
  }else if ($status == "D") {
    return "Deliverd";
  }else if ($status == "A") {
    return "Approved";
  }else if ($status == "C") {
    return "Cancled";
  }else{
    return "N/A";
  }
}

function getOrderType($type){
  if ($type == "IO") {
    return "Instant Order";
  }else if ($type == "PBO") {
    return "Pre Booking Order";
  }else {
    return "N/A";
  }
}




function timeago($date) {
     $timestamp = strtotime($date); 
     
     $strTime = array("second", "minute", "hour", "day", "month", "year");
     $length = array("60","60","24","30","12","10");

     $currentTime = time();
     if($currentTime >= $timestamp) {
      $diff     = time()- $timestamp;
      for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
      $diff = $diff / $length[$i];
      }

      $diff = round($diff);
      return $diff . " " . $strTime[$i] . "(s) ago ";
     }
  }


  function getDeliverByName($userID){
    global $conn;
    $sql = "SELECT * FROM `tbl_users` WHERE `user_id` = '$userID'";
    $result = mysqli_query($conn,$sql);
    if($result){
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $userType = $row['user_type'];
          $userName = $row['user_name'];

          if ($userType == "A") {
            $userTypeTitle = "Admin";
          }elseif ($userType == "S") {
            $userTypeTitle = "Staff";
          }

          return $userName." (".$userTypeTitle.")";
        }else{
          return "N/A";
        }
      }else{
        return "N/A";
      }
    }
  }


function getReservationStatus($status){
  if ($status == "P") {
    return "Pending";
  }else if ($status == "A") {
    return "Approved";
  } else if ($status == "R") {
    return "Rejected";
  } else{
    return "N/A";
  }
}


function getOrderRating($orderID){
  global $conn;
  $sql = "SELECT * FROM `tbl_ratings` WHERE `rating_orderID` = '$orderID'";
  $result = mysqli_query($conn,$sql);
  if($result){
    if (mysqli_num_rows($result) == 1) {
      if($row = mysqli_fetch_array($result)){
        return $row['rating_stars'];
      }
    }
  }
}


function getTotalStaffOrderStats($tbl,$statusFiled="",$statusFieldValue="",$userTypeFiled="",$userTypeVal=""){
global $conn;
   if ($statusFiled == "" && $statusFieldValue == "" && $userTypeFiled == "" && $userTypeVal == "") {
    $sql = "SELECT count(*) as tot FROM `".$tbl."`"; 
   }else if($statusFiled == "" && $statusFieldValue == "" && $userTypeFiled != "" && $userTypeVal != ""){
      $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$userTypeFiled."` = '$userTypeVal'"; 
   }else if($statusFiled != "" && $statusFieldValue != "" && $userTypeFiled != "" && $userTypeVal != ""){
      $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$statusFiled."` = '$statusFieldValue' AND `".$userTypeFiled."` = '$userTypeVal'"; 
   }else {
     $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$statusFiled."` = '$statusFieldValue'"; 
   }
   
    $result=mysqli_query($conn,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
}
 
function getTotalStats($tbl,$statusFiled="",$statusFieldValue=""){
   global $conn;
    if($statusFiled != "" && $statusFieldValue != "" ){

      $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$statusFiled."` = '$statusFieldValue'"; 

   }else {

     $sql = "SELECT count(*) as tot FROM `".$tbl."` "; 
   }
   
    $result=mysqli_query($conn,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }

?>