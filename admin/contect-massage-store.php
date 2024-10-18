<?php 
 
 include 'database.php';
 include 'includes/dash-header.php';
 include 'includes/dash-top-nav.php';
 include 'includes/dash-sidebar.php';

?>

 <?php
   $obj = new Database();
   
   // Delete Code

   $obj->select('contect','*',null,null,null,6);
   $data = $obj->getResult();

   if(isset($_GET['contect_id'])){
     $con_id = $_GET['contect_id'];

     $obj->delete('contect',"contect_id='$con_id'");
   }
 ?>
 <link rel="stylesheet" href="css/All-Page.css">
  <div class="content-wrapper">
  <div class="container">
      <div class="row">
        <div class="col-md-12 py-3">
           <h3 class="ml-5">Message :</h3>
        </div>
      </div>
  </div>
    <div class="container">
      <div class="row">
        <div class="col-md-11 mx-auto">
          <table class="table table-hover table-light">
            <thead>
              <tr>
                <th>id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php 
               foreach($data as $contect){
              ?>
              <tr class="font-weight-bold tabletd">
                <td><?php echo $contect['contect_id'] ?></td>
                <td><?php echo $contect['name'] ?></td>
                <td><?php echo $contect['email'] ?></td>
                <td><?php echo $contect['comment'] ?></td>
                <td><?php echo $contect['added_on'] ?></td>
                <td><a href="?contect_id=<?php echo $contect['contect_id'] ?>"><i class="fa-sharp fa-solid fa-square-xmark trash mt-0"></i></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
            <!-- PAGINATION -->
            <?php 
               echo $obj->pagination('contect',null,null,6);
            ?>
            <!-- CLOSE -->
        </div>
      </div>
    </div>
  </div>
<?php 
 include 'includes/dash-footer.php';
?>