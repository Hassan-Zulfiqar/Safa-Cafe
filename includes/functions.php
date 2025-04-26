<?php 
function checkLogin(){
    if(isset($_SESSION['customerID']) && $_SESSION['customerID'] != "" && isset($_SESSION['customerFullName']) && $_SESSION['customerFullName'] != "" && isset($_SESSION['customerEmail']) && $_SESSION['customerType'] != "" && isset($_SESSION['customerType']) && $_SESSION['customerEmail'] != "" ){
       
        return true;

    }else{
      return false;
    }
  }


function get_rand_prod_img($productID){
    global $conn;
    $sql = "select product_image from tbl_products where product_id = '$productID'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['product_image'];
}
function cal_prod_discount($productID){
    global $conn;
    $get_productDiscount = "SELECT `product_discount`,`product_price` FROM `tbl_products` WHERE `product_id` = '$productID'";
    $res_productDiscount = mysqli_query($conn,$get_productDiscount);
    $row_discount = mysqli_fetch_assoc($res_productDiscount);
    $productDiscount = $row_discount['product_discount'];
    $productPrice = $row_discount['product_price'];
    $discount = $productDiscount/100;
    return $discount_price = $discount*$productPrice;
}

function checkOldPassword($password){
  global $conn;
  $password = md5($password);
  $userID= $_SESSION['customerID'];
 
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


function getCurrentPageName(){
    
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
  return $curPageName;
}

function getPageTitle(){
  $curPageName = getCurrentPageName();
  $pageTitle = "Safa Cafe  ";
  if ($curPageName == "index.php") {
        $pageTitle .= " | Home";
  }else if($curPageName == "login.php"){
        $pageTitle .= " |  Login ";
  }else if($curPageName == "menu.php"){
        $pageTitle .= " | Menu Details ";
  }else if($curPageName == "singleProduct.php"){
        $pageTitle .= " | View Product Details ";
  }else if($curPageName == "cart.php"){
    $pageTitle .= " | My Cart";
  }else if($curPageName == "myOrders.php"){
        $pageTitle .= " | My Orders Details ";
  }else if($curPageName == "myOrderDetails.php"){
        $pageTitle .= " | Single Order Details ";
  }else if($curPageName == "changePassword.php"){
    $pageTitle .= "| Change Password ";
  }else if ($curPageName == "myProfile.php") {
    $pageTitle .= "| My Profile ";
  }else if($curPageName == "register.php"){
    $pageTitle .= " | Register As Customer";
  }else if($curPageName == "viewAllNotifications.php"){
    $pageTitle .= " | All Notifications Listing";
  }else if($curPageName == "ourTables.php"){
    $pageTitle .= " | All Table Available for Reservation";
  }
  return $pageTitle;
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


function checkProdInCart($prodID){
  if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
    for($i = 0; $i < count($_SESSION['cart']); $i++){
      $cartProd  = $_SESSION['cart'][$i]['productID'];
      if($cartProd == $prodID){
        return true;
      }
    }
  }else{
    return false;
  }
}

function getProdPrice($prodID){
  global $conn;
  $sql = "SELECT `product_price` FROM `tbl_products` WHERE `product_id` = '$prodID'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  return $row['product_price'];
}


function getOrderNo($size) {
  $alpha_key = '';
  $keys = range('A', 'Z');
  
  for ($i = 0; $i < 2; $i++) {
    $alpha_key .= $keys[array_rand($keys)];
  }
  
  $length = $size - 2;
  
  $key = '';
  $keys = range(0, 9);
  
  for ($i = 0; $i < $length; $i++) {
    $key .= $keys[array_rand($keys)];
  }
  
  return $alpha_key . $key;
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


function getActiveStaffID(){
  global $conn;
  $sql = "SELECT * FROM `tbl_users` WHERE `user_type` = 'S' AND `user_status` = 'A' ORDER BY `user_id` DESC LIMIT 1";
  
  $result = mysqli_query($conn,$sql);
  if ($result) {
      if(mysqli_num_rows($result) == 1){
        if ($row = mysqli_fetch_array($result)) {
          return $row['user_id'];
        }
      }
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



function checkTableReserved($date,$tableID){
  global $conn;

  $sql = "SELECT * FROM `tbl_table_bookings` WHERE DATE(`table_booking_date`) = DATE('$date') AND `table_booking_tabelID` = '$tableID' AND `table_booking_status` = 'A'";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if(mysqli_num_rows($result)>0){
      return true;
    }else{
      return false;
    }
  }
} 


function checkTableBooking($date,$tableID,$time){
  global $conn;

  // $time1 = strtotime($time) + 60*60;

  // $time2 = date('H:i', $time1);

  $sql = "SELECT * FROM `tbl_table_bookings` WHERE DATE(`table_booking_date`) = DATE('$date') AND TIME(`table_booking_time`) = TIME('$time') AND `table_booking_tabelID` = '$tableID' AND (`table_booking_status` = 'A' || `table_booking_status` = 'P')";
  // $sql = "SELECT * FROM `tbl_table_bookings` WHERE DATE(`table_booking_date`) = DATE('$date') AND (`table_booking_time` BETWEEN '$time' AND '$time2' ) AND `table_booking_tabelID` = '$tableID' AND (`table_booking_status` = 'A' || `table_booking_status` = 'P')";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if(mysqli_num_rows($result)>0){
      return true;
    }else{
      return false;
    }
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

?>
