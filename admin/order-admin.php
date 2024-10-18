<?php 
 
 include "includes/dash-header.php";
 include "includes/dash-top-nav.php";
 include "includes/dash-sidebar.php";
 include "database.php";

 isAdmin();
?>
 
<?php 
 
  $obj = new Database();
 
?>
 <link rel="stylesheet" href="css/All-Page.css">
 <div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-11 bg-white mx-auto mt-4 py-2">
                <h5 class="ml-3 py-2"><b>ORDER</b></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 mt-4 mx-auto">
            <table class="table table-bordered table-hover table-light text-center">
               <thead>
                  <tr>
                    <th>PDF</th>
                    <th>Order Id</th>
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Payment Type</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                  </tr>
               </thead>
               <tbody>
                 <?php
                  $join = "order_status ON product_order.order_status = order_status.status_id"; 
                  $obj->select('product_order','*',$join,null,null,6);
                  $order = $obj->getResult();
                  foreach($order as $product){
                 ?>
                 <tr class="tabletd font-weight-bold">
                    <td><a href="order_pdf.php?id=<?php echo $product['id'] ?>" id="myorder_pdf"><i class="fa-solid fa-file-pdf text-danger"></i></a></td>
                    <td><a href="order-admin-deatail.php?id=<?php echo $product['id'] ?>" class="btn btn-success" id="myor_detail"><?php echo $product['id'] ?> Deatail</a></td>
                    <td><?php echo $product['added_on'] ?></td>
                    <td><?php echo $product['address'] ?></td>
                    <td><?php echo $product['payment_type'] ?></td>
                    <td><?php echo $product['payment_status'] ?></td>
                    <td><?php echo $product['status_name'] ?></td>
                 </tr>
                 <?php } ?>
               </tbody>
            </table>
        <!-- PAGINATION -->
         <?php 
           echo $obj->pagination('product_order',$join,null,6);
         ?>
         <!-- PAGE CLOSE -->
        </div>
    </div>
 </div>
<?php 
 
  include "includes/dash-footer.php"; 

?>