<?php require "includes/head.php"; ?>

<style type="text/css">
                
/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:1.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:yellow;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

</style>
<?php 
$orderID = $orderNo = $orderDate = $orderTotalAmount = $orderCustomerName = $orderCustomerEmail = $orderCustomerAddress = $orderCustomerContact = $orderDeliveryDate = $orderType = $orderTypeTitle = $orderPBODate = $orderPBOTime = $orderDescription = "";
if(isset($_GET['notiID'])){
    $notiID = $_GET['notiID'];
    $sql = "UPDATE `tbl_notifications` SET `notification_status` = '1' WHERE `notification_id` = '$notiID' AND `notification_status` = '0'";
    mysqli_query($conn,$sql);
}
if (isset($_GET['orderID']) && is_numeric($_GET['orderID']) && $_GET['orderID'] != "") {
  $orderID = $_GET['orderID'];

  $sql = "SELECT * FROM `tbl_orders` WHERE `order_id` = '$orderID'";
  $result = mysqli_query($conn,$sql);
  if ($result) {
    if(mysqli_num_rows($result) == 1){
      if ($row = mysqli_fetch_array($result)) {
        $orderNo = $row['order_no'];
        $orderDate = date("d-m-Y",strtotime($row['order_date']));
        if($row['order_deliveredDate'] != ""){
          $orderDeliveryDate = date("d-m-Y", strtotime($row['order_deliveredDate']));  
        }else{
          $orderDeliveryDate = "N/A";
        } 
        

        $orderTotalAmount = $row['order_totalAmount']." PKR";
        $orderType = $row['order_type'];
        if ($orderType == "IO") {
          $orderTypeTitle = "Instant Order";
        }else if ($orderType == "PBO") {
          $orderTypeTitle = "Pre Booking Order";
        }
        $orderStatus = $row['order_status'];
        $orderStatusTitle = getOrderStatus($orderStatus);

        $orderCustomerName = $row['order_customerName'];
        $orderCustomerEmail = $row['order_customerEmail'];
        $orderCustomerContact = $row['order_customerContact'];
        $orderCustomerAddress = $row['order_customerAddress'];
        $orderPBODate = date("d-m-Y", strtotime($row['order_deliveryDate']));
        $orderPBOTime = date("h:i A", strtotime($row['order_deliveryTime']));
        $orderCustomerID = $row['order_customerID'];


        $deliverdByID = $row['order_staffID'];
        $deliverdByName = getDeliverByName($deliverdByID);
        $orderDescription = $row['order_description'];

        
      }
    }else{
      $_SESSION['errorMessage'] = "Access Denied...!";
      header("location:viewAllOrders.php");
      exit();
    }
  }
}


