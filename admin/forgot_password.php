<?php 
 
 include "includes/header.php";
 include "includes/top-navbar.php";

?>
<link rel="stylesheet" href="css/All-Page.css">
 <div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
          <form action="" method="POST" id="passwordforget-form">
            <div class="card-header">
                <h4>Forget Password Form</h4>
            </div>
          <div id="login_input" class="mt-4">
            <div class="form-group pb-2">
                <input type="email" name="email" id="email" class="form-control form-control-lg shadow-none" placeholder="Enter Password">
                <span class="error_field" id="email_for_pass"></span>
            </div>
            <button type="button" onclick="forget_password()" class="btn btn-success btn-lg shadow-none col-3" id="Password_forget">Submit</button>
             <span class="error_field" id="forget_pass_result"></span>
          </form>
        </div>
    </div>
 </div>
 
   <script src="js-and-jquery/jquery.js"></script>
   <script>
     
     function forget_password(){
      $("#forget_pass_result").html("");
      let email = $("#email").val();

      if(email == ''){
        $("#email_for_pass").html("Plese Enter Your Email");
      }else{
           $("#Password_forget").html("Plese wait...");
           $("#Password_forget").attr('disabled',true);
        $.ajax({
            url:"forgot_password_smtp.php",
            type:"post",
            data:{email:email},
            success:function(result){ 
              result=result.trim();
               if(result=='done'){
                  $("#Password_forget").html('SUBMIT');
                  $("#Password_forget").attr('disabled',false); 
               }else{
                  $('#forget_pass_result').html('Plese Check Your Email Id For Password.');
               }
            }
        });
      }
      
     }
       
     
   </script>

<?php 
 
 include "includes/footer.php";

?>
