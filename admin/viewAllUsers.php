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

<!-- Datatable -->
    <link href="./vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

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
                            <h4>View All Users</h4>
                            <p class="mb-0">See Listing of all <?php echo $userTypeTitle; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View <?php echo $userTypeTitle; ?></a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View All <?php echo $userTypeTitle; ?> Details</h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION['successMessage'])) {
                                    ?>
                                    <div class="alert alert-success">
                                        <?php echo $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?>
                                    </div>
                                    <?php
                                } ?>


                                <?php if (isset($_SESSION['errorMessage'])) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?>
                                    </div>
                                    <?php
                                } ?>




                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $sql = "SELECT * FROM `tbl_users` WHERE `user_type` = '$userType' ORDER BY `user_id` DESC";
                                        $result = mysqli_query($conn,$sql);

                                        if($result){
                                            if(mysqli_num_rows($result)>0){
                                                $srNo = 1;
                                                ?>
                                                <tbody>
                                                    <?php
                                                    while($row = mysqli_fetch_array($result)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td><?php echo $row['user_name'] ?></td>
                                                            <td><?php echo $row['user_email']; ?></td>
                                                            <td>
                                                                <?php if($row['user_image'] != "" && file_exists($row['user_image'])){
                                                                    ?>
                                                                    <img style="width: 100px;height: 100px;" src="<?php echo $row['user_image']; ?>">
                                                                    <?php
                                                                }else{
                                                                    echo "N/A";
                                                                } ?>
                                                            </td>
                                                            <td><?php echo getStatusTitle($row['user_status']); ?></td>
                                                            <td>
                                                                <a href="editUser.php?userID=<?php echo $row['user_id']; ?>&userType=<?php echo $userType; ?>" class="btn btn-sm btn-success">Edit</a>
                                                                <a href="deleteUser.php?userID=<?php echo $row['user_id']; ?>&userType=<?php echo $userType; ?>" class="btn btn-sm btn-danger delete-confirm">Delete</a>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        $srNo++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <?php

                                            }else{
                                                ?>
                                                <div class="alert alert-info">
                                                    No User(s) Found.
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                        
                                            
                                        <tfoot>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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

    <!-- Datatable -->
    <script src="./vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="./js/plugins-init/datatables.init.js"></script>


     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
            title: 'Are you sure delete this <?php echo $userTypeTitle; ?>?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });
    </script>
</body>

</html>