<?php 
require "includes/head.php"; 
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
                            <h4>View All Notifications</h4>
                            <p class="mb-0">See Listing of all Notifications</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Notifications</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Notifications</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View All Notifications Details</h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION['successMessage'])) { ?>
                                    <div class="alert alert-success">
                                        <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
                                    </div>
                                <?php } ?>


                                <?php if (isset($_SESSION['errorMessage'])) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?>
                                    </div>
                                <?php } ?>




                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Title</th>
                                                <th>Date & Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $notiForID = $_SESSION['userID'];
                                        $notiFor = $_SESSION['userType'];
                                        $sql = "SELECT * FROM `tbl_notifications` WHERE `notification_for` = '$notiFor' AND `notification_forID` = '$notiForID' ORDER BY `notification_id` DESC" ;
                                        $result = mysqli_query($conn,$sql);

                                        if($result){
                                            if(mysqli_num_rows($result)>0){
                                                $srNo = 1;
                                                ?>
                                                <tbody>
                                                    <?php
                                                    while($row = mysqli_fetch_array($result)){
                                                        $notiID = $row['notification_id'];
                                                        $notiTitle = $row['notification_title'];
                                                        $notiType= $row['notification_type'];
                                                        $notiTypeID = $row['notification_typeID'];
                                                        $notiUrl = "javascript:;";
                                                        if ($notiType == "O") {
                                                            $notiUrl = "orderDetails.php?orderID=".$notiTypeID."&notiID=".$notiID;
                                                        }else if ($notiType == "T") {
                                                            $notiUrl = "reservationDetails.php?reservationID=".$notiTypeID."&notiID=".$notiID;
                                                        }else{
                                                            $notiUrl = "javascript:;";
                                                        }
                                                        $notiDateTime = $row['notification_date'];
                                                        $notiTime = date("h:i A",strtotime($notiDateTime));
                                                        $notiDate = date("d-m-Y",strtotime($notiDateTime));
                                                        $timeAgo =timeago($notiDateTime);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td><?php echo $notiTitle; ?></td>
                                                            <td><?php echo $notiDate." & ".$notiTime; ?></td>
                                                            <td>
                                                                <a href="<?php echo $notiUrl; ?>" class="btn btn-sm btn-success">Details</a>
                                                                
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
                                                    No Notification(s) Found.
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                        
                                            
                                        <tfoot>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Title</th>
                                                <th>Date & Time</th>
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

</body>

</html>