<?php 
       
ob_start();
       
  include "includes/header.php";
  include "includes/top-navbar.php";

?>

<?php 
  
  $obj = new Database();

  $product_id = $_GET['id'];
  $join= "main_category ON product.category = main_category.category_id
          LEFT JOIN product_attribute pa ON product.product_id=pa.product_id";

  $obj->select('product','product.*,main_category.category_name,pa.quantity,pa.price,pa.mrp',$join,"product.product_id='$product_id' GROUP BY product.product_id",null,null);
  $data = $obj->getResult();

?>
<link rel="stylesheet" href="css/All-Page.css">
<link rel="stylesheet" href="css/home.css">
 <div class="container mt-5">
   <div class="row">
     <div class="col-md-1">
        <?php
          $obj->select('product_images','*',null,"product_id='$product_id'",null,null);
          $producs_image = $obj->getResult();
        
          foreach($producs_image as $small_img){
          if($small_img['product_images']){
              echo '<div class="small-img">
                      <img src="'.$small_img['product_images'].'" class="w-100 d-block" onclick=showSmallImg("'.$small_img["product_images"].'")>
                    </div>';
          }
        }
        ?>
     </div>
       <?php 
         foreach($data as $result){
       ?>

     <div class="col-md-5" id="bigimg">
        <img src="<?php echo $result['image'] ?>" data-origin="<?php echo $result['image'] ?>" class="img-fluid w-100">
     </div>

     <div class="col-md-6 mx-auto">
        <h3>PRODUCT </h3>
        <h4 class="py-3 new_mrp d-none">&#8377;<?php echo $result['mrp'] ?></h4>
        <h4 class="py-3 new_price">&#8377;<?php echo $result['price'] ?></h4>
        <h5><?php echo $result['short_desc']; ?></h5>
        <h6 class="py-3">Product Name : <?php echo $result['p_name'] ?> </h6>
        <h6>Categories : <?php echo $result['category_name'] ?></h6>

   <!-- STOCK CHECK -->
      
    <?php

     $is_color='';
     $is_size='';

     $cart_box_show='hide_cart';
     $cart_show="yes";
     
     if($is_color==0 && $is_size==0){
      
      $cart_box_show='';
      
      $getProductAttribute = getProductAttribute($result['product_id']);
      $productSoldQtyByProductId = productSoldQtyByProductId($result['product_id'],$getProductAttribute); 
      
      $stock = '';
      if($result['quantity']>$productSoldQtyByProductId){
         $stock = "In Stock";
      }else{
        $stock = "Not In Stock";
        $cart_show="";
      }
    
     $pending_quantity = $result['quantity']-$productSoldQtyByProductId;
   
      ?>
    <!-- END STOCK CHECK -->
    
    <h6 class="py-3">Availability : <?php echo $stock ?></h6>
    <span id='Availqty' class=""><?php echo $pending_quantity ?></span>
    
    <?php } ?> 
    
    <!-- Colorb Size -->
        <?php 
          $join="color_manage color_m ON product_attribute.color_id = color_m.color_id AND color_m.status=1
                 LEFT JOIN size_master size_m ON product_attribute.size_id = size_m.size_id AND size_m.status=1";
          $obj->select('product_attribute','product_attribute.*,color_m.color,size_m.size',$join,"product_attribute.product_id='$product_id'",null,null);
          $attr = $obj->getResult();
         
          $sizeArr=[];
          $colorArr = [];
          $chaeck_color=[];
          $chaeck_size=[];
          
          foreach($attr as $attrdata){
            $colorArr[$attrdata['color_id']][] = $attrdata['color'];
            $sizeArr[$attrdata['size_id']][] = $attrdata['size'];
            $chaeck_color[] = $attrdata['color'];
            $chaeck_size[] = $attrdata['size']; 
          }
            $is_color = count(array_filter($chaeck_color));
            $is_size = count(array_filter($chaeck_size));

          // $colorArr = array_unique($colorArr);
          // $sizeArr = array_unique($chaeck_size);
          ?>
      <?php
        if($is_color>0){
      ?>
       <ul class="nav mt-4">
        <h6 class="pt-2">Color : </h6>
         <?php 
            foreach($colorArr as $key => $val){ 
             echo '<li class="nav-item mx-3" id="color-box">
                     <a style="background:'.$val[0].'" href="javascript:void(0)" class="nav-link active py-3" onclick=load_Attribute("'.$key.'","'.$attr[0]['product_id'].'","color")></a>
                  </li>';
            }
         ?>
       </ul>
       <?php } ?>

       <?php
          if($is_size>0){
       ?>
       <ul class="nav mt-4" id="size_attr">
         <h6 class="mt-2">Size : </h6>
         <?php
           foreach($sizeArr as $key => $val){
             echo "<li class='nav-item box shadow-sm' id='size-box'>
                      <a class='nav-link showQuantity' href='".$key."'>".$val[0]."</a>
                 </li>";
           }    
         ?>
        </ul>
        <?php } ?>

        <?php
           
          if($cart_show!=''){

          $ishideQuantity = "quantity_hide";
        
          if($is_color==0 && $is_size==0){
             $ishideQuantity = "";
          }
        ?>
      
    <p class="error_field ml-5 mt-3" id="attr_result_mag"></p>
  
   <!-- Quantity Div -->
    <div id="hide_quantity_cart_box">
      <div class="input-group mt-4 pb-3" id="<?php echo $ishideQuantity ?>">
        <div class="input-group-prepend">
          <span class="mt-2">Quantity : </span>
          <button class="input-group-text btn btn-light shadow-none" id="minus"><i class="fa-solid fa-angles-left"></i></button>
          <input type="number" id="quantity" name="quantity" class="value form-control pl-5 shadow-none" value="1"> 
          <button class="input-group-text btn btn-light shadow-none" id="plus"><i class="fa-solid fa-angles-right"></i></button>
        </div>
       </div> <!-- Quantity div Close -->
       
       <?php } ?>
      
     
   <!-- ADD TO CART BUY NOW BTN -->
     <div id="is_hide_cart_box" class="<?php echo $cart_box_show ?>">
       <div class="mt-4 pt-2">
         <a href="javascript:void(0)" onclick="shoping_cart('<?php echo $result['product_id'] ?>','add')" class="btn btn-primary btn-lg shadow-none text-md" id="cartbtn">Add To Cart</a>
         <a href="javascript:void(0)" onclick="shoping_cart('<?php echo $result['product_id'] ?>','add','buy_now_yes')" class="btn btn-primary btn-lg shadow-none text-md" id="buynow">Buy Now</a> 
       </div>
     </div>
    </div>

      <!-- SOCIAL ICON -->
       <div class="py-4 social-icon">
         <a target="_blank" href="https://facebook.com/share.php?u=<?php echo $url ?>"><img src="image/facebook.png" width="20"></a>
         <a target="_blank" href="https://twitter.com/share?text<?php echo $result['p_name'] ?>&url=<?php echo $url ?>"><img src="image/twitter.jpg" class="mx-3" width="20"></a>
         <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urldecode($url) ?> <?php echo $result['p_name'] ?>"><img src="image/whatsapp1.png" id="whatsapp" width="20"></a>
       </div>
      </div>
      <?php
        }
      ?>
    </div>
 </div>

  <input type="hidden" id="colorid">  <!-- Color Value -->
  <input type="hidden" id="sizeid">   <!-- Size Value -->
 
  <!-- DESCRIPTION PRODUCT -->
  <?php
     if(isset($_POST['rating_btn'])){
       $user_id = $_SESSION['id'];
       $rating= isset($_POST['rating']) ? $_POST['rating'] : '';
       $review= isset($_POST['review']) ? $_POST['review'] : '';
       $added_on = date('d-m-y h:i:s');

      $obj->insert('product_review',['product_id'=>$product_id,'user_id'=>$user_id,'rating'=>$rating,'review'=>$review,'status'=>1,'added_on'=>$added_on]);
     }
   ?>

  <!-- DESCRIPTON BOTTOM PART -->
    <div class="container py-5">
      <div class="row">
        <div class="col-md-12">
        <div id="accordion">
      <?php 
       if(isset($_SESSION['email'])){
      ?>
     <!-- <b class="bg-white  rounded-0">Description</b> -->
   
  
  <!-- RATING FORM -->
   <h3 class="bg-white border rounded-0"><b>Reviews</b></h3>
   <div class="border">
        <button type="button" class="shadow-none ml-2" id="rating_form_show"><i class="fas fa-star"></i>Add Review </button>
        <br><small class="ml-2">Please Review Our Product</small>
    
    <div id="rating_form_hide">
     <form method="post" class="py-3" id="rating_form">
        <div class="form-group col-md-6">
          <label>Rating</label>
            <select name="rating" id="rating" class="form-control shadow-none">
              <option>Select Rating</option>
              <option>Wrost</option>
              <option>Bad</option>
              <option>Good</option>
              <option>Very Good</option>
              <option>Fantastic</option>
            </select>
          <span class="error_field" id="rating_error"></span>
        </div>
        <div class="form-group col-md-6">
          <label>Review</label>
            <textarea name="review" id="review" cols="50" rows="2" class="form-control shadow-none" placeholder="Type your message here..."></textarea>
              <span class="error_field" id="review_error"></span>            
        </div>
        <div class="form-group">
          <input type="submit" name="rating_btn" id="rating_btn" value="Submit" class="ml-3 btn bnt-primary btn-lg">
        </div>
      </form>
      </div>
    <?php 
      }else{
        echo "<br><span class='text-dark text-sm ml-4'>Please <a href='login-registration.php'>Login</a> To Submit Your Review.</span>";
      }

      $join="user_registration ur ON product_review.user_id=ur.id";
      $obj->select('product_review','product_review.*,ur.name',$join,"product_id='$product_id' AND product_review.status='1'","product_review.review_id desc",null);
      $rating = $obj->getResult();
    
      if(empty($rating)){
         echo "<h6 class='ml-4 my-3'>No Reviews Available.</h6>";
       }else{
     foreach($rating as $rating_result){
     ?>

    <div class="border review_item my-3">
      <h6><i class="fas fa-star mr-1"></i><?php echo $rating_result['review'] ?></h6>
      <p><?php echo $rating_result['rating'] ?></p>
      <h5 class="review_user"><?php echo $rating_result['name'] ?> 
      <b class="float-right">
      <?php 
          $added_on =strtotime($rating_result['added_on']); 
           echo date('d-M-Y ',$added_on);
        ?>
      </b></h5>
    </div>

    <?php 
      }
     }
    ?>
      </div>
     </div>
    </div>
   </div>
