<?php require "includes/head.php"; 
if (getUserType() != "A" && getUserType() != "S") {
    header("location:index.php");
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
        $userID = $_SESSION['userID'];

        $sql = "UPDATE `tbl_users` SET `user_password` = '$password',`user_updatedDate` = '$userUpdateDate' WHERE `user_id` = '$userID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Password Updated Successfully, Please Login with new Password";
            header("location:logout.php");
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
                            <h4>Change Password</h4>
                            <p class="mb-0">Update Your Password</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Change Password</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Password</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="changePassword.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-oldPassword">Old Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-oldPassword" name="val-oldPassword" placeholder="Enter a Old Password..">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $oldPasswordErr; ?></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-newPassword">New Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-newPassword" name="val-newPassword" placeholder="Enter a Old Password..">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $newPasswordErr; ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-confirmPassword">Confirm Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-confirmPassword" name="val-confirmPassword" placeholder="Enter a Old Password..">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $confirmPasswordErr; ?></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-confirmPassword"></label>
                                                    <div class="col-lg-6">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $passwordErr; ?></div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updatePasswordBtn">Update Password</button>
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
                "val-oldPassword": {
                    required: !0
                },
                "val-newPassword": {
                    required: !0
                },
                "val-confirmPassword": {
                    required: !0
                },
                
            },
            messages: {
                "val-oldPassword": {
                    required: "Please enter a Old Password",
                },
                "val-newPassword": {
                    required: "Please enter a New Password",
                },
                "val-confirmPassword": {
                    required: "Please enter a Confirm Password",
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