<?php require "includes/head.php"; 
if (checkLogin() === false) {
  header("location:login.php");
  exit();
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
        <div class="col-md-12 p-4 border" >
          <div class="heading_container">
            <h2>
              My Orders
            </h2>
          </div>
          <div class="form_container">

            <?php
            if(isset($_SESSION['successMessage'])){
              ?>
              <div class="alert alert-success">
                <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
              </div>
              <?php
            }
            $userID = $_SESSION['customerID'];
            $sql = "SELECT * FROM `tbl_orders` WHERE `order_customerID` ='$userID' ORDER BY `order_id` DESC"; 
                $result = mysqli_query($conn,$sql);
                if($result){
                  if(mysqli_num_rows($result)>0){
                    ?>
                     <table id="cateTbl" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Sr #</th>
                          <th>Order No</th>
                          <th>Order Date</th>
                          <th>Total Price</th>
                          <th>Order Type</th>
                          <th>Delivery Date</th>
                          <th>Order Rating</th>
                          <th>Status</th>
                          <th>Action</th>
                          
                          
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                          $srNO = 1;
                          while($row = mysqli_fetch_assoc($result)){
                            $rate = getOrderRating($row['order_id']);
                          ?>
                            <tr>
                              <td ><?php echo $srNO; ?></td>
                              <td><?php echo $row['order_no']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($row['order_date'])) ; ?></td>
                              <td><?php echo $row['order_totalAmount']." PKR"; ?></td>
                              <td>
                                <?php if($row['order_type'] == "IO"){
                                  echo "Instant Order";
                                }else if($row['order_type'] == "PBO"){
                                  echo "Pre Booking Order";
                                } ?>
                              </td>
                              <td><?php 
                                    if ($row['order_deliveredDate'] != "" && $row['order_deliveredDate'] != "0000-00-00") {
                                      echo date("d-m-Y",strtotime($row['order_deliveredDate'])) ;  
                                    }else{
                                      echo "N/A";
                                    }
                                  ?>
                              </td>
                              <td>
                                <?php if ($rate != "") {
                                  echo $rate;
                                  ?>
                                  <i class="fa fa-star text-warning"></i>
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?>
                              </td>

                              <td><?php echo getOrderStatus($row['order_status']); ?></td>
                              <td>
                                <a class="btn btn-success btn-sm" href="myOrderDetails.php?orderID=<?php echo $row['order_id']; ?>">Details</a> 
                                
                              </td>
                            </tr>
                        <?php
                          $srNO++;
                        }
                          ?>
                        </tbody>
                      </table>
                            
                    <?php
                  }else{
                    ?>
                    <div class="alert alert-info">
                      No Order(s) Found.
                    </div>
                    <?php
                    echo "No Record Found";
                  }
                }
              ?>
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