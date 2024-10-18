<?php 

 session_start();
 include "database.php";

 if(isset($_POST['min_price']) && isset($_POST['max_price'])){
   $cate_id=$_SESSION['CATEGORY_ID'];
   $min_price = isset($_POST['min_price']) ? $_POST['min_price'] : ''; 
   $max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';

  if(!$cate_id==''){
    $main_cate = " product.category='$cate_id' ";
  }

  $max_price_condition='';
  if(!empty($max_price)){
    $max_price_condition=" AND pa.price BETWEEN {$min_price} AND {$max_price}";
  }

  $join="main_category ON product.category = main_category.category_id 
        LEFT JOIN product_attribute pa ON product.product_id= pa.product_id";

  $obj->select('product','product.*,pa.quantity,pa.price,pa.mrp',$join,"$main_cate $max_price_condition AND product.status='1' GROUP BY product.product_id",null,null);
  $filter_data = $obj->getResult();

  if(empty($filter_data)){
        
    echo "No Record Found";
    
  }else{
    foreach($filter_data as $filter){ 
 ?>
    <div class="col-md-4 mt-3 my-2" id="main-image-div">
      <div class="card rounded-0 border-0">   
          <a href="product-deatail.php?id=<?php echo $filter['product_id'] ?>">
            <img src="<?php echo $filter['image'] ?>" class="card-img-top img-fit">
          </a>
        <div class="hover-icon">
          <ul class="">
            <li class=""><a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $filter['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a></li>
            <li class="mt-1"><a href="javascript:void(0)" onclick="shoping_cart('<?php echo $filter['product_id'] ?>','add')"><i class="fa-solid fa-bag-shopping"></i></a></li>
          </ul>
        </div>
        <div class="card-body pb-0">
        <a href="product-deatail.php?id=<?php echo $filter['product_id'] ?>" class="text-dark">
         <div class="pt-4">
            <h5 class="card-title"><?php echo $filter['p_name'] ?></h5>
            <p class="card-text"><?php echo $filter['short_desc'] ?></p>
         </div>
         <div class="mt-3">
            <mark class="mr-0">&#8377;<?php echo $filter['price'] ?></mark>
            <small><del>&#8377;<?php echo $filter['discount_price'] ?></del></small>
            <span><small class="ml-1 text-success"><?php echo $filter['discount_precentage'] ?>% off</small></span>
         </div>
        </a>
          </div>
      </div>
    </div>
<?php 
  }  
}
}

?>