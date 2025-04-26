<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}
?>

<?php 
$tableTitle = $tableSittingCapacity = "";
$tableStatus = "A";
$tableTitleErr = $tableSittingCapacityErr = "";

if (isset($_POST['addNewTableBtn'])) {
    if (empty($_POST['val-tableTitle'])) {
        $tableTitleErr = "Please enter Table Title.";
    }else{
        $tableTitle = mysqli_real_escape_string($conn,$_POST['val-tableTitle']);
        if (checkTableExist($tableTitle)>0) {
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

    if ($tableTitleErr == "" && $tableSittingCapacityErr == "")  {
        $tableStatus = "A";
        $tableCreatedDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `tbl_tables` (`table_title`,`table_status`,`table_sittingCapacity`,`table_createdDate`) VALUES ('$tableTitle','$tableStatus','$tableSittingCapacity','$tableCreatedDate')";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Table Added Successfully";
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
                            <h4>Add New Table</h4>
                            <p class="mb-0">Add Details of Your Table</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Table</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New Table Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="addNewTable.php" method="post" enctype="multipart/form-data">
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
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="addNewTableBtn">Add New Table</button>
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
                "val-tableSittingCapacity": {
                    required: !0,            
                      number: true
                },
                
            },
            messages: {
                "val-tableTitle": {
                    required: "Please enter a Table Title",
                    minlength: "Your Table Title must consist of at least 3 characters"
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