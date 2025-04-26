<?php require "includes/head.php"; 
if (getUserType() != "A" && getUserType() != "S"  ) {
    header("location:index.php");
    exit();
}
?>

<?php 
$userName = $userEmail = $userImage= $userAddress = $userContactNo ="";
$type = "U";
$userNameErr = $userEmailErr = $userImageErr = $passwordErr=  $userContactNoErr = $userAddressErr ="";

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM `tbl_users` WHERE `user_id` = '$userID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $userName = $row['user_name'];
                $userImage = $row['user_image'];
                $userImageOld = $row['user_image'];
                $userContactNo = $row['user_contactno']; 
                $userEmail = $row['user_email'];
                $userAddress = $row['user_address'];

            }
        }else{
            header("location:index.php");
            exit();
        }
    }
}

if (isset($_POST['updatePasswordBtn'])) {
    if (empty($_POST['val-userName'])) {
        $userNameErr = "Please enter User Name.";
    }else{
        $userName = mysqli_real_escape_string($conn,$_POST['val-userName']);
        
    }

    if (empty($_POST['val-userEmail'])) {
        $userEmailErr = "Please enter New Password.";
    }else{
        $userEmail = mysqli_real_escape_string($conn,$_POST['val-userEmail']);
        if (checkUserEmailExist($userEmail,$_SESSION['userID']) > 0) {
            $userEmailErr = "Email Already Exist.";
        }
        
    }

    if ($_SESSION['userType'] == "S") {
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
    }

    if( basename($_FILES["val-userIamge"]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["val-userIamge"]["name"]); //uploads/12131231-abc.jpg 
       
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            
          if (file_exists($target_file)) {
              $userImageErr =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES["val-userIamge"]["size"] > 500000) {
              $userImageErr = "File is too large";
          }


         
          
        if ($userImageErr == "") {

          if (move_uploaded_file($_FILES["val-userIamge"]["tmp_name"], $target_file)) {
              //your query with file path
                if ($userImage != "" && file_exists($userImage)) {
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



    
    if ($userNameErr == "" && $userEmailErr == "" && $userImageErr == "")  {
        $userUpdateDate = date("Y-m-d H:i:s");
        $userID = $_SESSION['userID'];
        $_SESSION['userImage']=$userImage;

        $sql = "UPDATE `tbl_users` SET `user_name` = '$userName',`user_email`='$userEmail',`user_image`='$userImage',`user_updatedDate` = '$userUpdateDate',`user_contactno` = '$userContactNo',`user_address` = '$userAddress' WHERE `user_id` = '$userID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Profile Updated Successfully";
            header("location:myProfile.php");
            exit();
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
                            <h4>My Profile</h4>
                            <p class="mb-0">Update Profile</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Profie</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Profile</h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION['successMessage'])) {
                                    ?>
                                    <div class="alert alert-success">
                                        <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
                                    </div>
                                    <?php
                                } ?>
                                <form class="form-valide" action="myProfile.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-userName">Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-userName" name="val-userName" placeholder="Enter a Name.." value="<?php echo $userName; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userNameErr; ?></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-userEmail">Email
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="email" class="form-control" id="val-userEmail" name="val-userEmail" placeholder="Enter a Email.." value="<?php echo $userEmail; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userEmailErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-userIamge">Image 
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input type="file" class="form-control" id="val-userIamge" name="val-userIamge" placeholder="..Upload user image">
                                                        
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $userImageErr; ?></div>
                                                    </div>
                                                    <?php if ($userImage !="" && file_exists($userImage)) {
                                                        ?>
                                                        <div class="col-lg-1">
                                                            <img src="<?php echo $userImage; ?>" style="width: 50px; height: 50px;">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php if($_SESSION['userType'] == "S"){
                                                    ?>
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
                                                    <?php
                                                } ?>
                                                
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updatePasswordBtn">Update Profile</button>
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
                "val-userName": {
                    required: !0,
                    minlength: 3
                },
                "val-userEmail": {
                    required: !0,
                    email: true
                },
                <?php if($_SESSION['userType']=="S"){ ?>
                    "userContactNo": {
                        required: !0
                    },
                    "userAddress": {
                        required: !0,
                    },
                <?php } ?>

                
            },
            messages: {
                "val-userName": {
                    required: "Please enter a User Name",
                    minlength: "Your User Name must consist of at least 3 characters"

                },
                "val-userEmail": {
                    required: "Please enter a User Email",
                },
                <?php if($_SESSION['userType']=="S"){ ?>
                    "userContactNo": {
                        required: "Please provide a User Contact No",
                    },
                    "userAddress": {
                        required: "Please provide a User Address",
                    },
                <?php } ?>
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