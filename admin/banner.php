<?php 

include "includes/dash-header.php";
include "includes/dash-sidebar.php";
include "includes/dash-top-nav.php";
include "database.php";


?>
<?php 
 $id='';

 $obj = new Database();
  
 //ADD BANNER  
 if(isset($_POST['benner_insert'])){
    $hadding_first = $_POST['hadding_first'];
    $hadding_second = $_POST['hedding_second'];
    $btn_text = $_POST['btn_text'];
    $benner_paragraph = $_POST['banner_paragraph'];
    $category_id = $_POST['main_bcategory'];
   
    $image = $_FILES['banner_images'];
    $file_name = $image['name'];
    $file_tmp = $image['tmp_name'];
    $file_error = $image['error'];
  
    if($file_error == 0){
     $destfile = 'upload/'.$file_name;
     move_uploaded_file($file_tmp,$destfile);
      
    $obj->insert('banner',['hadding_first'=>$hadding_first,'hedding_second'=>$hadding_second,'btn_text'=>$btn_text,'banner_paragraph'=>$benner_paragraph,'main_bcategory'=>$category_id,
    'banner_image'=>$destfile,'status'=>1]);
    $get_id= $obj->getResult();
    $id = $get_id[0];
    }
 }

 // UPDATE BANNER
  $update_banner = isset($_GET['update_banner']) ? $_GET['update_banner'] : '';
 if(isset($_POST['update_banner'])){
    $hadding_first = $_POST['hadding_first'];
    $hadding_second = $_POST['hedding_second'];
    $btn_text = $_POST['btn_text'];
    $benner_paragraph = $_POST['banner_paragraph'];
    $category_id = $_POST['main_bcategory'];
   
    $image = $_FILES['banner_images'];
    $file_name = $image['name'];
    $file_tmp = $image['tmp_name'];
    $file_error = $image['error'];
  
    if($file_error == 0){
     $destfile = 'upload/'.$file_name;
     move_uploaded_file($file_tmp,$destfile);
      
    $obj->update('banner',['hadding_first'=>$hadding_first,'hedding_second'=>$hadding_second,'btn_text'=>$btn_text,'banner_paragraph'=>$benner_paragraph,'main_bcategory'=>$category_id,
    'banner_image'=>$destfile,'status'=>1],"banner_id='$update_banner'");
    $get_id= $obj->getResult();
    $id = $get_id[0];
    }
 }  

 // DELETE BANNER
    $delete_id = isset($_GET['banner_delete']) ? $_GET['banner_delete'] : '';
    $obj->delete('banner',"banner_id='$delete_id'");

 // ACTIVE DEACTIVE BANNER 
 if(isset($_GET['type']) && $_GET['type'] != ''){
   $type = $_GET['type'];
   if($type == 'status'){
     $Deactive = $_GET['opration'];
     $id = $_GET['id'];
    if($Deactive == 'Active'){
      $role = '1';
    }else{
      $role = '0';
    }
   $obj->update('banner',['status'=>$role],"banner_id = '$id'");
   }
 }

