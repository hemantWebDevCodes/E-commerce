<?php 
 
  
  include "database.php";

  $obj = new database();

  $color_size_id = isset($_POST['color_size_id']) ? $_POST['color_size_id'] : '';
  $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
  $type = isset($_POST['type']) ? $_POST['type'] : '';
   
  $html='';
  if($type=='color'){
    $join = "size_master size_m ON product_attribute.size_id= size_m.size_id";
    $obj->select('product_attribute','product_attribute.size_id,size_m.size',$join,"product_attribute.product_id='$product_id'
                  AND product_attribute.color_id='$color_size_id'","size_m.order_by",null);
    $data = $obj->getResult();
    
    echo '<h6 class="mt-2 pt-1">Size : </h6>';
    
    foreach($data as $attr_data_size){
    $html.= '<li class="nav-item mx-2 border">
                <a class="nav-link text-gray showQuantity" href="'.$attr_data_size['size_id'].'">'.$attr_data_size['size'].'</a>
            </li>';
    }
  }
  echo $html;
?>