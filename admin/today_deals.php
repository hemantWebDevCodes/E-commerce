<?php 
  
  include "includes/header.php";
  include "includes/top-navbar.php";
  
?>

<link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="css/slick-theme.min.css">
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/All-Page.css">

<!-- TODAY DEAL -->
<div class="container border-bottom mt-5 latest-best-product">
    <div class="row d-flex">
       <h5 class="mb-0">TODAY DEAL</h5>
    </div>
  </div>

<div class="container card-images">
 <div class="row g-3">
<?php 
    $join = "product p ON order_deatail.product_id = p.product_id";
    $obj->select('order_deatail','order_deatail.*,p.p_name,p.image,p.short_desc,p.discount_precentage,p.discount_price',$join,null,null,8);
    $order_data = $obj->getResult();
    foreach($order_data as $order){
?>
    <div class="col-md-3 mt-3 pb-4" id="main-image-div">
       <div class="card rounded-0 border-0">
          <a href="product-deatail.php?id=<?php echo $order['product_id'] ?>">
          <img src="<?php echo $order['image'] ?>" class="card-img-top img-fit" alt="Card image cap">
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
    <?php } ?>
 </div>
</div>
 <!-- PAGINATION -->
 <?php 
     echo $obj->pagination('order_deatail',$join,null,8);
   ?>
 <!-- CLOSE -->
<?php
  include "includes/footer.php";
?>