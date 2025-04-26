<!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->


  <script type="text/javascript">
     function addtoCart(productID,productName,productQty,productPrice) {
        var prodPrice  = productQty*productPrice
        
        $.ajax({
          url:"addtoCart.php",
          type:"POST",
          data:{
            productID: productID,
            productName : productName,
            productPrice : prodPrice,
            productQty : productQty,
          },
          success:function(response) {
              if(response == 1){
                  $("#addtocartBtn"+productID).remove();
                //$('#addtocartBtn'+productID).css('display', 'none');
                  $("#addtocartSuccess"+productID).show();

                  <?php  //if($pageName == "index.php" || $pageName == "menu.php"){ ?>
                    // $("#successMessageDiv_"+productID).show();
                    <?php
                  //} ?>

                  $("#cartCounter").load("loadCartCounter.php");
                   
              }else if(response == "AE"){
                alert('Alread In Cart');
              }
           
         },
         error:function(){
          alert("error");
         }

        });
    }


    function updateCartProdQty(indexNO,prodID){
        var qtyid  = "#productQty"+prodID;
        var productQty = $(qtyid).val();
        
        
            if(productQty != "" && productQty != '0' && productQty != undefined){
            $.ajax({
                url:"updateCartProdQty.php",
                type:"POST",
                data:{
                  productID: prodID,
                  indexNO: indexNO,
                  productQty : productQty
                 },
                success:function(response) {
                 if(response == 1){
                    $("#CheckoutDiv").load("cartData.php");
                 }else if(response == "NA"){
                    $(qtyid).val("1");

                    alert("Product Out of Stock");
                    $("#CheckoutDiv").load("cartData.php");
                 }else if(response == "OS"){
                    $(qtyid).val("1");
                    alert("Product Out of Stock");
                    $("#CheckoutDiv").load("cartData.php");
                 }
                 $("#cartCounter").load("loadCartCounter.php");
                 
               },
               error:function(){
                alert("error");
               }

          });
        }else{
            alert("Please Enter Valid Quantity");
            $.ajax({
                url:"updateCartProdQty.php",
                type:"POST",
                data:{
                  productID: prodID,
                  indexNO: indexNO,
                  productQty : 1
                 },
                success:function(response) {

                 if(response == 1){
                    $(qtyid).val("1");
                    $("#CheckoutDiv").load("cartData.php");
                 }else if(response == "NA"){
                    alert("Product Out of Stock");
                    $("#CheckoutDiv").load("cartData.php");
                 }else if(response == "OS"){
                    alert("Product Out of Stock");
                    $("#CheckoutDiv").load("cartData.php");
                 }
                $("#cartCounter").load("loadCartCounter.php");
                
                
                 
               },
               error:function(){
                alert("error");
               }

          });
        } 
        
        
    }
    function removerFromCart(prodID,indexNO) {
         $.ajax({
            url:"removeCartItem.php",
            type:"POST",
            data:{
              prod_id: prodID,
              indexNO: indexNO
             },
            success:function(response) {
                $("#cartCounter").load("loadCartCounter.php");
                $("#CheckoutDiv").load("cartData.php");
                
           },
           error:function(){
            alert("error");
           }

          });
    }


  </script>


<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>