<?php 

include "database.php";
include "add-to-cart.php";

?>

<?php

 $obj  = new Database(); 
    $coupon_code = isset($_POST['coupon_str']) ? $_POST['coupon_str'] : '';
    $obj->select('coupon','*',null,"coupon_code='$coupon_code' && status='1'",null,null);
    $count = $obj->getResult();

     print_r($count);

    $jsonArr = array();
    $total = 0;
   if($_SESSION['COUPON_ID']){    
      unset($_SESSION['COUPON_ID']);
      unset($_SESSION['COUPON_VALUE']);
      unset($_SESSION['COUPON_CODE']);
    }
    foreach($_SESSION['cart'] as $key => $val){
      $obj->select('product_attribute','price',null,"product_id='$key'",null,null);
      $product = $obj->getResult();
      print_r($val);
      $total += $product[0]['price']*$val['quantity'];
    }

    if(!empty($count)){
        $coupon_id = $count[0]['coupon_id'];
        $coupon_value = $count[0]['coupon_value'];
        $coupon_type = $count[0]['coupon_type'];
        $cart_min_value = $count[0]['coupon_min_value'];
  
      if($cart_min_value > $total){
        $jsonArr=array('is_error'=>'yes','result'=>$total,'discount'=>'Cart total must be greater than or equal to the coupon minimum '.$cart_min_value);
      }else{
          if($coupon_type == 'Rupee'){
              $final_price = $total-$coupon_value;
          }else{
              $final_price = floor($total-(($total*$coupon_value)/100));
          }
          $discount = $total-$final_price;
          $_SESSION['COUPON_ID'] = $coupon_id;
          $_SESSION['FINAL_PRICE'] = $final_price;
          $_SESSION['COUPON_VALUE'] = $discount;
          $_SESSION['COUPON_CODE'] = $coupon_code;
          $jsonArr=array('is_error'=>'no','result'=>$final_price,'discount'=>$discount);
      }
   
      }else{
        $jsonArr =array('is_error'=>'yes','result'=>$total,'discount'=>'Coupon Code Not Found');
      }
      echo json_encode($jsonArr);
    
     exit();
    ?>
 