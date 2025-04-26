<?php require 'includes/connection.php'; 

require "includes/functions.php";

if (checkLogin() === true) {
    header("location:index.php");
    exit();
}

if (!isset($_SESSION["errors"]) || count($_SESSION['errors']) == 0) {
    $_SESSION['errors'] = array();
}


$email = $password = "";

if (isset($_POST['loginBtn'])) {
    if (empty($_POST['email'])) {
        array_push($_SESSION['errors'],"Email is Required");
    }else{
        $email = mysqli_real_escape_string($conn,$_POST['email']);
    }


    if (empty($_POST['password'])) {
        array_push($_SESSION['errors'],"Password is Required");
    }else{
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $password = md5($password);
    }


    if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
        $sql = "SELECT * FROM `tbl_users` WHERE `user_email` = '$email' AND `user_password` = '$password' ";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                if($row = mysqli_fetch_array($result)){
                    $_SESSION['userID'] = $row['user_id'];
                    $_SESSION['userFullName'] = $row['user_name'];
                    $_SESSION['userType'] = $row['user_type'];
                    $_SESSION['userEmail'] = $row['user_email'];
                    $_SESSION['userImage'] = $row['user_image'];


                    header("location:index.php");
                    exit();


                }
            }else{
                array_push($_SESSION['errors'],"Email or Password is incorrect, Please enter correct Email and Password.");

            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Safa Cafe | Admin Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>

                                    <?php if (isset($_SESSION['successMessage'])) {
                                        ?>
                                        <div class="alert alert-success">
                                            <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
                                        </div>
                                        <?php
                                    } ?>
                                    <?php if(isset($_SESSION['errors']) && count($_SESSION['errors'])>0){
                                        $errors = $_SESSION['errors'];
                                        foreach($errors as $error){
                                            ?>
                                            <div class="alert alert-danger text-white">
                                                <?php echo $error; ?>
                                            </div>
                                            <?php
                                        }
                                        unset($_SESSION['errors']);
                                    } ?>
                                    <form action="login.php" method="POST">
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="" placeholder="Enter Your Email" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="" placeholder="Enter Your Password" name="password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="loginBtn" class="btn btn-primary btn-block">Sign me in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>

</body>

</html>