<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}
?>

<?php 
$userName = $userEmail = $userPassword = $userImage = $userAddress = $userContactNo = $userType = "";

$userNameErr = $userContactNoErr = $userAddressErr = $userEmailErr = $userImageErr = $userTypeErr ="";

if (isset($_POST['addNewUserBtn'])) {
    if (empty($_POST['userName'])) {
        $userNameErr = "Please enter Full Name.";
    }else{
        $userName = mysqli_real_escape_string($conn,$_POST['userName']);
        $userPassword = md5($userName);
    }

    if (empty($_POST['userEmail'])) {
        $userEmailErr = "Please enter Email.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
        if (checkUserEmailExist($userEmail) > 0) {
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

    if (empty($_POST['userType'])) {
        $userTypeErr = "Please Select User Type.";
    }else{
        $userType = mysqli_real_escape_string($conn,$_POST['userType']);
        
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

              if (move_uploaded_file($_FILES["val-user-image"]["tmp_name"], $target_file)) {
                  //your query with file path
                  $userImage = $target_file;

              } else {
                $userImageErr = "Sorry, there was an error uploading your file.";
              }
          

          }

                
          
        
      }
    if ($userNameErr == "" && $userContactNoErr == "" && $userAddressErr == "" && $userEmailErr == "" && $userImageErr == "" && $userAddressErr == "" && $userTypeErr == "")  {
        $userStatus = "A";
        $userCreatedDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `tbl_users` (`user_name`,`user_email`,`user_password`,`user_type`,`user_image`,`user_contactno`,`user_address`,`user_status`,`user_createdDate`) VALUES ('$userName','$userEmail','$userPassword','$userType','$userImage','$userContactNo','$userAddress','$userStatus','$userCreatedDate')";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if($userType == "S"){
                $staffID= mysqli_insert_id($conn);
                $userUpdatedDate = date("Y-m-d H:i:s");

                $sql = "UPDATE `tbl_users` SET `user_status` = 'B',`user_updatedDate` = '$userUpdatedDate' WHERE `user_type` = 'S' AND `user_id` != '$staffID'";
                $result = mysqli_query($conn,$sql);

                $_SESSION['successMessage'] = "Staff Added Successfully";
                header("location:viewAllUsers.php?userType=".$userType);
                exit();    
            }else if($userType == "C"){
                $_SESSION['successMessage'] = "Customer Added Successfully";
                header("location:viewAllUsers.php?userType=".$userType);
                exit();    
            }
            
        }
    }
} ?>

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
                            <h4>Add New User</h4>
                            <p class="mb-0">Add Details of Your User</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add User</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New User Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="addNewUser.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="userName">Full Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter a Full Name" value="<?php echo $userName; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userNameErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="userEmail">Email <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Your valid email" value="<?php echo $userEmail; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userEmailErr; ?></div>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="userContactNo">Contact #
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="tel" class="form-control" id="userContactNo" name="userContactNo" placeholder="Enter User Contact No" value="<?php echo $userContactNo; ?>">

                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userContactNoErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="userAddress">Address <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="4" name="userAddress" placeholder="Enter User Address"><?php echo $userAddress; ?></textarea>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userAddressErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">User Type <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="userType" id="userType">
                                                            <option value="">Select Type</option>
                                                            <option value="S" <?php if($userType == "S"){echo "selected";} ?>>Staff</option>
                                                            <option value="C" <?php if($userType == "C"){echo "selected";} ?>>Customer</option>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userTypeErr; ?></div>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-user-image">User Image 
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="file" class="form-control" id="val-user-image" name="val-user-image" placeholder="Upload user image">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userImageErr; ?></div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="addNewUserBtn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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



    <!-- Jquery Validation -->
    <script src="./vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <!-- <script src="./js/plugins-init/jquery.validate-init.js"></script> -->

    <script type="text/javascript">
        jQuery(".form-valide").validate({
            rules: {
                "userName": {
                    required: !0,
                    minlength: 3
                },
                "userEmail": {
                    required: !0,
                    email: !0
                },
                "userContactNo": {
                    required: !0
                },
                "userAddress": {
                    required: !0,
                },"userType": {
                    required: !0,
                },
                
            },
            messages: {
                "userName": {
                    required: "Please enter a Full Name",
                    minlength: "Your username must consist of at least 3 characters"
                },
                "userEmail": "Please enter a valid User email address",
                "userContactNo": {
                    required: "Please provide a User Contact No",
                },
                "userAddress": {
                    required: "Please provide a User Address",
                },
                "userType": {
                    required: "Please Select a User Type",
                }
                
            },

            ignore: [],
            errorClass: "invalid-feedback animated fadeInUp",
            errorElement: "div",
            errorPlacement: function(e, a) {
                jQuery(a).parents(".form-group > div").append(e)
            },
            highlight: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            },
            success: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            },
        });


        
    </script>

</body>

</html>