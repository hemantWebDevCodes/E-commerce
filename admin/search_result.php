<?php 
   
   include "includes/header.php";
   include "includes/top-navbar.php";

?>
 
 <?php 

$obj = new Database();

// MAIN CATEGORY ID
$cate_id = $_SESSION['CATEGORY_ID'];

//  SELECT DROPDOWN PRODUCT
$sort_order = "";
 $search_item='';
 
 $price_low_selecte = "";
 $price_high_selecte = "";
 $new_selecte = "";
 $old_selecte = "";

 if(isset($_GET['search_box'])){
   $searches = $_GET['search_box'];

  $obj->select('sub_categories','*',null,"subcate_name='$searches'",null,null);
  $datas = $obj->getResult();
  $search_item = $datas[0]['subcate_id'];

if(isset($_GET['sort'])){
  $sort = $_GET['sort'];

  if($sort == "price_low"){
    $sort_order = "pa.price desc";
    $price_low_selecte = "selected";
  }
  if($sort == "price_high"){
    $sort_order = "pa.price asc";
    $price_high_selecte = "selected";
  }
  
  if($sort == "new"){
    $sort_order = "product_id desc";
    $new_selecte = "selected";
  }      
  if($sort == "old"){
    $sort_order = "pa.product_id asc";
    $old_selecte= "selected";
   }
  }

    $join="sub_categories sc ON product.sub_category_id = sc.subcate_id 
    LEFT JOIN product_attribute pa ON product.product_id= pa.product_id";
    $obj->select('product','product.*,sc.subcate_name,sc.subcate_id,pa.quantity,pa.price,pa.mrp',$join,"product.status='1' AND product.sub_category_id=$search_item GROUP BY product.product_id",$sort_order,null);
 }else{
    $join="sub_categories sc ON product.sub_category_id = sc.subcate_id 
    LEFT JOIN product_attribute pa ON product.product_id= pa.product_id";
    $obj->select('product','product.*,sc.subcate_name,sc.subcate_id,pa.quantity,pa.price,pa.mrp',$join,"product.status='1' GROUP BY product.product_id",$sort_order,6);
 }
  $data = $obj->getResult();  
?>

<link rel="stylesheet" href="css/All-Page.css">
 <link rel="stylesheet" href="css/home.css">
 <link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="css/slick-theme.min.css">

 <!-- BANNER IMAGES -->
  
  <?php 
    $obj->select('banner','*',null,"main_bcategory='$cate_id'",null,null);
    $banner = $obj->getResult();
  ?>

