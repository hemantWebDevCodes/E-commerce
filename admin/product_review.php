<?php 

include "includes/dash-header.php";
include "includes/dash-sidebar.php";
include "includes/dash-top-nav.php";
include "database.php";


?>
<?php 
 $id='';

 $obj = new Database();

 // PRODUCT REVIEW UPDATE
  $update_review = isset($_GET['update_review_id']) ? $_GET['update_review_id'] : '';
 if(isset($_POST['update_review'])){
    $update_review = $_GET['update_review_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
      
    $obj->update('product_review',['rating'=>$rating,'review'=>$review],"review_id='$update_review'");
    print_r($obj->getResult());   
}

 // DELETE PRODUCT REVIEW
 $delete_id = isset($_GET['review_delete_id']) ? $_GET['review_delete_id'] : '';
 $obj->delete('product_review',"review_id='$delete_id'");

 // ACTIVE DEACTIVE PRODUCT REVIEW
 if(isset($_GET['type']) && $_GET['type'] != ''){
   $type = $_GET['type'];
   if($type == 'status'){
    $Deactive = $_GET['review'];
    $id = $_GET['id'];
    if($Deactive == 'Active'){
      $role = '1';
    }else{
      $role = '0';
    }
  $obj->update('product_review',['status'=>$role],"review_id='$id'");
   }

 }
?>

  <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">     
  <div class="container">
    <div class="row">
        <div class="col-md-11 bg-white py-3 mt-3 px-3 mx-auto">
            <button class="btn btn-primary btn-lg" id="update_review_form_show">UPDATE REVIEW</button>
        </div>
    </div>
  </div>

  
  <!-- PRODUCT REVIEW UPDATE -->
  <?php 
    $obj->select('product_review','*',null,"review_id='$update_review'",null,null);
    $get_data = $obj->getResult();
    foreach($get_data as $row){
  ?>
<div class="container bg-light" id="review_update_form">
    <div class="row">
        <div class="col-md-11 mx-auto mt-3">
            <div class="card rounded-0">
                <div class="card-header">
                    <h4 class="fotn-wieght-bold">Update Review Form</h4>
                </div>
                 <form method="post">
                    <div class="card-body">
                    <div class="form-group">
                        <label>Rating</label>
                        <select name="rating" class="form-control shadow-none">
                           <?php
                           ?>
                            <option>Select Rating</option>
                            <option>Wrost</option>
                            <option>Bad</option>
                            <option>Good</option>
                            <option>Very Good</option>
                            <option>Fantastic</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Review</label>
                        <textarea name="review" cols="50" rows="2" class="form-control shadow-none"></textarea>
                    </div>
                    <div class="form-group">
                       <input type="submit" name="update_review" id="update_review_btn" class="btn bnt-primary btn-lg">
                    </div>
                    </div>
                </form>
                </card>
            </div>
        </div>
    </div>
</div>
    <?php 
      }
     ?>
  

  <!-- PRODUCT REVIEW TABLE -->
       <div class="col-md-11 mx-auto mt-2"> 
         <table class="table table-light table-hover mb-4 text-center">
           <thead>
             <tr>
                <th>Id</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Active/Deactive</th>
                <th>Edit</th>
                <th>Delete</th>
             </tr>
           </thead>
           <tbody>
            <?php 
              $join ="user_registration login ON product_review.user_id = login.id";
              $obj->select('product_review','product_review.*,login.name,login.email',$join,null,null,6);
              $data = $obj->getResult();
              foreach($data as $res){
            ?>
             <tr class="tabletd">
                <td><?php echo $res['review_id'] ?></td>
                <td><?php echo $res['name'] ?></td>
                <td><?php echo $res['email'] ?></td>
                <td><?php echo $res['rating'] ?></td>
                <td><?php echo $res['review'] ?></td>
                <?php 
                if($res['status'] == 1){
                echo "<td><a href='?type=status&review=Deactive&id=" . $res['review_id'] . "' class='btn btn-primary active'>Active</a></td>";
                }else{
                echo "<td><a href='?type=status&review=Active&id=". $res['review_id']."' class='btn btn-success Deactive'>Deactive</a></td>";
                }
                ?>
                <td><a href="product_review.php?update_review_id=<?php echo $res['review_id'] ?>"><i class="fa-solid fa-square-pen mt-0"></i></a></td>
                <td><a href="?review_delete_id=<?php echo $res['review_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
             </tr>
            <?php 
              }
            ?>
           </tbody>
         </table>
          <!-- PAGINATION -->
          <?php 
            echo $obj->pagination('product_review',null,null,6);
          ?>
          <!-- CLOSE -->
       </div>
     </div>
<script src="js-and-jquery/jquery.js"></script>
  <script>
   $(document).ready(function(){
   $('#update_review_form_show').click(function(){
    $('#review_update_form').slideToggle();
   });
  });

  </script>
<?php 
 
 include "includes/dash-footer.php";
 
?>