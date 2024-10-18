<?php 

 include "includes/dash-header.php";
 include "includes/dash-top-nav.php";
 include "includes/dash-sidebar.php";
 include "database.php";

 isAdmin();
?>

<?php 

  $obj = new Database();

   $success = '';
   $error = '';
 // ADD COUPON  
  if(isset($_POST['coupon_submit'])){
    $coupon_code = $_POST['coupon_code'];
    $coupon_type = $_POST['coupon_type'];
    $coupon_value = $_POST['coupon_value'];
    $coupon_min_value = $_POST['coupon_min_value'];
    $expire_date = $_POST['expire_date'];

    $obj->select('coupon','*',null,"coupon_code='$coupon_code'",null,null);
    $check = $obj->getResult();
    
    if(!empty($check)) {
      $error = "<script>swal('Sorry', 'Coupon Code already exists', 'error');</script>";
    }else {
      
    $obj->insert('coupon',['coupon_code'=>"$coupon_code","coupon_type"=>"$coupon_type",'coupon_value'=>"$coupon_value",
                           'coupon_min_value'=>"$coupon_min_value",'expire_date'=>"$expire_date",'status'=>'1']);
    $insert = $obj->getResult();
    if($insert){
      $success = "<script>swal('Thank You', 'Coupon Successfull Added', 'success');</script>";
    }else{
      $error = "<script>swal('Sorry', 'Coupon Not Added', 'error');</script>";
    }
    }
  }

  // COUPON UPDATE 
  if(isset($_POST['coupon_submit'])){
    $update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';
    $coupon_code = $_POST['coupon_code'];
    $coupon_type = $_POST['coupon_type'];
    $coupon_value = $_POST['coupon_value'];
    $coupon_min_value = $_POST['coupon_min_value'];
    $expire_date = $_POST['expire_date'];
      
    $obj->update('coupon',['coupon_code'=>"$coupon_code","coupon_type"=>"$coupon_type",'coupon_value'=>"$coupon_value",
                           'coupon_min_value'=>"$coupon_min_value",'expire_date'=>"$expire_date"],"coupon_id='$update_id'");
    $insert = $obj->getResult();
    if($insert){
      $success = "<script>swal('Thank You', 'Coupon Successfull Update', 'success');</script>";
    }else{
      $error = "<script>swal('Sorry', 'Coupon Not Update', 'error');</script>";
    }
    }

 //DELETE COUPON
   $delete_id = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
   $obj->delete('coupon',"coupon_id='$delete_id'");
  
   // Active Deactive
  if(isset($_GET['type']) && $_GET['type'] != ''){
     $type = $_GET['type'];
   if($type == 'status'){
     $Deactive = $_GET['coupon'];
     $id = $_GET['id'];
   if($Deactive == 'Active'){
      $role = '1';
    }else{
      $role = '0';
    }
   $obj->update('coupon',['status'=>$role],"coupon_id = '$id'");
    }
 
  }

  // SELECT FORM DATA
  $update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';
  $obj->select('coupon','*',null,"coupon_id='$update_id'",null,null);
  $select_form = $obj->getResult();
