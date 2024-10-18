
<?php

use Mpdf\Tag\Img;
include "database.php";
include "includes/dash-header.php";
include "includes/dash-sidebar.php";
include "includes/dash-top-nav.php";

?>
<?php 

$condition='';
if($_SESSION['ADMIN_ROLE'] == 0){
   $condition = 'added_by="'.$_SESSION["ADMIN_ID"] .'"';
}

$eid = isset($_GET['p_eid']) ? $_GET['p_eid'] : '';

$obj = new Database();
$sub_category='';

// PRODUCT UPDATE
if(isset($_POST['product_update'])){
  //  print_r($_POST);
   $eid = $_GET['p_eid'];
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
   
   $files = $_FILES['image'];   
   $file_name = $files['name'];
   $file_error = $files['error'];
   $file_tmp = $files['tmp_name'];
      
   if ($file_error == 0) {
   $destfile = 'upload/'.$file_name;
   move_uploaded_file($file_tmp,$destfile);
 
   $obj->update('product',['p_name'=>$pname,'category'=>$c_name,'sub_category_id'=>$sub_category,'image'=>$destfile,'discount_price'=>$discount_price,'discount_precentage'=>$discount_precentage,'short_desc'=>$short_desc,'description'=>$description,
   'meta_title'=>$meta_title,'meta_description'=>$meta_description,'meta_keyword'=>$meta_keyword,'best_seller'=>$best_seller],"product_id='$eid'");
   $result = $obj->getResult();
    if($result){
          echo "<script>window.location.href='product-handel.php';</script>";
    }
   }
 

  // MULTIPLE PRODUCT IMAGES  
  
  if(isset($_GET['p_eid']) && $_GET['p_eid']!=''){
    if(isset($_FILES['product_images']['name'])){
     foreach($_FILES['product_images']['name'] as $key => $val){
       if($_FILES['product_images']['name'][$key]!= ''){
         if(isset($_POST['product_image_id_multiple'][$key])){
            $file_name = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
            $file_error = $_FILES['product_images']['error'][$key];
            $file_tmp = $_FILES['product_images']['tmp_name'][$key];  
            if ($file_error == 0) {
            $destfile = 'upload/products_image/'.$file_name;
            move_uploaded_file($file_tmp,$destfile);
            
            $obj->update('product_images',['product_images'=>$destfile],"images_id='".$_POST['product_image_id_multiple'][$key]."'");
         }
        }else{
            $file_name = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
            $file_error = $_FILES['product_images']['error'][$key];
            $file_tmp = $_FILES['product_images']['tmp_name'][$key];  
            if ($file_error == 0) {
            $destfile = 'upload/products_image/'.$file_name;
            move_uploaded_file($file_tmp,$destfile);
            
            $obj->insert('product_images',['product_id'=>$eid,'product_images'=>$destfile]);
            }          
        }
       }
     }
    }
  }
  // PRODUCT ATTRIBUTES START
   
  if(isset($_POST['mrp'])){
    foreach($_POST['mrp'] as $key => $val){
      if(isset($_GET['p_eid']) && $_GET['p_eid']!=''){
        $mrp= $_POST['mrp'][$key];
        $price = $_POST['price'][$key];
        $quantity = $_POST['quantity'][$key];
        $color = $_POST['color_id'][$key];
        $size = $_POST['size_id'][$key];
        $attr_id = $_POST['attr_id'][$key];
      }
      if($attr_id>0){
        $obj->update('product_attribute',['size_id'=>$size,'color_id'=>$color,'mrp'=>$mrp,'price'=>$price,'quantity'=>$quantity],"id='$attr_id'");
      }else{
        $obj->insert('product_attribute',['product_id'=>$eid,'size_id'=>$size,'color_id'=>$color,'mrp'=>$mrp,'price'=>$price,'quantity'=>$quantity]);
      }
    }
  }
}
  
  $obj->select('product_images','*',null,"product_id='$eid'",null,null);
  $multiple_product = $obj->getResult();

  // ATTRIBUTE DATA SELECT 
   $obj->select('product_attribute','*',null,"product_id='$eid'",null,null);
   $attr_data = $obj->getResult();

 // MULTIPLE PRODUCT IMAGES DELETE
   if(isset($_GET['pi'])){
     $id=$_GET['pi'];
    $obj->delete('product_images',"images_id='$id'");
    echo "<script>window.location.href='product-handel.php';</script>";
   } 

  // PRODUCT SELECT   
  $obj->select('product','*',null,"product_id='$eid'",null,null);
  $store = $obj->getResult();
  foreach($store as $data){

 ?>
<link rel="stylesheet" href="css/All-Page.css">
<div class="content-wrapper">
 <div class="container">
   <div class="row">
       <div class="col-md-11 mt-5 mx-auto">
           <div class="card rounded-0" id="product-input">
               <div class="card-header">
                   <h3 class="">Update Product Form</h3>
               </div>
               <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
               <div class="card-body"> 
                   <div class="form-row">
                       <div class="form-group col-6">
                           <label for="Name">Product Name</label>
                           <input type="text" name="p_name" class="form-control" value="<?php echo $data['p_name'] ?>">
                       </div>                        
                       <div class="form-group col-6">
                         <label for="category">Select Category</label>
                         <select name="category_name" class="form-control" onchange="change_main_category('')" id="category_name">
                           <option>Select Category</option>
                            <?php 
                               $obj->select('main_category','*',null,"category_role='1'",null,null);
                               $category = $obj->getResult();
                                foreach($category as $cate_row){
                                 if($cate_row['category_id']==$data['category']){
                                   echo "<option value=".$cate_row['category_id']." selected>".$cate_row['category_name']."</option>";
                                 }else{
                                    echo "<option value=".$cate_row['category_id'].">".$cate_row['category_name']."</option>";
                                 } 
                                } 
                            ?>
                         </select>   
                       </div>
                   </div>
                   <div class="form-row py-2">
                   <div class="form-group col-6">
                         <label for="category">Select SubCategory</label>
                         <select name="sub_category" class="form-control" id="sub_category">
                           <option>Select Sub Category</option> 
                         </select>   
                       </div>
                       <div class="form-group col-6">
                        <label for="">Best Seller</label>
                         <select name="best_seller" class="form-control">
                             <?php 
                               if($data['best_seller']==1){
                                echo "<option value='1' selected>Yes</option>
                                      <option value='0'>No</option>";
                               }elseif($data['best_seller']==0){
                                echo "<option value='1'>No</option>
                                      <option value='0'>Yes</option>";
                               }else{
                                echo "<option value='1'>Yes</option>
                                      <option value='0'>No</option>";
                               }
                             ?>
                         </select>
                       </div>
                   </div>
                  <?php
                     $attr_id=1;
                    foreach($attr_data as $list){ 
                  ?>
                   <div class="form-row attr_main_<?php echo $attr_id ?>">
                        <div class="form-group col-2">
                            <label for="Mrp">MRP</label>
                            <input type="text" name="mrp[]" value="<?php echo $list['mrp'] ?>" class="form-control">
                        </div>                     
                        <div class="form-group col-2">
                            <label for="price">Price</label>
                            <input type="text" name="price[]" value="<?php echo $list['price'] ?>" class="form-control" placeholder="Enter Price" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="qnt">quantity</label>
                            <input type="text" name="quantity[]" value="<?php echo $list['quantity'] ?>" class="form-control" placeholder="Enter Quantity" required>
                        </div>
                        <div class="form-group col-2" id="size_attr">
                          <label for="Size">Size</label>
                            <select name="size_id[]" id="size_id" class="form-control shadow-none">
                            <option value="">Select</option>
                            <?php 
                              $obj->select('size_master','*',null,"status='1'",null,null);
                              $color = $obj->getResult();
                              foreach($color as $color_data){
                                if($list['size_id']==$color_data['size_id']){
                                  echo "<option value=".$color_data['size_id']." selected>".$color_data['size']."</option>";                               
                              }else{
                                  echo "<option value=".$color_data['size_id'].">".$color_data['size']."</option>";                               
                              }
                            }
                            ?>
                          </select>  
                       </div>
                        <div class="form-group col-2" id="color_attr">
                          <label for="qnt">Color</label>
                            <select name="color_id[]" class="form-control shadow-none" id="color_id">
                              <option value="">Select</option>
                              <?php 
                                $obj->select('color_manage','*',null,"status='1'",null,null);
                                $color = $obj->getResult();
                                foreach($color as $color_data){
                                  if($color_data['color_id']==$list['color_id']){
                                  echo "<option value=".$color_data['color_id']." selected>".$color_data['color']."</option>";                               
                                }else{
                                  echo "<option value=".$color_data['color_id'].">".$color_data['color']."</option>";                               
                                }
                              }
                            ?>
                            </select>
                        </div>
                        <?php 
                          if($attr_id == 1){
                        ?>
                            <div class="form-group col-2 mt-4">
                               <input type="button" class="btn btn-primary px-4 mt-2" value="ADD MORE" id="Add_more_attr">
                            </div>
                        <?php
                          }else{
                        ?>
                         <div class="form-group col-2 mt-4">
                            <input type="button" onclick="remove_Attr('<?php echo $attr_id ?>','<?php echo $list['id'] ?>')" class="btn btn-primary mt-2 px-5" value="REMOVE" id="More_img_attr_remove">
                         </div>
                        <?php } ?>
                        <input type="hidden" name="attr_id[]" value="<?php echo $list['id'] ?>">
                    </div>
                    <?php 
                       $attr_id++;
                       }
                     ?>
                    <div id="attr_result"></div>
                   <div class="form-row" id="image">                        
                        <div class="form-group col-10">
                            <label for="image">image</label>
                            <input type="File" name="image" class="form-control">
                            <?php
                               if($data['image']!=''){
                                 echo "<a href='".$data['image']."' target='_blanck'><img src='".$data['image']."' width='70'></a>";
                               }
                            ?>
                        </div>
                        <div class="form-group col-2 mt-3">
                          <label for=""></label>
                          <input type="button" id="Add_more_image" class="btn btn-primary shadow-none mt-2" value="ADD MORE IMAGE">
                        </div>
                    </div>
                    <div class="form-row" id="more_img">
                       <?php 
                         foreach($multiple_product as $product_img){
                            echo '<div class="form-group col-10 add_image_'.$product_img['images_id'].'"><label for="image">image</label><input type="File" name="product_images[]" class="form-control"></div>
                                 <div class="form-group ml-3 mt-4 add_image_'.$product_img['images_id'].'"><label for="image"></label><button type="button" id="More_img_remove"
                                   class="btn btn-primary shadow-none mt-2"><a href="?id='.$data['product_id'].'&pi='.$product_img['images_id'].'" class="text-white">REMOVE IMAGE</a></button></div>';
                            echo '<div class="form-group col-12 mb-4"><a href="'.$product_img['product_images'].'" target="_blank"><img src="'.$product_img['product_images'].'" width="70"></a></div>';
                            echo '<input type="hidden" name="product_image_id_multiple[]" value="'.$product_img['images_id'].'">';
                     
                         } 
                       ?>
                    </div>
                    <div class="form-row py-2">
                       <div class="form-group col-6">
                           <label for="desc">Discount Price</label>
                           <input type="text" name="discount_price" class="form-control" value="<?php echo $data['discount_price'] ?>">
                       </div>
                       <div class="form-group col-6">
                           <label for="desc">Discount Precentage</label>
                           <input type="text" name="discount_precentage" class="form-control" value="<?php echo $data['discount_precentage'] ?>">
                       </div>
                   </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="description" cols="30" rows="2" value="" class="form-control" placeholder="Enter Description"><?php echo $data['description'] ?></textarea>
                    </div>                        
                   <div class="form-row py-2">
                       <div class="form-group col-6">
                           <label for="desc">Short Description</label>
                           <input type="text" name="short_description" class="form-control" value="<?php echo $data['short_desc'] ?>">
                       </div>
                       <div class="form-group col-6">
                           <label for="desc">Meta Title</label>
                           <input type="text" name="meta_title" class="form-control" value="<?php echo $data['meta_title'] ?>">
                       </div>
                   </div>
                   <div class="form-row py-2">
                       <div class="form-group col-6">
                           <label for="desc">Meta Description</label>
                           <input type="text" name="meta_description" class="form-control" value="<?php echo $data['meta_description'] ?>">
                       </div>
                       <div class="form-group col-6">
                           <label for="desc">Meta Keyword</label>
                           <input type="text" name="meta_keyword" class="form-control" value="<?php echo $data['meta_keyword'] ?>">
                       </div>
                       <input type="submit" value="Submit" name="product_update" class="btn btn-success col-12 btn-lg my-3" id="product-updatebtn">
                   </div>
               </div>
               </form>
           </div>
       </div>
   </div>
 </div>
 <?php 
    }
  ?>
 </div>

<?php 

 include "includes/dash-footer.php";

?>
<script>
<?php 
  if(isset($_GET['p_eid'])){
?>
  change_main_category();
<?php
  }
?>
</script>