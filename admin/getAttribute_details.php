<?php 
 
 include "database.php";


 $obj = new Database();

 $color = isset($_POST['color']) ? $_POST['color'] : '';
 $product_id = isset($_POST['product_id']) ? $_POST['product_id']: '';
 $size = isset($_POST['size']) ? $_POST['size'] : '';

 if($color==''){
    $color=0;
 }

 if($size==''){
    $size=0;
 }

 $obj->select('product_attribute','*',null,"product_id='$product_id' AND color_id='$color' AND size_id='$size'",null,null);
 $data = $obj->getResult();

 if($data>0){

 $productSoldQtyByProductId = productSoldQtyByProductId($product_id,$data[0]['id']); 

 $pending_quantity = $data[0]['quantity']-$productSoldQtyByProductId;

 echo json_encode(['quantity'=>$pending_quantity,'price'=>$data[0]['price'],'mrp'=>$data[0]['mrp']]);
 }
?>