if (isset($_GET['oStatus'])) {
    $oStatus = $_GET['oStatus'];
    $deliverdBy = $_SESSION['userID'];
    $deliverdDate = date("Y-m-d H:i:s");
    $sql = "UPDATE `tbl_orders` SET `order_status` = '$oStatus',`order_staffID`='$deliverdBy',`order_deliveredDate` = '$deliverdDate' WHERE `order_id` = '$orderID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if($orderType == "IO"){
          $notiTitle = "Your Instant Order # ".$orderNo." has been Deliverd By ".$_SESSION['userFullName'];  
        }else if($orderType == "PBO"){
          $notiTitle = "Your Pre Booking Order # ".$orderNo." has been Deliverd By ".$_SESSION['userFullName'];;
        }
        $notiTitle = mysqli_real_escape_string($conn,$notiTitle);
        $notiFor = "U";
        $notiForID = $orderCustomerID;
        $notiType = "O";
        $notiTypeID = $orderID;
        
        $notiSql = "INSERT INTO `tbl_notifications` (`notification_for`,`notification_type`,`notification_title`,`notification_typeID`,`notification_forID`,`notification_status`,`notification_date`) VALUES ('$notiFor','$notiType','$notiTitle','$notiTypeID','$notiForID','0','$deliverdDate')";
        $notiResult = mysqli_query($conn,$notiSql);
        if ($notiResult) {
            $_SESSION['successMessage'] = "Order Status Has been updated";
            header("location:orderDetails.php?orderID=".$orderID);
            exit();
        }

    }
}
$rateDescription = $rateStars = "";
$rateFlag = 0;
$sql = "SELECT * FROM `tbl_ratings` WHERE `rating_orderID` = '$orderID'";
$result = mysqli_query($conn,$sql);
if($result){
  if (mysqli_num_rows($result) == 1) {
    if($row = mysqli_fetch_array($result)){
      $rateFlag = 1;
      $rateStars = $row['rating_stars'];
      $rateDescription = $row['rating_description'];
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
                            <h4>View Customer Order</h4>
                            <p class="mb-0">See Order Details</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Customer Order</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Order Details</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Orders Details</h4>
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
                                    <div class="col-md-6 p-4  " >
                                      <div class="heading_container">
                                        <h2>
                                          Order # <?php echo $orderNo; ?>

                                          <?php if($orderStatus == "P"){

                                            if ($orderType == "PBO") {
                                                $currentDate= date("Y-m-d");
                                                if(strtotime($orderPBODate) == strtotime($currentDate)){
                                                    ?>
                                                    <a href="orderDetails.php?orderID=<?php echo $orderID; ?>&oStatus=D" class="btn btn-primary btn-sm float-right">Deliver</a>

                                                    <?php
                                                }else{
                                                    ?>
                                                    <a href="javascript:;" class="btn btn-danger btn-sm mb-3 float-right">You Can Deliver this at <?php echo $orderPBODate." - ".$orderPBOTime; ?></a>

                                                    <?php
                                                }    
                                            }else{
                                                ?>
                                                <a href="orderDetails.php?orderID=<?php echo $orderID; ?>&oStatus=D" class="btn btn-primary btn-sm float-right">Deliver</a>

                                                <?php
                                            }

                                            
                                            ?>
                                            <?php
                                          } ?>
                                        </h2>
                                      </div>
                                      <div class="form_container">
                                        <table class="table table-bordered table-striped">
                                          <tr class="text-dark">
                                            <th>Order Type</th>
                                            <td><?php echo $orderTypeTitle; ?></td>
                                          </tr>
                                          <?php if($orderType == "PBO"){ ?>
                                            <tr class="text-dark">
                                              <th>Order Delivery Date/Time</th>
                                              <td><?php echo $orderPBODate." / ".$orderPBOTime; ?></td>
                                            </tr>
                                          <?php } ?>

                                          <tr class="text-dark">
                                            <th>Order Date</th>
                                            <td><?php echo $orderDate; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Order Total Amount</th>
                                            <td><?php echo $orderTotalAmount; ?></td>
                                          </tr>

                                          <tr class="text-dark">
                                            <th>Order Status</th>
                                            <td><?php echo $orderStatusTitle; ?></td>
                                          </tr>
                                          
                                          <tr class="text-dark">
                                            <th>Order Delivered Date</th>
                                            <td><?php echo $orderDeliveryDate; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                              <th>Deliverd By</th>
                                              <td><?php echo $deliverdByName; ?></td>
                                          </tr>
                                        </table>
                                        <?php if ($orderDescription != "") { ?>
                                                <div class="row mb-3">
                                                  <div class=col-md-12>
                                                    <ul class="list-group">
                                                      <li class="list-group-item bg-dark text-white text-center"><b>Order Description</b></li>
                                                      <li class="list-group-item">
                                                        <p class="text-justify text-dark">
                                                          <?php echo $orderDescription; ?>
                                                        </p>
                                                      </li>
                                                    </ul>
                                                  </div>
                                                </div>
                                        <?php } ?>
                                        <table class="table table-bordered table-striped">
                                          <tr class="bg-dark text-white text-center">
                                            <th colspan="2">Customer Details</th>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Name</th>
                                            <td><?php echo $orderCustomerName; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Email</th>
                                            <td><?php echo  $orderCustomerEmail; ?></td>
                                          </tr>
                                          <tr class="text-dark">
                                            <th>Contact</th>
                                            <td><?php echo $orderCustomerContact; ?></td>
                                          </tr>

                                          <tr class="text-dark">
                                            <th>Address</th>
                                            <td><?php echo $orderCustomerAddress; ?></td>
                                          </tr>
                                        </table>
                                      </div>
                                    </div>
                                    
                                    <div class="col-md-6 p-4" >
                                      <div class="heading_container">
                                        <h2>
                                          Products Details
                                        </h2>
                                      </div>
                                      <div class="form_container">
                                        <table class="table table-bordered table-striped">
                                          <tr>
                                            <th>Sr #</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                          </tr>
                                          <?php 
                                          $sql = "SELECT `tbl_order_details`.*,`tbl_products`.* FROM `tbl_order_details` INNER JOIN `tbl_products` ON `tbl_order_details`.`order_detail_productID` = `tbl_products`.`product_id` WHERE `tbl_order_details`.`order_detail_orderID` = '$orderID' ORDER BY `tbl_order_details`.`order_detail_id`";

                                          $result = mysqli_query($conn,$sql);
                                          if ($result) {
                                            if (mysqli_num_rows($result)>0) {
                                              $srNo = 1;
                                              while($row = mysqli_fetch_array($result)){
                                                $productImagePath = $row['product_image'];
                                                $productPrice = $row['order_detail_productQty']*$row['order_detail_productPrice'];
                                                ?>
                                                <tr class="text-dark">
                                                  <td><?php echo $srNo; ?></td>
                                                  <td class="text-center">
                                                    <?php if($productImagePath !="" && file_exists($productImagePath)){
                                                      ?>
                                                      <div class="mb-2">
                                                        <img src="<?php echo $productImagePath; ?>" class="img-thumbnail mx-auto" style="display: block; width: 50px; height:50px;">
                                                      </div>
                                                      <?php
                                                    }  ?>
                                                    <span class="badge badge-dark text-white"><?php echo $row['product_name']; ?></span>
                                                  </td>
                                                  <td><?php echo $row['order_detail_productQty']; ?></td>
                                                  <th><?php echo $productPrice." PKR"; ?></th>
                                                </tr>
                                                <?php
                                                $srNo++;
                                              }

                                            }else{
                                              ?>
                                              <div class="alert alert-info">No Product(s) Found</div>
                                              <?php
                                            }
                                          }
                                          ?>
                                          
                                        </table>
                                      </div>


                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="heading_container">
                                            <h2>
                                              Order Ratings
                                            </h2>
                                          </div>
                                          <?php if ($rateFlag == 1) { ?>
                                              <div class='rating-stars text-center'>
                                                <ul id='stars'>
                                                  <li class='star <?php if ($rateStars >= "1" ) {echo "selected";} ?>' title='Poor' data-value='1'>
                                                    <i class='fa fa-star'></i>
                                                  </li>
                                                  <li class='star <?php if ($rateStars >= "2") {echo "selected";} ?>' title='Fair' data-value='2'>
                                                    <i class='fa fa-star'></i>
                                                  </li>
                                                  <li class='star <?php if ($rateStars >= "3") {echo "selected";} ?>' title='Good' data-value='3'>
                                                    <i class='fa fa-star'></i>
                                                  </li>
                                                  <li class='star <?php if ($rateStars >= "4") {echo "selected";} ?>' title='Excellent' data-value='4'>
                                                    <i class='fa fa-star'></i>
                                                  </li>
                                                  <li class='star <?php if ($rateStars >= "5") {echo "selected";} ?>' title='WOW!!!' data-value='5'>
                                                    <i class='fa fa-star'></i>
                                                  </li>
                                                </ul>
                                              </div>
                                              <div>
                                                <p><?php echo $rateDescription; ?></p>
                                              </div>
                                          <?php }else{ ?>
                                              <div class="alert alert-info">
                                                No Rating Found
                                              </div>
                                          <?php } ?>
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