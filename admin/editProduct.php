<?php require "includes/head.php"; 
if (getUserType() != "A") {
    header("location:index.php");
    exit();
}
?>

<?php 
$productName = $productImage = $productCategoryID = $productSubCategoryID = $productPrice = $productDescription = $productStatus = "";
$productDiscount = "0";
$productNameErr = $productImageErr = $productCategoryIDErr = $productSubCategoryIDErr = $productPriceErr = $productDiscountErr = $productDescriptionErr = $productStatusErr = "";


if (isset($_GET['productID']) && is_numeric($_GET['productID']) && $_GET['productID'] != "") {
    $productID = $_GET['productID'];

    $sql = "SELECT * FROM `tbl_products` WHERE `product_id` = '$productID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $productName = $row['product_name'];
                $productImage = $row['product_image'];
                $productStatus = $row['product_status'];
                $oldproductImage = $row['product_image'];
                $productPrice = $row['product_price'];
                $productDiscount = $row['product_discount'];
                $productDescription = $row['product_description'];
                
                $productCategoryID = $row['product_categoryID'];

                // $_SESSION['productCategoryID'] = $productCategoryID;
                // $productSubCategoryID = $row['product_subCategoryID'];
                // $_SESSION['productSubCategoryID'] = $productSubCategoryID;
            }    
        }else{
            $_SESSION['errorMessage'] = "Access Denied....!";
            header("location:viewAllProducts.php");
            exit();
        }
    }else{
        $_SESSION['errorMessage'] = "Access Denied....!";
        header("location:viewAllProducts.php");
        exit();
    }
}else{
    $_SESSION['errorMessage'] = "Access Denied....!";
    header("location:viewAllProducts.php");
    exit();
}


