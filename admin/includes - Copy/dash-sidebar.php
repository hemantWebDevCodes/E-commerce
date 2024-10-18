
  <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar col-md-3 sidebar-dark-primary elevation-4">
  
      <!-- Sidebar Logo -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-2 mb-3 d-flex">
        <div class="image">
          <img src="image/logo1.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="home.php" class="d-block"><h4>E-Shop<h4></a>
        </div>
      </div>


      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
   

            <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                dashboard
              </p>
            </a>
         </li>
          <li class="nav-item">
                <a href="product-handel.php" class="nav-link">
                  <i class="fa fa-shopping-cart text-light"></i>
                  <p>Proucts</p>
                </a>
              </li>  
          <li class="nav-item">
        <?php 
           if($_SESSION['ADMIN_ROLE']==1){
              echo "<a href='order_vendor.php' class='nav-link'>";
            }else{
              echo "<a href='order-admin.php' class='nav-link'>";
            }
           ?>
           <i class='fas fa-dot-circle mr-2'></i>
                 <p>Order</p>
            </a>
          </li>
      <?php 
         if($_SESSION['ADMIN_ROLE'] != 1){ 
       ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
              Category
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="main-category.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Main Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sub-category.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Sub Category</p>
                </a>
              </li>   
            </ul>
          </li>
          <li class="nav-item">
                <a href="size_manage.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p> Size Manage</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="color_manage.php" class="nav-link">
            <i class='fas fa-dot-circle mr-2'></i>
              <p> Color Manage</p>
            </a>
          </li>
          <li class="nav-item">
                <a href="product_review.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Product Review</p>
                </a>
              </li> 
          <li class="nav-item">
                <a href="banner.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Banner</p>
                </a>
              </li> 
          <li class="nav-item">
            <a href="#" class="nav-link">
             <i class="fas fa-user"></i>
              <p class="ml-2">
                Auth
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin_login.php" class="nav-link">
                 <i class='fas fa-dot-circle mr-2'></i>
                  <p>Login </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin_register.php" class="nav-link">
                  <i class='fas fa-dot-circle mr-2'></i>
                  <p>Register</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="admin_logout.php" class="nav-link">
                  <i class='fas fa-dot-circle mr-2'></i>
                  <p>Logout</p>
                </a>
              </li>
            </ul>
          </li>
              <li class="nav-item">
                <a href="vendor_manage.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p> Vender Manage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="coupon-manage.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Coupon </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="contect-massage-store.php" class="nav-link">
                <i class='fas fa-dot-circle mr-2'></i>
                  <p>Contects </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-user-cog"></i>
                  <p class="ml-2">
                   Profile
                  </p>
                </a>
            </li>
          <?php
          
           }
          ?>
            </ul>
          </nav>
        </div>
      </aside>
    <!-- /.sidebar -->
