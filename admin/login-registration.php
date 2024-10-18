<?php 
  
  include "includes/header.php";
  include "includes/top-navbar.php";

  if(isset($_SESSION['email'])){
     echo "<script>window.location.href='dashbord.php';</script>";
  }

 ?>
<link rel="stylesheet" href="css/All-Page.css" />
<link rel="stylesheet" href="css/login.css" />

<div class="bg-light">
    <div class="container">
        <div class="row">
            <!-- Login Form -->
            <div class="col-md-5 mt-5 ml-5">
                <h5 class="">LOGIN</h5>
                <form method="POST" id="login-form">
                    <div id="login_input" class="mt-4">
                        <div class="form-group input-group-lg">
                            <input type="email" id="login_email" name="login_email" class="form-control shadow-none" placeholder="Your Email*" />
                            <span class="error_field" id="login_Eerror"></span>
                        </div>
                        <div class="form-group input-group-lg py-3">
                            <input type="password" id="login_password" name="login_password" class="form-control shadow-none" placeholder="Your Password*" autocomplete="on"/>
                            <span class="error_field" id="login_perror"></span>
                        </div>
                        <div class="form-group">
                            <input type="button" name="login" id="loginbtn" value="Login" class="btn-success shadow-none mt-1 col-3 btn-lg" />
                            <span class="text-danger" id="success-login"></span>
                            <a href="forgot_password.php" class="btn btn-primary shadow-none mt-1" id="forgetpass_btn">Forger Password</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Registration Form -->
            <div class="col-md-5 ml-5 mt-5">
                <h5 class="">REGISTER</h5>
                <form action="" method="POST" id="validate_register">
                    <div id="registrer_input" class="mt-4">
                        <div class="form-group input-group-lg">
                            <input type="text" name="name" id="name" class="form-control shadow-none " placeholder="Your Name*" required />
                            <span class="error_field" id="name_error"></span>
                        </div>
             <!-- EMAIL OTP VERIFICATION -->
                        <div class="form-row pt-3">
                            <div class="form-group input-group-lg col-8">
                                <input type="email" name="email" id="email" class="form-control shadow-none email" placeholder="Your email*" required />
                                <span class="error_field" id="email_error"></span>
                            </div>
                            <div class="form-group input-group-lg col-3" id="verify_otp_result">
                                <button type="button" id="send_otp" onclick="email_send_otp()" class="btn btn-dark btn-lg px-4 shadow-none">SEND OTP</button>
                                
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="form-group input-group-lg col-8">
                                <input type="number" name="email_verify" id="email_verify" class="form-control shadow-none email_ver_show" placeholder="OTP*" required />
                                <span class="error_field" id="get_email_otp"></span>
                            </div>
                            <div class="form-group input-group-lg col-4">
                                <input type="button" name="email_otp" id="verify_otpbtn" onclick="email_verify_otp()" class="btn btn-dark btn-lg shadow-none email_ver_show" value="VERIFY OTP" />
                                <span class="error_field" id="email_error"></span>
                            </div>
                            <span class="error_field" id="otp_unvalid"></span>
                        </div>                 
                <!-- MOBILE OTP VERIFICATION -->
                          <div class="form-group input-group-lg">
                            <input type="number" name="mobile" class="mobile form-control shadow-none" placeholder="Enter Mobile Number" required>
                            <span class="error_field" id="mobile_error"></span>
                          </div>
                <!-- CLOSE MOBILE FIELD -->
                        <div class="form-group input-group-lg py-3">
                            <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Your Password*" autocomplete="on" required />
                            <span class="error_field" id="password_error"></span>
                        </div>
                        <input type="hidden" id="check_verify_otp"> 
                        <input type="button" name="register" onclick="Registration_send()" value="Register" disabled class="btn btn-success col-3 btn-lg mt-2 shadow-none" id="registerbtn" />
                    </div>
                    <span class="text-success" id="success"></span>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
 
  include "includes/footer.php";
 
?>