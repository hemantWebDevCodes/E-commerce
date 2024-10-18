<?php 

   include "database.php";
   include "add-to-cart.php";
   
   if(!isset($_SESSION['email'])){
      die();
   }
   $order_id = $_GET['id'];
   $user = $_SESSION['id'];
   
   $obj = new Database();
   $obj->select('coupon','*',null,"coupon_id='$user'",null,null);
   $coupon = $obj->getResult();
   $coupon_value = $coupon[0]['coupon_value'];
   
   $join= "product ON order_deatail.product_id = product.product_id 
         LEFT JOIN product_order ON order_deatail.id = product_order.id";
         
   $where = "order_deatail.order_id=$order_id AND product_order.user_id=$user"; 
   
   $obj->select('order_deatail','order_deatail.*,product.image,product.p_name',$join,$where,null,null);
   
   $product = $obj->getResult();
   

  $css = file_get_contents('css/All-Page.css');
  $css2 = file_get_contents('bootstrap/css/bootstrap.css');
 
 $orderhtml = "
            <div class='pdf-header'>
               <strong>ORDER DEATAIL</strong>
            </div>
            <table id='pdftable'>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>";
                
                foreach($product as $order){            
        $orderhtml .="<tbody>
                    <tr>
                        <td>" .$order['p_name'] ."</td>
                        <td><img src=".$order['image']." width='200'></td>
                        <td> " . $order['quantity'] . "</td>
                        <td>&#8377; ". $order['price'] ."</td>
                        <td>&#8377; ".  $order['price']*$order['quantity'] ."</td>
                    </tr>
                    <tr>
                        <td colspan='3'></td>
                        <td>Coupon Price : </td>
                        <td>&#8377; " . $coupon_value . "</td>
                    </tr>
                    <tr>
                        <td colspan='3'></td>
                        <td>Total Price : </td>
                        <td>&#8377; " . $order['price']*$order['quantity']-$coupon_value . " </td>
                    </tr>
                    </tr>";
                   } 
    $orderhtml.="</tbody>
            </table>
        </div>
    </div>
</div>
";
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($orderhtml,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');
?>

