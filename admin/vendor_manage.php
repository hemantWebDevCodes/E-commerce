<?php

  include "includes/dash-header.php";
  include "includes/dash-top-nav.php";
  include "includes/dash-sidebar.php";
  include "database.php";

isAdmin();
?>
<?php 
 
 $obj = new Database();

 //VENDOR ADD 
$error = '';
// if(isset($_POST['submit'])){
  $admin_name = isset($_POST['username']) ? $_POST['username'] : '';
  $admin_email = isset($_POST['email']) ? $_POST['email'] : '';
  $admin_password = isset($_POST['password']) ? $_POST['password']: '';
  $admin_mobile = isset($_POST['admin_mobile']) ? $_POST['admin_mobile'] : '';

  $obj->select('admin_user','username,email',null,"username='$admin_name'",null,null);
  $check_exit = $obj->getResult();

  if($check_exit){
    $error = "<script>swal('Sorry', 'Your Email AllReady Exists.', 'error');</script>";
  }else{
  $value=['username'=>$admin_name,'email'=>$admin_email,'password'=>$admin_password,'admin_mobile' =>$admin_mobile,'role'=>1,'status'=>1];
  $obj->insert('admin_user',$value);

//   }
}

// UPDATE VANDOR
 if(isset($_POST['update'])){
  $update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';
  $admin_name = isset($_POST['username']) ? $_POST['username'] : '';
  $admin_email = isset($_POST['email']) ? $_POST['email'] : '';
  $admin_password = isset($_POST['password']) ? $_POST['password']: '';
  $admin_mobile = isset($_POST['admin_mobile']) ? $_POST['admin_mobile'] : '';

  $value=['username'=>$admin_name,'email'=>$admin_email,'password'=>$admin_password,'admin_mobile' =>$admin_mobile];
  $obj->update('admin_user',$value,"admin_id='$update_id'");
 }

// VENDER DELETE
  $delete_id = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
   $obj->delete('admin_user',"admin_id='$delete_id'");
 
// ACTIVE DEACTIVE VENDOR
if(isset($_GET['type']) && $_GET['type'] != ''){
    $type = $_GET['type'];
    if($type == 'status'){
     $Deactive = $_GET['vendor'];
     $id = $_GET['id'];
     if($Deactive == 'Active'){
       $status = '1';
     }else{
       $status = '0';
     }
   $obj->update('admin_user',['status'=>$status],"admin_id = '$id'");
    }
}
?>
<link rel="stylesheet" href="css/All-Page.css">
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto mt-4">
                <div class="card rounded-0 py-2 px-3">
                  <div class="">
                    <input type="button" value="ADD VENDOR" id="add-vendor" class="btn btn-dark btn-lg shadow-none">
                    <input type="button" value="UPDATE VENDOR" id="update-vendor" class="btn btn-dark  btn-lg shadow-none">
                </div>
                </div>
                <div class="card rounded-0" id="vendor-none">
                    <div class="card-header">
                        <h4>ADD VENDOR</h4>
                    </div>
                    <form method="post" id="vendor-register">
                        <div class="card-body" id="admin_registration">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="username" id="username" class="form-control shadow-none form-control-lg" placeholder="Enter Name">
                                    <span class="error_field" id="name_error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control shadow-none form-control-lg" placeholder="Enter Email">
                                    <span class="error_field" id="email_error"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Password</label>
                                    <input type="password" name="password" id="password" class="form-control shadow-none form-control-lg" placeholder="Enter Password">
                                    <span class="error_field" id="password_error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Mobile</label>
                                    <input type="number" name="admin_mobile" id="admin_mobile" class="form-control shadow-none form-control-lg" placeholder="Enter Mobile Number">
                                    <span class="error_field" id="mobile_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="button" onclick="admin_rgister()" name="submit" value="Submit" id="admin_registerbtn" class="btn btn-primary shadow-none btn-lg">
                            </div>
                        </div>
                    </form>
                </div>
            <!-- VENDOR UPDATE FORM -->
            <div class="card rounded-0" id="vendor-update-form">
                    <div class="card-header">
                        <h4>UPDATE VENDOR</h4>
                    </div>
                    <form method="post">
                        <?php 
                          $update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';
                           $obj->select('admin_user','*',null,"admin_id='$update_id'",null,null);
                           $vender = $obj->getResult();
                           foreach($vender as $row){
                        ?>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control shadow-none form-control-lg">
                                    <span class="error_field" id="name_error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control shadow-none form-control-lg">
                                    <span class="error_field" id="email_error"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Password</label>
                                    <input type="password" name="password" value="<?php echo $row['password'] ?>" class="form-control shadow-none form-control-lg">
                                    <span class="error_field" id="password_error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Mobile</label>
                                    <input type="number" name="admin_mobile" value="<?php echo $row['admin_mobile'] ?>" class="form-control shadow-none form-control-lg">
                                    <span class="error_field" id="mobile_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="UPDATE" id="admin_update" class="btn btn-primary shadow-none btn-lg">
                            </div>
                        </div>
                        <?php
                           }
                        ?>
                    </form>
                </div>
                <table class="table table-light table-hover text-center">
                    <thead>
                        <tr>
                            <th>Vendor Id</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Mobile</th>
                            <th>Action</th>
                            <th>Delete</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                         $obj->select('admin_user','*',null,"role='1'",null,6);
                         $data = $obj->getResult();
                         foreach($data as $vendor){
                        ?>
                        <tr class="tabletd">
                            <td><?php echo $vendor['admin_id'] ?></td>
                            <td><?php echo $vendor['username'] ?></td>
                            <td><?php echo $vendor['email'] ?></td>
                            <td><?php echo $vendor['password'] ?></td>
                            <td><?php echo $vendor['admin_mobile'] ?></td>
                            <?php 
                              if($vendor['status'] == 1){
                                echo "<td><a href='?type=status&vendor=Deactive&id=" . $vendor['admin_id'] . "' class='btn btn-primary active'>Active</a></td>";
                              }else{
                                echo "<td><a href='?type=status&vendor=Active&id=". $vendor['admin_id']."' class='btn btn-success Deactive'>Deactive</a></td>";
                               }
                            ?>
                            <td><a href="?update_id=<?php echo $vendor['admin_id'] ?>" class="update_a"><i class="fa-solid fa-square-pen mt-0 update_a"></i></a></td>
                            <td><a href="?delete_id=<?php echo $vendor['admin_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
                        </tr>
                        <?php
                         }
                       ?>
                    </tbody>
                </table>
                <!-- PAGINATION -->
                <?php 
                echo $obj->pagination('admin_user',null,null,6);
                ?>
                <!-- CLOSE -->
            </div>
        </div>
    </div>
</div>
</div>

<script src="js-and-jquery/jquery.js"></script>
<script>
    $("#add-vendor").click(function() {
        $("#vendor-none").fadeToggle();
    });
    $("#update-vendor").click(function(){
        $("#vendor-update-form").fadeToggle();
    });

</script>
<?php

   include "includes/dash-footer.php";

?>
<?php 
   
   echo $error;
   
?>