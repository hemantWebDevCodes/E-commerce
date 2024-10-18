<?php 

include "database.php";
include "includes/dash-header.php";
include "includes/dash-sidebar.php";
include "includes/dash-top-nav.php";
?>
<?php 
 $id='';
 $condition='';
 $condition1='';
if($_SESSION['ADMIN_ROLE'] == 1){
    $condition = 'product.added_by="'.$_SESSION["ADMIN_ID"] .'"';
    $condition1 = 'added_by="'.$_SESSION["ADMIN_ID"].'"';
}

// print_r($_SESSION);

 $obj = new Database();
  
 //ADD PRODUCT  
 if(isset($_POST['product_insert'])){
  print_r($_POST);
    $pname = $_POST['p_name'];
    $c_name = $_POST['category_name'];
    $sub_category = $_POST['sub_category'];
    $discount_price = $_POST['discount_price'];
    $discount_precentage = $_POST['discount_precentage'];
    $short_desc = $_POST['short_description'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $best_seller = $_POST['best_seller'];
    $admin_id =$_SESSION["ADMIN_ID"];   

    $files = $_FILES['image'];   
    $file_name = $files['name'];
    $file_error = $files['error'];
    $file_tmp = $files['tmp_name']; 
    if ($file_error == 0) {
    $destfile = 'upload/'.$file_name;
    move_uploaded_file($file_tmp,$destfile);
   
    $obj->insert('product',['category'=>$c_name,'p_name'=>$pname,'sub_category_id'=>$sub_category,'image'=>$destfile,'short_desc'=>$short_desc,'discount_price'=>$discount_price,
    'discount_precentage'=>$discount_precentage,'description'=>$description,'meta_title'=>$meta_title,'meta_description'=>$meta_description,'meta_keyword'=>$meta_keyword,'best_seller'=>$best_seller,'status'=>1,"added_by"=>$_SESSION["ADMIN_ID"]]);
    $get_id= $obj->getResult();
    $id = $get_id[0];
  }
 }

//  MULTIPLE IMAGE UPLOAD
    if(isset($_FILES['product_images']['name'])){
      foreach($_FILES['product_images']['name'] as $key => $val){
      $file_name = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
      $file_error = $_FILES['product_images']['error'][$key];
      $file_tmp = $_FILES['product_images']['tmp_name'][$key];  
      if ($file_error == 0) {
      $destfile = 'upload/products_image/'.$file_name;
      move_uploaded_file($file_tmp,$destfile);
      
    $obj->insert('product_images',['product_id'=>$id,'product_images'=>$destfile]);
    }
  }
  } 
  
 //ADD MULTIPLE ATRRIBUTE DATA
  if(isset($_POST['mrp'])){
foreach($_POST['mrp'] as $key=>$val){
      $mrp= $_POST['mrp'][$key];
      $price= $_POST['price'][$key];
      $quantity = $_POST['quantity'][$key];
      $color = $_POST['color_id'][$key];
      $size = $_POST['size_id'][$key];

    $obj->insert('product_attribute',['product_id'=>$id,'size_id'=>$size,'color_id'=>$color,'mrp'=>$mrp,'price'=>$price,'quantity'=>$quantity]);
    print_r($obj->getResult());
    }
  }
 
 // DELETE PRODUCT
 $delete_id = isset($_GET['p_deleteid']) ? $_GET['p_deleteid'] : '';
 $obj->delete('product',"product_id='$delete_id'");

 // ACTIVE DEACTIVE PRODUCT 
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
  $obj->update('product',['status'=>$role],"product_id='$id' AND '$condition1'");
   }

 }
