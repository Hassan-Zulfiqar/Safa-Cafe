<?php 
require ("includes/connection.php");
require ("includes/functions.php"); 
?>

<div class="mt-2">
    <table class="table table-striped table-bordered">
        <?php $subtotalArray = array();
            if(isset($_SESSION['cart'])){
                if(is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0 ){
                    $cartData = $_SESSION['cart'];
                    //print_r($cartData);
                    $i = 0;
            ?>
            <thead class="bg-dark">
                <tr class="text-white text-center">
                    <th>Sr #</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totlQty = 0;
                    for($i = 0; $i < count($_SESSION['cart']); $i++){ 
                     $cartProductID  = $_SESSION['cart'][$i]['productID'];
                     $cartProductName  = $_SESSION['cart'][$i]['productName'];
                     $cartProductPrice  = $_SESSION['cart'][$i]['productPrice'];
                     $cartProductQty  = $_SESSION['cart'][$i]['productQty'];
                     $totProductPrice = $cartProductPrice *  $cartProductQty;
                     array_push($subtotalArray, $totProductPrice);

                     $totlQty+=$cartProductQty;
                ?>

                    <tr class="text-center align-middle align-items-center">
                        <td><?php echo $i+1; ?></td>
                        <td>
                            <?php if (get_rand_prod_img($cartProductID) != "") { ?>
                                    <div><img src="admin/<?php echo get_rand_prod_img($cartProductID); ?>" style="width: 50px;" alt=""></div>
                                    
                            <?php } ?>
                            
                            <h6 class="mt-2"> <?php echo $cartProductName; ?></h6>
                        </td>
                        <td>RS <?php echo $cartProductPrice; ?></td>
                        <td class="qty">
                            <div class="quantity">
                                <input type="number" class="qty-text" step="1" min="1" max="99" name="quantity[]" onchange="updateCartProdQty(<?php echo $i; ?>,<?php echo $cartProductID; ?>);" onkeyup="updateCartProdQty(<?php echo $i; ?>,<?php echo $cartProductID; ?>);" value="<?php echo $cartProductQty; ?>" id="productQty<?php echo $cartProductID; ?>" style="border: none; outline: none; padding:5px; display: block; width:100%;">

                                <div class="col-md-12 mb-3"></div>
                            </div>
                        </td>
                        <td><?php echo "RS".$cartProductQty*$cartProductPrice; ?></td>
                        <td><button class="btn btn-sm btn-danger" onclick="removerFromCart(<?php echo $cartProductID; ?>,<?php echo $i; ?>);" id="removeFromCart<?php echo $cartProductID; ?>"><i class="fa fa-trash"></i></button></td>
                    </tr>
                <?php
                    }
                    ?>
                    <tr >
                        <td colspan="4" class="text-right">Cart Total</td>
                        <td colspan="2"><?php echo $totlQty; ?> Item(s)</td>
                    </tr>
                    <tr >
                        <td colspan="4" class="text-right">Sub Total</td>
                        <td colspan="2">RS <?php echo array_sum($subtotalArray); ?></td>
                    </tr>
                    <tr >
                        <td colspan="4" class="text-right">Shipping</td>
                        <td colspan="2">Free</td>
                    </tr>
                    <tr >
                        <td colspan="4" class="text-right">Grand Total</td>
                        <td colspan="2">RS <?php echo array_sum($subtotalArray); ?> Item(s)</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <?php if(checkLogin() === false ){
                                ?>
                                <a href="login.php" class="btn btn-sm btn-block btn-warning text-dark">Login Now to Place your Order</a>
                                <?php
                            }else{
                                ?>
                                <a href="placeOrder.php" class="btn btn-sm btn-block btn-warning text-dark">Place your Order</a>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <?php
                }else{ ?>
                    <div class="alert alert-danger">
                        <strong>Cart : </strong>Your Cart is empty
                    </div>
                <?php } ?>
            </tbody>
        <?php }else{ ?>
            <div class="alert alert-danger mt-2">
                <strong>Cart : </strong>Your Cart is empty
            </div>
        <?php } ?>
            
    </table>
  </div>