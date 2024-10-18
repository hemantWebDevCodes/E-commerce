<?php

include "includes/header.php";
include "includes/top-navbar.php";

?>
  
  <?php

  $obj = new Database();

  $product_id = isset($_POST['product_id']) ? $_POST['product_id'] :'';
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $user_id = $_SESSION['id'];

  if($type=='add'){
   $obj->select('wishlist','*',null,"product_id='$product_id'",null,null);
   $check_data =$obj->getResult();

  if($check_data){
    echo "Data already Exits";
  }else{
    $date = date('d-m-y h:i:s');
    $obj->insert('wishlist',['user_id'=>$user_id,'product_id'=>$product_id,'added_on'=>$date]);
  }
}


  // Delete Wishist
  if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $obj->delete('wishlist', "wishlist_id=$delete_id AND user_id=$user_id");
    $obj->getResult();
}

  ?>
  <?php 
     $join = "product p ON wishlist.product_id=p.product_id LEFT JOIN product_attribute pa ON p.product_id=pa.product_id";
     $where = "user_id='$user_id' GROUP BY p.product_id";
     $obj->select('wishlist','wishlist.wishlist_id,p.image,p.p_name,pa.price,p.product_id',$join,$where,"wishlist.wishlist_id",null);
     $whislist = $obj->getResult();

  ?>
<link rel="stylesheet" href="css/All-Page.css">
 <div class="container mt-4">
  <div class="row">
    <div class="col-md-11 wish-pheader mx-auto mt-4 py-2">
        <h5 class="ml-3 py-2"><b>Wishlist</b></h5>
     </div>
   </div>
    <div class="row">
    <div class="col-md-11 mx-auto">
      <table class="table table-light table-hover text-center mt-4">
        <thead>
          <tr>
            <th>wishlist Id</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Delete</th>
            <th>Add To Cart</th>
          </tr>
        </thead>
        <tbody>
    <?php foreach ($whislist as $product_data) { ?>
      <tr class="tabletd font-weight-bold">
        <td><?php echo $product_data['wishlist_id']; ?></td>
        <td><img src="<?php echo $product_data['image']; ?>" height="120"></td>
        <td><?php echo $product_data['p_name']; ?> <br>&#8377;<?php echo $product_data['price']; ?></td>
        <td><a href="wishlist.php?delete_id='<?php echo $product_data['wishlist_id']; ?>'"><i class="fa-sharp fa-solid fa-square-xmark trash"></i></a></td>
        <td><a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>" class="btn btn-primary btn-lg shadow-none text-md" id="cartbtn">Add To Cart</a></td>
      </tr>
   <?php 
    }
   ?>
   </table>
  <?php
    include "includes/footer.php";
  ?>
 