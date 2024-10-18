<?php 
 
  include "includes/header.php";
  include "includes/top-navbar.php";

?>

 <?php 

  $obj = new Database();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $message = $_POST['comment'];

    $obj->insert('contect',['name' => $name,'email' => $email,'mobile' => $mobile,'comment' => $message]);
    print_r($obj->getResult());
  }

  ?>
 <link rel="stylesheet" href="css/All-Page.css">
 <div class="container bg-light">
  <div class="row">
    <div class="col-md-10 mx-auto mt-4">
      <h4 class="">Send Mail</h4>
    </div>
  </div>
 </div>

 <div class="container bg-light">
   <div class="row">
    <div class="col-md-10 mx-auto mt-5">
      <form action="" method="post" id="contect_form">
         <div class="mx-auto"> 
        <div class="form-row" id="contect-input">
          <div class="form-group col-4 input-group-lg">
            <label for="name">Name : </label>
            <input type="text" name="name" id="name" class="form-control input-lg shadow-none" placeholder="Name">
          </div>
          <div class="form-group col-4 input-group-lg">
            <label for="name">Email : </label>
            <input type="email" name="email" id="email" class="form-control input-lg shadow-none" placeholder="Email">
          </div>
          <div class="form-group col-4 input-group-lg">
            <label for="name">Mobile Number : </label>
            <input type="text" name="mobile" id="mobile" class="form-control input-lg shadow-none" placeholder="Mobile">
          </div>
        </div>
          <div class="form-group">
            <label for="name">Massage : </label>
            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control shadow-none"></textarea>
          </div>
        <input type="submit" value="Send Message" id="Massage_btn" class="btn btn-success shadow-none mt-3 btn-lg">
        </div>
      </form>
    </div>         
    </div>
   </div>
 </div>
<?php 

 include "includes/footer.php";
 
?>
 

