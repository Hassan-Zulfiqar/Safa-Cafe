<?php require "includes/head.php"; ?>

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>
    <!-- header section strats -->
    <?php require "includes/header.php"; ?>
  </div>

  <!-- food section -->

  <section class="food_section layout_padding-bottom mt-4">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Menu
        </h2>
      </div>


      <ul class="filters_menu">
        <li class="active" data-filter="*">All</li>
        <?php 
        $sql = "SELECT * FROM `tbl_categories` WHERE `category_status` = 'A' ORDER BY `category_id` DESC";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_array($result)){
            $className = "category_".$row['category_id'];

            ?>
              <li data-filter=".<?php echo $className; ?>"><?php echo $row['category_name']; ?></li>
            <?php
          }
        }

        ?>
        
      </ul>

      <div class="filters-content">
        <div class="row grid">
          <?php 
          $sql= "SELECT `tbl_products`.*,`tbl_categories`.* FROM `tbl_products` INNER JOIN `tbl_categories` ON `tbl_categories`.`category_id` = `tbl_products`.`product_categoryID` WHERE `tbl_products`.`product_status` = 'A' ORDER BY `tbl_products`.`product_id` DESC ";
          $result = mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
              // $className = "category_".$row['product_categoryID'];
              // $productImagePath = "admin/".$row['product_image'];
              // $singleProductUrl = "singleProduct.php?productID=".$row['product_id'];
              $productID = $row['product_id'];
              $className = "category_".$row['product_categoryID'];
              $productImagePath = "admin/".$row['product_image'];
              $productName = $row['product_name'];
              $singleProductUrl = "singleProduct.php?productID=".$row['product_id'];
              
          ?>
              <div class="col-sm-6 col-lg-4 all cursor-pointer <?php echo $className; ?>">
                <div class="box">
                  <div>
                    <div onclick="window.location.href='<?php echo $singleProductUrl; ?>'" class="img-box">
                      <?php if ($productImagePath != "admin/" && file_exists($productImagePath)) {
                          ?>
                          <img src="<?php echo $productImagePath; ?>" alt="<?php echo $row['product_name']." Image"; ?>">

                          <?php
                      }else{
                        ?>
                          <img src="images/f1.png" alt="">
                        <?php
                      } ?>
                    </div>
                    <div class="detail-box">
                      <h5>
                        <?php echo $row['product_name']; ?>
                      </h5>
                      <p>
                        <?php 
                          if (strlen($row['product_description']) > 100) {
                            echo substr($row['product_description'], 0,99)."..";
                          }
                        ?>
                      </p>
                      <div class="options">
                        <h6>
                          <?php $discount = cal_prod_discount($row['product_id']);
                                $finalPrice = $row['product_price'] - $discount; 
                                if ($discount > 0) {
                                  ?>
                                  <del class="badge badge-danger"><?php echo $row['product_price']." PKR"; ?></del>
                                  <span class="badge badge-success"><?php echo $finalPrice." PKR"; ?></span>
                                  <?php
                                }else{
                                  ?>
                                  <span class="badge badge-success"><?php echo $finalPrice." PKR"; ?></span>
                                  <?php
                                }
                          ?>
                        </h6>
                        <?php  if (checkProdInCart($productID) == true) { ?>
                                  <a data-toggle="tooltip"  title="Already in Cart" id="addtocartSuccess<?php echo $productID; ?>" href="javascript:;" style="background: green;"><i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i></a>
                          <?php }else{ ?>
                                <a id="addtocartBtn<?php echo $productID; ?>" href="javascript:;" name="addtocart"  onclick="addtoCart(<?php echo  $productID; ?>,'<?php echo $productName; ?>','1',<?php echo $finalPrice; ?>);"><i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i></a>

                                <a data-toggle="tooltip"  title="Added To Cart" id="addtocartSuccess<?php echo $productID; ?>" href="javascript:;" name="addtocart"  style="background: green !important; display: none !important;"><i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i></a>
                      <?php } ?>
                        
                      </div>
                      <!-- <div style="display: none;" id="successMessageDiv_<?php echo $productID; ?>" class="row mt-2">
                        <div class="col-md-12">  <div class="alert alert-success">Added successfully</div> </div>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
          <?php 
            }
          } ?>
        </div>
      </div>
    </div>
  </section>


  <!-- end food section -->
  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>

</body>

</html>