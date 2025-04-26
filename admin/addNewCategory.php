<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}
?>

<?php 
$categoryName = $categoryImage = "";
$type = "U";
$categoryNameErr = $categoryImageErr = "";

if (isset($_POST['addNewCategoryBtn'])) {
    if (empty($_POST['val-categoryname'])) {
        $categoryNameErr = "Please enter Category Name.";
    }else{
        $categoryName = mysqli_real_escape_string($conn,$_POST['val-categoryname']);
        if (checkCategoryExist($categoryName)>0) {
            $categoryNameErr = "Category Name already Exist.";
        }
    }

    if( basename($_FILES["val-user-image"]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["val-user-image"]["name"]); //uploads/12131231-abc.jpg 
       
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            
          if (file_exists($target_file)) {
              $categoryImageErr =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES["val-user-image"]["size"] > 500000) {
              $categoryImageErr = "File is too large";
          }


         
          
          if ($categoryImageErr == "") {

              if (move_uploaded_file($_FILES["val-user-image"]["tmp_name"], $target_file)) {
                  //your query with file path
                  $categoryImage = $target_file;

              } else {
                $categoryImageErr = "Sorry, there was an error uploading your file.";
              }
          

          }

                
          
        
      }
    if ($categoryNameErr == "" && $categoryImageErr == "")  {
        $categoryStatus = "A";
        $categoryCreatedDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `tbl_categories` (`category_name`,`category_status`,`category_image`,`category_createdDate`) VALUES ('$categoryName','$categoryStatus','$categoryImage','$categoryCreatedDate')";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Category Added Successfully";
            header("location:viewAllCategories.php");
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
                            <h4>Add New Category</h4>
                            <p class="mb-0">Add Details of Your Category</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Category</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New Category Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="addNewCategory.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-categoryname">Category Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-categoryname" name="val-categoryname" placeholder="Enter a Category Name.." value="<?php echo $categoryName; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $categoryNameErr; ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-user-image">Category Image 
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="file" class="form-control" id="val-user-image" name="val-user-image" placeholder="..Upload user image">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $categoryImageErr; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="addNewCategoryBtn">Add New Category</button>
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
                "val-categoryname": {
                    required: !0,
                    minlength: 3
                },
                
            },
            messages: {
                "val-categoryname": {
                    required: "Please enter a Category Name",
                    minlength: "Your Category Name must consist of at least 3 characters"
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