<?php require "includes/head.php"; ?>
<?php 
// unset($_SESSION['cart']);
$productID = "";
$discount = $finalPrice = 0;
$productName = $productImage = $productCategoryID = $productPrice = $productDescription = $productStatus = $productCategoryName = "";


if (isset($_GET['productID']) && is_numeric($_GET['productID']) && $_GET['productID'] != "") {
    $productID = $_GET['productID'];

    $sql= "SELECT `tbl_products`.*,`tbl_categories`.* FROM `tbl_products` INNER JOIN `tbl_categories` ON `tbl_categories`.`category_id` = `tbl_products`.`product_categoryID` WHERE `tbl_products`.`product_status` = 'A' AND `tbl_products`.`product_id` = '$productID'";
    $result = mysqli_query($conn,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $productName = $row['product_name'];
                $productImage = "admin/".$row['product_image'];
                $productStatus = $row['product_status'];
                $productPrice = $row['product_price'];
                $productDiscount = $row['product_discount'];
                $productDescription = $row['product_description'];
                $productCategoryID = $row['product_categoryID'];
                $productCategoryName = $row['category_name'];
                $discount = cal_prod_discount($row['product_id']);
                $finalPrice = $row['product_price'] - $discount;


            }    
        }else{
            header("location:menu.php");
            exit();
        }
    }else{
        header("location:menu.php");
        exit();
    }
}else{
    header("location:menu.php");
    exit();
}


?>
  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>
    <!-- header section strats -->
    <?php require "includes/header.php"; ?>
    <!-- end header section -->
  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <?php if($productImage != "admin/" && file_exists($productImage)){
              ?>
              <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
              <?php
            }else{
              ?>
              <img src="images/about-img.png" alt="">
              <?php  
            } ?>
            
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                <?php echo $productName; ?>
                <span class="badge badge-warning text-danger">
                  <?php echo $productCategoryName; ?>
                </span>
              </h2>
            </div>
            <p>
              <?php echo $productDescription; ?>
            </p>
            <div class="options">
              
              <h6>
                <?php if ($discount > 0) { ?>
                          <del class="badge badge-danger"><?php echo $row['product_price']." PKR"; ?></del>
                          <span class="badge badge-success"><?php echo $finalPrice." PKR"; ?></span>
                  <?php }else{ ?>
                          <span class="badge badge-success"><?php echo $finalPrice." PKR"; ?></span>
                  <?php } ?>
              </h6>
            </div>
            <!-- <a href="">
              Read More
            </a> -->


            <?php  if (checkProdInCart($productID) == true) { ?>
                      <a id="addtocartSuccess<?php echo $productID; ?>" href="javascript:;" name="addtocart" class="btn cart-submit d-block"><i class="fa fa-shopping-cart"></i> Already in cart</a>
            <?php }else{ ?>
                      <a id="addtocartBtn<?php echo $productID; ?>" href="javascript:;" name="addtocart"  onclick="addtoCart(<?php echo  $productID; ?>,'<?php echo $productName; ?>','1',<?php echo $finalPrice; ?>);" class="btn cart-submit d-block"><i class="fa fa-shopping-cart"></i> Add to cart</a>

                      <a id="addtocartSuccess<?php echo $productID; ?>" href="javascript:;" name="addtocart" class="btn cart-submit d-block" style="background: green !important; display: none !important;"><i class="fa fa-shopping-cart"></i> SuccessFully Added</a>
            <?php } ?>
            
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>

</body>

</html>