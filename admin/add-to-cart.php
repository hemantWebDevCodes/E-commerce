<?php

session_start();

class shopcart{

   public function Addcart($product_id, $quantity, $attr_id){
      $_SESSION['cart'][$product_id][$attr_id]['quantity'] = $quantity;
   }

   public function updatecart($product_id, $quantity, $attr_id){
      if (isset($_SESSION['cart'][$product_id][$attr_id])) {
         $_SESSION['cart'][$product_id][$attr_id]['quantity'] = $quantity;
      }
   }

   public function removecart($product_id, $attr_id){
      if (isset($_SESSION['cart'][$product_id][$attr_id])) {
         unset($_SESSION['cart'][$product_id][$attr_id]);
      }
   }

   public function emptycart(){
      unset($_SESSION['cart']);
   }

   public function totalcart(){
      if (isset($_SESSION['cart'])) {
         $totalCount = 0;
         foreach ($_SESSION['cart'] as $cartcount) {
            $totalCount = $totalCount + count($cartcount);
         }
         return $totalCount;
      } else {
         return 0;
      }
   }
}

?>
