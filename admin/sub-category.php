<?php 
 
 include "includes/dash-header.php";
 include "includes/dash-top-nav.php";
 include "includes/dash-sidebar.php";
 include "database.php";

 isAdmin();
?>
<?php 
  $obj = new Database();
  
  $error='';

  // ADD SUB CATEGORY
  $main_category="";
  if(isset($_POST['Add_sub_category'])){
    $sub_category  = $_POST['sub_category'];
    $main_category = $_POST['main_category'];
  
  $obj->select('sub_categories','*',null,"category_id='$main_category' AND subcate_name='$sub_category'",null,null);
  $checkresub = $obj->getResult();

  if(!empty($checkresub)){
      $error = "<script>swal('Sorry', 'Sub Category Already Exists.', 'error');</script>"; 
   }else{
     $obj->insert('sub_categories',['subcate_name' => $sub_category,'category_id'=>$main_category,'status'=>'1']);
  }
}
  
  // UPDATE SUB CATEGORY
  if(isset($_POST['update_sub_category'])){
    $update_id = $_GET['update_id'];
    $sub_category = $_POST['sub_category'];
    $main_category = $_POST['main_category'];

    $obj->update('sub_categories',['subcate_name' => $sub_category,'category_id'=> $main_category],"subcate_id='$update_id'");
    print_r($obj->getResult());
  }


  //DELETE SUB CATEGORY
  $delete_id = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
  $obj->delete('sub_categories',"subcate_id='$delete_id'"); 

  // ACTIVE AND DEACTIVE
  if(isset($_GET['type']) && $_GET['type'] !=''){
    $type = $_GET['type'];
    if($type == 'status'){
      $Deactive = $_GET['statusrole'];
      $id = $_GET['sub_cate_id'];

     if($Deactive == 'Active'){
        $role = '1';
     } else{
        $role = '0';
     }
     $obj->update('sub_categories',['status' => $role],"subcate_id='$id'");
     print_r($obj->getResult());
    }
  }

?>
 <link rel="stylesheet" href="css/All-Page.css">

 <div class="content-wrapper">
    <div class="container">
        <div class="row">
          <!-- ADD SUB CATEGORY -->
            <div class="col-md-11 mx-auto mt-4">
                <div class="card rounded-0">
                    <div class="card-header">
                       <button type="button" class="btn btn-primary btn-lg shadow-none" id="Show_sub_category">ADD SUB CATEGORY</button>
                       <button type="button" class="btn btn-primary btn-lg shadow-none float-right" id="sub_cate_update">UPDATE SUB CATEGORY</button>
                    </div>
                  <div class="card-body" id="sub_cate_input">
                    <form action="" method="POST">
                      <div class="form-group mt-0">
                         <label for="category">Category</label>
                         <input type="text" name="sub_category" class="form-control form-control-lg" placeholder="Enter Sub Category">
                      </div>
                      <div class="form-group">
                        <select name="main_category" id="" class="form-control shadow-none form-control-lg">
                         <option value="">Select</option>
                           <?php
                           $obj->select('main_category', '*', null, "category_role='1'", null, null);
                           $category = $obj->getResult();
                           foreach ($category as $main) { ?>
                            <option value="<?php echo $main['category_id']; ?>" selected><?php echo $main['category_name']; ?></option>   
                           <?php }
                           ?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="Add_sub_category" id="cate_btn">ADD CATEGORY</button>
                      </form>
                    </div>

        <!--  UPDATE CATRGORY -->
                  <div class="card-body" id="sub_update_cate">
                  <form action="" method="POST"> 
                    <?php
                    $update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';
                    $obj->select('sub_categories', '*', null, "subcate_id='$update_id'", null, null);
                    $category = $obj->getResult();
                    foreach ($category as $main) { ?>
                      <div class="form-group mt-0">
                         <label for="category">Category</label>
                         <input type="text" name="sub_category" class="form-control form-control-lg" value="<?php echo $main['subcate_name']; ?>">
                      </div>
                      <div class="form-group">
                        <select name="main_category" id="" class="form-control shadow-none form-control-lg">
                         <option value="">Select</option>
                           <?php
                           $obj->select('main_category', '*', null, "category_role='1'", null, null);
                           $category = $obj->getResult();
                           foreach ($category as $main) { ?>
                            <?php if ($main['category_id'] == $main_category) {
                                echo "<option value=" . $main['category_id'] . " selected>" . $main['category_name'] . "</option>";
                            } else {
                                echo "<option value=" . $main['category_id'] . ">" . $main['category_name'] . "</option>";
                            } ?>
                           <?php }
                           ?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-success btn-lg col-12 py-2" name="update_sub_category" id="cate_btn">UPDATE CATEGORY</button>
                        <?php }
                    ?>
                             </form>
                </div>
            </div>
          </div>
        </div>
      </div>
      
  <!-- TABLE SUB CATEGORY -->
    <div class="container">
      <div class="row">
        <div class="col-md-11 mx-auto">
          <table class="table table-hover table-light mb-4 text-center">
            <thead> 
              <tr>
                <th>Category ID</th>
                <th>Sub Category</th>
                <th>Main Category</th>
                <th>Active/Deactive</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $join = "main_category mc ON sub_categories.category_id = mc.category_id";
              $obj->select('sub_categories', '*', $join,null,null,7);
              $categories = $obj->getResult();
              foreach ($categories as $row) { ?>
              <tr class="tabletd ">
                <td><?php echo $row['subcate_id']; ?></td>
                <td><?php echo $row['subcate_name']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
              <td>
              <?php if ($row['status'] == 1) {
                  echo "<a href='?type=status&statusrole=Deactive&sub_cate_id=" . $row['subcate_id'] . "' class='btn btn-primary active'>ACTIVE</a>";
              } else {
                  echo "<a href='?type=status&statusrole=Active&sub_cate_id=" . $row['subcate_id'] . "' class='btn btn-success deactive'>DEACTIVE</a>";
              } ?>
              </td>
              <td><a href="?update_id=<?php echo $row['subcate_id']; ?>"><i class="fa-solid fa-square-pen mt-0"></i></a></td>
              <td><a href="?delete_id=<?php echo $row['subcate_id']; ?> "><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
              </tr>
              <?php }
              ?>
            </tbody>
          </table>
        <!-- PAGINATION -->
        <?php
            echo $obj->pagination('sub_categories',null,null,7);
          ?>
        <!-- CLOSE -->
        </div>
      </div>
    </div>
</div>
   
<script src="js-and-jquery/jquery.js"></script>
<script>
   $(document).ready(function(){
    $("#Show_sub_category").click(function(){
     $("#sub_cate_input").slideToggle();
    });

    $("#sub_cate_update").click(function(){
      $('#sub_update_cate').slideToggle();
    });
   });
</script>
<?php 
 
 include "includes/dash-footer.php";

?>
<?php echo $error ?>