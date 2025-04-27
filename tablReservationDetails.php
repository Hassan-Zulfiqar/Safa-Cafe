<?php require "includes/head.php"; 
if (checkLogin() === false) {
  header("location:login.php");
  exit();
}

$orderID = $tableName = $tableName = $reservationTime = $reservationTime = $reservationStatus = $reservationStatusTitle = $orderCustomerContact = $orderDeliveryDate = $orderType = $orderTypeTitle = $orderPBODate = $orderPBOTime = $tableReservationFeeReceipt = "";
if(isset($_GET['notiID'])){
    $notiID = $_GET['notiID'];
    $sql = "UPDATE `tbl_notifications` SET `notification_status` = '1' WHERE `notification_id` = '$notiID' AND `notification_status` = '0'";
    mysqli_query($conn,$sql);
}
if (isset($_GET['reservationID']) && is_numeric($_GET['reservationID']) && $_GET['reservationID'] != "") {
  $reservationID = $_GET['reservationID'];

  $sql = "SELECT `tbl_users`.*, `tbl_table_bookings`.*,`tbl_tables`.* FROM `tbl_table_bookings` INNER JOIN `tbl_users` ON `tbl_users`.`user_id` = `tbl_table_bookings`.`table_booking_userID` INNER JOIN `tbl_tables` ON `tbl_tables`.`table_id` = `tbl_table_bookings`.`table_booking_tabelID` WHERE `tbl_table_bookings`.`table_booking_id` = '$reservationID'";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if(mysqli_num_rows($result) == 1){
      if ($row = mysqli_fetch_array($result)) {
        $tableName = $row['table_title'];
        $reservationDate = date("d-m-Y",strtotime($row['table_booking_date']));
        $reservationTime = date("h:i A", strtotime($row['table_booking_time']));  
        $tableSitting = $row['table_sittingCapacity']." Seater";
        $tableReservationFeeReceipt = "admin/".$row['table_booking_receipt'];
        $reservationStatus = $row['table_booking_status'];
        $reservationStatusTitle = getReservationStatus($reservationStatus);


       
        
      }
    }else{
      $_SESSION['errorMessage'] = "Access Denied...!";
      header("location:myTableReservations.php");
      exit();
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
        <div class="col-md-12 p-4 border mr-1 ml-5" >
          <div class="heading_container">
            <h2>
              Reservation of <?php echo $tableName; ?>
            </h2>
          </div>
          <div class="form_container">
            <table class="table table-bordered table-striped">
              <tr>
                <th>Reseravtion Table</th>
                <td><?php echo $tableName; ?></td>
              </tr>
              <tr>
                <th>Reseravtion Table Siiting</th>
                <td><?php echo $tableSitting; ?></td>
              </tr>
              <tr>
                <th>Reseravtion Date</th>
                <td><?php echo $reservationDate; ?></td>
              </tr>
              <tr>
                <th>Reseravtion Time</th>
                <td><?php echo $reservationTime; ?></td>
              </tr>

              <tr>
                <th>Reseravtion Status</th>
                <td><?php echo $reservationStatusTitle; ?></td>
              </tr>

              <tr>
                <th>Reservation Fee</th>
                <td>
                  <?php if($tableReservationFeeReceipt != "admin/" && file_exists($tableReservationFeeReceipt) ){
                    ?>
                      <a target="_blank" href="<?php echo $tableReservationFeeReceipt; ?>" class="btn btn-sm btn-success">Receipt</a>
                    <?php
                  }else{
                    echo "N/A";
                  } ?>
                </td>
              </tr>
              
              
            </table>
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
</body>

</html>