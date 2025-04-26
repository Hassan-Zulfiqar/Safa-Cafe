<?php require "includes/head.php"; ?>

<?php 
$reservationID = $tableName = $reservationDate = $tableSitting = $reservationCustomerName = $reservationCustomerEmail = $reservationCustomerAddress = $reservationCustomerContact = $reservationTime = $reservationType = $reservationTypeTitle = $reservationPBODate = $reservationPBOTime = $tableReservationFeeReceipt = "";
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
        
        $reservationStatus = $row['table_booking_status'];
        $reservationStatusTitle = getReservationStatus($reservationStatus);

        $reservationCustomerName = $row['user_name'];
        $reservationCustomerEmail = $row['user_email'];
        $reservationCustomerContact = $row['user_contactno'];
        $reservationCustomerAddress = $row['user_address'];
        
        $reservationCustomerID = $row['table_booking_userID'];

        $tableReservationFeeReceipt = $row['table_booking_receipt'];
       
        
      }
    }else{
      $_SESSION['errorMessage'] = "Access Denied...!";
      header("location:viewAllTableReservations.php");
      exit();
    }
  }
}


if (isset($_GET['rStatus'])) {
    $rStatus = $_GET['rStatus'];
    $deliverdBy = $_SESSION['userID'];
    $updateDate = date("Y-m-d H:i:s");
    $sql = "UPDATE `tbl_table_bookings` SET `table_booking_status` = '$rStatus',`table_booking_updatedDate` = '$updateDate' WHERE `table_booking_id` = '$reservationID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if($rStatus == "A"){
          $notiTitle = "Your Table Reservation Request for table ".$tableName." has been Approved By ".$_SESSION['userFullName'];  
        }else if($rStatus == "R"){
          $notiTitle = "Your Table Reservation Request for table ".$tableName." has been Rejected By ".$_SESSION['userFullName'];  
        }
        $notiTitle = mysqli_real_escape_string($conn,$notiTitle);
        $notiFor = "U";
        $notiForID = $reservationCustomerID;
        $notiType = "T";
        $notiTypeID = $reservationID;
        
        $notiSql = "INSERT INTO `tbl_notifications` (`notification_for`,`notification_type`,`notification_title`,`notification_typeID`,`notification_forID`,`notification_status`,`notification_date`) VALUES ('$notiFor','$notiType','$notiTitle','$notiTypeID','$notiForID','0','$updateDate')";
        $notiResult = mysqli_query($conn,$notiSql);
        if ($notiResult) {
            $_SESSION['successMessage'] = "Reservation Status Has been updated";
            header("location:reservationDetails.php?reservationID=".$reservationID);
            exit();
        }

    }
}
?>

<!-- Datatable -->
    <link href="./vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <?php require "includes/navHeader.php"; ?>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <?php require "includes/header.php"; ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php require "includes/sideBar.php"; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>View Customer Table Reservation</h4>
                            <p class="mb-0">See Table Reservation Details</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Customer Table Reservation</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Table Reservation Details</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Table Reservation Details</h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION['successMessage'])) {
                                    ?>
                                    <div class="alert alert-success">
                                        <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
                                    </div>
                                    <?php
                                } ?>


                                <?php if (isset($_SESSION['errorMessage'])) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?>
                                    </div>
                                    <?php
                                } ?>




                               <div class="container-fluid">
      
                                  <div class="row">
                                    <div class="col-md-12 p-4  " >
                                      <div class="heading_container">
                                        <h2>
                                          Reservation of <?php echo $tableName; ?>

                                          <?php if($reservationStatus == "P"){

                                                $currentDate= date("Y-m-d");
                                                if(strtotime($currentDate) <= strtotime($reservationDate)){
                                                    ?>
                                                    <a href="reservationDetails.php?reservationID=<?php echo $reservationID; ?>&rStatus=A" class="btn btn-primary btn-sm float-right ml-3">Accept</a>

                                                    <a href="reservationDetails.php?reservationID=<?php echo $reservationID; ?>&rStatus=R" class="btn btn-danger btn-sm float-right">Reject</a>

                                                    <?php
                                                }
                                          } ?>
                                        </h2>
                                      </div>
                                      <div class="form_container">
                                        <table class="table table-bordered table-striped">
                                          
                                          <tr class="text-dark">
                                            <th>Reservation Table </th>
                                            <td><?php echo $tableName; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Reservation Table Sitting</th>
                                            <td><?php echo $tableSitting; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Reservation Arival Date</th>
                                            <td><?php echo $reservationDate; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Reservation Arival Time</th>
                                            <td><?php echo $reservationTime; ?></td>
                                          </tr>

                                          

                                          <tr class="text-dark">
                                            <th>Reservation Status</th>
                                            <td><?php echo $reservationStatusTitle; ?></td>
                                          </tr>
                                          <tr class="text-dark">
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

                                          <tr class="bg-dark text-white text-center">
                                            <th colspan="2">Customer Details</th>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Name</th>
                                            <td><?php echo $reservationCustomerName; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Email</th>
                                            <td><?php echo  $reservationCustomerEmail; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Contact</th>
                                            <td><?php echo $reservationCustomerContact; ?></td>
                                          </tr>

                                          <tr class="text-dark">
                                            <th>Address</th>
                                            <td><?php echo $reservationCustomerAddress; ?></td>
                                          </tr>
                                        </table>
                                      </div>
                                    </div>
                                    
                                    
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <?php require 'includes/footer.php'; ?>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <?php require "includes/jsScriptsp.php"; ?>
    <!-- Circle progress -->

    <!-- Datatable -->
    <script src="./vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="./js/plugins-init/datatables.init.js"></script>


     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
            title: 'Are you sure delete this Orders?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });
    </script>
</body>

</html>