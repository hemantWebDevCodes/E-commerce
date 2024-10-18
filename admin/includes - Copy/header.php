 <?php 

  include "database.php";
  include "add-to-cart.php";

  $obj = new Database;
   
  // Title And Meta Title
  $title = "EShope Website";
  $meta_desc = "EShope Website";
  $meta_keyword = "EShope Website";
  $url='';
  $product_image="";

  $script_name = $_SERVER['SCRIPT_NAME'];
  $script_name_arr = explode('/',$script_name);
  $product_page = $script_name_arr[count($script_name_arr)-1];
  
 if($product_page=='product-deatail.php'){
   $id = $_GET['id'];
   $obj->select('product','meta_title,meta_description,meta_keyword,image',null,"product_id='$id'",null,null);
   $meta = $obj->getResult();
    foreach($meta as $meata_deatail){
   $title = isset($meata_deatail['meta_title']) ? $meata_deatail['meta_title']:'';
   $meta_desc = isset($meata_deatail['meta_description']) ? $meata_deatail['meta_description'] : '';
   $meta_keyword = isset($meata_deatail['meta_keyword']) ? $meata_deatail['meta_keyword'] : '';
   $url = "http://localhost/hemant/Furniture/admin/category-product.php?id=".$id;
   $product_image = isset($meata_deatail['image']) ? $meata_deatail['image']: '';
  }
}
 if($product_page=='contect.php'){
   $title = 'Contect Us';
  }


?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title ?></title>
  <meta name="meta_description" content="<?php echo $meta_desc ?>">
  <meta name="meta_keyword" content="<?php echo $meta_keyword ?>">
  <meta property="og:title" constant="<?php echo $title ?>">
  <meta property="og:image" constant="<?php echo $product_image ?>">
  <meta property="og:url" constant="<?php echo $url ?>">
  <meta property="og:site_name" constant="http://localhost/hemant/Furniture/admin/home.php">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
 

<!-- Font  Awsom -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="css/All-Page.css">
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



