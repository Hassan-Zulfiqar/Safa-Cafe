<?php require "includes/head.php"; 
if (checkLogin() === false) {
  header("location:login.php");
  exit();
}

?>
<?php $orderDescription = $userEmail = $preBookDate = $preBookTime = $userImage = $userAddress = $userContactNo = $userType = $orderType = ""; 
$userName = $userEmail = ""; 
$orderDescriptionErr = $userContactNoErr = $userAddressErr = $userEmailErr = $userImageErr = $userTypeErr = $preBookDateErr = $preBookTimeErr = $orderTypeErr = $orderDescription = "";

if (isset($_SESSION['customerID'])) {
  $customerID = $_SESSION['customerID'];
  $sql = "SELECT * FROM `tbl_users` WHERE `user_id` = '$customerID'";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if($row= mysqli_fetch_array($result)){
        $userAddress = $row['user_address'];
        $userContactNo = $row['user_contactno'];
        $userName = $row['user_name'];
        $userEmail = $row['user_email'];

      }
    }
  }
}

if (isset($_POST['placeOrder'])) {
    // if (empty($_POST['orderDescription'])) {
    //     $orderDescriptionErr = "Please enter Full Name.";
    // }else{
        // $orderDescription = mysqli_real_escape_string($conn,$_POST['orderDescription']);
    // }

    $orderDescription = mysqli_real_escape_string($conn,$_POST['orderDescription']);


    // if (!empty($_POST['userEmail'])) {
    //   $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
    // }else{
    //     $userEmail = "";
    // }

    if (empty($_POST['orderType'])) {
        $orderTypeErr = "Please Select Order Type";
    }else{
        $orderType = mysqli_real_escape_string($conn,$_POST['orderType']);
    }

    if($orderType == "PBO"){
      if (empty($_POST['preBookDate'])) {
        $preBookDateErr = "Please enter User Password.";
      }else{
          $preBookDate = mysqli_real_escape_string($conn,$_POST['preBookDate']);
      }
      if (empty($_POST['preBookTime'])) {
        $preBookTimeErr = "Please enter User Confirm Password.";
      }else{
          $preBookTime = mysqli_real_escape_string($conn,$_POST['preBookTime']);
          
      }  
    }
    
    if (empty($_POST['userContactNo'])) {
        $userContactNoErr = "Please enter User Contact No.";
    }else{
        $userContactNo = mysqli_real_escape_string($conn,$_POST['userContactNo']);
        
    }

    if (empty($_POST['userAddress'])) {
        $userAddressErr = "Please enter User Addrress.";
    }else{
        $userAddress = mysqli_real_escape_string($conn,$_POST['userAddress']);
        
    }
    
    if ($orderDescriptionErr == "" && $userContactNoErr == "" && $userAddressErr == "" && $userAddressErr == "" && $orderTypeErr == "" && $preBookDateErr == "" && $preBookTimeErr == "")  {
        
        if(isset($_SESSION['cart']) && checkLogin() === true){
          if(is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0 ){ 
            $userID = $_SESSION['customerID'];
            $orderNo = getOrderNo(6);

            $createdDate = date("Y-m-d h:i:s");
            $orderStatus = "P";
            $totPriceArray = array();
            $orderSql = "INSERT INTO 
            `tbl_orders` (`order_no`,`order_customerID`,`order_customerName`,`order_customerEmail`,`order_customerContact`,`order_customerAddress`,`order_date`,`order_type`,`order_totalAmount`,`order_status`,`order_deliveryDate`,`order_deliveryTime`,`order_description`) 
            VALUES ('$orderNo','$userID','$userName','$userEmail','$userContactNo','$userAddress','$createdDate','$orderType','','$orderStatus','$preBookDate','$preBookTime','$orderDescription')";
        
            $orderResult = mysqli_query($conn,$orderSql);
            if($orderResult){
              $orderID = mysqli_insert_id($conn);
                for($i = 0; $i < count($_SESSION['cart']); $i++){ 
                  $cartProductID  = $_SESSION['cart'][$i]['productID'];
                     $cartProductName  = $_SESSION['cart'][$i]['productName'];
                     $cartProductPrice  = $_SESSION['cart'][$i]['productPrice'];
                     $cartProductQty  = $_SESSION['cart'][$i]['productQty'];
                     $totProductPrice = $cartProductPrice *  $cartProductQty;
                     array_push($totPriceArray, $totProductPrice);


                     

                     $orderDetailSql = "INSERT INTO `tbl_order_details` (`order_detail_orderID`,`order_detail_productID`,`order_detail_productQty`,`order_detail_productPrice`,`order_detail_createdDate`) VALUES ('$orderID','$cartProductID','$cartProductQty','$cartProductPrice','$createdDate')";
                      $orderDetailResult = mysqli_query($conn,$orderDetailSql);

                }
                $orderTotPrice = array_sum($totPriceArray);
                $updatePriceColSql = "UPDATE `tbl_orders` SET `order_totalAmount` = '$orderTotPrice' WHERE `order_id` = '$orderID'";
                $orderTotPriceResult = mysqli_query($conn,$updatePriceColSql);

                if($orderTotPriceResult){
                    if($orderType == "IO"){
                      $notiTitle = $_SESSION['customerFullName']." - Place New Instant Order # ".$orderNo;  
                    }else if($orderType == "PBO"){
                      $notiTitle = $_SESSION['customerFullName']." - Place New Pre Booking Order # ".$orderNo;
                    }
                    $notiTitle = mysqli_real_escape_string($conn,$notiTitle);

                    /*notification for staff-start*/
                    $staffID = getActiveStaffID();
                    
                    $notiSql = "INSERT INTO `tbl_notifications` (`notification_for`,`notification_type`,`notification_title`,`notification_typeID`,`notification_forID`,`notification_status`,`notification_date`) VALUES ('S','O','$notiTitle','$orderID','$staffID','0','$createdDate')";
                      $notiResult = mysqli_query($conn,$notiSql);
                    /*notification for staff-end*/

                    /*notification for admin-start*/
                      
                      $notiSql = "INSERT INTO `tbl_notifications` (`notification_for`,`notification_type`,`notification_title`,`notification_typeID`,`notification_forID`,`notification_status`,`notification_date`) VALUES ('A','O','$notiTitle','$orderID','1','0','$createdDate')";
                      $notiResult = mysqli_query($conn,$notiSql);
                    /*notification for admin-end*/

                      if($notiResult){
                        unset($_SESSION['cart']);
                        $_SESSION['orderPlacedSuccessfully'] = "Your Order Request Has Been Submitted to Admin";
                        header("location:cart.php");
                        exit();
                    }

                    
                }
                
            }
          }
        }
    }
}


