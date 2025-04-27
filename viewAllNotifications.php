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
              All Notifications
            </h2>
          </div>
          <div class="form_container">
            <?php
             $notiForID = $_SESSION['customerID'];
            $notiFor = "U";
            $sql = "SELECT * FROM `tbl_notifications` WHERE `notification_for` = '$notiFor' AND `notification_forID` = '$notiForID' ORDER BY `notification_id` DESC" ; 
                $result = mysqli_query($conn,$sql);
                if($result){
                  if(mysqli_num_rows($result)>0){
                    ?>
                     <table id="cateTbl" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Sr #</th>
                          <th>Title</th>
                          <th>Date & Time</th>
                          <th>Action</th>
                          
                          
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                          $srNO = 1;
                          while($row = mysqli_fetch_assoc($result)){
                            $notiID = $row['notification_id'];
                            $notiTitle = $row['notification_title'];
                            $notiType= $row['notification_type'];
                            $notiTypeID = $row['notification_typeID'];
                            $notiUrl = "javascript:;";
                            if ($notiType == "O") {
                                $notiUrl = "myOrderDetails.php?orderID=".$notiTypeID."&notiID=".$notiID;
                            }else if ($notiType == "T") {
                                $notiUrl = "tablReservationDetails.php?reservationID=".$notiTypeID."&notiID=".$notiID;
                            }else{
                                $notiUrl = "javascript:;";
                            }
                            $notiDateTime = $row['notification_date'];
                            $notiTime = date("h:i A",strtotime($notiDateTime));
                            $notiDate = date("d-m-Y",strtotime($notiDateTime));
                            $timeAgo =timeago($notiDateTime);
                          ?>
                            <tr>
                              <td ><?php echo $srNO; ?></td>
                              <td><?php echo $notiTitle; ?></td>
                              <td><?php echo $notiDate." - ".$notiTime ; ?></td>
                              <td>
                                <a class="btn btn-success btn-sm" href="<?php echo $notiUrl; ?>">Details</a> 
                                
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
                      No Notification(s) Found.
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