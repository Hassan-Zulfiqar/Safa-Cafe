<?php require "includes/head.php"; 
if (checkLogin() === true) {
  header("location:index.php");
  exit();
}

?>

<?php 
$userEmail = $userPassword = ""; 
$userEmailErr = $userPasswordErr = "";

if (isset($_POST['loginBtn'])) {
    
    if (empty($_POST['userEmail'])) {
        $userEmailErr = "Please enter Email.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
        
    }

    if (empty($_POST['userPassword'])) {
        $userPasswordErr = "Please enter User Password.";
    }else{
        $userPassword = mysqli_real_escape_string($conn,$_POST['userPassword']);
        $userPassword= md5($userPassword);
        
    }

    if ( $userEmailErr == "" && $userPasswordErr == "" )  {
       $sql = "SELECT * FROM `tbl_users` WHERE `user_email` = '$userEmail' AND `user_password` = '$userPassword' AND `user_type` = 'C' ";
        $result = mysqli_query($conn,$sql);
        if ($result) {
          if (mysqli_num_rows($result) == 1) {
                if($row = mysqli_fetch_array($result)){
                  if ($row['user_status'] == "A") {
                    $_SESSION['customerID'] = $row['user_id'];
                    $_SESSION['customerFullName'] = $row['user_name'];
                    $_SESSION['customerType'] = $row['user_type'];
                    $_SESSION['customerEmail'] = $row['user_email'];
                    $_SESSION['customerImage'] = $row['user_image'];


                    header("location:index.php");
                    exit();
                  }else{
                    $_SESSION['errorMessage'] = "Your account has been Blocked by Admin.";

                  }
              }
            }else{
                $_SESSION['errorMessage'] = "Email or Password is incorrect, Please enter correct Email and Password.";

            }
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
              Login as Customer
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
            <form action="login.php" method="POST">
              <div>
                <input type="email" name="userEmail" id="userEmail" class="form-control" placeholder="Your Email" />
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userEmailErr; ?></p>
              </div>
              <div>
                <input type="password" name="userPassword" id="userPassword" class="form-control" placeholder="Your Password">
                <p id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userPasswordErr; ?></p>
              </div>
              <div class="btn_box">
                <button type="submit" name="loginBtn" class="float-right">
                  Login
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