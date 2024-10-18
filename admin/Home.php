<?php 

 include 'includes/header.php';
 include 'includes/top-navbar.php';

?>

<?php
 
   $obj = new Database();
      
   $join = "product_attribute pa ON product.product_id=pa.product_id GROUP BY product.product_id";
   $obj->select('product','product.*,pa.price,pa.mrp,pa.quantity',$join,null,"product.product_id ASC",4);
   $data = $obj->getResult();
 
?>

<link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="css/slick-theme.min.css">
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/All-Page.css">


<!-- BANNER IMAGE -->
<?php  
 $obj->select('banner','*',null,null,null,null);
 $banner = $obj->getResult();

?>

<div class="search_resilt"></div>

<div class="slider">
  <?php foreach ($banner as $showbanner) { ?>
    <div class="slide">
      <img src="<?php echo $showbanner['banner_image'] ?>" class="w-100 mb-0 d-block" alt="">
   </div>
  <?php } ?>
</div>

<!-- TODAY DEAL -->
<div class="container border-bottom mt-5 latest-best-product">
    <div class="row d-flex">
       <h5 class="mb-0">TODAY DEALS</h5>
       <p class="ml-auto mb-0"><a href="today_deals.php" class="btn btn-dark shadow-none show_all">Show All</a></p>
    </div>
  </div>

<div class="container card-images">
 <div class="row g-3">
<?php 
    $join = "product p ON order_deatail.product_id = p.product_id";
    $obj->select('order_deatail','order_deatail.*,p.p_name,p.image,p.short_desc,p.discount_precentage,p.discount_price',$join,null,null);
    $order_data = $obj->getResult();
    foreach($order_data as $order){
?>
<div class="col-md-3 mt-3 pb-4" id="main-image-div">
   <div class="card rounded-0 border-0">
      <a href="product-deatail.php?id=<?php echo $order['product_id'] ?>">
      <div class="card-image-box">
      <img src="<?php echo $order['image'] ?>" class="card-img-top img-fit" alt="Card image cap">
      </div>  
    </a>

      <div class="hover-icon">
         <ul class="">
            <li><a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $order['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a></li>
            <li class="mt-1"><a href="product-deatail.php?id=<?php echo $order['product_id'] ?>"><i class="fa-solid fa-bag-shopping"></i></a></li>
         </ul>
      </div>
      <div class="card-body pb-0">
         <a href="product-deatail.php?id=<?php echo $order['product_id'] ?>" class="text-dark">
            <div class="pt-1">
               <h5 class="card-title"><?php echo $order['p_name'] ?></h5>
               <p class="card-text"><?php echo $order['short_desc'] ?></p>
            </div>
            <div class="mt-3">
               <mark class="mr-0">&#8377;<?php echo $order['price'] ?></mark>
               <small><del>&#8377;<?php echo $order['discount_price'] ?></del></small>
               <span><small class="ml-1 text-success"><?php echo $order['discount_precentage'] ?>% off</small></span>
            </div>
         </a>
      </div>
   </div>
 </div>
  <?php 
    }
  ?>
 </div>
</div>

<!-- LATEST PRODUCT -->
<div class="container border-bottom mt-5 latest-best-product">
    <div class="row d-flex">
       <h5 class="mb-0">LATEST PRODUCT</h5>
       <p class="ml-auto mb-0"><a href="search_result.php" class="btn btn-dark shadow-none show_all">Show All</a></p>
    </div>
  </div>

  <div class="container card-images">
   <div class="row g-3">
      <?php 
         foreach($data as $product_data){
         ?>
      <div class="col-md-3 mt-3 pb-4" id="main-image-div">
         <div class="card rounded-0 border-0">
            <a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>">
            <div class="card-image_box">
            <img src="<?php echo $product_data['image'] ?>" class="card-img-top" alt="Card image cap">
            </div>   
         </a>
            <div class="hover-icon">
               <ul class="">
                  <li><a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $product_data['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a></li>
                  <li class="mt-1"><a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>"><i class="fa-solid fa-bag-shopping"></i></a></li>
               </ul>
            </div>
            <div class="card-body pb-0">
               <a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>" class="text-dark">
                  <div class="pt-1">
                     <h5 class="card-title"><?php echo $product_data['p_name'] ?></h5>
                     <p class="card-text"><?php echo $product_data['short_desc'] ?></p>
                  </div>
                  <div class="mt-3">
                     <mark class="mr-0">&#8377;<?php echo $product_data['price'] ?></mark>
                     <small><del>&#8377;<?php echo $product_data['discount_price'] ?></del></small>
                     <span><small class="ml-1 text-success"><?php echo $product_data['discount_precentage'] ?>% off</small></span>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <?php } ?>
   </div>
</div>
  <!-- Best Seller -->
  <?php 

    $join = "product_attribute pa ON product.product_id=pa.product_id";
    $obj->select('product','product.*,pa.price,pa.mrp,pa.quantity',$join,"best_seller = 1 GROUP BY product.product_id",null,4);
    $best_seller = $obj->getResult();
  
  ?>

  <div class="container border-bottom mt-5 latest-best-product">
    <div class="row d-flex">
       <h5 class="mb-0">BEST SELLER</h5>
       <p class="ml-auto mb-0"><a href="" class="btn btn-dark shadow-none show_all">Show All</a></p>
    </div>
  </div>

  <div class="container mt-4 card-images">
   <div class="row g-3">
      <?php 
         foreach($best_seller as $best_product){
         ?>
      <div class="col-md-3 mt-3" id="main-image-div">
         <div class="card rounded-0 border-0">
            <a href="product-deatail.php?id=<?php echo $best_product['product_id'] ?>">
            <img src="<?php echo $best_product['image'] ?>" class="card-img-top img-fit" alt="Card image cap">
            </a>
            <div class="hover-icon">
               <ul class="">
                  <li><a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $best_product['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a></li>
                  <li class="mt-1"><a href="product-deatail.php?id=<?php echo $best_product['product_id'] ?>"><i class="fa-solid fa-bag-shopping"></i></a></li>
               </ul>
            </div>
            <div class="card-body pb-0">
               <a href="product-deatail.php?id=<?php echo $best_product['product_id'] ?>" class="text-dark">
                  <div class="pt-1">
                     <h5 class="card-title"><?php echo $best_product['p_name'] ?></h5>
                     <p class="card-text"><?php echo $best_product['short_desc'] ?></p>
                  </div>
                  <div class="mt-1">
                     <mark class="mr-0">&#8377;<?php echo $best_product['price'] ?></mark>
                     <small><del>&#8377;<?php echo $best_product['discount_price'] ?></del></small>
                     <span><small class="ml-1 text-success"><?php echo $best_product['discount_precentage'] ?>% off</small></span>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <?php } ?>
   </div>
</div>
</div>
<?php
 include "includes/footer.php";
?>



 
