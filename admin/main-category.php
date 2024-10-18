<?php 


  include "database.php";
  include "includes/dash-header.php";
  include "includes/dash-top-nav.php";
  include "includes/dash-sidebar.php";

  isAdmin();

  if(!isset($_SESSION['ADMIN_USERNAME'])){
    echo "<script>window.location.href='admin_login.php';</script>";
  }
    ?>

 <?php

    $obj = new Database();
    
    if(isset($_POST['insert_category'])){
      $category = $_POST['category_name'];

      $obj->insert('main_category',['category_name' => $category]);
      print_r($obj->getResult());  
  }

    // CATEGORY UPDATE
    if(isset($_POST['update'])){
      $editid = isset($_GET['editid']) ? $_GET['editid'] : "";
      $category = $_POST['categorys'];

      $obj->update('main_category',['category_name' => $category],"category_id='$editid'");
      print_r($obj->getResult());
    }

    // CATEGORY DELETE
    $delete_id = isset($_GET['deleteid']) ? $_GET['deleteid'] : "";
    $obj->delete('main_category',"category_id='$delete_id'");

    // CATEGORY ACTIVE DEACTIVE
    if(isset($_GET['type']) && $_GET['type'] !=''){
      $type = $_GET['type'];
    if($type =='category_role'){
      $Deactive = $_GET['Oprationrole'];
      $id = $_GET['cate_id'];

      if($Deactive == 'Active'){
          $role = '1';
      }else{
        $role = '0';
      }

    $obj->update('main_category',['category_role' => $role],"category_id='$id'");
     }
   }
 ?> 

 <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">
<div class="container">
  <div class="row">
    <div class="col-md-11 mx-auto bg-white py-2 mt-4">
      <input type="submit" value="Add Category" id="category_show_btn" class="btn btn-primary">
      <input type="submit" value="Update Category" id="category_update_btn" class="btn btn-primary">
    </div>
  </div>
</div>
  <div class="container my-2" id="category_form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card">
        <div class="card-header">
          <h4>Category Form</h4>
        </div>
        <form action="main-category.php" method="POST">
         <div class="card-body">
          <div class="form-group mt-0">
            <label for="category">Category</label>
            <input type="text" name="category_name" class="form-control" placeholder="Add Category">
          </div>
            <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="insert_category" id="cate_btn">Submit</button>
          </div>
         </div>
         </div>
        </form>
       </div>
      </div>
      <div class="container my-2" id="edit_Form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card">
        <div class="card-header">
          <h4>Update Category Form</h4>
        </div>
        <form action="" method="POST">
         <div class="card-body">
          <div class="form-group mt-0">
            <label for="category">Category</label>

            <?php
              $id = isset($_GET['editid']) ? $_GET['editid'] : "";

              $obj->select('main_category','*',null,"category_id='$id'",null,null);
              $fetch = $obj->getResult();
              foreach($fetch as $get_cate){
              ?>
            <input type="text" name="categorys"  value="<?php echo $get_cate['category_name']; ?>" class="form-control">
            <?php } ?> 

             </div>
            <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="update" id="cate_btn">Edit Category</button>
          </div>
         </div>
         </div>
           </form>
       </div>
      </div>
<div class="container mt-2">
  <div class="row">
    <div class="col-md-11 mx-auto table-responsive-md">
    <table class="table table-bordered table-hover table-light text-center">
     <thead>
      <tr>
        <th>Id</th>
        <th>Category Name</th>
        <th>status</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php 

    $obj->select('main_category','*',null,null,null,6);
      $data = $obj->getResult();
      
      foreach($data as $row){
    ?>
      <tr class="tabletd">
        <td><?php echo $row['category_id'] ?></td>
        <td><?php echo $row['category_name'] ?></td>
        <td>
          <?php
            if($row['category_role'] == 1){
              echo "<a href='?type=category_role&Oprationrole=Deactive&cate_id=" . $row['category_id'] . "' class='btn btn-primary active'>Active</a>";
            }else{
              echo "<a href='?type=category_role&Oprationrole=Active&cate_id=". $row['category_id'] ."' class='btn btn-success Deactive'>Deactive</a>";

            }
          ?> 
        </td>
       <td><a href='?editid=<?php echo $row['category_id'] ?>'><i class="fa-solid fa-square-pen mt-0"></i></a></td>
       <td><a href='?deleteid=<?php echo $row['category_id'] ?>'><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a> </td> 
      </tr>
    <?php
      }
    ?>
    </tbody>
   </table>
   <!-- PAGINATION -->
    <?php 
      echo $obj->pagination('main_category',null,null,6);
    ?>
   <!-- CLOSE -->
  </div>
    </div>
  </div>
</div>

<script src="js-and-jquery/jquery.js"></script>
  <script>
   $(document).ready(function(){
    $('#category_show_btn').click(function(){
      $('#category_form').slideToggle();
    });
   
    $("#chech-btn").click(function(){
      $(this).css({backgroundColor:'green'});
    });

     $("#category_update_btn").click(function(){  
      $('#edit_Form').fadeToggle();
    });
   });
 </script>

<?php 

  include "includes/dash-footer.php";

?>