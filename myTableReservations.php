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
              My Reservations 
            </h2>
          </div>
          <div class="form_container">
            <?php
            $userID = $_SESSION['customerID'];
            $sql = "SELECT `tbl_table_bookings`.*,`tbl_tables`.* FROM `tbl_table_bookings`  INNER JOIN `tbl_tables` ON `tbl_tables`.`table_id` = `tbl_table_bookings`.`table_booking_tabelID` WHERE `tbl_table_bookings`.`table_booking_userID`='$userID' ORDER BY `tbl_table_bookings`.`table_booking_id` DESC";
                $result = mysqli_query($conn,$sql);
                if($result){
                  if(mysqli_num_rows($result)>0){
                    ?>
                     <table id="cateTbl" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Sr #</th>
                          <th>Table</th>
                          <th>Sitting Capacity</th>
                          <th>Arival Date</th>
                          <th>Arival Time</th>
                          <th>Status</th>
                          <th>Action</th> 
                          
                          
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                          $srNO = 1;
                          while($row = mysqli_fetch_assoc($result)){
                          ?>
                            <tr>
                              <td><?php echo $srNO; ?></td>
                              <td><?php echo $row['table_title'] ?></td>
                              <td><?php echo $row['table_sittingCapacity']." Seater"; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($row['table_booking_date'])) ; ?></td>
                              <td><?php echo date("h:i A",strtotime($row['table_booking_time'])) ; ?></td>
                              <td><?php echo getOrderStatus($row['table_booking_status']); ?></td>
                              <td>
                                  <a class="btn btn-success btn-sm" href="tablReservationDetails.php?reservationID=<?php echo $row['table_booking_id']; ?>">Details</a> 
                                  
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
                      No Reservation(s) Found.
                    </div>
                    <?php
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