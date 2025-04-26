<?php require "includes/head.php"; ?>

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>
    <!-- header section strats -->
    <?php require "includes/header.php"; ?>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php 
          $indicators= "";
          $sql = "SELECT o.order_id, o.order_date, p.product_id, p.product_name, p.product_image,p.product_description,COUNT(*) AS order_count
            FROM tbl_orders o
            JOIN tbl_order_details od ON o.order_id = od.order_detail_orderID
            JOIN tbl_products p ON od.order_detail_productID = p.product_id
            WHERE o.order_date >= CURDATE() - INTERVAL 90 DAY
            GROUP BY p.product_id
            ORDER BY order_count DESC
            LIMIT 5";

          $result = mysqli_query($conn,$sql);
          if($result){
            if (mysqli_num_rows($result)>0) {
              $i=0;
              
              while($row = mysqli_fetch_array($result)){
                if ($i == 0) {
                  $classActive = "active";
                }else{
                  $classActive = "";
                }
                $indicators .= '<li data-target="#customCarousel1" data-slide-to="'.$i.'" class="'.$classActive.'"></li>';
                ?>
                  <div class="carousel-item <?php echo $classActive; ?>">
                    <div class="container ">
                      <div class="row">
                        <div class="col-md-7 col-lg-6 ">
                          <div class="detail-box">
                            <h1>
                              <?php echo $row['product_name']; ?>
                            </h1>
                            <p>
                              <img style="float:left; width: 200px; padding-right: 10px;" src="<?php echo "admin/".$row['product_image']; ?>">
                              <?php if(strlen($row['product_description'])>200){
                                  echo substr($row['product_description'],0,199)."...";
                              }else{
                                echo $row['product_description'];
                              } ?>
                            </p>
                            <div class="btn-box">
                              <a href="singleProduct.php?productID=<?php echo $row['product_id']; ?>" class="btn1">
                                Order Now
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>      
                <?php
                $i++;
              }
            }
          }

          ?>
          
          <!-- <div class="carousel-item ">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Fast Food Restaurant
                    </h1>
                    <p>
                      Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Fast Food Restaurant
                    </h1>
                    <p>
                      Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <div class="container">
          <ol class="carousel-indicators">
            <!-- <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel1" data-slide-to="1"></li>
            <li data-target="#customCarousel1" data-slide-to="2"></li> -->
            <?php echo $indicators; ?>
          </ol>
        </div>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- offer section -->

  <section class="offer_section layout_padding-bottom">
    <div class="offer_container">
      <div class="container ">
        <!-- <div class="row">
          <div class="col-md-6  ">
            <div class="box ">
              <div class="img-box">
                <img src="images/o1.jpg" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Tasty Thursdays
                </h5>
                <h6>
                  <span>20%</span> Off
                </h6>
                <a href="">
                  Order Now <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                    <g>
                      <g>
                        <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                     c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                      </g>
                    </g>
                    <g>
                      <g>
                        <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                     C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                     c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                     C457.728,97.71,450.56,86.958,439.296,84.91z" />
                      </g>
                    </g>
                    <g>
                      <g>
                        <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                     c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                      </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                  </svg>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-6  ">
            <div class="box ">
              <div class="img-box">
                <img src="images/o2.jpg" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Pizza Days
                </h5>
                <h6>
                  <span>15%</span> Off
                </h6>
                <a href="">
                  Order Now <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                    <g>
                      <g>
                        <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                     c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                      </g>
                    </g>
                    <g>
                      <g>
                        <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                     C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                     c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                     C457.728,97.71,450.56,86.958,439.296,84.91z" />
                      </g>
                    </g>
                    <g>
                      <g>
                        <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                     c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                      </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </section>

  <!-- end offer section -->

  <!-- food section -->

  <section class="food_section layout_padding-bottom">
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
          $sql= "SELECT `tbl_products`.*,`tbl_categories`.* FROM `tbl_products` INNER JOIN `tbl_categories` ON `tbl_categories`.`category_id` = `tbl_products`.`product_categoryID` WHERE `tbl_products`.`product_status` = 'A' ORDER BY `tbl_products`.`product_id` DESC LIMIT 12";
          $result = mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
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
                       <!--  <a href="javascript:;">
                          
                          <i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i>
                        </a> -->

                        <?php  if (checkProdInCart($productID) == true) { ?>
                                  <a data-toggle="tooltip"  title="Already Added in Cart" id="addtocartSuccess<?php echo $productID; ?>" href="javascript:;" style="background: green;"><i class="fa fa-shopping-cart text-light" style="font-size: 20px;"></i></a>
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
      <div class="btn-box">
        <a href="menu.php">
          View More
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                We Are Feane
              </h2>
            </div>
            <p>
              There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
              in some form, by injected humour, or randomised words which don't look even slightly believable. If you
              are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
              the middle of text. All
            </p>
            <a href="">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- book section -->
  <section class="book_section layout_padding">
    <!-- <div class="container">
      <div class="heading_container">
        <h2>
          Book A Table
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" class="form-control" placeholder="Your Name" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Phone Number" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Your Email" />
              </div>
              <div>
                <select class="form-control nice-select wide">
                  <option value="" disabled selected>
                    How many persons?
                  </option>
                  <option value="">
                    2
                  </option>
                  <option value="">
                    3
                  </option>
                  <option value="">
                    4
                  </option>
                  <option value="">
                    5
                  </option>
                </select>
              </div>
              <div>
                <input type="date" class="form-control">
              </div>
              <div class="btn_box">
                <button>
                  Book Now
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div> -->
  </section>
  <!-- end book section -->

  <!-- client section -->
  <?php 
          $sql = "SELECT `tbl_users`.*, `tbl_ratings`.* FROM `tbl_ratings` INNER JOIN `tbl_users` ON `tbl_users`.`user_id` = `tbl_ratings`.`rating_userID` WHERE `tbl_ratings`.`rating_description` != '' ORDER BY `tbl_ratings`.`rating_id` DESC";
          $result = mysqli_query($conn,$sql);
          if ($result) {
            if (mysqli_num_rows($result)>0) {
  ?>
              <section class="client_section layout_padding-bottom">
                <div class="container">
                  <div class="heading_container heading_center psudo_white_primary mb_45">
                    <h2>
                      What Says Our Customers
                    </h2>
                  </div>
                  <div class="carousel-wrap row ">
                    <div class="owl-carousel client_owl-carousel">

                      <?php
                          while($row = mysqli_fetch_array($result)){
                            ?>
                              <div class="item">
                                <div class="box">
                                  <div class="detail-box">
                                    <p>
                                      <?php echo $row['rating_description']; ?>
                                    </p>
                                    <h6>
                                      <?php echo $row['user_name']; ?>
                                    </h6>
                                    <!-- <p>
                                      magna aliqua
                                    </p> -->
                                  </div>
                                  <div class="img-box">
                                    <?php $userImage = $row['user_image']; 
                                    if ($userImage != "" && file_exists($userImage)) {
                                      ?>
                                        <img src="<?php echo $userImage; ?>" alt="" class="box-img">

                                      <?php
                                    }else{
                                      ?>
                                        <img src="images/client1.jpg" alt="" class="box-img">

                                      <?php
                                    }

                                    ?>
                                  </div>
                                </div>
                              </div>      
                            <?php
                          }
                      ?>
                      
                      
                    </div>
                  </div>
                </div>
              </section>
<?php 
  }
}
?>

  <!-- end client section -->

  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>

</body>

</html>