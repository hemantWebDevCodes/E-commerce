<?php 
  
  include "includes/header.php";
  include "includes/top-navbar.php";

?>
  <?php 

    if(isset($_SESSION['cart']) AND count($_SESSION['cart'])==0){
    ?>
    <script>
      window.location.href="home.php";
    </script>
  <?php
    } 
  ?>

 <?php 
   
    if(isset($_POST['submit'])){
      $mobile = $_POST['mobile'];
      $state = $_POST['state'];
      $city = $_POST['city'];
      $pincode = $_POST['pincode'];
      $address = $_POST['address'];
      $payment_type = $_POST['payment_type'];
      $payment_status = 'pending';
      if($payment_type == 'cod'){
        $payment_status = 'success';
      }
      $total = 0;
      foreach($_SESSION['cart'] as $key => $val){
        foreach($val as $qtykey => $qtyval){

          if($qtykey>0){
            $Attr_id = 'id='.$qtykey; 
          }
        $obj->select('product_attribute','price',null,$Attr_id,null,null);
        $product = $obj->getResult();
        $total += $product[0]['price']*$qtyval['quantity'];
      }
    }
     print_r($total);
      $user_id = $_SESSION['id'];
      $totle_price = $total;
      $order_status = '1';
      $added_on = date('Y-m-d H:i:s');

      // Coupon Data

      if(isset($_SESSION['COUPON_ID'])){
        $coupon_id = $_SESSION['COUPON_ID'];
        $coupon_value = $_SESSION['COUPON_VALUE'];
        $coupon_code = $_SESSION['COUPON_CODE'];
        $totle_price = $totle_price-$coupon_value;
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_VALUE']);
        unset($_SESSION['COUPON_CODE']);
      }else{
        $coupon_id ='';
        $coupon_value = '';
        $coupon_code = '';
      }

      $data = ['user_id' => $user_id,'mobile' => $mobile,'state' => $state,'city' => $city,'pincode' => $pincode,
      'address' => $address,'payment_type' => $payment_type,'total_price' => $totle_price,'payment_status' => $payment_status,
      'order_status' => $order_status,'coupon_id'=>$coupon_id,'coupon_value'=>$coupon_value,'coupon_code'=>$coupon_code,'added_on' => $added_on ]; 

      $obj->insert('product_order',$data);
      $result = $obj->getResult();
    
      
      $order_id = $obj->mysqli->insert_id;
      
      foreach($_SESSION['cart'] as $key => $val){
        foreach($val as $qtykey => $qtyval){

          if($qtykey>0){
            $Attr_id = 'id='.$qtykey; 
          }
        
        $obj->select('product_attribute','price',null,$Attr_id,null,null);
        $productArr = $obj->getResult();
        
        $quantity = $qtyval['quantity'];
        $price = $productArr[0]['price'];

      $obj->insert('order_deatail',['order_id'=>$order_id,'product_id'=>$key,'product_attribute_id'=>$qtykey,'quantity'=>$quantity,'price'=>$price]); 
    }
  }
    unset($_SESSION['cart']);
    echo "<script>
            window.location.href='Thank_you.php';
         </script>";
    }

 ?>

 <link rel="stylesheet" href="css/All-Page.css">
 <div class="container mt-5">
  <div class="row">
    <div class="col-md-7 Acordian">
    <?php    
     $acordian_class = "acordian-title";
    if(!isset($_SESSION['email'])){
      $acordian_class = "acordian-item";
    ?>
     <div class="card">
      <div class="card-header py-3 acordian-title">
        <i class="fas fa-minus"></i><span class="ml-3 text-white">Checkout Method</span>
      </div>
     <div class="card-body active-acordian">
     <div class="row">
    <!-- Login Form -->
      <div class="col-md-6 mt-2">
        <h5 id="slide-up">LOGIN</h5>
       <form method="POST" id="login-form">
        <div id="login_input" class="mt-4">    
          <div class="form-group input-group-lg">
           <input type="email" id="login_email" name="login_email" class="form-control shadow-none" placeholder="Your Name*">
           <span class="error_field" id="login_Eerror"></span>
          </div>
          <div class="form-group input-group-lg py-3">
           <input type="password" id="login_password" name="login_password" class="form-control shadow-none" placeholder="Your Password*">
           <span class="error_field" id="login_perror"></span>
          </div>
          <input type="submit" name="login" onclick="login_send()" id="loginbtn" value="Login" class="btn-success shadow-none mt-1 col-3 btn-lg"> 
          <!-- <span class="text-danger" id="success-login"></span> -->
        </div>
       </form>
    </div>
    
   <!-- Registration Form -->
    <div class="col-md-6 mt-2">
      <h5 class="">REGISTER</h5>
     <form action="" method="POST" id="validate_register">
       <div id="registrer_input" class="mt-4"> 

        <div class="form-group input-group-lg">
         <input type="text" name="name" id="name" class="form-control shadow-none" placeholder="Your Name*">
         <span class="error_field" id="name_error"></span>
        </div>

        <div class="form-group input-group-lg py-3">
         <input type="email" name="email" id="email" class="form-control shadow-none" placeholder="Your email*">
         <span class="error_field" id="email_error"></span>
        </div>

        <div class="form-group input-group-lg">
         <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Your Password*">
         <span class="error_field" id="password_error"></span>
        </div>

        <input type="submit" name="register" onclick="Registration_send()" value="Register" class="btn-success col-6 btn-lg mt-2 shadow-none" id="registerbtn">
       </div>
       <span class="text-success" id="success"></span>
     </form>
    </div>
  </div>

     </div>
    </div>
    <?php
   } 
   ?>
   <!-- ADDRESS INFORMATION FORM -->
   <form method="POST">
    <div class="card">
      <div class="card-header py-3 <?php echo $acordian_class ?>">
        <i class="fas fa-plus"></i><span class="ml-3 text-white">Address Informetion</span>
      </div>
       <div class="card-body" id="address">
          <div class="form-row mt-2">
          <div class="form-group input-group-lg col-md-6">
            <input type="number" name="mobile" id="mobile" class="form-control shadow-none" placeholder="Mobile Number*">
          </div>
          <div class="form-group input-group-lg col-md-6">
            <input type="number" name="pincode" id="pincode" class="form-control shadow-none" placeholder="PinCode*">
          </div>
        </div>
        <div class="form-row py-2">
          <div class="form-group input-group-lg col-md-6">
            <input type="text" name="state" id="mobile" class="form-control shadow-none" placeholder="State*">
          </div>
          <div class="form-group input-group-lg col-md-6">
            <input type="text" name="city" id="city" class="form-control shadow-none" placeholder="City*">
          </div>
        </div>
          <div class="form-group input-group-lg">
            <input type="text" name="address" id="mobile" class="form-control shadow-none" placeholder="House No. Building Name">
          </div>
          <div class="text-center"><i class="fa-solid fa-arrow-down text-dark"></i></div>
        </div>
      </div>

    <!-- PAYMENT TYPE -->
      <div class="card">
        <div class="card-header py-3  <?php echo $acordian_class ?>">
          <i class="fas fa-plus"></i><span class="ml-3 text-white">Payment Process</span>
        </div>
      <div class="card-body bg-light">
        <div class="form-check pt-3">
          <input name="payment_type" class="form-check-input" type="radio" id="payradio" value="option2">
          <label class="form-check-label"><b class="text-secondary">(UPI) UNIFIED PAYMENTS INTERFACE</b></label>
        </div>
        <div class="form-check py-3">
          <input name="payment_type" class="form-check-input" type="radio" id="payradio" value="cod">
          <label class="form-check-label"><b class="text-secondary">(COD) CASE ON DELIVERY</b></label>
        </div>
        <input type="submit" name="submit" value="SUBMIT" class="btn btn-dark btn-lg shadow-none col-5 mt-2 mb-3" id="Addressbtn">
      </div>
      </div>
    </form>
    </div>

  <!-- ORDER LIST TABLE -->
  <div class="col-md-5">
    <div class="card rounded-0">
      <div class="card-header bg-light">
        <h6 class="text-center"><b>YOUR ORDER</b></h6>
      </div>
       <table class="table text-center table-light">
        <tbody>
          <?php 
            $total = 0;
            if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $key => $val){
              foreach($val as $qtykey => $qtyval){

               if($qtykey>0){
                 $Attr_id='pa.id='.$qtykey;
               }
              $join="product_attribute pa ON product.product_id=pa.product_id";
              $obj->select('product','product.*,pa.price,pa.quantity,pa.mrp',$join,'product.product_id='.$key ." AND " .$Attr_id,null,null);
              $product = $obj->getResult();
              $total +=($product[0]['price']*$qtyval['quantity']);
          ?>
        
          <tr class="tabletd">
            <td><img src="<?php echo $product[0]['image'] ?>" height="100"></td>
            <td>
              <span class="mr-3"><?php echo $product[0]['p_name'] ?></span><br><br>
              &#8377;<span class="pt-2"><?php echo $product[0]['price'] ?></span>
              <span class="ml-4"><?php echo $qtyval['quantity'] ?></span>
            </td>
            <td><a href="javascript:void(0)" onclick="shoping_cart_update('<?php echo $key ?>','remove')"><i class="fa-sharp fa-solid fa-square-xmark trash"></i></a></td>
          </tr>
         <?php
           } } }
         ?>
          <tr class="tabletd" id="coupon_box_tr">
            <td>Coupne Price :</td>
            <td>&#8377;<span id="coupon_price"></span></td>
          </tr>
          <tr class="tabletd">
            <td >Total Price :</td>
            <td>&#8377;<span id="order_total_price"><?php echo $total ?></span></td>
          </tr>
      </tbody>
     </table>
    <div class="card-body">
          <div id="coupon_apply_inp">
            <form method="post" class="form-inline">
               <td>
               <div class="form-group">
                  <input type="text" name="coupon_str" id="coupon_str" class="form-control form-control-lg shadow-none" placeholder="Coupon Code">
                </div>
               </td>
              <td>
              <div class="form-group">
                  <input type="button" id="coupon_apply" onclick="apply_coupon()" class="btn btn-primary btn-lg shadow-none" value="APPLY COUPON">
                </div>
              </td>
              <span id="coupon_result"></span>
              </form>
            </div>
         </div>
      </div>
    </div>
  </div>
 </div>

<?php
    // unset Coupon Session
    if(isset($_SESSION['COUPON_ID'])){    
      unset($_SESSION['COUPON_ID']);
      unset($_SESSION['COUPON_VALUE']);
      unset($_SESSION['COUPON_CODE']);
    }
  
  include "includes/footer.php";

?>
