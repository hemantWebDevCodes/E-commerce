<?php 
 
  include "database.php";
  
?>
 
  <?php
     
     $obj = new Database();

   //   if(isset($_POST['search_tearm'])){
        $search = isset($_POST['search_list']) ? $_POST['search_list'] : '';
         
        $obj->select('sub_categories','*',null,"subcate_name LIKE '%{$search}%'",null,null);
        $product_data = $obj->getResult();   
        
        $output='<ul class="list-group">';

        if(!empty($product_data)){

         foreach($product_data as $data){
          $output .= "<li class='list-group-item rounded-0 border-left-0 border-right-0 py-2 text-capitalize'><a class='list-group-item-action' href='search_result.php?search_box={$data['subcate_name']}'><b>{$data["subcate_name"]}</b></a></li>";
        }
      }else{
        echo "<li class='list-group-item'>Search Not Found.</li>";
      }
    $output .="</ul>";
    
    echo $output;

  
?>