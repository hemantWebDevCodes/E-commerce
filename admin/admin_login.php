<?php 

session_start();

include "database.php";

$obj = new Database();

 if(isset($_SESSION['ADMIN_USERNAME'])){
    echo "<script>window.location.href='dashbord.php';</script>";
 }

 $error='';   
 if(isset($_POST['login'])){
  $admin_name = $_POST['admin_name'] ? $_POST['admin_name'] : '';
  $admin_password = $_POST['admin_password'] ? $_POST['admin_password'] : '';

 $obj->select('admin_user','*',null,"username='$admin_name' && password='$admin_password'",null,null);
 $condition = $obj->getResult();
 
 if($condition){ 
   if($condition[0]['status'] == '0'){
      $error = "<script>swal('Sorry', 'Your Account is Deactivated', 'error');</script>";
   }else{
     $_SESSION['ADMIN_USERNAME'] = $admin_name;
     $_SESSION['ADMIN_PASSWORD'] = $admin_password;
     $_SESSION['ADMIN_ID']=$condition[0]['admin_id'];
     $_SESSION['ADMIN_ROLE']=$condition[0]['role'];
     header('location:main-category.php');
   }
 }else{
   $error = "<script>swal('Login Unsuccessfull', 'Invalid Your UserName And Password', 'error');</script>";
}
}
?>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/All-Page.css">
<div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-5 mx-auto py-5 mt-5">
            <div class="card rounded-0">
                <div class="card-header admin-header text-center">
                    <h3>Admin Login Form</h3>
                </div>
                <form method="post">
                    <div class="card-body" id="admin_login_form">
                        <div class="form-group py-2">
                            <label for="">Name</label>
                            <input type="text" id="admin_name" name="admin_name" class="form-control form-control-lg shadow-none" placeholder="Enter Name">
                            <span class="error_field" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" id="admin_password" name="admin_password" class="form-control shadow-none form-control-lg" placeholder="Enter Password">
                            <span class="error_field" id="password_error"></span>
                        </div>
                        <div class="form-group py-2">
                            <input type="submit" onclick="adminlogin()" name="login" value="Login" id="admin_login" class="btn btn-dark shadow-none form-control-lg">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js-and-jquery/jquery.js"></script>
<script src="js-and-jquery/sweet-alert.js"></script>

<?php 

 echo $error;
 
?>
