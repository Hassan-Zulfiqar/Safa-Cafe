<?php require "includes/head.php"; 
if (checkLogin() === false) {
  $_SESSION['errorMessage'] = "Please Login First, to access this page";
  header("location:login.php");
  exit();
}

?>

<?php 
$oldPassword = $newPassword = $confirmPassword= "";
$type = "U";
$oldPasswordErr = $newPasswordErr = $confirmPasswordErr = $passwordErr= "";

if (isset($_POST['updatePasswordBtn'])) {
    if (empty($_POST['val-oldPassword'])) {
        $oldPasswordErr = "Please enter Old Password.";
    }else{
        $oldPassword = mysqli_real_escape_string($conn,$_POST['val-oldPassword']);
        if (checkOldPassword($oldPassword) == false) {
            $oldPasswordErr = "Old Password Not Matched.";
        }
    }

    if (empty($_POST['val-newPassword'])) {
        $newPasswordErr = "Please enter New Password.";
    }else{
        $newPassword = mysqli_real_escape_string($conn,$_POST['val-newPassword']);
        
    }

    if (empty($_POST['val-confirmPassword'])) {
        $confirmPasswordErr = "Please enter confirm Password.";
    }else{
        $confirmPassword = mysqli_real_escape_string($conn,$_POST['val-confirmPassword']);
    }

    if ($newPassword != $confirmPassword) {
        $passwordErr = "Password Not Matched.";
    }else{
        $password = md5($newPassword);
    }



    
    if ($oldPasswordErr == "" && $newPasswordErr == "" && $confPasswordErr == "" && $passwordErr == "")  {
        $userUpdateDate = date("Y-m-d H:i:s");
        $userID = $_SESSION['customerID'];

        $sql = "UPDATE `tbl_users` SET `user_password` = '$password',`user_updatedDate` = '$userUpdateDate' WHERE `user_id` = '$userID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Password Updated Successfully, Please Login with new Password";
            header("location:logout.php");
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
        <div class="col-md-6 offset-md-3 border p-4">
          <div class="heading_container">
            <h2>
              Change Password
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
            <form action="changePassword.php" method="POST">
              <div>
                <input type="password" class="form-control" id="val-oldPassword" name="val-oldPassword" placeholder="Enter a Old Password..">
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $oldPasswordErr; ?></p>
              </div>
              <div>
                <input type="password" class="form-control" id="val-newPassword" name="val-newPassword" placeholder="Enter a Old Password..">
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $newPasswordErr; ?></p>
              </div>

              <div>
                <input type="password" class="form-control" id="val-confirmPassword" name="val-confirmPassword" placeholder="Enter a Old Password..">
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $confirmPasswordErr; ?></p>
              </div>
              <div>
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $passwordErr; ?></p>
              </div>
              <div class="btn_box">
                <button type="submit" name="updatePasswordBtn" class="float-right">
                  Update Password
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