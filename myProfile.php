<?php require "includes/head.php"; 
if (checkLogin() === false) {
  $_SESSION['errorMessage'] = "Please Login First to access profile.";
  header("location:login.php");
  exit();
}
?>
<?php $userName = $userEmail = $userPassword = $userConfirmPassword = $userImage = $userAddress = $userContactNo = $userType = ""; 
$userNameErr = $userContactNoErr = $userAddressErr = $userEmailErr = $userImageErr = $userTypeErr = $userPasswordErr = $userConfirmPasswordErr = "";

if (isset($_SESSION['customerID']) && is_numeric($_SESSION['customerID']) && $_SESSION['customerID'] != "") {
    $customerID = $_SESSION['customerID'];

    $sql = "SELECT * FROM `tbl_users` WHERE `user_id` = '$customerID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $userName = $row['user_name'];
                $userEmail = $row['user_email'];
                $userContactNo = $row['user_contactno'];
                $userAddress = $row['user_address'];
                $userStatus = $row['user_status'];
                $userImage = "admin/".$row['user_image'];
                $olduserImage = $row['user_image'];
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:login.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:login.php");
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:login.php");
    exit();
}


if (isset($_POST['updateProfileBtn'])) {
    if (empty($_POST['userName'])) {
        $userNameErr = "Please enter Full Name.";
    }else{
        $userName = mysqli_real_escape_string($conn,$_POST['userName']);
    }

    if (empty($_POST['userEmail'])) {
        $userEmailErr = "Please enter Email.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
        if (checkUserEmailExist($userEmail,$customerID) > 0) {
            $userEmailErr = "Sorry, ".$userEmail. " already Exists.";
        }
    }


    if (empty($_POST['userContactNo'])) {
        $userContactNoErr = "Please enter User Contact No.";
    }else{
        $userContactNo = mysqli_real_escape_string($conn,$_POST['userContactNo']);
        
    }

    if (empty($_POST['userAddress'])) {
        $userAddressErr = "Please enter User Addrress.";
    }else{
        $userAddress = mysqli_real_escape_string($conn,$_POST['userAddress']);
        
    }




    if( basename($_FILES["val-user-image"]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["val-user-image"]["name"]); //uploads/12131231-abc.jpg 
       
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            
          if (file_exists($target_file)) {
              $userImageErr =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES["val-user-image"]["size"] > 500000) {
              $userImageErr = "File is too large";
          }


         
          
          if ($userImageErr == "") {

              if (move_uploaded_file($_FILES["val-user-image"]["tmp_name"], "admin/".$target_file)) {
                  //your query with file path
                  if ($userImage != "admin/" && file_exists($userImage)) {
                    unlink($userImage);
                  }
                  $userImage = $target_file;

              } else {
                $userImageErr = "Sorry, there was an error uploading your file.";
              }
          }        
      }else{
        $userImage = $userImageOld;
      }
    if ($userNameErr == "" && $userContactNoErr == "" && $userAddressErr == "" && $userEmailErr == "" && $userImageErr == "" && $userAddressErr == "")  {
        $userUpdatedDate = date("Y-m-d H:i:s");
        $sql = "UPDATE `tbl_users` SET `user_name` = '$userName', `user_email` = '$userEmail', `user_image` = '$userImage', `user_contactno`='$userContactNo', `user_address`='$userAddress', `user_updatedDate` = '$userUpdatedDate' WHERE `user_id` = '$customerID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Customer Profile Updated Successfully";
            header("location:myProfile.php");
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
        <div class="col-md-6 offset-md-3 p-4 border" >
          <div class="heading_container">
            <h2>
              My Profile
            </h2>
          </div>
          <div class="form_container">
            <?php 
            if(isset($_SESSION['successMessage'])){
              ?>
              <div class="alert alert-success">
                <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']) ?>
              </div>
              <?php
            }

            if(isset($_SESSION['errorMessage'])){
              ?>
              <div class="alert alert-danger">
                <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']) ?>
              </div>
              <?php
            }

            ?>
            <form action="myProfile.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6">

                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userNameErr; ?></div>
                  <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter a Full Name" value="<?php echo $userName; ?>">
                </div>
                <div class="col-lg-6">

                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userEmailErr; ?></div>
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Your valid email" value="<?php echo $userEmail; ?>">

                </div>  
              </div>
                                               
              
              <div class="row">
                  <div class="col-lg-6">
                      <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userContactNoErr; ?></div>
                      <input type="tel" class="form-control" id="userContactNo" name="userContactNo" placeholder="Enter User Contact No" value="<?php echo $userContactNo; ?>">
                  </div>
                  <div class="col-lg-4">
                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userImageErr; ?></div>
                    <input type="file" class="form-control" id="val-user-image" name="val-user-image" placeholder="Upload user image">
                  </div>
                  <div class="col-lg-2">
                      <?php if($userImage != "admin/" && file_exists($userImage)){
                          ?>
                              <img src="<?php echo $userImage; ?>" style="width: 50px; height:50px;">
                          <?php
                      } ?>
                  </div>

              </div>
              
              

              
              <div>
                <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userAddressErr; ?></div>
                <textarea class="form-control" rows="4" name="userAddress" placeholder="Enter User Address"><?php echo $userAddress; ?></textarea>
                
              </div>
              <div class="btn_box">
                <button type="submit" class="float-right" name="updateProfileBtn">
                  Update Profile
                </button>
              </div>
            </form>
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

</body>

</html>