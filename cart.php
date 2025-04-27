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
          My Cart
        </h2>
      </div>


      

      <!-- <div class="filters-content">

        <div class="grid row">
          <div class="box">
            <div>
              <div class="img-box">
                <div id="CheckoutDiv" class="container"></div>
              </div>
          </div>
          </div>
        </div>
      </div> -->

      <div class="filters-content">
        <div class="row grid">
          
              <div class="col-sm-12 col-lg-12 all">
                <?php if (isset($_SESSION['orderPlacedSuccessfully'])) {
                  ?>
                  <div class="alert alert-success">
                    <?php echo  $_SESSION['orderPlacedSuccessfully']; unset($_SESSION['orderPlacedSuccessfully']); ?>
                  </div>
                  <?php
                } ?>
                <div id="CheckoutDiv">
                  
                </div>
              </div>
          
        </div>
      </div>
    </div>
  </section>


  <!-- end food section -->
  <!-- footer section -->
  <?php require "includes/footer.php"; ?>
  <!-- footer section -->

  <?php require "includes/jsScripts.php"; ?>

   
   
  <script type="text/javascript">
    $(document).ready(function(){
        $("#CheckoutDiv").load("cartData.php");
    });
  </script>

</body>

</html>