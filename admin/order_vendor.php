<?php 
 
 include "includes/dash-header.php";
 include "includes/dash-top-nav.php";
 include "includes/dash-sidebar.php";
 include "database.php";

?>
 <link rel="stylesheet" href="css/All-Page.css">
 <div class="content-wrapper">
 <div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">
          <div class="table-header py-3 px-2">
            <h5>YOUR ORDER</h5>
          </div>
            <table class="table table-bordered table-hover text-center">
              <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Vendor Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Address</th>
                    <th>Payment Type</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  
                  $obj= new Database();

                  $join = "product_order po ON order_deatail.id = po.id
                           LEFT JOIN product p ON order_deatail.product_id=p.product_id 
                           LEFT JOIN order_status os ON order_deatail.id=os.status_id
                          ";

                  $where="p.added_by='".$_SESSION['ADMIN_ID']."'";
                  $obj->select('order_deatail','order_deatail.*,p.p_name,p.quantity,po.added_on,po.address,po.payment_status,po.payment_type,os.status_name',$join,$where,null,null);
                  $order_data = $obj->getResult();
                  foreach($order_data as $order){
                ?>
                <tr class="tabletd font-weight-bold">
                   <td><?php echo $order['id']; ?></td>
                   <td><?php echo $_SESSION['ADMIN_USERNAME']; ?></td>
                   <td><?php echo $order['p_name'] ?></td>
                   <td><?php echo $order['quantity'] ?></td>
                   <td><?php echo $order['address'] ?></td>
                   <td><?php echo $order['payment_type'] ?></td>
                   <td><?php echo $order['payment_status'] ?></td>
                   <td><?php echo $order['status_name'] ?></td>
                   <td><?php echo $order['added_on'] ?></td>
                </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
        </div>
    </div>
 </div>
 </div>
<?php
 
 include "includes/dash-footer.php";
?>