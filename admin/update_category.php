<?php 
//   include "database.php";

//   $obj = new Database();
  include "includes/dash-header.php";
  include "includes/dash-top-nav.php";
  include "includes/dash-sidebar.php";


?>

<?php 

   // CATEGORY UPDATE
   if(isset($_POST['update'])){
    $editid = isset($_GET['editid']) ? $_GET['editid'] : "";
    $category = $_POST['categorys'];

    $obj->update('main_category',['category_name' => $category],"id='$editid'");
    print_r($obj->getResult());
  }

?>
<link rel="stylesheet" href="css/All-Page.css">

<div class="content-wrapper">
<div class="container my-2">
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

                $obj->select('main_category','*',null,"id='$id'",null,null);
                $fetch = $obj->getResult();
                foreach($fetch as $get_cate){
              ?>
            <input type="text" name="categorys"  value="<?php echo $get_cate['category_name']; ?>" class="form-control">
            <?php } ?>
        </div>
            <button type="submit" class="form-control btn-success py-2" name="update" id="cate_btn"><b>Edit Category</b></button>
          </div>
         </div>
         </div>
           </form>
       </div>
      </div>
    </div>
      
<!-- <script src="js-and-jquery/jquery.js">
    $(document).ready(function(){

    $("#editbtn").click(function(event){
      event.preventDefault();
      $('#edit_Form').fadeIn();
    });
    }); -->
</script>