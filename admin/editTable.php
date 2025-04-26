<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}

?>

<?php 
$tableTitle  = $tableStatus = $tableSittingCapacity = $tableID = "";

$tableTitleErr = $tableStatusErr = $tableSittingCapacityErr = "";

if (isset($_GET['tableID']) && is_numeric($_GET['tableID']) && $_GET['tableID'] != "") {
    $tableID = $_GET['tableID'];

    $sql = "SELECT * FROM `tbl_tables` WHERE `table_id` = '$tableID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $tableTitle = $row['table_title'];
                $tableSittingCapacity = $row['table_sittingCapacity'];
                $tableStatus = $row['table_status'];
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllTables.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllTables.php");
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:viewAllTables.php");
    exit();
}



if (isset($_POST['updateTableBtn'])) {
    if (empty($_POST['val-tableTitle'])) {
        $tableTitleErr = "Please enter Table Title.";
    }else{
        $tableTitle = mysqli_real_escape_string($conn,$_POST['val-tableTitle']);
        if (checkTableExist($tableTitle,$tableID)>0) {
            $tableTitleErr = "Table Title already Exist.";
        }
    }
    if (empty($_POST['val-tableSittingCapacity'])) {
        $tableSittingCapacityErr = "Please enter Sitting Capacity.";
    }else{
        $tableSittingCapacity = mysqli_real_escape_string($conn,$_POST['val-tableSittingCapacity']);
        if (!is_numeric($tableSittingCapacity)) {
            $tableTitleErr = "Please Enter Valid Sitting Capacity Number.";
        }else if($tableSittingCapacity == 0 || $tableSittingCapacity < 0){
            $tableTitleErr = "Please Enter Valid Sitting Capacity Number.";
        }
    }

    if (empty($_POST['val-tableStatus'])) {
        $tableStatusErr = "Please Select Table Status.";
    }else{
        $tableStatus = mysqli_real_escape_string($conn,$_POST['val-tableStatus']);
    }




    if ($tableTitleErr == "" && $tableStatusErr == "" && $tableSittingCapacityErr == "")  {
        $tableUpdateDate = date("Y-m-d H:i:s");
        $sql = "UPDATE `tbl_tables` SET `table_title` = '$tableTitle', `table_status` = '$tableStatus', `table_sittingCapacity` = '$tableSittingCapacity',`table_updatedDate` = '$tableUpdateDate' WHERE `table_id` = '$tableID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Table Updated Successfully";
            header("location:viewAllTables.php");
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
                            <h4>Update Table</h4>
                            <p class="mb-0">Update Details of Your Table</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Table</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Table Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="editTable.php?tableID=<?php echo $tableID; ?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-tableTitle">Table Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-tableTitle" name="val-tableTitle" placeholder="Enter a Table Name.." value="<?php echo $tableTitle; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $tableTitleErr; ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-tableSittingCapacity">Table Sitting Capacity 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-tableSittingCapacity" name="val-tableSittingCapacity" placeholder="Enter a Table Sitting Capacity.." value="<?php echo $tableSittingCapacity; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $tableSittingCapacityErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Table Status <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="val-tableStatus" id="val-tableStatus">
                                                            <option value="">Select Status</option>
                                                            <option value="A" <?php if($tableStatus == "A"){echo "selected";} ?>>Active</option>
                                                            <option value="B" <?php if($tableStatus == "B"){echo "selected";} ?>>Blocked</option>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $tableStatusErr; ?></div>

                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updateTableBtn">Update Table</button>
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
                "val-tableTitle": {
                    required: !0,
                    minlength: 3
                },
                "val-tableStatus": {
                    required: !0
                },
                "val-tableSittingCapacity": {
                    required: !0,
                    number: true
                },
                
            },
            messages: {
                "val-tableTitle": {
                    required: "Please enter a Table Name",
                    minlength: "Your tableTitle must consist of at least 3 characters"
                },
                "val-tableStatus": {
                    required: "Please Select Table Status",
                },
                "val-tableSittingCapacity": {
                    required: "Please enter a Table Sitting Capacity"
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