<?php require "includes/head.php"; 
if (getUserType() != "A") {
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
                            <h4>View All Products</h4>
                            <p class="mb-0">See Listing of all Products</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Products</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Products</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View All Products Details</h4>
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
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Status</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        // $sql= "SELECT `tbl_products`.*,`tbl_categories`.*,`tbl_subcategories`.* FROM `tbl_products` INNER JOIN `tbl_categories` ON `tbl_categories`.`category_id` = `tbl_products`.`product_categoryID` INNER JOIN `tbl_subcategories` ON `tbl_subcategories`.`subcategory_id` = `tbl_products`.`product_subCategoryID` ORDER BY `tbl_products`.`product_id` DESC";

                                        $sql= "SELECT `tbl_products`.*,`tbl_categories`.* FROM `tbl_products` INNER JOIN `tbl_categories` ON `tbl_categories`.`category_id` = `tbl_products`.`product_categoryID` ORDER BY `tbl_products`.`product_id` DESC";
                                        $result = mysqli_query($conn,$sql);

                                        if($result){
                                            if(mysqli_num_rows($result)>0){
                                                $srNo = 1;
                                                ?>
                                                <tbody>
                                                    <?php
                                                    while($row = mysqli_fetch_array($result)){
                                                        $productImagePath = $row['product_image'];
                                                        
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td>
                                                                <?php if($productImagePath != "" && file_exists($productImagePath)){
                                                                    ?>
                                                                    <div class="text-center">
                                                                        <img src="<?php echo $productImagePath; ?>" style="width: 80px; height:50px;">
                                                                    </div>
                                                                    <?php
                                                                } ?>
                                                                <div class="text-center"><?php echo $row['product_name'] ?></div>
                                                            </td>
                                                            <td><?php echo $row['product_price']." PKR"; ?></td>
                                                            <td><?php echo $row['product_discount']." %"; ?></td>

                                                            <td><?php echo getStatusTitle($row['product_status']); ?></td>
                                                            <td>
                                                                <span class="badge badge-primary"><?php echo $row['category_name']; ?></span>
                                                                <!-- <span class="badge badge-success"><?php echo $row['subcategory_name']; ?></span> -->
                                                            </td>
                                                            <td>
                                                                <a href="editProduct.php?productID=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-success">Edit</a>
                                                                <a href="deleteProduct.php?productID=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-danger delete-confirm">Delete</a>
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
                                                    No Product(s) Found.
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                        
                                            
                                        <tfoot>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Status</th>
                                                <th>Category</th>
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
            title: 'Are you sure delete this Product?',
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