if (isset($_POST['updateProductBtn'])) {
    if (empty($_POST['val-productName'])) {
        $productNameErr = "Please enter Product Name.";
    }else{
        $productName = mysqli_real_escape_string($conn,$_POST['val-productName']);
        // if (checkCategoryExist($productName)>0) {
        //     $productNameErr = "Product Name already Exist.";
        // }
    }

    if (empty($_POST['val-productCategoryID']) ) {
        $productCategoryIDErr = "Please Select Product Category.";
    }else{
        $productCategoryID = mysqli_real_escape_string($conn,$_POST['val-productCategoryID']);
        $_SESSION['productCategoryID'] = $productCategoryID;
    }

    // if (empty($_POST['val-productSubCategoryID']) ) {
    //     $productSubCategoryIDErr = "Please Select Product Sub Category.";
    // }else{
    //     $productSubCategoryID = mysqli_real_escape_string($conn,$_POST['val-productSubCategoryID']);
    //     $_SESSION['productSubCategoryID'] = $productSubCategoryID;
    // }

    if (empty($_POST['val-productDescription']) ) {
        $productDescriptionErr = "Please Enter Product Description.";
    }else{
        $productDescription = mysqli_real_escape_string($conn,$_POST['val-productDescription']);
    }

    if (empty($_POST['val-productPrice']) || !is_numeric($_POST['val-productPrice']) || $_POST['val-productPrice'] == 0 || $_POST['val-productPrice'] < 0 ) {
        $productPriceErr = "Please enter Valid Product Price.";
    }else{
        $productPrice = mysqli_real_escape_string($conn,$_POST['val-productPrice']);
    }


    if ($_POST['val-productDiscount'] < 0 ) {
        $productDiscountErr = "Please enter Valid Product Discount.";
    }else{
        $productDiscount = mysqli_real_escape_string($conn,$_POST['val-productDiscount']);
    }

    if( basename($_FILES["val-productImage"]["name"] != "")){

        $target_dir = "uploads/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["val-productImage"]["name"]); //uploads/12131231-abc.jpg 
       
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            
          if (file_exists($target_file)) {
              $productImageErr =  "Sorry, file already exists";
          }

          //Check file size
          if ($_FILES["val-productImage"]["size"] > 500000000) {
              $productImageErr = "File is too large";
          }


         
          
          if ($productImageErr == "") {

              if (move_uploaded_file($_FILES["val-productImage"]["tmp_name"], $target_file)) {
                  //your query with file path
                  $productImage = $target_file;

              } else {
                $productImageErr = "Sorry, there was an error uploading your file.";
              }
          

          }

      }else{
        $productImage = $oldproductImage;
      }
    if ($productNameErr == "" && $productImageErr == "" && $productDiscountErr == "" && $productPriceErr == "" && $productDescriptionErr == "" && $productCategoryIDErr == "" && $productSubCategoryIDErr == "")  {
        
        $productUpdatedDate = date("Y-m-d H:i:s");

        $sql = "UPDATE `tbl_products` SET `product_name` = '$productName',`product_categoryID` = '$productCategoryID',`product_subCategoryID` = '$productSubCategoryID',`product_discount` = '$productDiscount',`product_price` = '$productPrice',`product_description` = '$productDescription',`product_image` = '$productImage',`product_status` = '$productStatus', `product_updatedDate` = '$productUpdatedDate' WHERE `product_id` = '$productID'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            // unset($_SESSION['productCategoryID']);
            // unset($_SESSION['productSubCategoryID']);

            $_SESSION['successMessage'] = "Product Updated Successfully";
            header("location:viewAllProducts.php");
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
                            <h4>Update Product</h4>
                            <p class="mb-0">Update Details of Your Product</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Products</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Product</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Product Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-valide" action="editProduct.php?productID=<?php echo $productID; ?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-productName">Product Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-productName" name="val-productName" placeholder="Enter a Product Name.." value="<?php echo $productName; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productNameErr; ?></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Product Category <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <!-- onchange="getSubCate()" -->
                                                        <select  class="form-control" name="val-productCategoryID" id="val-productCategoryID">
                                                            <option value="">Select Category</option>
                                                            <?php
                                                            $sql = "SELECT * FROM `tbl_categories` WHERE `category_status` = 'A' ORDER BY `category_id` DESC";
                                                            $result = mysqli_query($conn,$sql);
                                                            if ($result) {
                                                                if (mysqli_num_rows($result)>0) {
                                                                    while($row=mysqli_fetch_assoc($result)){
                                                                        ?>
                                                                        <option value="<?php echo $row['category_id']; ?>" <?php if($productCategoryID == $row['category_id']){echo "selected";} ?>><?php echo $row['category_name']; ?></option>
                                                                        <?php 
                                                                    }
                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productCategoryIDErr; ?></div>

                                                    </div>
                                                </div>


                                                <!-- <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Product Sub Category <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="val-productSubCategoryID" id="val-productSubCategoryID">
                                                            <option value="">Select Sub Category</option>
                                                            

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productSubCategoryIDErr; ?></div>

                                                    </div>
                                                </div> -->
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-productImage">Product Price  <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="number" class="form-control" id="val-productPrice" name="val-productPrice" placeholder="Product Price" value="<?php echo $productPrice; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productPriceErr; ?></div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-productImage">Product Discount 
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="number" class="form-control" id="val-productDiscount" name="val-productDiscount" placeholder="Product Discount" min="0" value="<?php echo $productDiscount; ?>">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productDiscountErr; ?></div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-productImage">Product Image  <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input type="file" class="form-control" id="val-productImage" name="val-productImage" placeholder="..Upload user image">
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productImageErr; ?></div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <?php if($productImage != "" && file_exists($productImage)){
                                                            ?>
                                                                <img src="<?php echo $productImage; ?>" style="width: 50px; height:50px;">
                                                            <?php
                                                        } ?>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-productImage">Product Description  <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="val-productDescription" id="val-productDescription" placeholder="Enter Product Description"><?php echo $productDescription; ?></textarea>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productDescriptionErr; ?></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Product Status <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="val-productStatus" id="val-productStatus">
                                                            <option value="">Select Status</option>
                                                            <option value="A" <?php if($productStatus == "A"){echo "selected";} ?>>Active</option>
                                                            <option value="B" <?php if($productStatus == "B"){echo "selected";} ?>>Blocked</option>

                                                        </select>
                                                        <div id="" class="invalid-feedback animated fadeInUp" style="display: block;"><?php echo $productStatusErr; ?></div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">

                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary" name="updateProductBtn">Update Product</button>
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
                "val-productName": {
                    required: !0,
                    minlength: 3
                },
                "val-productCategoryID": {
                    required: !0
                },
                // "val-productSubCategoryID": {
                //     required: !0
                // },
                "val-productPrice": {
                    required: !0
                },
                "val-productDescription":{
                    required: !0,
                    minlength: 50

                },
                "val-productStatus":{
                    required: !0
                }
            },
            messages: {
                "val-productName": {
                    required: "Please Enter a Product Name",
                    minlength: "Your Product Name must consist of at least 3 characters"
                },
                "val-productCategoryID": {
                    required: "Please Select a Product Category",
                },
                // "val-productSubCategoryID": {
                //     required: "Please Select a Product Sub Category",
                // },
                "val-productPrice": {
                    required: "Please Enter Product Valid Product Price",
                },
                "val-productDescription":{
                    required: "Please Enter Product Description",
                    minlength: "Your Product Description must consist of at least 50 characters"

                },
                "val-productStatus": {
                    required: "Please Select a Product Status",
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



<script type="text/javascript">
  <?php //if(isset($_SESSION['productCategoryID'])){
    ?>
    // getSubCate();
    <?php
//  } ?>

  // function getSubCate(){
  //   var cateID = $("#val-productCategoryID").val();
  //   $.ajax({
  //       url:"getSubcategories.php",
  //       type:"POST",
  //       data:{
  //         cateID: cateID
  //        },
  //       success:function(response) {
       
  //       document.getElementById("val-productSubCategoryID").innerHTML =response;
  //      },
  //      error:function(){
  //       alert("error");
  //      }

  //     });
  // }

</script>


</body>

</html>