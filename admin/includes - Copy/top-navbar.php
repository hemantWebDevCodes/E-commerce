<?php 

?>

<?php 
$obj = new Database();

$cart = new shopcart();

$totelcart = $cart->totalcart();

// Toatal Wishlist
if(isset($_SESSION['email'])){
  $user_id = $_SESSION['id'];
  $join="product p ON wishlist.wishlist_id = p.product_id LEFT JOIN product_attribute pa ON p.product_id = pa.product_id";
  $where="wishlist.user_id='$user_id'";
  $obj->select('wishlist','wishlist.wishlist_id,p.image,p.p_name,pa.price',$join,$where,null,null);
  $totalwish = count($obj->getResult());
  
}

?>
  <link rel="stylesheet" href="css/navbar.css">
  <!-- <div class="navbar-fixed-top fixed-top"> -->
     <!-- <nav class="navbar navbar-expend-md navbar-white border py-3" id="topnav"> -->
   <div class="container py-2" id="topnav">
    <div class="row">
      <div class="col-md-3 mt-3">
     <a class="navbar-brand" href="#">
       <h4 class="text-dark">EcoShop</h4> 
    </a>
      </div>
      <div class="col-md-5 mt-2">
      <div class="position-relative">
        <form action="search_result.php" id="search_form" class="d-flex search-form rounded-0" method="GET">
            <input type="search" name="search_box" id="search_box" class="form-control shadow-none form-control-lg" autocomplete="off" placeholder="Search Product Here..." aria-label="Search">
                <button type="submit" class="px-3" id="search_btn"><i class="fas fa-search"></i></button>
          </form>
        <div class="position-absolute search-content">
          <div id="search_suggetion">
          
          </div>
        </div>
      </div>
      </div>



      <div class="col-md-4">
        <ul class="nav" id="nav-link">
        <li class="nav-item">
          <a class="nav-link" href="user_account.php"><i class="fa-regular fa-user ml-5"></i><br>
          <span class="ml-3"> My Account</span>
          </a>
        </li>
        <li class="nav-item">
          <?php 
            if(isset($_SESSION['email'])){
          ?>
          <a class="nav-link" href="wishlist.php"><i class="fa-regular fa-heart ml-4"></i><sup><?php echo $totalwish ?></sup><br>
          <span class="ml-2">Wishlist</span>
          </a>
          <?php 
            }
          ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping ml-2"></i><sup class="cart_count"><?php echo $totelcart ?></sup><br>
          <span class="cart_count mr-5">Cart</span>
          </a>
        </li>
       </ul> 
       </div>
    </div>
   </div>
     
  <!-- Second Navbar -->
    <nav class="navbar navbar-expand-md p-0" id="second-navbar" style="background-color:#059473;">    
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php 
            $obj->select('main_category','*',null,"category_role='1'",null,null);
            $category = $obj->getResult();
          ?>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="home.php" class="nav-link">Home</a>
          </li>
          <?php
            foreach($category as $row){
          ?>
           <li class="nav-item" id="dropdown">
              <a class="nav-link" href="category-product.php?cate_id=<?php echo $row['category_id'] ?>" >
                  <?php echo $row['category_name'] ?></a>
                <?php 
                    $main_cateid = $row['category_id'];
                    $obj->select('sub_categories','*',null,"category_id='$main_cateid' AND status='1'",null,null);
                    $sub_cate = $obj->getResult();
                    if(!empty($sub_cate)){
                ?>
              <ul class="navbar-nav mx-auto" id="dropdown-content">
                <?php 
                    foreach($sub_cate as $sub_category){
                      echo "<li class='nav-item'><a href='category-product.php?cate_id=".$row['category_id']."&subcate_id=".$sub_category['subcate_id']."'
                            class='nav-link'>".$sub_category['subcate_name']."</a></li>";
                    }
                ?>
              </ul>
            <?php } ?>
           </li>
          <?php
            }
          ?>
          <li class="nav-item ml-auto">
            <a href="contect.php" class="nav-link"> Contect </a>         
          </li>
          <?php 
           if(isset($_SESSION['email'])){
            echo " <li class='nav-item'><a href='My-Order.php' class='nav-link'>My Order</a></li>";
            echo " <li class='nav-item'><a href='logout.php' class='nav-link'> Log Out </a></li>";
           }else{
            echo " <li class='nav-item'><a href='login-registration.php' class='nav-link'>login/Registration </a></li>";
          }

          ?>
        </ul>
      </div>
    </nav>
  <!-- </div> -->
