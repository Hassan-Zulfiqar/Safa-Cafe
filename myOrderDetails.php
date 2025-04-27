<?php require "includes/head.php"; 
if (checkLogin() === false) {
  header("location:login.php");
  exit();
}
if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
  $_SESSION['errors'] = array();
}

?>
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
        $orderDescription = $row['order_description'];
        
      }
    }else{
      $_SESSION['errorMessage'] = "Access Denied...!";
      header("location:myOrders.php");
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

if (isset($_POST['rateNow'])) {
  if (empty($_POST['rateStars'])) {
      array_push($_SESSION['errors'],'Please Select Stars');
  }else{
      $rateStars = mysqli_real_escape_string($conn,$_POST['rateStars']);
  }
  $rateDescription = mysqli_real_escape_string($conn,$_POST['rateDescription']);

  if(count($_SESSION['errors']) == 0 || !isset($_SESSION['errors'])){
    $rateDate = date("Y-m-d h:i:s");
    $userID = $_SESSION['customerID'];

    if($rateFlag == 1){
      $sql = "UPDATE `tbl_ratings` SET `rating_stars` = '$rateStars',`rating_description` = '$rateDescription',`rating_date` = '$rateDate' WHERE `rating_orderID` = '$orderID' AND `rating_userID` = '$userID'";
    }else{
      $sql = "INSERT INTO `tbl_ratings` (`rating_orderID`,`rating_userID`,`rating_stars`,`rating_description`,`rating_date`) VALUES ('$orderID','$userID','$rateStars','$rateDescription','$rateDate')";  
    }

    
    $result = mysqli_query($conn,$sql);
    if ($result) {
      $_SESSION['successMessage'] = "Rating has been added Successfully";
      header("location:myOrders.php");
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
        <div class="col-md-12">
          <?php 
            if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
              $errors = $_SESSION['errors'];
              foreach($errors as $error){
                ?>
                <div class="alert alert-danger">
                  <?php echo $error; ?>
                </div>
                <?php
              }
              unset($_SESSION['errors']);
            }
          ?>
        </div>
        <div class="col-md-5 p-4 border mr-1 ml-5" >
          <div class="heading_container">
            <h2>
              Order # <?php echo $orderNo; ?>
            </h2>
          </div>
          <div class="form_container">
            <table class="table table-bordered table-striped">
              <tr>
                <th>Order Type</th>
                <td><?php echo $orderTypeTitle; ?></td>
              </tr>
              <?php if($orderType == "PBO"){ ?>
                <tr>
                  <th>Order Delivery Date/Time</th>
                  <td><?php echo $orderPBODate." / ".$orderPBOTime; ?></td>
                </tr>
              <?php } ?>

              <tr>
                <th>Order Date</th>
                <td><?php echo $orderDate; ?></td>
              </tr>
              <tr>
                <th>Order Total Amount</th>
                <td><?php echo $orderTotalAmount; ?></td>
              </tr>

              <tr>
                <th>Order Status</th>
                <td><?php echo $orderStatusTitle; ?></td>
              </tr>
              
              <tr>
                <th>Order Delivered Date</th>
                <td><?php echo $orderDeliveryDate; ?></td>
              </tr>
            </table>
            <?php if ($orderDescription != "") { ?>
            <div class="row mb-3">
              <div class=col-md-12>
                <ul class="list-group">
                  <li class="list-group-item bg-warning text-white text-center">Order Description</li>
                  <li class="list-group-item">
                    <p class="text-justify">
                      <?php echo $orderDescription; ?>
                    </p>
                  </li>
                </ul>
              </div>
            </div>
            <?php } ?>
            
            <table class="table table-bordered table-striped">
              <tr class="bg-warning text-white text-center">
                <th colspan="2">Customer Details</th>
              </tr>
              <tr>
                <th>Name</th>
                <td><?php echo $orderCustomerName; ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?php echo  $orderCustomerEmail; ?></td>
              </tr>
              <tr>
                <th>Contact</th>
                <td><?php echo $orderCustomerContact; ?></td>
              </tr>

              <tr>
                <th>Address</th>
                <td><?php echo $orderCustomerAddress; ?></td>
              </tr>
            </table>
          </div>
        </div>
        
        <div class="col-md-6 p-4 border" >
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
                    $productImagePath = "admin/".$row['product_image'];
                    $productPrice = $row['order_detail_productQty']*$row['order_detail_productPrice'];
                    ?>
                    <tr>
                      <td><?php echo $srNo; ?></td>
                      <td class="text-center">
                        <?php if($productImagePath !="admin/" && file_exists($productImagePath)){
                          ?>
                          <div class="mb-2">
                            <img src="<?php echo $productImagePath; ?>" class="img-thumbnail mx-auto" style="display: block; width: 80px; height:80px;">
                          </div>
                          <?php
                        }  ?>
                        <span class="badge badge-warning text-white"><?php echo $row['product_name']; ?></span>
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

            <?php if ($orderStatus == "D") { ?>
            
              <div class="row ">
                <div class="col-md-12">
                  <div class="heading_container">
                    <h2>
                      Rate This Order
                    </h2>
                  </div>
                  <form action="" method="post" role="form" class="">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <input type="hidden" id="rateStars" name="rateStars">
                        
                        <!-- Rating Stars Box -->
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
                        
                      </div>
                    </div>
                    
                    <div class="form-group mt-3">
                      <textarea  class="form-control" name="rateDescription" style="height:150px;" placeholder="Message"><?php echo $rateDescription; ?></textarea>
                    </div>
                    
                    <div class="text-center mt-3 pb-3"><button type="submit" class="get-started-btn m-0 text-white w-100" name="rateNow">Rate Now</button></div>
                  </form>
                </div>
              </div>
            <?php } ?>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
  
        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
          var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
         
          // Now highlight all the stars that's not after the current hovered star
          $(this).parent().children('li.star').each(function(e){
            if (e < onStar) {
              $(this).addClass('hover');
            }
            else {
              $(this).removeClass('hover');
            }
          });
          
        }).on('mouseout', function(){
          $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
          });
        });
        
        
        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
          var onStar = parseInt($(this).data('value'), 10); // The star currently selected
          var stars = $(this).parent().children('li.star');

          $("#rateStars").val(onStar);
          
          for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
          }
          
          for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
          }
          
          
        });
        
        
      });


      
  </script>
</body>

</html>