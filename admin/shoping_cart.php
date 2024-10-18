<?php
  // session_start();
  include "database.php";
  include "add-to-cart.php";
  ?>
  <?php
  $cart = new shopcart();
  $obj = new Database();

  $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
  $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
  $type = isset($_POST['type']) ? $_POST['type'] : '';

  // print_r($_POST);
  $attr_id = 0;
  if (isset($_POST['size_id']) && isset($_POST['color_id'])) {
      $size_condition = '';
      $color_condition = '';

      $size_id = $_POST['size_id'];
      $color_id = $_POST['color_id'];

      if ($size_id > 0) {
          $size_condition = " and size_id=$size_id ";
      }
      if ($color_id > 0) {
          $color_condition = " and color_id=$color_id ";
      }
      $obj->select('product_attribute', 'id', null, "product_id='$product_id' $size_condition $color_condition", null, null);
      $data = $obj->getResult();

      $attr_id = $data[0]['id'];
  }

  $productSoldQtyByProductId = productSoldQtyByProductId($product_id, $attr_id); // GET PRODUCT ID IN STOCK

  $product_quantity = productQuantity($product_id, $attr_id); // TOTAL QUANTITY

  $pending_quantity = $product_quantity - $productSoldQtyByProductId;

  if ($quantity > $pending_quantity) {
      echo "not_availble_product";
      die();
  }

  if ($type == 'add') {
      $cart->Addcart($product_id, $quantity, $attr_id);
  }

  if ($type == 'update') {
      $cart->updatecart($product_id, $quantity, $attr_id);
  }

  if ($type == 'remove') {
      $cart->removecart($product_id, $attr_id);
  }

  $cart->totalcart();
  ?>
  <?php
//  include "includes/footer.php";
?>


