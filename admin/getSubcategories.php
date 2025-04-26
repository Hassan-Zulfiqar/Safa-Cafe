<?php 
require("includes/connection.php");
$productSubCategoryID = "";
if (isset($_SESSION['productSubCategoryID'])) {
  $productSubCategoryID = $_SESSION['productSubCategoryID'];

}

if(isset($_POST['cateID'])){
	$cateID = $_POST['cateID'];
	   $sql = "SELECT * FROM `tbl_subcategories` WHERE `subcategory_status` = 'A' and `subcategory_categoryID` = '$cateID'"; 
      $result = mysqli_query($conn,$sql);
      if($result){
         if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){ 
?>
              <option <?php if($productSubCategoryID == $row['subcategory_id']){ echo "selected"; } ?> value="<?php echo $row['subcategory_id']; ?>"><?php echo $row['subcategory_name']; ?></option>
       <?php }
           }else{
            ?>
            <option value="">No Sub Categories Found</option>
            <?php
           }
         }
	   }
?>