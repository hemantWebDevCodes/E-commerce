<?php
 
  include "database.php";

  $obj = new Database();
 
?> 

 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/All-Page.css">

<?php 
 $obj->select('sub_categories','*',null,null,3,null);
 echo "<pre>";
 print_r($obj->getResult());
  
 echo $obj->pagination('sub_categories',null,null,3);

?>

<?php 
 
  include "database.php";
  
?>
 
  <?php
     
     $obj = new Database();

   //   if(isset($_POST['search_tearm'])){
        $search = isset($_POST['search_tearm']) ? $_POST['search_tearm'] : '';

        $join = "product_attribute pa ON product.product_id=pa.product_id";
        $obj->select('product','product.*,pa.price,pa.quantity,pa.mrp',$join,"product.p_name LIKE '%$search%' OR product.short_desc LIKE '$search%' GROUP BY product.product_id",null,null);
        $product_data = $obj->getResult();
        $search='';    
        if(!empty($product_data)){
          foreach($product_data as $search_data){

        $search .='<div class="col-md-3 mt-3" id="main-image-div">
         <div class="card rounded-0 border-0">
            <a href="product-deatail.php?id='.$search_data["product_id"].'">
            <img src="'.$search_data["image"].'" class="card-img-top img-fit" alt="Card image cap">
            </a>
            <div class="hover-icon">
               <ul class="">
                  <li><a href="javascript:void(0)" onclick="manage_wishlist("'.$search_data["product_id"].'","add")"><i class="fa-regular fa-heart"></i></a></li>
                  <li class="mt-1"><a href="product-deatail.php?id='.$search_data["product_id"].'"><i class="fa-solid fa-bag-shopping"></i></a></li>
               </ul>
            </div>
            <div class="card-body pb-0">
               <a href="product-deatail.php?id='.$search_data["product_id"].'" class="text-dark">
                  <div class="pt-1">
                     <h5 class="card-title">'.$search_data["p_name"].'</h5>
                     <p class="card-text">'.$search_data["short_desc"].'</p>
                  </div>
                  <div class="mt-3">
                     <mark class="mr-0">&#8377;'.$search_data["price"] .'</mark>
                     <small><del>&#8377;'.$search_data["discount_price"] .'</del></small>
                     <span><small class="ml-1 text-success">'.$search_data["discount_precentage"].' % off</small></span>
                  </div>
               </a>
            </div>
         </div>
      </div>';
      echo $search;
     }
   }else{
     echo "<h4 class='text-center text-danger my-5 mx-auto'>No Search Found</h4>";
   }
     
  ?>
