<?php require "includes/head.php"; ?>
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
                            <h4>Hi <?php echo $_SESSION['userFullName']; ?>, welcome back!</h4>
                            <p class="mb-0">Your Dashboard</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Stats</h4>
                            </div>
                            <div class="card-body">
                                <?php if($_SESSION['userType'] == "A"){?> 
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-user text-success border-success"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Customers</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_users','user_type','C'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-user text-info border-info"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Staff</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_users','user_type','S'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-list-ol text-primary border-primary"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Categories</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_categories'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-list text-pink border-pink"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Products</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_products') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-primary border-primary"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Orders</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-warning border-warning"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Pending</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_status','P') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-success border-success"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Delivered</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_status','D') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-danger border-danger"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Instant</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_type','IO') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-dark border-dark"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Pre-Booking</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_type','PBO') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-layout-accordion-separated text-info border-info"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Reservations</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_table_bookings','table_booking_status','P') ?> <small style="font-size:10px;">Pending</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-layout-accordion-separated text-info border-info"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Reservations</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_table_bookings','table_booking_status','A') ?> <small style="font-size:10px;">Confirmed</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ ?> 
                                    <div class="row">
                                        
                                        
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-warning border-warning"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Pending</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_status','P') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-success border-success"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Delivered</div>
                                                        <div class="stat-digit"><?php echo getTotalStaffOrderStats('tbl_orders','order_status','D','order_staffID',$_SESSION['userID']) ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-danger border-danger"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Instant</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_type','IO') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-6">
                                            <div class="card">
                                                <div class="stat-widget-one card-body">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="ti-shopping-cart text-dark border-dark"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text">Pre-Booking</div>
                                                        <div class="stat-digit"><?php echo getTotalStats('tbl_orders','order_type','PBO') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Today's Orders</h3>
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
                                                          <th>Order Rating</th>
                                                          <th>Action</th>
                                                          
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                                    $sql = "SELECT `tbl_users`.*, `tbl_orders`.* FROM `tbl_orders` INNER JOIN `tbl_users` ON `tbl_users`.`user_id` = `tbl_orders`.`order_customerID` WHERE DATE(`tbl_orders`.`order_date`) = CURDATE() ORDER By `tbl_orders`.`order_id` DESC";
                                                    $result = mysqli_query($conn,$sql);

                                                    if($result){
                                                        if(mysqli_num_rows($result)>0){
                                                            $srNo = 1;
                                                            ?>
                                                            <tbody>
                                                                <?php
                                                                while($row = mysqli_fetch_array($result)){
                                                                $rate = getOrderRating($row['order_id']);
                                                                    
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
                                                                            <?php if ($rate != "") {
                                                                              echo $rate;
                                                                              ?>
                                                                              <i class="fa fa-star text-warning"></i>
                                                                              <?php
                                                                            }else{
                                                                              echo "N/A";
                                                                            } ?>
                                                                          </td>
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
                                                          <th>Order Rating</th>

                                                          <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
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