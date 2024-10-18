<?php 
 
 session_start();

 unset($_SESSION['email']);

 header('location:login-registration.php');

?>