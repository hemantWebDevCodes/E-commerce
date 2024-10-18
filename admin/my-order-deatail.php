<?php
   include "includes/header.php";
   include "includes/top-navbar.php";
   
   ?>
<?php 
   $order_id = $_GET['id'];
   $user = $_SESSION['id'];
   
   $obj->select('product_order','*',null,"id='$user'",null,null);
   $coupon = $obj->getResult();
   $coupon_value = $coupon[0]['coupon_value'];

   if($coupon_value==''){
      $coupon_value=0;
   }
   
   $join= "product ON order_deatail.product_id = product.product_id 
         LEFT JOIN product_order ON order_deatail.id = product_order.id";
         
   $where = "order_deatail.order_id=$order_id AND product_order.user_id=$user"; 
   
   $obj->select('order_deatail','order_deatail.*,product.image,product.p_name',$join,$where,null,null);
   
   $product = $obj->getResult();
   
   ?>
<link rel="stylesheet" href="css/All-Page.css">
<div class="container">
   <div class="row">
      <div class="col-md-12 mt-5">
         <div class="py-3 px-2 table-header">
            <h5>ORDER DEATAIL</h5>
         </div>
         <table class="table table-bordered table-light table-hover text-center">
            <thead>
               <tr>
                  <th>Product Name</th>
                  <th>Product Image</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total Price</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  foreach($product as $order){
                  ?>
               <tr class="tabletd font-weight-bold">
                  <td width="300"><?php echo $order['p_name'] ?></td>
                  <td><img src="<?php echo $order['image'] ?>" alt="" height="250"></td>
                  <td><?php echo $order['quantity'] ?></td>
                  <td>&#8377;<?php echo $order['price'] ?></td>
                  <td>&#8377;<?php echo $order['price']*$order['quantity'] ?></td>
               </tr>
               <?php 
                  if($coupon_value != ''){
                  ?>
               <tr class="tabletd">
                  <td colspan="3"></td>
                  <td>Coupon Price : </td>
                  <td>&#8377;<?php echo $coupon_value; ?></td>
               </tr>
               <?php   
                  }
                  ?>
               <tr class="tabletd">
                  <td colspan="3"></td>
                  <td>Total Price : </td>
                  <td>&#8377;<?php echo $order['price']*$order['quantity']-$coupon_value; ?></td>
               </tr>
               <?php
                  }
                  ?>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php 
   include "includes/footer.php";
   
   ?>