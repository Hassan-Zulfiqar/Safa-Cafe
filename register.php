<?php require "includes/head.php"; 
if (checkLogin() === true) {
  header("location:index.php");
  exit();
}
?>
<?php $userName = $userEmail = $userPassword = $userConfirmPassword = $userImage = $userAddress = $userContactNo = $userType = ""; 
$userNameErr = $userContactNoErr = $userAddressErr = $userEmailErr = $userImageErr = $userTypeErr = $userPasswordErr = $userConfirmPasswordErr = "";

if (isset($_POST['addNewUserBtn'])) {
    if (empty($_POST['userName'])) {
        $userNameErr = "Please enter Full Name.";
    }else{
        $userName = mysqli_real_escape_string($conn,$_POST['userName']);
    }

    if (empty($_POST['userEmail'])) {
        $userEmailErr = "Please enter Email.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
        if (checkUserEmailExist($userEmail) > 0) {
            $userEmailErr = "Sorry, ".$userEmail. " already Exists.";
        }
    }

    if (empty($_POST['userPassword'])) {
        $userPasswordErr = "Please enter User Password.";
    }else{
        $userPassword = mysqli_real_escape_string($conn,$_POST['userPassword']);
        
    }

    if (empty($_POST['userConfirmPassword'])) {
        $userConfirmPasswordErr = "Please enter User Confirm Password.";
    }else{
        $userConfirmPassword = mysqli_real_escape_string($conn,$_POST['userConfirmPassword']);
        
    }

    if($userConfirmPassword != $userPassword){
      $userPasswordErr = "Password Not Matched.";
    }else{
      $userPassword = md5($userPassword);
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
                  $userImage = $target_file;

              } else {
                $userImageErr = "Sorry, there was an error uploading your file.";
              }
          

          }

                
          
        
      }
    if ($userNameErr == "" && $userContactNoErr == "" && $userAddressErr == "" && $userEmailErr == "" && $userImageErr == "" && $userAddressErr == "" && $userTypeErr == "" && $userPasswordErr == "" && $userConfirmPasswordErr == "")  {
        $userStatus = "A";
        $userType = "C";
        
        $userCreatedDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `tbl_users` (`user_name`,`user_email`,`user_password`,`user_type`,`user_image`,`user_contactno`,`user_address`,`user_status`,`user_createdDate`) VALUES ('$userName','$userEmail','$userPassword','$userType','$userImage','$userContactNo','$userAddress','$userStatus','$userCreatedDate')";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Customer Account has been created Successfully";
            header("location:login.php");
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
              Register as Customer
            </h2>
          </div>
          <div class="form_container">
            <form action="register.php" method="POST" enctype="multipart/form-data">
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
                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userPasswordErr; ?></div>
                  <input type="password" name="userPassword" id="userPassword" class="form-control" placeholder="Your Password" />
                </div>
                <div class="col-lg-6">

                  <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userConfirmPasswordErr; ?></div>
                  <input type="password" name="userConfirmPassword" id="userConfirmPassword" class="form-control" placeholder="Confirm Password" />
                </div>

              </div>                                    
              
              <div class="row">
                  <div class="col-lg-6">
                      <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userContactNoErr; ?></div>
                      <input type="tel" class="form-control" id="userContactNo" name="userContactNo" placeholder="Enter User Contact No" value="<?php echo $userContactNo; ?>">
                  </div>
                  <div class="col-lg-6">
                    <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userImageErr; ?></div>
                    <input type="file" class="form-control" id="val-user-image" name="val-user-image" placeholder="Upload user image">
                  </div>
              </div>
              
              

              
              <div>
                <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userAddressErr; ?></div>
                <textarea class="form-control" rows="4" name="userAddress" placeholder="Enter User Address"><?php echo $userAddress; ?></textarea>
                
              </div>
              <div class="btn_box">
                <button type="submit" class="float-right" name="addNewUserBtn">
                  Register
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