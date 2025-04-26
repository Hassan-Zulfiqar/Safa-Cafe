<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}
$userType = $userTypeTitle = "";
if (isset($_GET['userType']) && $_GET['userType'] != "") {
    $userType = $_GET['userType'];
    if ($userType == "C") {
        $userTypeTitle = "Customer";
    }else if ($userType == "S") {
        $userTypeTitle = "Staff";
    }else{
        header("location:index.php");
        exit();
    }
}else{
    header("location:index.php");
    exit();
}
?>

<?php 
$userName = $userEmail = $userPassword = $userImage = $userAddress = $userContactNo = $userStatus = "";

$userNameErr = $userContactNoErr = $userAddressErr = $userEmailErr = $userImageErr = $userStatusErr ="";

if (isset($_GET['userID']) && is_numeric($_GET['userID']) && $_GET['userID'] != "") {
    $userID = $_GET['userID'];

    $sql = "SELECT * FROM `tbl_users` WHERE `user_id` = '$userID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $userName = $row['user_name'];
                $userEmail = $row['user_email'];
                $userContactNo = $row['user_contactno'];
                $userAddress = $row['user_address'];
                $userStatus = $row['user_status'];
                $userImage = $row['user_image'];
                $olduserImage = $row['user_image'];
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllUsers.php?userType=".$userType);
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllUsers.php?userType=".$userType);
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:viewAllUsers.php?userType=".$userType);
    exit();
}



if (isset($_POST['updateUserBtn'])) {
    if (empty($_POST['userName'])) {
        $userNameErr = "Please enter Full Name.";
    }else{
        $userName = mysqli_real_escape_string($conn,$_POST['userName']);
    }

    if (empty($_POST['userEmail'])) {
        $userEmailErr = "Please enter Email.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['userEmail']);
        if (checkUserEmailExist($userEmail,$userID) > 0) {
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

    if (empty($_POST['userStatus'])) {
        $userStatusErr = "Please Select User Status.";
    }else{
        $userStatus = mysqli_real_escape_string($conn,$_POST['userStatus']);
        
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
      }else{
        $userImage = $olduserImage;
      }
    if ($userNameErr == "" && $userContactNoErr == "" && $userAddressErr == "" && $userEmailErr == "" && $userImageErr == "" && $userAddressErr == "" && $userStatusErr == "")  {
        $userUpdatedDate = date("Y-m-d H:i:s");
        $sql = "UPDATE `tbl_users` SET `user_name` = '$userName', `user_email` = '$userEmail', `user_image` = '$userImage', `user_contactno`='$userContactNo', `user_address`='$userAddress', `user_status`='$userStatus', `user_updatedDate` = '$userUpdatedDate' WHERE `user_id` = '$userID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if($userType == "S"){
                $_SESSION['successMessage'] = "Staff Updated Successfully";
                header("location:viewAllUsers.php?userType=".$userType);
                exit();    
            }else if($userType == "C"){
                $_SESSION['successMessage'] = "Customer Updated Successfully";
                $_SESSION['successMessage'] = "Customer Updated Successfully";
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
                            <h4>Update User</h4>
                            <p class="mb-0">Update Details of Your <?php echo $userTypeTitle; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Update <?php echo $userTypeTitle; ?></a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update <?php echo $userTypeTitle; ?> Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="editUser.php?userID=<?php echo $userID; ?>&userType=<?php echo $userType; ?>" method="post" enctype="multipart/form-data">
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
                                                    <label class="col-lg-4 col-form-label" for="val-email">User Status <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="userStatus" id="userStatus">
                                                            <option value="">Select Status</option>
                                                            <option value="A" <?php if($userStatus == "A"){echo "selected";} ?>>Active</option>
                                                            <option value="B" <?php if($userStatus == "B"){echo "selected";} ?>>Blocked</option>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userStatusErr; ?></div>

                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-user-image">User Image 
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input type="file" class="form-control" id="val-user-image" name="val-user-image" placeholder="..Upload user image">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userImageErr; ?></div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <?php if($userImage != "" && file_exists($userImage)){
                                                            ?>
                                                                <img src="<?php echo $userImage; ?>" style="width: 50px; height:50px;">
                                                            <?php
                                                        } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updateUserBtn">Submit</button>
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
                },"userStatus": {
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
                "userStatus": {
                    required: "Please Select a User Status",
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