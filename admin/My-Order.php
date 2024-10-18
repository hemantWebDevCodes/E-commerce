<?php 
 
 include "includes/header.php";
 include "includes/top-navbar.php";

?>
 <link rel="stylesheet" href="css/All-Page.css">
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
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Payment Type</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $user = $_SESSION['id'];
                  $join = "order_status ON product_order.order_status = order_status.status_id";
                  $where = "user_id=$user";
                  $obj->select('product_order','*',$join,$where,null,null);
                  $order_data = $obj->getResult();
                  foreach($order_data as $order){
                ?>
                <tr class="tabletd font-weight-bold">
                   <td><a href="my-order-deatail.php?id=<?php echo $order['id'] ?>" class="btn btn-dark shadow-none" id="myor_detail"><?php echo $order['id'] ?> Deatail</a><br><br>
                       <a href="order_pdf.php?id=<?php echo $order['id']; ?>" class="shadow-none" id="myorder_pdf"><i class="fa-solid fa-file-pdf text-danger"></i></a></td>
                   <td><?php echo $order['added_on'] ?></td>
                   <td>
                    <?php echo $order['address'] ?>
                    <?php echo $order['city'] ?><br>Pincode:
                    <?php echo $order['pincode'] ?>
                   </td>
                   <td><?php echo $order['payment_type'] ?></td>
                   <td><?php echo $order['payment_status'] ?></td>
                   <td><?php echo $order['status_name'] ?></td>
                </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
        </div>
    </div>
 </div>

<?php
 
 include "includes/footer.php";
?>