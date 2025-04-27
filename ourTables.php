<?php require "includes/head.php"; ?>
<style type="text/css">
  .nice-select{
    line-height: 30px !important;
    width: 100% !important;
  }
</style>
<?php 
$bookingDate = $bookingTime= "";
$whereClause = " WHERE `table_status` = 'A' ";
$tableSeats = $tableBookingDate = "";
$tableBookingDate = date("Y-m-d");
if (isset($_POST['searchTable'])) {
  if (!empty($_POST['tableSeats'])) {
    $tableSeats = $_POST['tableSeats'];
    $whereClause .= " AND `table_sittingCapacity` = '$tableSeats' ";
  }

  if (!empty($_POST['tableBookingDate'])) {
    $tableBookingDate = $_POST['tableBookingDate'];
  }

  
}

$errorFlag = "";
if (isset($_GET['tableID'])) {
  $tableID = $_GET['tableID'];
  $tID = $_GET['tableID'];

  $btnName= "bookTableBtn_".$tableID;
  if (isset($_POST[$btnName])) {
    
    $bookingDateField = "bookingDate_".$tableID;
    $bookingTimeField = "bookingTime_".$tableID;
    $bookingReceiptField = "bookingReceipt_".$tableID; 

    $bookingDate = mysqli_real_escape_string($conn,$_POST[$bookingDateField]);
    $bookingTime = mysqli_real_escape_string($conn,$_POST[$bookingTimeField]);

    if(checkTableBooking($bookingDate,$tableID,$bookingTime) == true){

      $errorFlag = "Table Already Reserved at this Date and Time.";

    }

     if( basename($_FILES[$bookingReceiptField]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES[$bookingReceiptField]["name"]); //uploads/12131231-abc.jpg 
       
          if (file_exists($target_file)) {
              $errorFlag  =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES[$bookingReceiptField]["size"] > 500000) {
              $errorFlag  = "File is too large";
          }


         
          
          if ($errorFlag  == "") {

              if (move_uploaded_file($_FILES[$bookingReceiptField]["tmp_name"], "admin/".$target_file)) {
                  //your query with file path
                  $receipt = $target_file;

              } else {
                $errorFlag  = "Sorry, there was an error uploading your file.";
              }
          

          } 
      }else{
        $errorFlag = "Upload Fee Receipt ";
      }

    if ($errorFlag == "") {
      

      $userID = $_SESSION['customerID'];
      $createdDate = date("Y-m-d H:i:s");
      $sql = "INSERT INTO `tbl_table_bookings` (`table_booking_tabelID`,`table_booking_userID`,`table_booking_date`,`table_booking_time`,`table_booking_status`,`table_booking_createdDate`,`table_booking_receipt`) VALUES('$tableID','$userID','$bookingDate','$bookingTime','P','$createdDate','$receipt')";

      $result = mysqli_query($conn,$sql);
      if ($result) {
        $bookingID = mysqli_insert_id($conn);
        $notiTitle = $_SESSION['customerName']." Sends Request for Table Resrvation";

        $notiTitle = mysqli_real_escape_string($conn,$notiTitle);

        /*notification for staff-start*/
        $staffID = 1;
        
        $notiSql = "INSERT INTO `tbl_notifications` (`notification_for`,`notification_type`,`notification_title`,`notification_typeID`,`notification_forID`,`notification_status`,`notification_date`) VALUES ('A','T','$notiTitle','$bookingID','$staffID','0','$createdDate')";
          $notiResult = mysqli_query($conn,$notiSql);
        /*notification for staff-end*/

        $resultNoti = mysqli_query($conn,$notiSql);
        if($resultNoti){
          $_SESSION['successMessage'] = "Table Resrvation Request sent to admin";
          header("location:ourTables.php");
          exit();
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

  <!-- food section -->

  <section class="food_section layout_padding-bottom mt-4">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Tables
        </h2>
      </div>

      <div class="row mt-3">
          <div class="col-md-8 offset-md-3">
              <form  action="ourTables.php" method="POST">
                <div class="row">
                <div class="col-md-4 ">
                  <select class="form-control" name="tableSeats" id="tableSeats">
                    <option value="">Select Seats</option>
                    <?php 
                    for ($i=1; $i <= 10 ; $i++) {
                      ?>
                      <option <?php if ($tableSeats == $i) { echo "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?> Seats</option>
                      <?php
                    }
                    ?>
                    
                  </select>
                </div>
                <div class="col-md-4 ">
                  <input type="date" class="form-control" id="tableBookingDate" name="tableBookingDate" value="<?php echo $tableBookingDate; ?>">
                </div>

                <div class="col-md-4">
                
                  <button type="submit" name="searchTable" class="btn btn-warning">Search</button>
                </div>
                </div>
              </form>
          </div>
        </div>

      <div class="filters-content">
        <?php if (isset($_SESSION['successMessage'])) {
          ?>
          <div class="alert alert-success">
            <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
          </div>
          <?php
        } ?>
        <div class="row grid">
          <?php 
          $sql= "SELECT * FROM `tbl_tables` ".$whereClause." ORDER BY `table_id`";
          $result = mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
              $tableID = $row['table_id'];
              $tableImage = "images/table-red.png";
              if(checkTableReserved($tableBookingDate,$tableID) == true){
                $tableImage = "images/table-red.png";
                $btnText = "Book For Future Date";
                $btnClass = "btn-danger";
                $toolTipText = "Already Book for Today you can Reserve Your Table for Future Date.";
              }else{
                $tableImage = "images/table-green.png";
                $btnText = "Book Now";
                $btnClass = "btn-warning";
                $toolTipText = "Reserve Your Table Now";

              }
              $tableTitle = $row['table_title'];
              $bookTableUrl = "singleProduct.php?tableID=".$tableID;
              $tableSeats = $row['table_sittingCapacity'];
          ?>
              <div class="col-sm-3 col-lg-3 all cursor-pointer" data-toggle="tooltip" data-placement="top" title="<?php echo $toolTipText; ?>">
                <div class="box">
                  <div>
                    <div class="img-box">
                      <?php if ($tableImage != "admin/" && file_exists($tableImage)) {
                          ?>
                          <img src="<?php echo $tableImage; ?>" alt="<?php echo $tableTitle." Image"; ?>">

                          <?php
                      }else{
                        ?>
                          <img src="images/f1.png" alt="">
                        <?php
                      } ?>
                    </div>
                    <div class="detail-box">
                      <h5 class="text-center">
                        <?php echo $tableTitle; ?>
                      </h5>
                      
                      <div class="options">
                        <h6 class="text-center" style="width:100%;">
                          <span class="badge badge-success p-1">Sitting Capacity : <?php echo $tableSeats; ?> Seater</span>
                        </h6>
                       <!--  <a href="javascript:;">
                          
                          <i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i>
                        </a> -->

                        

                      
                      
                      </div>
                      <div>
                        <?php if(checkLogin() === false){
                          ?>
                          <a href="login.php"  data-toggle="tooltip" data-placement="top" title="For Reservation Please Login" class="btn btn-sm <?php echo $btnClass; ?> btn-block text-white"><?php echo $btnText; ?></a>

                          <?php
                        }else{
                          ?>
                          <a href="javascript:;"  data-toggle="modal" data-target="#bookTable_<?php echo $tableID; ?>" class="btn btn-sm <?php echo $btnClass; ?> btn-block text-white"><?php echo $btnText; ?></a>

                          <?php
                        } ?>
                        </div>
                      
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal -->
              <div id="bookTable_<?php echo $tableID; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Reserve Your Table</h5>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form_container">
                            <form enctype="multipart/form-data" action="ourTables.php?tableID=<?php echo $tableID; ?>" method="POST">
                              <div class="mb-2">
                                <input required type="date" class="form-control bookingDate" name="bookingDate_<?php echo $tableID; ?>" value="<?php echo $bookingDate; ?>" />
                                <?php if($errorFlag !=""){
                                  ?>
                                  <span class="text-danger"><?php echo $errorFlag; ?></span>
                                  <?php
                                } ?>
                              </div>
                              <div class="mb-2">
                                <input required type="time" class="form-control" name="bookingTime_<?php echo $tableID; ?>" value="<?php echo $bookingTime; ?>" />
                              </div>

                              <div class="mb-2">
                                <span class="text-danger">Upload 1000 PKR Receipt for Complete Reservation </span>
                                <input required type="file" class="form-control" name="bookingReceipt_<?php echo $tableID; ?>"  />
                              </div>
                              
                              <div class="btn_box">
                                <button type="submit" name="bookTableBtn_<?php echo $tableID; ?>" class="btn btn-sm btn-warning btn-block">
                                  Book Now
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
          <?php 
            }
          }else{
            ?>
            <div class="alert alert-info">No Tables Found</div>
            <?php
          } ?>
        </div>
      </div>
    </div>
  </section>


  <!-- end food section -->
  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>

  <script type="text/javascript">
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

      // or instead:
      // var maxDate = dtToday.toISOString().substr(0, 10);
      $('#tableBookingDate').attr('min', maxDate);
      $('.bookingDate').attr('min', maxDate);

    });
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });


<?php if ($errorFlag != "") { ?>
  $('#bookTable_<?php echo $tID; ?>').modal('show');
<?php } ?>
  </script>

</body>

</html>