</div>
    </div>
 <!-- DESCRIPTION PART CLOSE -->

 <!-- RECENT VIEW COKKIE -->
   <?php 
    
    // unset($_COOKIE['recently_viewed']);
     if(isset($_COOKIE['recently_viewed'])){
        $arrRecentview = unserialize($_COOKIE['recently_viewed']);
      
          $countRecentview = count($arrRecentview);
          $countRecentview = $countRecentview-8;
      if($countRecentview>8){
        $countstart = array_slice($arrRecentview,$countstart,$countRecentview);
        }
      
      $join = "product_attribute pa ON product.product_id=pa.product_id";
      $RecentviewId = implode(",",$arrRecentview);
      $obj->select('product','product.*,pa.price,pa.mrp,pa.quantity',$join," product.product_id IN ($RecentviewId) GROUP BY product.product_id",null,null);
      $data = $obj->getResult();
 ?>
 
  <!-- DISPLAY RECENT VIEW -->
   <div class="container card-images mt-5">
    <h4>RECENT VIEW</h4>
      <div class="row">
        <?php 
          foreach($data as $product_data){
        ?>
      <div class="col-md-3 mt-3 my-2" id="main-image-div">
        <div class="card rounded-0">   
            <a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>">
              <img src="<?php echo $product_data['image'] ?>" class="card-img-top img-fit">
            </a>
          <div class="hover-icon">
            <ul class="">
              <li class=""><a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $product_data['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a></li>
              <li class="mt-1"><a href="javascript:void(0)" onclick="shoping_cart('<?php echo $product_data['product_id'] ?>','add')"><i class="fa-solid fa-bag-shopping"></i></a></li>
            </ul>
          </div>
          <div class="card-body pb-0">
          <a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>" class="text-dark">
           <div class="pt-4">
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

  <?php 
    
    $arrRecent =unserialize($_COOKIE['recently_viewed']);
    if(($key=array_search($product_id,$arrRecent)) !== false){
        unset($arrRecent[$key]); 
      }
      $arrRecent[]= $product_id;
      setcookie('recently_viewed',serialize($arrRecent),time()+60*60*24*365);
    }else{
      $arrRecent[] = $product_id;
      setcookie('recently_viewed',serialize($arrRecent),time()+60*60*24*365);
    }
  ?>

  <script src="js-and-jquery/jquery.js"></script>
  <script>
      let is_color ="<?php echo $is_color ?>";
      let is_size = "<?php echo $is_size ?>"; 
      let product_id = "<?php echo $product_id ?>";
  </script>
  <?php 
  
   include "includes/footer.php";
   ob_flush();
 ?>
