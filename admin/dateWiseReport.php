<?php require "includes/head.php"; ?>
<?php $orderType = $orders = $orderDeliveryDate = ""; 

$whereClause = " WHERE `tbl_orders`.`order_id` != '' " ;

if(isset($_POST['showReport'])){
    
    $orders = mysqli_real_escape_string($conn,$_POST['orders']);
    
    $orderType = mysqli_real_escape_string($conn,$_POST['orderType']);
    if ($orderType != "") {
        $whereClause .= " AND `tbl_orders`.`order_type` = '$orderType' ";
    }

    $orderDeliveryDate = mysqli_real_escape_string($conn,$_POST['orderDeliveryDate']);
    if ($orderDeliveryDate != "") {
        if($orders == "D"){
            $whereClause .= " AND DATE(`tbl_orders`.`order_deliveredDate`) = DATE('$orderDeliveryDate') AND `tbl_orders`.`order_status` = 'D'";    
        }else if($orders == "R"){
            $whereClause .= " AND DATE(`tbl_orders`.`order_date`) = DATE('$orderDeliveryDate') AND (`tbl_orders`.`order_status` = 'D' OR `tbl_orders`.`order_status` = 'P' OR `tbl_orders`.`order_status` = 'C' OR `tbl_orders`.`order_status` = 'A')";
        }else{
             $whereClause .= " AND DATE(`tbl_orders`.`order_date`) = DATE('$orderDeliveryDate') "; 
        }
        
    }else{
        $orderDeliveryDate = date("Y-m-d");
        $whereClause .= " AND DATE(`tbl_orders`.`order_date`) = DATE('$orderDeliveryDate') AND (`tbl_orders`.`order_status` = 'D' OR `tbl_orders`.`order_status` = 'P' OR `tbl_orders`.`order_status` = 'C' OR `tbl_orders`.`order_status` = 'A')";

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
                            <h4>View All Customers Deliver Orders Date Wise Report</h4>
                            <p class="mb-0">See Listing of all Orders</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Report</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Date Wise Orders Reports</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View All Orders Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="dateWiseReport.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <select class="form-control" name="orders" id="orders">
                                                    <option value="">Select Order</option>
                                                    <option <?php if($orders == "R"){echo "selected";} ?> value="R">Today Placed Orders</option>
                                                    <option <?php if($orders == "D"){echo "selected";} ?> value="D">Today Deliverd Orders</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <select class="form-control" name="orderType" id="orderType">
                                                    <option value="">Select Order Type</option>
                                                    <option <?php if($orderType == "IO"){echo "selected";} ?> value="IO">Instant Orders</option>
                                                    <option <?php if($orderType == "PBO"){echo "selected";} ?> value="PBO">Pre Booking Orders</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                               <input class="form-control" type="date" name="orderDeliveryDate" value="<?php echo $orderDeliveryDate; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                               <input class="btn btn-primary btn-sm btn-block"  type="submit" name="showReport" value="View Report">
                                            </div>
                                        </div>
                                        
                                    </div>

                                        
                                    
                                </form>
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
                                              <th>Order No</th>
                                              <th>Order Date</th>
                                              <th>Total Price</th>
                                              <th>Order Type</th>
                                              <th>Delivery Date</th>
                                              <th>Order By</th>
                                              <th>Status</th>
                                              <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <?php 
                                       $sql = "SELECT `tbl_users`.*, `tbl_orders`.* FROM `tbl_orders` INNER JOIN `tbl_users` ON `tbl_users`.`user_id` = `tbl_orders`.`order_customerID` ".$whereClause." ORDER By `tbl_orders`.`order_id` DESC";
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
                                                            <td><?php echo $row['order_no'] ?></td>
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
                                                            <td><?php echo $row['user_name']; ?></td>
                                                            <td><?php echo getOrderStatus($row['order_status']); ?></td>
                                                            <td>
                                                                <a class="btn btn-success btn-sm" href="orderDetails.php?orderID=<?php echo $row['order_id']; ?>">Details</a> 
                                                                
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
                                                    No Order(s) Found.
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                        
                                            
                                        <tfoot>
                                            <tr>
                                              <th>Sr #</th>
                                              <th>Order No</th>
                                              <th>Order Date</th>
                                              <th>Total Price</th>
                                              <th>Order Type</th>
                                              <th>Delivery Date</th>
                                              <th>Order By</th>
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