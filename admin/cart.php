<?php

include "includes/header.php";
include "includes/top-navbar.php";

?>
 
<?php

 $cart = new shopcart();

?>

<link rel="stylesheet" href="css/All-Page.css">
 <div class="container mt-4">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-hover text-center table-white" id="cart_table">
        <thead>
          <tr>
            <th>PRODUCTS</th>
            <th>NAME OF PRODUCTS</th>
            <?php 
             
             if(isset($si_ci_data[0]['color'])=='' && isset($si_ci_data[0]['size'])==''){
               echo "<th>Size & Color</th>";
             }
             
            ?>
            <th>PRICE</th>
            <th>QUANTITY</th>
            <th>TOTAL</th>
            <th>REMOVE</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total_price = 0;
            if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $key => $val){
              foreach($val as $keyqty => $valqty){

              if($keyqty>0){
                $Attr_id=' pa.id='.$keyqty;
              }

              $join = "product_attribute pa ON product.product_id=pa.product_id";
              $obj->select('product','product.*,pa.price,pa.mrp,pa.quantity',$join,'product.product_id='.$key ." AND". $Attr_id,null,null);
              $product = $obj->getResult();
              $total_price += $product[0]['price']*$valqty['quantity'];
             
             ?> 
            <tr class="font-weight-bold tabletd">

              <td><img src="<?php echo $product[0]['image'] ?>" height="120"></td> 
              <td><?php echo $product[0]['p_name'] ?></td>
            <td>
              
            <!-- COLOR & SIZE -->
            <?php
              $condition ='';
              $join="color_manage color_m ON product_attribute.color_id = color_m.color_id AND color_m.status=1
                     LEFT JOIN size_master size_m ON product_attribute.size_id = size_m.size_id AND size_m.status=1";
              $obj->select('product_attribute','product_attribute.*,color_m.color_id,color_m.color,size_m.size_id,size_m.size',$join,"product_attribute.id='$keyqty'",null,null);
              $si_ci_data = $obj->getResult();
              
               foreach($si_ci_data as $sid_cid){

                 if(isset($sid_cid['color']) && $sid_cid['color']!=''){
                    echo "". $sid_cid['color'] . "<br>";
                   }
              
                  if(isset($sid_cid['size']) && $sid_cid['size']!=''){
                    echo $sid_cid['size'];
                  }else{
                    echo ".....";
                  }
               }

            ?>
           </td>
              <td><?php echo $product[0]['price'] ?></td>
              
          <!-- QUANTITY INPUT -->
              <td>
                <div class="input-group mb-1">
                  <div class="input-group-prepend mx-auto">
                    <button class="input-group-text btn btn-light shadow-none" id="minus"><i class="fa-solid fa-angles-left"></i></button>
                    <input type="number" id="<?php echo $key ?>quantity" value="<?php echo $valqty['quantity'] ?>" class="form-control value pl-5 shadow-none">
                    <button class="input-group-text btn btn-light shadow-none" id="plus"><i class="fa-solid fa-angles-right"></i></button>
                  </div>
                </div>
                <a href="javascript:void(0)" onclick="shoping_cart('<?php echo $key ?>','update','<?php echo $sid_cid['size_id'] ?>','<?php echo $sid_cid['color_id'] ?>')" class="text-dark mt-0">Update</a>
              </td>
          
              <td><?php echo $total_price; ?></td>
              
              <td>
                <a href="javascript:void(0)" onclick="shoping_cart_update('<?php echo $key ?>','remove','<?php echo $sid_cid['size_id'] ?>','<?php echo $sid_cid['color_id'] ?>')"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a>
              </td>
            </tr>
          <?php } } } ?>
        </tbody>
      </table>
      <a href="home.php" class="btn btn-success shadow-none btn-lg" id="continue_shoping">Contineu Shoping</a>
      <a href="checkout.php" class="btn btn-success shadow-none btn-lg float-right" id="checkout">CHECKOUT</a>
    </div>
  </div>

  <input type="hidden" id="sizeid">
  <input type="hidden" id="colorid">
 </div>
    
<?php 
 
 include "includes/footer.php";

?> 