<?php 
  
  session_start();

  include "database.php";  

  $type = isset($_POST['type']) ? $_POST['type'] : '';
   $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
   
   if($type=='email'){
     if($otp==$_SESSION['EMAIL_OTP']){

        echo "done";
     }else{
        echo "no";
     }
   }

?>