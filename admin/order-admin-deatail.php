<?php 
   include "includes/dash-header.php";
   include "includes/dash-top-nav.php";
   include "includes/dash-sidebar.php";
   include "database.php";

   isAdmin();
   ?>
<?php
   $obj = new Database();
   
   $user = $_SESSION['id'];
   $order = $_GET['id'];
   
   // COUPON PRICE
   
   $obj->select('product_order','coupon_value',null,"id='$order'",null,null);
   $coupon = $obj->getResult();
   $coupon_value = $coupon[0]['coupon_value'];
   if($coupon_value == ''){
      $coupon_value = 0;
   }
   
   // ORDER DEATIL SELECT
   $join = "product p ON order_deatail.product_id = p.product_id LEFT JOIN product_order po ON order_deatail.id=po.id";
   $where = "order_deatail.order_id='$order' AND po.user_id='$user'";
   $obj->select('order_deatail','order_deatail.*,p.p_name,p.image,po.address,po.pincode',$join,$where,null,null);
   $data = $obj->getResult();
   ?>
<link rel="stylesheet" href="css/All-Page.css">
<div class="content-wrapper">
<div class="container">
   <div class="row">
      <div class="col-md-11 bg-white py-3 mt-3 mx-auto px-3">
         <strong>ORDER DEATAIL :</strong>
      </div>
   </div>
</div>
<div class="container">
   <div class="row">
      <div class="col-md-11 mt-4 mx-auto">
         <table class="table table-bordered table-hover table-light text-center">
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
                  $total = 0;
                  foreach($data as $product){
                  ?>
               <tr class="tabletd font-weight-bold">
                  <td><?php echo $product['p_name'] ?></td>
                  <td><img src="<?php echo $product['image'] ?>" height="250"></td>
                  <td><?php echo $product['quantity'] ?></td>
                  <td>&#8377;<?php echo $product['price'] ?></td>
                  <td>&#8377;<?php echo $product['price']*$product['quantity'] ?></td>
               </tr>
               <?php
                  $total += $product['price']*$product['quantity'];
                  }
                  ?>
               <?php 
                  if($coupon_value != ''){
                  ?>
               <tr>
                  <td colspan="3"></td>
                  <td>Coupon Price : </td>
                  <td> <?php echo $coupon_value ?></td>
               </tr>
               <?php
                  }
                  
                  ?>
               <tr class="font-weight-bold">
                  <td colspan="3"></td>
                  <td>Total Price:</td>
                  <td>&#8377;<?php echo $total-$coupon_value ?></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<div class="container">
   <div class="row">
      <div class="col-md-11 mx-auto">
         <div class="bg-white py-3 px-3">
            <strong>Address : <?php echo $data[0]['address'] ?></strong>
            <strong class="ml-2">PinCode : <?php echo $data[0]['pincode'] ?></strong>
            <div class="my-3">
               <?php 
                  //Update Order Status
                   if(isset($_POST['status'])){
                   $status_name =$_POST['status'];
                   $obj->update('product_order',['order_status' => $status_name],"id='$order'");
                   $obj->getResult();
                   }
                  
                   $join = "product_order po ON po.order_status=order_status.status_id";
                   $where = "po.id = $order";
                   $obj->select('order_status','order_status.status_name',$join,$where,null,null);
                   $status = $obj->getResult();
                   ?>
               <strong>Order Status : <?php echo $status[0]['status_name'] ?></strong>
               <form method="POST">
                  <?php
                     $obj->select('order_status','*',null,null,null,null);
                     $store = $obj->getResult();
                     ?>
                  <div class="form-group status_select mt-3">
                     <select name="status" class="form-control col-5 shadow-none">
                        <option>Select</option>
                        <?php 
                           foreach($store as $status){
                           echo "<option value=" . $status['status_id'] . ">" . $status['status_name'] . "</option>";
                           } 
                           ?>
                     </select>
                  </div>
                  <input type="submit" value="Submit" class="btn btn-dark shadow-none order_status my-2">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php 
   include "includes/dash-footer.php";
   
   ?>