?>

  <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">     
  <div class="container">
    <div class="row">
        <div class="col-md-11 bg-white py-3 mt-3 mx-auto">
            <button class="btn btn-primary btn-lg" id="product_formshow">Add Product</button>
        </div>
    </div>
  </div>
  <div class="container bg-light" id="product_form">
    <div class="row">
        <div class="col-md-12 mx-auto mt-3">
            <div class="card rounded-0" id="product-input">
                <div class="card-header">
                    <h4 class="fotn-wieght-bold">Add Product Form</h4>
                </div>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="Name">Product Name</label>
                            <input type="text" name="p_name" class="form-control" placeholder="Product Name" required>
                        </div>                        
                        <div class="form-group col-6">
                          <label for="category">Select Main Category</label>
                          <select name="category_name" class="form-control" onchange="change_main_category()" id="category_name" required>
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
                    </div>
                    <div class="form-row py-2">
                       <div class="form-group col-6">
                            <label for="category">Select Sub Category</label>
                            <select name="sub_category" class="form-control" id="sub_category">
                             <option>Select Sub Category</option>
                            </select>   
                        </div>
                        <div class="form-group col-6">
                          <label for="">Best Seller</label>
                          <select name="best_seller" class="form-control">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-row attr_main">
                        <div class="form-group col-2">
                            <label for="Mrp">MRP</label>
                            <input type="text" name="mrp[]" class="form-control" placeholder="Enter MRP">
                        </div>                     
                        <div class="form-group col-2">
                            <label for="price">Price</label>
                            <input type="text" name="price[]" class="form-control" placeholder="Enter Price" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="qnt">quantity</label>
                            <input type="text" name="quantity[]" class="form-control" placeholder="Enter Quantity" required>
                        </div>
                        <div class="form-group col-2" id="size_attr">
                          <label for="Size">Size</label>
                            <select name="size_id[]" id="size_id" class="form-control shadow-none">
                            <option value="">Select</option>
                            <?php 
                              $obj->select('size_master','*',null,null,null,null);
                              $color = $obj->getResult();
                              foreach($color as $color_data){
                                echo "<option value=".$color_data['size_id'].">".$color_data['size']."</option>";                               
                              }
                            ?>
                          </select>  
                       </div>
                        <div class="form-group col-2" id="color_attr">
                          <label for="qnt">Color</label>
                            <select name="color_id[]" class="form-control shadow-none" id="color_id">
                              <option value="">Select</option>
                              <?php 
                                $obj->select('color_manage','*',null,null,null,null);
                                $color = $obj->getResult();
                                print_r($color);
                                foreach($color as $color_data){
                                  echo "<option value=".$color_data['color_id'].">".$color_data['color']."</option>";                               
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-2 mt-4">
                            <input type="button" class="btn btn-primary ml-3 mt-2" value="ADD MORE" id="Add_more_attr">
                        </div>
                    </div>
                    <div id="attr_result"></div>
                    <div class="form-row" id="image">                        
                        <div class="form-group col-10">
                            <label for="image">image</label>
                            <input type="File" name="image" class="form-control" required>
                        </div>
                        <div class="form-group col-2 mt-4">
                          <label for=""></label>
                          <input type="button" id="Add_more_image" class="btn btn-primary shadow-none" value="ADD MORE IMAGE">
                        </div>
                    </div>
                    <div class="form-row" id="more_img">
                    </div>
                    <div class="form-row py-2">
                        <div class="form-group col-6">
                            <label for="s_desc">Discount Price</label>
                            <input type="number" name="discount_price" class="form-control" placeholder="Enter Discount Price">
                        </div>                          
                        <div class="form-group col-6">
                            <label for="s_desc">Discout Precentage</label>
                            <input type="number" name="discount_precentage" class="form-control" placeholder="Enter Discout Precentage">
                        </div>                           
                      </div>
                      <div class="main_img"></div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="description" id="" cols="30" rows="2" class="form-control" placeholder="Enter Description"></textarea>
                    </div>  
                    <div class="form-row py-2">
                        <div class="form-group col-6">
                            <label for="s_desc">Short Description</label>
                            <input type="text" name="short_description" class="form-control" placeholder="Enter Short Description">
                        </div>                          
                        <div class="form-group col-6">
                            <label for="s_desc">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Meta Title">
                        </div>                           
                      </div> 
                      <div class="form-row py-2"> 
                      <div class="form-group col-6">
                            <label for="desc">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control" placeholder="Enter Meta Description">
                        </div>
                        <div class="form-group col-6">
                            <label for="desc">Meta Keyword</label>
                            <input type="text" name="meta_keyword" class="form-control" placeholder="Meta Title">
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" name="product_insert" id="p_editbtn" class="col-12 btn-success btn-lg ml-2 text-white">
                    </div>
                </div>
                </div>
                </form>
            </card>
        </div>
    </div>
    </div>

   <div class="container">
     <div class="row">
       <div class="col-md-12 mx-auto mt-3 ">
         <table class="table table-bordered table-light table-hover text-center">
           <thead>
             <tr>
                <th>Id</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Mrp</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Active/Deactive</th>
                <th>Edit</th>
                <th>Delete</th>
             </tr>
           </thead>
           <tbody>
            <?php 
      
              $join = "main_category mc ON product.category = mc.category_id
                       LEFT JOIN product_attribute pa ON product.product_id = pa.product_id GROUP BY product.product_id";
              $obj->select('product','product.*,mc.category_name,pa.quantity,pa.price,pa.mrp',$join,null,null,4);
              $data = $obj->getResult();
              foreach($data as $res){
            ?>
             <tr class="tabletd">
                <td><?php echo $res['product_id'] ?></td>
                <td><?php echo $res['p_name'] ?></td>
                <td><?php echo $res['category_name'] ?></td>
                <td><?php echo $res['mrp'] ?></td>
                <td><?php echo $res['price'] ?></td>
                <td><?php echo $res['quantity'] ?><br><?php echo "Pand. Qty ".$res['quantity']-$eve = productSoldQtyByProductId($res['product_id'],'') ?></td>
                <td><img src="<?php echo $res['image'] ?>" height="120"></td>
                <?php 
                if($res['status'] == 1){
                echo "<td><a href='?type=status&opration=Deactive&id=" . $res['product_id'] . "' class='btn btn-primary active'>Active</a></td>";
                }else{
                echo "<td><a href='?type=status&opration=Active&id=". $res['product_id']."' class='btn btn-success Deactive'>Deactive</a></td>";
                }
                ?>
                <td><a href="product-edit.php?p_eid=<?php echo $res['product_id'] ?>" id="select"><i class="fa-solid fa-square-pen mt-0"></i></a></td>
                <td><a href="?p_deleteid=<?php echo $res['product_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
             </tr>
            <?php 
              }
            ?>
           </tbody>
         </table>
         <!-- PAGINATION -->
         <?php 
           echo $obj->pagination('product',null,null,4);
         ?>
         <!-- PAGE CLOSE -->
       </div>
     </div>
    </div>
</div>
<script src="js-and-jquery/jquery.js"></script>
  <script>
   $(document).ready(function(){
    $('#product_formshow').click(function(){
    $('#product_form').slideToggle();
   });
   
  });

  </script>
<?php 
 
 include "includes/dash-footer.php";
 
?>