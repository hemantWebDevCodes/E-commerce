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

  // ADD COLOR
  $error = '';
  if (isset($_POST['insert_color'])) {
    $color = $_POST['color'];

    $obj->select('color_manage', 'color', null, "color='$color'", null, null);
    $duplicate = $obj->getResult();

    if ($duplicate) {
        $error = "<script>swal('Sorry', 'Color Already Exists.', 'error');</script>";
    } else {
        $obj->insert('color_manage',['color' => $color,'status' => 1]);
        print_r($obj->getResult());
    }
  }

  // COLOR UPDATE
  if (isset($_POST['color_update'])) {
    $editid = isset($_GET['editid']) ? $_GET['editid'] : "";
    $color = $_POST['color'];

    $obj->update('color_manage', ['color' => $color], "color_id='$editid'");
    print_r($obj->getResult());
  }

  // COLOR DELETE
  $delete_id = isset($_GET['deleteid']) ? $_GET['deleteid'] : "";
  $obj->delete('color_manage', "color_id='$delete_id'");

  // COLOR ACTIVE DEACTIVE
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
        $obj->update('color_manage', ['status' => $role], "color_id='$id'");
        print_r($obj->getResult());
    }
  }


 ?> 

 <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">
<div class="container">
  <div class="row">
    <div class="col-md-11 mx-auto bg-white py-2 px-3 mt-4">
      <input type="button" value="Add Color" id="color_show_btn" class="btn-lg color_button">
      <input type="button" value="Update Color" id="color_update_btn" class="color_button float-right">
    </div>
  </div>
</div>
  <!-- ADD COLOR  -->
  <div class="container my-2" id="color_form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card rounded-0">
        <div class="card-header">
          <h4>Color Add Form</h4>
        </div>
        <form method="POST">
         <div class="card-body">
          <div class="form-group mt-0">
            <label for="Color">Color</label>
            <input type="text" name="color" class="form-control" placeholder="Add Color">
          </div>
            <button type="submit" class="btn btn-success btn-lg col-12 my-2" name="insert_color" id="insert_color_btn">Submit</button>
          </div>
         </div>
         </div>
        </form>
       </div>
      </div>
  
 <!-- COLOR UPDATE FORM -->
  <div class="container my-2 color_form" id="update_color_form">
    <div class="row">
      <div class="col-md-11 mx-auto">
       <div class="card">
        <div class="card-header">
          <h4>Color Update Form</h4>
        </div>
        <form action="" method="POST">
         <div class="card-body">
            <?php
              $id = isset($_GET['editid']) ? $_GET['editid'] : "";

              $obj->select('color_manage','*',null,"color_id='$id'",null,null);
              $fetch = $obj->getResult();
              foreach($fetch as $color_field){
            ?>
           <div class="form-group mt-0">
             <label>Color</label>
             <input type="text" name="color"  value="<?php echo $color_field['color']; ?>" class="form-control"> 
           </div>
            <button type="submit" class="btn btn-success btn-lg col-12 my-2" name="color_update" id="color_edit_btn">Edit Category</button>
        <?php } ?>  
        </div>
         </div>
         </div>
       </form>
     </div>
   </div>
 <!-- COLOR TABLE -->
<div class="container mt-2">
  <div class="row">
    <div class="col-md-11 mx-auto table-responsive-md">
    <table class="table table-bordered table-hover mb-5 table-light text-center">
     <thead>
      <tr>
        <th>Id</th>
        <th> Color</th>
        <th>Active & Deactive</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php 

    $obj->select('color_manage','*',null,null,null,6);
      $data = $obj->getResult();
      
      foreach($data as $row){
    ?>
      <tr class="tabletd">
        <td><?php echo $row['color_id'] ?></td>
        <td><?php echo $row['color'] ?></td>
        <td>
          <?php
                if($row['status'] == 1){
                    echo "<a href='?type=status&statusrole=Deactive&id=".$row['color_id']."' class='btn btn-primary active'>ACTIVE</a>";
                  }else{
                    echo "<a href='?type=status&statusrole=Active&id=".$row['color_id']."' class='btn btn-success deactive'>DEACTIVE</a>";
                  }
          ?> 
        </td>
       <td><a href='?editid=<?php echo $row['color_id'] ?>'><i class="fa-solid fa-square-pen mt-0"></i></a></td>
       <td><a href='?deleteid=<?php echo $row['color_id'] ?>'><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a> </td> 
      </tr>
    <?php
      }
    ?>
    </tbody>
   </table>
    <!-- PAGINATION -->
     <?php 
       echo $obj->pagination('color_manage',null,null,6);
     ?>
    <!-- CLOSE -->
  </div>
    </div>
  </div>
</div>

<script src="js-and-jquery/jquery.js"></script>
  <script>
   $(document).ready(function(){
    $('#color_show_btn').click(function(){
      $('#color_form').slideToggle();
    });
   
     $("#color_update_btn").click(function(){  
      $('#update_color_form').fadeToggle();
    });
   });
 </script>

<?php 

  include "includes/dash-footer.php";

?>
<?php echo $error ?>