<!-- SHORT BY PRICE -->
<div class="container mt-4">
  <div class="row">
      <div class="col-md-3 filter-acordian">
        <div class="filter px-4 border">
        <h5 class="mt-3"><b>Filter</b></h5><hr>
          <div class="filter-title py-2 active-filter"><span>PRODUCT CATEGORY</span> <i class="fa fa-angle-down float-right"></i></div>
          <div class="acordian-body py-3">
              <ul class="nav flex-column">
                  <?php 
                     $obj->select('main_category','*',null,"category_id='$cate_id'",null,null);
                     $product_cate = $obj->getResult();
                     foreach($product_cate as $pro_cate){
                      if(isset($_GET['search_box'])){
                   ?>

                  <li class="nav-item">
                    <a class="nav-link text-dark" href="category-product.php?cate_id=<?php echo $cate_id ?>"><b><i class='fas fa-angle-right'></i> <?php echo $pro_cate['category_name'] ?></b></a>
        
                  <?php } } ?>

                <ul class="nav flex-column ml-4">
                    <?php
                     if(isset($_GET['search_box'])){
                      $obj->select('sub_categories','*',null,"category_id='$cate_id'",null,null);
                      $subcate = $obj->getResult();
                      foreach($subcate as $subcategory_cate){ ?>
                  
                   <li class="nav-item" style="margin-top: -10px;">
                     <a href="category-product.php?<?php echo $product_cate[0]['category_id'] ?>&subcate_id=<?php echo $subcategory_cate['subcate_id'] ?>" class="nav-link text-dark"><b><?php echo $subcategory_cate['subcate_name'] ?></b></a>
                   </li>
                   
                  <?php
                     } 
                    }else{
                      $obj->select('main_category','*',null,null,null,null);
                      $maincate = $obj->getResult();
                      foreach($maincate as $maincategory_cate){    
                  ?>
                  
                  <li class="nav-item" style="margin-top: -10px;">
                     <a href="category-product.php?cate_id=<?php echo $maincategory_cate['category_id'] ?>" class="nav-link text-dark"><b><?php echo $maincategory_cate['category_name'] ?></b></a>
                   </li>
                  
                  <?php 
                    }
                  }
                    ?>
                  </ul>
                </li>
              </ul>
          </div>

          <div class="filter-title py-3"><span>PRICE</span><i class="fa fa-angle-up float-right"></i></div>
          <div class="acordian-body py-3">
              <div class="main-filter">
                  <b class="">Price Range:</b>
                  <div id="slider-range"></div>

                  <div class="form-row mt-5" id="filter-input">
                      <div class="form-group col-6">
                          <label>Min :</label>
                          <input type="number" min="0" max="999990" oninput="validity.valid||(value='0');" id="min_price" class="form-control shadow-none" />
                      </div>
                      <div class="form-group col-6">
                          <label>Max :</label>
                          <input type="number" min="0" max="100000" id="max_price" oninput="validity.valid||(value='10000');" class="form-control shadow-none" />
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-9 mb-5">
          <div class="row border ml-1">
            <div class="py-3 ml-3">
               <h5><b>
                 <?php 
                  if(isset($_GET['search_box'])){
                     echo $data[0]['subcate_name']; 
                   }else{
                    echo '<h5><b>All Products</b></h5>';
                   } ?>
               </b></h5></div>
              <form class="form-inline mr-2 ml-auto my-2">
                  <div class="form-group input-group-md">
                      <label class="mr-2">Short By </label>
                      <select id="sort_product_id" onchange="sort_product_select('<?php echo $cate_id ?>','<?php echo SITE_PATH ?>')" class="form-control short-by-choose shadow-none">
                          <option>Defult Sopping</option>
                          <option value="price_low" <?php echo $price_low_selecte ?> >Sort By Price low To High</option>
                          <option value="price_high" <?php echo $price_high_selecte ?> >Sort By Price hight To Low</option>
                          <option value="new" <?php echo $new_selecte ?>>Sort By New First</option>
                          <option value="old" <?php echo $old_selecte ?>>Sort By Old First</option>
                      </select>
                  </div>
              </form>
          </div>

          <!-- CATEGORY PRODUCT -->
          <div class="row card-images mt-4" id="result_filter">
              <?php 
       foreach($data as $product_data){
    ?>
              <div class="col-md-4 mt-3 my-2" id="main-image-div">
                  <div class="card rounded-0 border-0">
                      <a href="product-deatail.php?id=<?php echo $product_data['product_id'] ?>">
                          <img src="<?php echo $product_data['image'] ?>" class="card-img-top img-fit" />
                      </a>
                      <div class="hover-icon">
                          <ul class="">
                              <li class="">
                                  <a href="javascript:void(0)" onclick="manage_wishlist('<?php echo $product_data['product_id'] ?>','add')"><i class="fa-regular fa-heart"></i></a>
                              </li>
                              <li class="mt-1">
                                  <a href="javascript:void(0)" onclick="shoping_cart('<?php echo $product_data['product_id'] ?>','add')"><i class="fa-solid fa-bag-shopping"></i></a>
                              </li>
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
                                  <small>
                                      <del>&#8377;<?php echo $product_data['discount_price'] ?></del>
                                  </small>
                                  <span>
                                      <small class="ml-1 text-success"><?php echo $product_data['discount_precentage'] ?>% off</small>
                                  </span>
                              </div>
                          </a>
                      </div>
                  </div>
              </div>
              <?php } ?>
          </div>
      </div>
  </div>
</div>
    <!-- PAGINATION -->
    <?php 
     if(!isset($_GET['search_box'])){
      echo $obj->pagination('product',null,null,6);
     }
    ?>
    <!-- PAGINATION -->


<?php 
  include "includes/footer.php";
?>
