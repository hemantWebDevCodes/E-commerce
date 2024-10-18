<?php
 
  session_start();

  unset($_SESSION['ADMIN_USERNAME']);

  echo "<script>window.location.href='admin_login.php';</script>";


?>