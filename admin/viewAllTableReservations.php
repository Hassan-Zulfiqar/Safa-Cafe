<?php require "includes/head.php"; ?>

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
                            <h4>View All Customers Table Reservations</h4>
                            <p class="mb-0">See Listing of all Table Reservations</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Customers</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Table Reservations</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View All Table Reservations Details</h4>
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




                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                              <th>Sr #</th>
                                              <th>Table</th>
                                              <th>Sitting Capacity</th>

                                              <th>Arival Date</th>
                                              <th>Arival Time</th>

                                              <th>Customer</th>
                                              <th>Status</th>
                                              <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql = "SELECT `tbl_users`.*, `tbl_table_bookings`.*,`tbl_tables`.* FROM `tbl_table_bookings` INNER JOIN `tbl_users` ON `tbl_users`.`user_id` = `tbl_table_bookings`.`table_booking_userID` INNER JOIN `tbl_tables` ON `tbl_tables`.`table_id` = `tbl_table_bookings`.`table_booking_tabelID` ORDER By `tbl_table_bookings`.`table_booking_id` DESC";
                                        $result = mysqli_query($conn,$sql);

                                        if($result){
                                            if(mysqli_num_rows($result)>0){
                                                $srNo = 1;
                                                ?>
                                                <tbody>
                                                    <?php
                                                    while($row = mysqli_fetch_array($result)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td><?php echo $row['table_title'] ?></td>
                                                            <td><?php echo $row['table_sittingCapacity']." Seater"; ?></td>
                                                            <td><?php echo date("d-m-Y",strtotime($row['table_booking_date'])) ; ?></td>
                                                            <td><?php echo date("h:i A",strtotime($row['table_booking_time'])) ; ?></td>
                                                            
                                                            <td><?php echo $row['user_name']; ?></td>
                                                            <td><?php echo getOrderStatus($row['table_booking_status']); ?></td>
                                                            <td>
                                                                <a class="btn btn-success btn-sm" href="reservationDetails.php?reservationID=<?php echo $row['table_booking_id']; ?>">Details</a> 
                                                                
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $srNo++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <?php

                                            }else{
                                                ?>
                                                <div class="alert alert-info">
                                                    No Table Reservation(s) Found.
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                        
                                            
                                        <tfoot>
                                            <tr>
                                              <th>Sr #</th>
                                              <th>Table</th>
                                              <th>Sitting Capacity</th>

                                              <th>Arival Date</th>
                                              <th>Arival Time</th>

                                              <th>Customer</th>
                                              <th>Status</th>
                                              <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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