?>
<link rel="stylesheet" href="css/All-Page.css">
 <div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                <div class="card rounded-0 mt-4">
                    <div class="card-header">
                    <button type="button" class="btn btn-primary btn-lg col-3" id="show_coupon">ADD COUPON</button>
                    <button type="button" class="btn btn-primary btn-lg col-3" id="update_coupon_btn">UPDATE COUPON</button>
                  </div>
            <!-- ADD COUPON -->
                      <div class="card-body rounded-0" id="coupon_form">
                      <form method="POST">
                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="Name">Coupon Code</label>
                             <input type="text" name="coupon_code" class="form-control form-control-lg shadow-none" placeholder="Product Coupon Code" required>
                           </div>                        
                          <div class="form-group col-6">
                            <label for="">Coupon Type</label>
                            <select name="coupon_type" class="form-control form-control-lg shadow-none">
                              <option value="">Select</option>
                             <?php 
                               if($coupon_type =='Percentage'){
                                 echo "<option value='Percentage' selected>Percentage</option>";
                               }elseif($coupon_type == 'Rupee'){
                                 echo "<option value='percentage'>Percentage</option>";
                                 echo "<option value='Rupee' selected>Rupee</option>";
                               }else{
                                 echo "<option value='Percentage'>Percentage</option>";
                                 echo "<option value='Rupee'>Rupee</option>";
                               }
                              ?>
                            </select>
                           </div>
                        </div>
                        <div class="form-row py-2">
                          <div class="form-group col-6">
                            <label for="s_desc">Coupon Value</label>
                            <input type="text" name="coupon_value" class="form-control form-control-lg shadow-none" placeholder="Enter Short Coupon Value">
                          </div>
                          <div class="form-group col-6">
                            <label for="desc">Coupon Min Value</label>
                            <input type="text" name="coupon_min_value" class="form-control form-control-lg shadow-none" placeholder="Enter Coupon Min Value">
                          </div>                           
                        </div>
                          <div class="form-group col-6">
                            <label>Coupon Expire Date</label>
                            <input type="date" name="expire_date" class="form-control form-control-lg shadow-none">
                          </div>                          
                        <input type="submit" name="coupon_submit" id="coupon_btn" class="btn-success col-11 mx-auto btn-lg mb-4">
                      </form>
                    </div>
      <!-- UPDATE COUPON -->
           <div class="card-body rounded-0" id="update_coupon">
              <form action="" method="POST">
                <?php 
                 foreach($select_form as $result){
                ?>
                  <div class="form-row">
                    <div class="form-group col-6">
                      <label for="Name">Coupon Code</label>
                      <input type="text" name="coupon_code" value="<?php echo $result['coupon_code'] ?>" class="form-control form-control-lg shadow-none" required>
                    </div>                        
                    <div class="form-group col-6">
                      <label for="">Coupon Type</label>
                      <select name="coupon_type" class="form-control form-control-lg shadow-none">
                        <option value="">Select</option>
                         <?php 
                            if($coupon_type =='Percentage'){
                              echo "<option value='Percentage' selected>Percentage</option>";
                            }elseif($coupon_type == 'Rupee'){
                              echo "<option value='percentage'>Percentage</option>";
                              echo "<option value='Rupee' selected>Rupee</option>";
                            }else{
                              echo "<option value='Percentage'>Percentage</option>";
                              echo "<option value='Rupee'>Ruppes</option>";
                            }
                           ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row py-2">
                    <div class="form-group col-6">
                      <label for="s_desc">Coupon Value</label>
                       <input type="text" name="coupon_value" value="<?php echo $result['coupon_value'] ?>" class="form-control form-control-lg shadow-none">
                    </div>
                    <div class="form-group col-6">
                      <label for="desc">Coupon Min Value</label>
                      <input type="text" name="coupon_min_value" value="<?php echo $result['coupon_min_value'] ?>" class="form-control form-control-lg shadow-none">
                    </div>                           
                  </div>
                    <div class="form-group col-6">
                      <label>Coupon Expire Date</label>
                      <input type="date" name="expire_date"  value="<?php echo $result['expire_date'] ?>" class="form-control form-control-lg shadow-none">
                    </div>                          
                    <input type="submit" name="coupon_submit" id="update_btn" class="btn-success col-12 mx-auto btn-lg mb-4">
             <?php } ?> 
             </form>
            </div>
          </div>
        </div>
      </div>
  <!-- SHOW COUPON -->
      <div class="container bg-light">
        <div class="col-md-12 mx-auto">
          <table class="table table-light text-center table-hover">
            <thead>
              <tr>
                <th>Coupon ID</th>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Value</th>
                <th>Expire Date</th>
                <th>Active/Deactive</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $obj->select('coupon','*',null,null,null,6);
                $data = $obj->getResult();
                foreach($data as $coupon_row){ 
                  // print_r($data);
              ?>
              <tr>
                <td><?php echo $coupon_row['coupon_id'] ?></td>
                <td><?php echo $coupon_row['coupon_code'] ?></td>
                <td><?php echo $coupon_row['coupon_type'] ?></td>
                <td><?php echo $coupon_row['coupon_value'] ?></td>
                <td><?php echo $coupon_row['coupon_min_value'] ?></td>
                <td><?php echo $coupon_row['expire_date'] ?></td>
                <td>
                  <?php 
                    if($coupon_row['status'] == '1'){
                      echo "<a href='?type=status&coupon=Deactive&id=".$coupon_row['coupon_id'] ."' class='btn btn-primary active'>Active</a>";
                    }else{
                      echo "<a href='?type=status&coupon=Active&id=".$coupon_row['coupon_id']."' class='btn btn-dark Deactive'>Deactive</a>";
                    }
                  ?>
                </td>
                <td><a href="?update_id=<?php echo $coupon_row['coupon_id'] ?>"><i class="fa-solid fa-square-pen mt-0"></i></a></td>
                <td><a href="?delete_id=<?php echo $coupon_row['coupon_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
              </tr>
              <?php 
                }
              ?>
            </tbody>
          </table>
            <!-- PAGINATION -->
            <?php 
               echo $obj->pagination('coupon',null,null,6);
            ?>
            <!-- CLOSE -->
        </div>
      </div>
    </div>
   </div>
 <script src="js-and-jquery/jquery.js"></script>
  <script>
    $(document).ready(function(){
      $("#show_coupon").click(function(){
        $("#coupon_form").slideToggle();
      });
      $("#update_coupon_btn").click(function(){
        $("#update_coupon").slideToggle();
      });
    });
  </script>
<?php 
 
 include "includes/dash-footer.php";
 
?>
<?php
 
 echo $success;
 echo $error;
?>