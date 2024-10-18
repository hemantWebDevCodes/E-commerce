 <?php 
   
   include "includes/header.php";
   include "includes/top-navbar.php";

?>
 
 <?php 

$obj = new Database();
$cate_id = "";

if(isset($_GET['cate_id'])){
  $cate_id = $_GET['cate_id'];
  $_SESSION['CATEGORY_ID']=$cate_id;
}

// SUB CATEGORY ID
$sub_category = '';
if(isset($_GET['subcate_id'])){
   $sub_category=$_GET['subcate_id'];
}

$obj->select('category',"*",null,"category_id='$cate_id'",null,null);

//  SELECT DROPDOWN PRODUCT

$sort_order = "";
$price_low_selecte ="";
$price_high_selecte ="";
$new_selecte ="";
$old_selecte ="";


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

  if($sub_category!=''){
    $sub_category = " AND sub_category_id='$sub_category'";
  }

  if($cate_id!=''){
    $maincate_id = " product.category='$cate_id'";
  }
  $join="main_category mc ON product.category = mc.category_id 
  LEFT JOIN product_attribute pa ON product.product_id= pa.product_id";
  $obj->select('product','product.*,mc.category_name,pa.quantity,pa.price,pa.mrp',$join,"$maincate_id $sub_category AND product.status='1' GROUP BY product.product_id",$sort_order,null);
  $data = $obj->getResult();  

  ?>

<link rel="stylesheet" href="css/All-Page.css">
 <link rel="stylesheet" href="css/home.css">
 <link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="css/slick-theme.min.css">

<!-- SHORT BY PRICE -->
<div class="container mt-4">
  <div class="row">
      <div class="col-md-3 filter-acordian">
        <div class="filter border px-3">
           <h5 class="mt-4"><b>Filter</b></h5><hr>
          <div class="filter-title py-2 active-filter"><span>PRODUCT CATEGORY </span> <i class="fa fa-angle-down float-right"></i></div>
          <div class="acordian-body py-3">
              <ul class="nav flex-column">
                  <?php 
                     $obj->select('sub_categories','*',null,"category_id='$cate_id'",null,null); $product_cate = $obj->getResult(); foreach($product_cate as $pro_cate){ ?>

                  <li class="nav-item">
                      <a class="nav-link text-dark" href="category-product.php?cate_id=<?php echo $cate_id ?>&subcate_id=<?php echo $pro_cate['subcate_id'] ?>"><b><?php echo $pro_cate['subcate_name'] ?></b></a>
                  </li>
                  <?php } ?>
              </ul>
          </div>

          <div class="filter-title py-3"><span>PRICE</span><i class="fa fa-angle-up float-right"></i></div>
          <div class="acordian-body py-3">
              <div class="main-filter">
                  <b class="">Price range:</b>
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
      <div class="col-md-9">
          <div class="row border">
             <?php if(isset($data[0]['category_name'])){ ?>
               <div class="py-2 ml-3 mt-1"><h5><b><?php echo $data[0]['category_name']; ?></b></h5></div>
             <?php } ?>
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
              <!-- </div> -->
          </div>
      </div>
  </div>
</div>



<?php 
  include "includes/footer.php";
?>