?>

  <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">     
  <div class="container">
    <div class="row">
        <div class="col-md-11 bg-white py-3 mt-3 px-3 mx-auto">
            <button class="btn btn-primary btn-lg" id="banner_form_show">ADD BANNER</button>
            <button class="btn btn-primary btn-lg" id="update_form_show">UPDATE BANNER</button>
        </div>
    </div>
  </div>

  <!-- ADD BANNER -->
  <div class="container bg-light" id="banner_form">
    <div class="row">
        <div class="col-md-11 mx-auto mt-3">
            <div class="card rounded-0" id="product-input">
                <div class="card-header">
                    <h4 class="fotn-wieght-bold">Add Banner Form</h4>
                </div>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="Name">Heding 1</label>
                            <input type="text" name="hadding_first" class="form-control" placeholder="Product Name" required>
                        </div>   
                        <div class="form-group col-4">
                            <label for="desc">Hedding 2</label>
                            <input type="text" name="hedding_second" class="form-control" placeholder="Enter Description">
                        </div> 
                        <div class="form-group col-4">
                            <label for="s_desc">Buttom Text</label>
                            <input type="text" name="btn_text" class="form-control" placeholder="Meta Title">
                        </div>                     
                    </div>
                    <div class="form-row py-2" id="image">                        
                        <div class="form-group col-9">
                            <label for="image">Product Images</label>
                            <input type="File" name="banner_images" class="form-control" required>
                        </div>
                        <div class="form-group col-3 mt-4">
                          <label for=""></label>
                          <input type="button" id="Add_more_image" class="btn btn-primary shadow-none mt-2" value="ADD MORE IMAGE">
                        </div>  
                    </div>
                    <div class="form-row" id="more_img">
                    </div>
                    <div class="main_img"></div>
                      <div class="form-row py-2">
                      <div class="form-group col-6">
                          <label for="category">Select Main Category</label>
                          <select name="main_bcategory" class="form-control" id="category_name" required>
                             <option>Select Category</option>
                              <?php 
                                $obj->select('main_category','*',null,"category_role='1'",null,null);
                                $category = $obj->getResult();
                                foreach($category as $cate_row){
                              
                              echo "<option value='{$cate_row['category_id']}'>{$cate_row['category_name']}</option>";
                              } 
                              ?>
                            </select>   
                        </div>
                      <div class="form-group col-6">
                            <label for="desc">Benner Paragraph</label>
                            <input type="text" name="banner_paragraph" class="form-control" placeholder="Enter Meta Description">
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" name="benner_insert" id="p_editbtn" class="col-12 btn-success btn-lg ml-2 text-white">
                      </div>
                </div>
                </div>
                </form>
            </card>
        </div>
    </div>
    </div>

  <!-- BANNER UPDATE -->
  
  <?php 
   
    $obj->select('banner','*',null,"banner_id='$update_banner'",null,null);
    $get_data = $obj->getResult();
    foreach($get_data as $row){
  ?>
<div class="container bg-light" id="update_form">
   <div class="row">
      <div class="col-md-11 mx-auto mt-3">
         <div class="card rounded-0" id="product-input">
            <div class="card-header">
               <h4 class="fotn-wieght-bold">Update Banner Form</h4>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
               <div class="card-body">
                  <div class="form-row">
                     <div class="form-group col-4">
                        <label for="Name">Heding 1</label>
                        <input type="text" name="hadding_first" value="<?php echo $row['hadding_first'] ?>" class="form-control"  required>
                     </div>
                     <div class="form-group col-4">
                        <label for="desc">Hedding 2</label>
                        <input type="text" name="hedding_second" value="<?php echo $row['hedding_second'] ?>" class="form-control">
                     </div>
                     <div class="form-group col-4">
                        <label for="s_desc">Buttom Text</label>
                        <input type="text" name="btn_text" class="form-control" value="<?php echo $row['btn_text'] ?>">
                     </div>
                  </div>
                  <div class="form-row py-2" id="image">
                     <div class="form-group col-9">
                        <label for="image">Product Images</label>
                        <input type="File" name="banner_images" class="form-control" required>
                     </div>
                     <div class="form-group col-3 mt-4">
                        <label for=""></label>
                        <input type="button" id="Add_more_image" class="btn btn-primary shadow-none mt-2" value="ADD MORE IMAGE">
                     </div>
                  </div>
                  <div class="form-row" id="more_img">
                  </div>
                  <div class="main_img"></div>
                  <div class="form-row py-2">
                     <div class="form-group col-6">
                        <label for="category">Select Main Category</label>
                        <select name="main_bcategory" class="form-control" id="category_name" required>
                           <option>Select Category</option>
                           <?php 
                              $obj->select('main_category','*',null,"category_role='1'",null,null);
                              $category = $obj->getResult();
                              foreach($category as $cate_row){
                              
                              echo "<option value='{$cate_row['category_id']}'>{$cate_row['category_name']}</option>";
                              } 
                              ?>
                        </select>
                     </div>
                     <div class="form-group col-6">
                        <label for="desc">Benner Paragraph</label>
                        <input type="text" name="banner_paragraph" class="form-control" value="<?php echo $row['banner_paragraph'] ?>">
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="submit" name="update_banner" id="p_editbtn" class="col-12 btn-success btn-lg ml-2 text-white">
                  </div>
               </div>
         </div>
         </form>
         </card>
      </div>
   </div>
</div>
<?php 
   }
   ?>
  

  <!-- BANNER TABLE -->
       <div class="col-md-12 mx-auto mt-2"> 
         <table class="table table-light mb-5 table-hover text-center">
           <thead>
             <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Hadding First</th>
                <th>Hadding Second</th>
                <th>Button Text</th>
                <th>Image</th>
                <th>Banner Description</th>
                <th>Active/Deactive</th>
                <th>Edit</th>
                <th>Delete</th>
             </tr>
           </thead>
           <tbody>
            <?php 
      
              $join ="main_category ON banner.main_bcategory = main_category.category_id";
              $obj->select('banner','*',$join,null,null,6);
              $data = $obj->getResult();
              foreach($data as $res){
            ?>
             <tr class="tabletd">
                <td><?php echo $res['banner_id'] ?></td>
                <td><?php echo $res['category_name'] ?></td>
                <td><?php echo $res['hadding_first'] ?></td>
                <td><?php echo $res['hedding_second'] ?></td>
                <td><?php echo $res['btn_text'] ?></td>
                <td><img src="<?php echo $res['banner_image'] ?>" height="50"></td>
                <td><?php echo $res['banner_paragraph'] ?></td>
                <?php 
                if($res['status'] == 1){
                echo "<td><a href='?type=status&opration=Deactive&id=" . $res['banner_id'] . "' class='btn btn-primary active'>Active</a></td>";
                }else{
                echo "<td><a href='?type=status&opration=Active&id=". $res['banner_id']."' class='btn btn-success Deactive'>Deactive</a></td>";
                }
                ?>
                <td><a href="?update_banner=<?php echo $res['banner_id'] ?>" id="select"><i class="fa-solid fa-square-pen mt-0"></i></a></td>
                <td><a href="?banner_delete=<?php echo $res['banner_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
             </tr>
            <?php 
              }
            ?>
           </tbody>
         </table>
            <!-- PAGINATION -->
            <?php 
               echo $obj->pagination('banner',null,null,6);
            ?>
            <!-- CLOSE -->
       </div>
     </div>

 <script src="js-and-jquery/jquery.js"></script>
  <script>
    $(document).ready(function () {
        $("#banner_form_show").click(function () {
            $("#banner_form").slideToggle();
        });
        $("#update_form_show").click(function () {
            $("#update_form").slideToggle();
        });
    });
  </script>

<?php 
 include "includes/dash-footer.php";
?>