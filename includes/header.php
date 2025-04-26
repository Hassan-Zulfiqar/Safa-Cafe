<header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>
              Safa Cafe
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item <?php if($pageName == "index.php"){ ?> active <?php } ?>">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item <?php if($pageName == "menu.php"){ ?> active <?php } ?>">
                <a class="nav-link" href="menu.php">Menu</a>
              </li>
              <li class="nav-item <?php if($pageName == "ourTables.php"){ ?> active <?php } ?>" >
                <a class="nav-link " href="ourTables.php">Book Table</a>
              </li>
            </ul>
            <div class="user_option">
              <a class="cart_link" href="cart.php">
                <i class="fa fa-shopping-cart text-warning" style="font-size: 20px;"></i>&nbsp;

                  <span id="cartCounter" class="badge badge-success">
                    <?php 
                      if (isset($_SESSION['cart'])) {
                        if (count($_SESSION['cart'])>0) {
                            echo count($_SESSION['cart']);
                        }
                      } 
                    ?>
                  </span>
              </a>

              <?php if(checkLogin() === true){
                ?>

                <?php 
                $notiForID = $_SESSION['customerID'];
                $notiFor = "U";
                $sql = "SELECT * FROM `tbl_notifications` WHERE `notification_for` = '$notiFor' AND `notification_forID` = '$notiForID' AND `notification_status` = '0' ORDER BY `notification_id` DESC" ;

                $result = mysqli_query($conn,$sql);
                $totalNotifications = mysqli_num_rows($result);


                ?>
                
                <div class="dropdown user_link" >
                  <i class="fa fa-bell" aria-hidden="true"></i> 
                  <span id="cartCounter" class="badge badge-success">
                    <?php 
                      
                        if ($totalNotifications > 0) {
                            echo $totalNotifications;
                        }
                       
                    ?>
                  </span>
                  <ul style="left: -80px;">
                    <?php if ($totalNotifications>0) {
                            while($row = mysqli_fetch_array($result)){
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
                    
                                <li class="border-bottom"><a style="font-size:11px;" href="<?php echo $notiUrl; ?>"><?php echo $notiTitle; ?></a></li>
                              <?php 
                              }
                            } ?>
                    <li style="background:#28a745 !important; text-align: center;"><a href="viewAllNotifications.php">View All Notification</a></li>

                  </ul>
                </div>
                &nbsp;
                &nbsp;
                <div class="dropdown user_link" >
                  <button style="background:#28a745 !important;">
                    <i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['customerFullName']; ?></button>
                  <ul>
                    <li><a href="myProfile.php">My Profile</a></li>
                    <li><a href="changePassword.php">Change Password</a></li>
                    <li><a href="myOrders.php">My Orders</a></li>
                    <li><a href="myTableReservations.php">My Table Reservations</a></li>

                    <li><a href="logout.php">Logout</a></li>

                  </ul>
                </div>
                <?php
              }else{
                ?>
                <div class="dropdown user_link" >
                  <button>
                    <i class="fa fa-user" aria-hidden="true"></i> Login/Registration</button>
                  <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Registration</a></li>
                  </ul>
                </div>
                <?php
              } ?>
              
             <!--  <a href="" class="user_link">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a> -->
              
              <!-- <form class="form-inline">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              <a href="" class="order_online">
                Order Online
              </a> -->
            </div>
          </div>
        </nav>
      </div>
    </header>