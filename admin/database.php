<?php

use setasign\Fpdi\PdfReader\Page;

define('SITE_PATH','http://localhost/hemant/Furniture/admin');

  class Database {
           
        private $localhost = "localhost";
        private $user = "root";
        private $pass = "";
        private $db = "MyShop";
        
        public $mysqli = "";
        private $result = array();
        private $conn = false;

         
    public function __construct() {
      if(!$this->conn){
        $this->mysqli = new mysqli($this->localhost,$this->user,$this->pass,$this->db);
        $this->conn = true;
        if ($this->mysqli->connect_error) {
          array_push($this->result,$this->mysqli->connect_error);
          return false;
        }
    }else{
      return true;
    }
  }

  // INSERT RECORD
  public function insert($table,$parameter = array()){
    if($this->TableExists($table)){
      // print_r($parameter);
        $column_key = implode(',',array_keys($parameter));
        $column_value = implode("','",$parameter);
      $insert = "INSERT INTO $table ($column_key) VALUES ('$column_value')";
     if($this->mysqli->query($insert)){

      // echo $insert;
        array_push($this->result,$this->mysqli->insert_id);
        return true;
     }else{
        array_push($this->result,$this->mysqli->error);
     }
    }else{
      return false;
    }
  } 
  
  // SELECT RECORD
  public function select($table,$row="*",$join = null,$where = null,$OrderBy = null, $limit = null){
    if($this->TableExists($table)){
    $select = "SELECT $row FROM $table";
    
    if($join != null){
      $select .=" LEFT JOIN $join";
    }
    if($where != null){
      $select .=" WHERE $where";
    }
    if($OrderBy != null){
      $select .= " ORDER BY $OrderBy ";
    }
    
    if($limit != null){

      if(isset($_GET['page'])){
        $page = $_GET['page'];
      }else{
        $page= 1;
      }
      
      $start = ($page - 1) * $limit;
      $select .= " LIMIT $start,$limit";
    } 

    // echo $select;
     $query = $this->mysqli->query($select);
     if($query){
       $this->result = $query->fetch_all(MYSQLI_ASSOC);
     }else{
       array_push($this->result,$this->mysqli->error);
       return false;
     }

    }else{
      return false;
    }
  }

  public function sql($sql){
   $query = $this->mysqli->query($sql);

   if($query){
     $this->result = $query->fetch_all(MYSQLI_ASSOC);
   }else{
    array_push($this->result,$this->mysqli->error);
   }
  }

 //UPDATE RECORD 
  public function update($table,$parameter = array(),$where = null){
    if($this->TableExists($table)){
       
      $args = [];
      foreach ($parameter as $key => $value) {
           $args[] = "$key = '$value'";
      //  print_r($args);
      }

     $update = "UPDATE $table SET " . implode(',',$args);
     if($where != null){
      $update .= " WHERE $where";
     }
    //  echo $update;
     if($this->mysqli->query($update)){
       array_push($this->result,$this->mysqli->affected_rows);
     }else{
      array_push($this->result,$this->mysqli->error);
     }
    }else{
      return false;
    }
  }

  // DELETE RECORD
     public function delete($table,$where = null){
      if($this->TableExists($table)){
       $delete ="DELETE FROM $table";
      
      if($where != null){
        $delete .= " WHERE $where";
      }  
      // echo $delete;
      if($this->mysqli->query($delete)){
        array_push($this->result,$this->mysqli->affected_rows);
        return true;
      }else{
        array_push($this->result,$this->mysqli->error);
        return false;
      }
    }else{
        return false;
    
      }
    }

  //CHECK TABLE EXIST 
  private function TableExists($table){
    $sql = "SHOW TABLES FROM $this->db LIKE '$table'";
    $tableDB = $this->mysqli->query($sql);
    if($tableDB){
        if($tableDB->num_rows == 1){
          return true;
        }else{
          array_push($this->result,$table . "Does Not Exists in This Database");
          return false;
        }
   }
  }

  // PAINATINON 
  public function pagination($table,$join=null,$where=null,$limit=null){
    if($this->TableExists($table)){

      if($limit != null){
      $sql="SELECT COUNT(*) FROM $table";

      if($join != null){
        $sql .= " LEFT JOIN $join";
      }
      if($where != null){
        $sql .=" WHERE $where";
      }

      $query = $this->mysqli->query($sql);
      
      $total_record = $query->fetch_array();
      $total_record = $total_record[0];

      $total_page = ceil($total_record / $limit);

      $url = basename($_SERVER['PHP_SELF']);

      if(isset($_GET['page'])){
        $page = $_GET['page'];
      }else{
        $page= 1;
      }
 
      $output = "<ul class='pagination justify-content-center' id='pagination-css'>";

      if($page>1){
        $output .= "<li class='page-item'><a class='shadow-none page-link' id='prev-page' href='$url?page=".($page-1)."'>Prev</a></li>";
      }
    
      if($total_record > $limit){
        for($i = 1; $i <= $total_page; $i++){
          
          if($i==$page){
            $cls="pagination-active";
          }else{
            $cls="";
          }

          $output .= "<li class='page-item $cls'><a class='page-link shadow-none' href='$url?page=$i'>$i</a></li>";
        }
      }
      if($total_page>$page){
        $output .= "<li class='page-item'><a class='shadow-none page-link' id='next-page' href='$url?page=".($page+1)."'>Next</a></li>";
      }
    $output .="</ul>";

    return $output;
    }else{
      return false;
    }
   }else{
     return false;
   }
  }

  // RESULT STORE
   public function getResult(){
     $val = $this->result;
     $this->result = array();
     return $val;
   }


  // DESTRUCT CONNECTION 
    public function __destruct()
    {
      if($this->conn){
       if($this->mysqli->close()){
          $this->conn = false;
          return true; 
       }
      }else{
        return false;
      }
    }
  }


  // IS ADMIN ROLE CHECK
  function isAdmin(){
   if(!isset($_SESSION['ADMIN_USERNAME'])){
      echo "<script>window.location.href='admin_login.php';</script>";
   }
    if($_SESSION['ADMIN_ROLE']==1){
   ?>
      <script>
       window.location.href="product-handel.php";
      </script>
   <?php
    }
   }


   
// QUANTITY STOCK CKECK 
  $obj= new Database();

  function productSoldQtyByProductId($id,$attr_id){
    global $obj;

    $join="product_order po ON order_deatail.id=po.id";
    $obj->select('order_deatail','sum(order_deatail.quantity) as quantity',$join,"order_deatail.product_id='$id' AND order_deatail.product_attribute_id='$attr_id' AND po.order_status!=4",null,null);
   
    $data = $obj->getResult();
    return $data[0]['quantity'];
 }

 // PRODUCT QUANTITY 
  function productQuantity($pid,$attr_id){
    global $obj;
    $obj->select('product_attribute','quantity',null,"id='$attr_id'",null,null);
    
    $quantity_data = $obj->getResult();
    return $quantity_data[0]['quantity'];
  }


  function getProductAttribute($pid){
    global $obj;

    $obj->select('product_attribute','id',null,"product_id='$pid'",null,null);
    $store = $obj->getResult();
    return $store[0]['id'];
    
        print_r($store[0]['id']);
  }

?>