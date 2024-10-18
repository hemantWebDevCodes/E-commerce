<?php

include "database.php";
include "includes/dash-header.php";
include "includes/dash-top-nav.php";
include "includes/dash-sidebar.php";

isAdmin();

if (!isset($_SESSION['ADMIN_USERNAME'])) {
    echo "<script>window.location.href='admin_login.php';</script>";
}
?>

 <?php
 $obj = new Database();

 // ADD SIZE
 $error = '';
 if (isset($_POST['insert_size'])) {
     $size = $_POST['size'];
     $order_by = $_POST['order_by'];

     $obj->select('size_master', 'size', null, "size='$size'", null, null);
     $checksize = $obj->getResult();

     if ($checksize[0] > 0) {
         $error = "<script>swal('Sorry', 'Size Already Exists.', 'error');</script>";
     } else {
         $obj->insert('size_master', ['size' => $size, 'order_by' => $order_by, 'status' => 1]);
         print_r($obj->getResult());
     }
 }

 // SIZE UPDATE
 if (isset($_POST['size_update'])) {
     $editid = isset($_GET['editid']) ? $_GET['editid'] : "";
     $size = $_POST['size'];
     $order_by = $_POST['order_by'];

     $obj->update('size_master', ['size' => $size, 'order_by' => $order_by], "size_id='$editid'");
     print_r($obj->getResult());
 }

 // SIZE DELETE
 $delete_id = isset($_GET['deleteid']) ? $_GET['deleteid'] : "";
 $obj->delete('size_master', "size_id='$delete_id'");

 // SIZE  ACTIVE DEACTIVE
 if (isset($_GET['type']) && $_GET['type'] != '') {
     $type = $_GET['type'];
     if ($type == 'status') {
         $Deactive = $_GET['statusrole'];
         $id = $_GET['id'];

         if ($Deactive == 'Active') {
             $role = '1';
         } else {
             $role = '0';
         }
         $obj->update('size_master', ['status' => $role], "size_id='$id'");
         print_r($obj->getResult());
     }
 }
 ?> 

 <link rel="stylesheet" href="css/All-Page.css">
 <div class="content-wrapper">
<div class="container">
  <div class="row">
    <div class="col-md-11 mx-auto bg-white py-2 mt-4">
      <input type="button" value="Add Size" id="size_show_btn" class="btn btn-primary">
      <input type="button" value="Update Size" id="size_update_btn" class="btn btn-primary">
    </div>
  </div>
</div>
  <!-- ADD SIZE  -->
  <div class="container my-2" id="size_form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card">
        <div class="card-header">
          <h4>Size Add Form</h4>
        </div>
        <form method="POST">
         <div class="card-body">
          <div class="form-group mt-0">
            <label for="size">Size</label>
            <input type="text" name="size" class="form-control" placeholder="Add Size">
          </div>
          <div class="form-group mt-0">
            <label for="order_by">Order By</label>
            <input type="number" name="order_by" class="form-control" placeholder="Add Size">
          </div>
            <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="insert_size" id="insert_size_btn">Submit</button>
          </div>
         </div>
         </div>
        </form>
       </div>
      </div>
  
 <!-- SIZE UPDATE FORM -->
  <div class="container my-2" id="update_size_form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card">
        <div class="card-header">
          <h4>Size Update Form</h4>
        </div>
        <form action="" method="POST">
         <div class="card-body">
            <?php
              $id = isset($_GET['editid']) ? $_GET['editid'] : "";

              $obj->select('size_master','*',null,"size_id='$id'",null,null);
              $fetch = $obj->getResult();
              foreach($fetch as $size_field){
              ?>
           <div class="form-group mt-0">
             <label>Size</label>
             <input type="text" name="size"  value="<?php echo $size_field['size']; ?>" class="form-control"> 
           </div>
           <div class="form-group mt-0">
             <label>Order By</label>
             <input type="text" name="order_by"  value="<?php echo $size_field['order_by']; ?>" class="form-control"> 
           </div>
            <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="size_update" id="cate_btn">Edit Category</button>
        <?php } ?>  
        </div>
         </div>
         </div>
       </form>
     </div>
   </div>
 <!-- SIZE TABLE -->
<div class="container mt-2">
  <div class="row">
    <div class="col-md-11 mx-auto table-responsive-md">
    <table class="table table-bordered table-hover table-light text-center">
     <thead>
      <tr>
        <th>Id</th>
        <th> Size</th>
        <th>Order By</th>
        <th>Active & Deactive</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php 

    $obj->select('size_master','*',null,null,null,4);
      $data = $obj->getResult();
      
      foreach($data as $row){
    ?>
      <tr class="tabletd">
        <td><?php echo $row['size_id'] ?></td>
        <td><?php echo $row['size'] ?></td>
        <td><?php echo $row['order_by'] ?></td>
        <td>
          <?php
                if($row['status'] == 1){
                    echo "<a href='?type=status&statusrole=Deactive&id=".$row['size_id']."' class='btn btn-primary active'>ACTIVE</a>";
                  }else{
                    echo "<a href='?type=status&statusrole=Active&id=".$row['size_id']."' class='btn btn-success deactive'>DEACTIVE</a>";
                  }
          ?> 
        </td>
       <td><a href='?editid=<?php echo $row['size_id'] ?>'><i class="fa-solid fa-square-pen mt-0"></i></a></td>
       <td><a href='?deleteid=<?php echo $row['size_id'] ?>'><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a> </td> 
      </tr>
    <?php
      }
    ?>
    </tbody>
   </table>
    <!-- PAGINATION -->
    <?php 
       echo $obj->pagination('size_master',null,null,4);
     ?>
    <!-- CLOSE -->
  </div>
    </div>
  </div>
</div>

<script src="js-and-jquery/jquery.js"></script>
  <script>
   $(document).ready(function(){
    $('#size_show_btn').click(function(){
      $('#size_form').slideToggle();
    });
   
     $("#size_update_btn").click(function(){  
      $('#update_size_form').fadeToggle();
    });
   });
 </script>

<?php 

  include "includes/dash-footer.php";

?>
<?php echo $error ?>