?>
  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>
    <!-- header section strats -->
    <?php require "includes/header.php"; ?>
  </div>


  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      
      <div class="row">
        <div class="col-md-6 offset-md-3 p-4 border" >
          <div class="heading_container">
            <h2>
              Place Your Order
            </h2>
          </div>
          <div class="form_container">
            <form action="placeOrder.php" method="POST" enctype="multipart/form-data">
              <!-- <div class="row">
                <div class="col-lg-6">

                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $orderDescriptionErr; ?></div>
                  <input type="text" class="form-control" id="orderDescription" name="orderDescription" placeholder="Enter a Full Name" value="<?php echo $orderDescription; ?>">
                </div>
                <div class="col-lg-6">

                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userEmailErr; ?></div>
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Your valid email" value="<?php echo $userEmail; ?>">

                </div>  
              </div> -->
                                                 
              
              <div class="row">
                  <div class="col-lg-6">
                      <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userContactNoErr; ?></div>
                      <input type="tel" class="form-control" id="userContactNo" name="userContactNo" placeholder="Enter User Contact No" value="<?php echo $userContactNo; ?>">
                  </div>
                  <div class="col-lg-6">
                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userAddressErr; ?></div>
                    <textarea class="form-control" rows="4" name="userAddress" placeholder="Enter User Address"><?php echo $userAddress; ?></textarea>
                
                  </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $orderDescriptionErr; ?></div>
                    <textarea class="form-control" rows="6" name="orderDescription" placeholder="Enter Order Description"><?php echo $orderDescription; ?></textarea>
                
                  </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div  class="invalid-feedback animated fadeInUp"  style="display: block;"><?php echo $orderTypeErr; ?></div>
                  <select class="form-control" name="orderType" id="orderType" onchange="showPreBookingDate();">
                    <option <?php if($orderType == "IO"){echo "selected";} ?> value="IO">Instant Order</option>
                    <option <?php if($orderType == "PBO"){echo "selected";} ?> value="PBO">Pre.Booking Order</option>

                  </select>
                </div>
              </div>

              <div id="preBookingDateTimeOrderDiv" style="display:none;" class="row">
                <div class="col-lg-6">
                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $preBookDateErr; ?></div>
                  <input type="date" name="preBookDate" id="preBookDate" class="form-control" placeholder="Select Date" value="<?php echo $preBookDate; ?>" />
                </div>
                <div class="col-lg-6">

                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $preBookTimeErr; ?></div>
                  <input type="time" name="preBookTime" id="preBookTime" class="form-control" placeholder="Select Time" value="<?php echo $preBookTime; ?>"/>
                </div>

              </div> 
              
              

              <div class="btn_box">
                <button type="submit" class="float-right" name="placeOrder">
                  Place Your Order
                </button>
              </div>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </section>
  <!-- end book section -->

  
  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>
<script type="text/javascript">
  <?php if($orderType == "PBO"){
    ?>
    $("#preBookingDateTimeOrderDiv").show();
   
    <?php
  } ?>
  function showPreBookingDate() {
   let orderType =  $("#orderType").val();
   // alert(orderType);
   if (orderType == "PBO") {
    $("#preBookingDateTimeOrderDiv").show();
   }else{
    $("#preBookingDateTimeOrderDiv").hide();

   }
  }
  $(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var maxDate = year + '-' + month + '-' + day;

    $('#preBookDate').attr('min', maxDate);
  });
</script>
</body>

</html>