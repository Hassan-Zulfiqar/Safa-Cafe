<div class="header">
<div class="header-content">
    <nav class="navbar navbar-expand">
        <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">
                <div class="search_bar dropdown">
                    <!-- <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                    <div class="dropdown-menu p-0 m-0">
                        <form>
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        </form>
                    </div> -->
                </div>
            </div>

            <ul class="navbar-nav header-right" >
                <?php 
                $notiForID = $_SESSION['userID'];
                $notiFor = $_SESSION['userType'];
                $sql = "SELECT * FROM `tbl_notifications` WHERE `notification_for` = '$notiFor' AND `notification_forID` = '$notiForID' AND `notification_status` = '0' ORDER BY `notification_id` DESC" ;

                $result = mysqli_query($conn,$sql);
                $totalNotifications = mysqli_num_rows($result);


                ?>
                <li class="nav-item dropdown notification_dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                        <i class="mdi mdi-bell"></i>
                        <?php if($totalNotifications>0){ ?>
                            <div class="pulse-css"></div>
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="list-unstyled" style="height:300px; overflow-y:scroll; overflow-x:hidden;">
                            <?php if ($totalNotifications>0) {
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
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-shopping-cart"></i></span>
                                            <div class="media-body">
                                                <a href="<?php echo $notiUrl; ?>">
                                                    <p><?php echo $notiTitle; ?></p>
                                                </a>
                                            </div>
                                            <span class="notify-time"><?php echo $timeAgo; ?></span>
                                        </li>
                                        
                                        <?php

                                    }
                            } ?>
                            
                        </ul>
                        <a class="all-notification" href="viewAllNotifications.php">See all notifications <i
                                class="ti-arrow-right"></i></a>
                    </div>
                </li>
                <li class="nav-item dropdown header-profile">
                    <a class="nav-link" href="javascript:;" role="button" data-toggle="dropdown">
                        <?php if (isset($_SESSION['userImage']) && file_exists($_SESSION['userImage'])) {
                            ?>
                            <img src="<?php echo $_SESSION['userImage']; ?>" style="width: 30px; height:30px; border-radius: 100px;">
                            <?php
                        }else{
                            ?>
                                <i class="mdi mdi-account"></i>

                            <?php
                        } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="myProfile.php" class="dropdown-item">
                            <i class="icon-user"></i>
                            <span class="ml-2">Profile </span>
                        </a>
                        <a href="changePassword.php" class="dropdown-item">
                            <i class="icon-key"></i>
                            <span class="ml-2">Change Password </span>
                        </a>
                        <a href="logout.php" class="dropdown-item">
                            <i class="icon-logout"></i>
                            <span class="ml-2">Logout </span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
</div>