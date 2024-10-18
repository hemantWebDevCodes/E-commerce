<nav class="main-header fixed-top navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Home</a>
      </li>
    </ul>
  <ul class="navbar-nav ml-auto mr-3">
    <li class="nav-item d-none d-sm-inline-block">
    <?php 
       if(isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : ''){
         echo "<a href='admin_logout.php' class='nav-link'>Welcome, ".$_SESSION['ADMIN_USERNAME'] ."</a>";
       }else{
         echo "<a href='admin_register.php' class='text-secondary'>REGISTRATION</a> /
               <a href='admin_login.php' class='text-secondary'>lOGIN</a>";
       }
    ?>
      </li>
    </ul>
</nav>
<div class="mt-5"></div>
 