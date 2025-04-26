<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}

?>

<?php 
$categoryName  = $categoryStatus = $categoryImage = $categoryID = "";

$categoryNameErr = $categoryStatusErr = $categoryImageErr = "";

$subCategoryName  = $subCategoryStatus = $subCategoryImage = "";

$subCategoryNameErr = $subCategoryStatusErr = $subCategoryImageErr = "";

if (isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) && $_GET['categoryID'] != "") {
    $categoryID = $_GET['categoryID'];

    $sql = "SELECT * FROM `tbl_categories` WHERE `category_id` = '$categoryID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $categoryName = $row['category_name'];
                $categoryImage = $row['category_image'];
                $categoryStatus = $row['category_status'];
                $oldcategoryImage = $row['category_image'];
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllCategories.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllCategories.php");
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:viewAllCategories.php");
    exit();
}



if (isset($_GET['subCategoryID']) && is_numeric($_GET['subCategoryID']) && $_GET['subCategoryID'] != "") {
    $subCategoryID = $_GET['subCategoryID'];

    $sql = "SELECT * FROM `tbl_subcategories` WHERE `subcategory_id` = '$subCategoryID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $subCategoryName = $row['subcategory_name'];
                $subCategoryImage = $row['subcategory_image'];
                $subCategoryImageOld = $row['subcategory_image'];
                $subCategoryStatus = $row['subcategory_status'];
                
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllSubCategories.php?categoryID=".$categoryID);
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllSubCategories.php?categoryID=".$categoryID);
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:viewAllSubCategories.php?categoryID=".$categoryID);
    exit();
}


if (isset($_POST['updateSubCategoryBtn'])) {
    if (empty($_POST['val-subCategoryname'])) {
        $subCategoryNameErr = "Please enter Category Name.";
    }else{
        $subCategoryName = mysqli_real_escape_string($conn,$_POST['val-subCategoryname']);
        if (checkSubCategoryExist($subCategoryName,$categoryID,$subCategoryID)>0) {
            $subCategoryNameErr = "Sub Category Name already Exist.";
        }
    }


    if (empty($_POST['val-subCategoryStatus'])) {
        $subCategoryStatusErr = "Please Select Sub Category Status.";
    }else{
        $subCategoryStatus = mysqli_real_escape_string($conn,$_POST['val-subCategoryStatus']);
    }




    if( basename($_FILES["subCategoryImage"]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["subCategoryImage"]["name"]); //uploads/12131231-abc.jpg 
       
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            
          if (file_exists($target_file)) {
              $subCategoryImageErr =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES["categoryImage"]["size"] > 500000) {
              $subCategoryImageErr = "File is too large";
          }
          
          if ($subCategoryImageErr == "") {

              if (move_uploaded_file($_FILES["subCategoryImage"]["tmp_name"], $target_file)) {
                  //your query with file path
                  $subCategoryImage = $target_file;

              } else {
                $subCategoryImageErr = "Sorry, there was an error uploading your file.";
              }
          

          }
        
      }else{
        $subCategoryImage = $subCategoryImageOld;
      }
    if ($subCategoryNameErr == "" && $subCategoryStatusErr == "" && $subCategoryImageErr == "")  {
        $subCategoryUpdatedDate = date("Y-m-d H:i:s");
        
        $sql = "UPDATE `tbl_subcategories` SET `subcategory_name` = '$subCategoryName',`subcategory_status` = '$subCategoryStatus',`subcategory_image` ='$subCategoryImage',`subcategory_updatedDate`= '$subCategoryUpdatedDate' WHERE `subcategory_id` = '$subCategoryID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['successMessage'] = "Sub Category Updated Successfully";
            header("location:viewAllSubCategories.php?categoryID=".$categoryID);
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
                            <h4>Update Sub Category of <?php echo $categoryName; ?></h4>
                            <p class="mb-0">Update Details of Your Sub Category of <?php echo $categoryName; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Categories</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Sub Category</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Sub Category Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="editSubCategories.php?categoryID=<?php echo $categoryID; ?>&subCategoryID=<?php echo $subCategoryID; ?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-subCategoryname">Sub Category Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-subCategoryname" name="val-subCategoryname" placeholder="Enter a Category Name.." value="<?php echo $subCategoryName; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $subCategoryNameErr; ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Sub Category Status <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="val-subCategoryStatus" id="val-subCategoryStatus">
                                                            <option value="">Select Status</option>
                                                            <option value="A" <?php if($subCategoryStatus == "A"){echo "selected";} ?>>Active</option>
                                                            <option value="B" <?php if($subCategoryStatus == "B"){echo "selected";} ?>>Blocked</option>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $categoryStatusErr; ?></div>

                                                    </div>
                                                </div>
                                                    
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="subCategoryImage">Sub Category Image 
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input type="file" class="form-control" id="subCategoryImage" name="subCategoryImage" placeholder="..Upload Sub Category image">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $subCategoryImageErr; ?></div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <?php if($subCategoryImage != "" && file_exists($subCategoryImage)){
                                                            ?>
                                                                <img src="<?php echo $subCategoryImage; ?>" style="width: 50px; height:50px;">
                                                            <?php
                                                        } ?>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updateSubCategoryBtn">Update Sub Category</button>
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
                "val-subCategoryname": {
                    required: !0,
                    minlength: 3
                },
                "val-subCategoryStatus": {
                    required: !0
                },
            },
            messages: {
                "val-subCategoryname": {
                    required: "Please enter a Sub Category Name",
                    minlength: "Your Sub Category Name must consist of at least 3 characters"
                },
                "val-subCategoryStatus": {
                    required: "Please Select Sub Category Status",
                },
                
                
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