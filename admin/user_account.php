<?php 
 
 include "includes/header.php";
 include "includes/top-navbar.php";

?>
<?php 
 
  if(!isset($_SESSION['email'])){
    echo "<script> window.location.href='home.php'; </script>";
  }
  $user_id = $_SESSION['id'];  //Current User ID

  // Update User Account
  if(isset($_POST['update'])){
    $files = $_FILES['image'];   
    $file_name = $files['name'];
    $file_error = $files['error'];
    $file_tmp = $files['tmp_name']; 
    if ($file_error == 0) {
    $destfile = 'upload/'.$file_name;
    move_uploaded_file($file_tmp,$destfile);

    $user_id = $_SESSION['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
 
    $obj->update('user_registration',['name'=>$name,'email'=>$email,'mobile'=>$mobile,'image'=>$destfile],"id='$user_id'");
    print_r($obj->getResult());
  }
  }
  // Change Password
  $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
  $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';

  $obj->select('user_registration','*',null,"id='$user_id'",null,null);
  $row = $obj->getResult();

  if($row[0]['password']!= $current_password){
    //  echo "Plese Enter Your Currrent Valid Password";
  }else{
     $obj->update('user_registration',['password' =>$new_password],"id='$user_id'");
     print_r($obj->getResult());
     echo "update Password";
  }

  // SELECT PROFILE
  $obj->select('user_registration','*',null,"id='$user_id'",null,null);
  $user = $obj->getResult();
?>
 <link rel="stylesheet" href="css/All-Page.css">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3 d-md-block">
        <div class="card card-left rounded-0">
          <div class="card-header text-center profile-photo">
            <img src="image/avatar4.png" class="w-50 rounded-circle">
          </div>
          <div class="card-body">
            <nav class="nav d-md-block profile-ancer d-none">
              <a data-toggle="tab" class="nav-link text-dark active" aria-current="page" data-toggle="list" href="#myprofile">My Profile</a>
              <a data-toggle="tab" class="nav-link text-dark" href="#myorder"> MY Order</a>
              <a data-toggle="tab" class="nav-link text-dark" href="#changepassword" role="tab" aria-controls="messages">Change Password</a>
              <a data-toggle="tab" id="logout_pro" class="nav-link text-dark" href="#logout" role="tab" aria-controls="settings">Logout</a>
            </nav>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-lg-9">
        <div class="card rounded-0">
          <div class="card-header border_bottom mb-3 d-md-none">
            <ul class="nav nav-tabs card-header-tabs nav-fill">
               <li class="nav-item">
                  <a data-toggle="tab" class="nav-link active" href="#myprofile">My Profile</a>
               </li>
               <li class="nav-item">
                  <a data-toggle="tab" class="nav-link" href="#myorder">My Order</a>
               </li>
               <li class="nav-item">
                  <a data-toggle="tab" class="nav-link" href="#mywhislist">My Wishlist</a>
               </li>
               <li class="nav-item">
                  <a data-toggle="tab" class="nav-link" href="#changepassword">Change Password</a>
               </li>
               <li class="nav-item">
                  <a data-toggle="tab" class="nav-link" href="#logout">Logout</a>
               </li>
            </ul>
          </div>
          <div class="card-body rounded-0 tab-content border-0">

            <div class="tab-pane active py-3 mb-3" id="myprofile">
               <h4 class="d-inline font-weight-bold">USER PROFILE</h4>
               <button typt="button" class="btn btn-primary shadow-none float-right" id="show_profile_input"><i class="fa fa-user mr-2"></i>Update Account</button>
              <br><br> <hr>
            <div class="card-body" id="profile-body">
               <form method="POST" enctype="multipart/form-data">
                
                <?php
                    foreach($user as $row_select){
                ?>

                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $row_select['name'] ?>" class="form-control form-control-lg shadow-none">
                    <span class="error_field" id="update_name"></span>
                  </div>
                      
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $row_select['email'] ?>" class="form-control form-control-lg shadow-none">
                    <span class="error_field" id="update_email"></span>
                  </div>

                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" id="image" value="<?php echo $row_select['image'] ?>" class="form-control form-control-lg shadow-none">
                    <span class="error_field" id="update_name"></span>
                  </div>
                      
                  <div class="form-group">
                    <label for="">Mobile Number</label>
                    <input type="number" name="mobile" id="mobile" value="<?php echo $row_select['mobile'] ?>" class="form-control form-control-lg shadow-none">
                    <span class="error_field" id="update_mobile"></span>
                  </div>
                    <input type="button" name="update" class="btn btn-primary btn-lg shadow-none" onclick="update_account()" id="update_profile" value="SUBMIT">
                  <?php 
                    }
                  ?>
                 </form>
              </div>
              <div class="card-body">
                 <div class="row">
                  <?php 
                    $obj->select('user_registration','*',null,"id='$user_id'",null,null,null);
                    $user = $obj->getResult();
                    foreach($user as $data){
                  ?>
                  <div class="col-md-6 py-4">
                    <img src="image/avatar4.png" class="w-50 rounded-circle">
                  </div>
                  <div class="col-md-6">
                  <h6 class="py-4">Name : <?php echo $data['name'] ?></h6>
                    <h6>Email: <?php echo $data['email'] ?></h6>
                    <h6 class="py-4">Mobile No. <?php echo $data['mobile'] ?></h6>
                  </div>
                    <?php
                    } 
                    ?>
                  </div>
                 </div>
              </div>

      <!-- MY ORDER -->
       <div class="tab-pane" id="myorder">
        <div class="py-3">
          <h5>YOUR ORDER</h5>
        </div>
        <div class="row">
         <div class="col-md-5">
          <?php 
            // PRODUCT ORDER
            $user = $_SESSION['id'];
            $join = "order_status ON product_order.order_status = order_status.status_id";
            $where = "user_id=$user";
            $obj->select('product_order','*',$join,$where,null,null);
            $order_data = $obj->getResult();
            // CLOSE

            foreach($order_data as $order){
          ?>
          <div class="py-4 border-bottom user_account_order">
            <h6 class="py-1">Order Date :<span><?php echo $order['added_on'] ?></span></h6>
            <h6 class="py-1">Address : <span><?php echo $order['city'] ?> <?php echo $order['address'] ?></span></h6>
            <h6 class="py-1">Payment Type : <span><?php echo $order['payment_type'] ?></span></h6>
            <h6 class="py-1">Payment Status : <span><?php echo $order['payment_status'] ?></span></h6>
            <h6 class="py-1">Order Status : <span><?php echo $order['status_name'] ?></span></h6>
            <h6 class="py-1">Pincode : <span><?php echo $order['pincode'] ?></span></h6>
          </div>
          <?php
           } 
          ?>
          </div>
        <div class="col-md-7">
          <?php
            $order_id = $order['id'];
            $join= "product ON order_deatail.product_id = product.product_id 
                    LEFT JOIN product_order ON order_deatail.id = product_order.id";
            $where = "order_deatail.order_id=$order_id AND product_order.user_id=$user"; 
            $obj->select('order_deatail','p_name,image,price,quantity',$join,$where,null,null);
            $product = $obj->getResult();          
           
           foreach($product as $order_deatail){ 
          ?>
          <div class="row border-bottom user_account_order">
            <div class="col-md-6 py-4">
             <h6 width="300">Product Name : <span><?php echo $order_deatail['p_name'] ?></span></h6>
             <h6 class="py-1">Price : <span><?php echo $order_deatail['price'] ?></span></h6>
             <h6 class="py-1">Quantity : <span><?php echo $order_deatail['quantity'] ?></span></h6>
            </div>
            <div class="col-md-6">
            <h6><img src="<?php echo $order_deatail['image'] ?>" height="250"></h6>
            </div>
              <?php } ?>
          </div> 
       </div>
      </div>
       </div>
        
   <!-- MY WISHLIST -->
      

         <!-- Update Password -->
          <div class="tab-pane" id="changepassword">
            <div class="">
              <h4>Change Password</h4>
            </div>
            <hr>
            <form method="POST" id="password_form">
            <div class="card-body">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control form-control-lg shadow-none" placeholder="Enter Your Current Password">
                <span class="error_field" id="current_pass"></span>
              </div>
              <div class="form-group py-3">
                <label>New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control form-control-lg shadow-none" placeholder="Enter Your Current Password">
                <span class="error_field" id="new_pass"></span>
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg shadow-none" placeholder="Enter Your Current Password">
                <span class="error_field" id="confirm_pass"></span>
              </div>
              <button type="button" value="Submit" class="btn btn-primary btn-lg shadow-none mt-2" onclick="change_password()" id="change_password_btn">SUBMIT</button>
            </div>
            </form>
           </div>
      </div>
    </div>
  </div>
  <script src="js-and-jquery/jquery.js"></script>
  <script>
    $(document).ready(function(){
      $("#logout_pro").click(function(){
        window.location.href='logout.php';
      });
    });
  </script>
<?php 

 include "includes/footer.php"; 

?>