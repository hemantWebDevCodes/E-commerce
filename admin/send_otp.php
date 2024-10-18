<?php 

session_start();
include "database.php";

?>
 
 <?php

$type = isset($_POST['type']) ? $_POST['type'] : '';

if($type=='email'){
  $email = isset($_POST['email']) ? $_POST['email'] : '';

  $otp=rand(111111,999999);
  $_SESSION['EMAIL_OTP']=$otp;
  $emailotp="Dear User, <br><br> Thank you for choosing E-shop for your online shopping needs. 
             To proceed with your account setup, please use the following One Time Password (OTP)
             for verification: <br><br> OTP : $otp <br><br>Please enter this OTP on the verification page to complete your registration process. <br><br>
             If you did not attempt to create an account on E-shop, please ignore this email. <br><br> Thank you,<br> Hemant Saini <br> E-shop Team";

  include "smtp/PHPMailerAutoload.php";

	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
    // $mail->SMTPDebug = 2;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="hemant12122006@gmail.com";
	$mail->Password="cdktzonvdkuabunu";
	$mail->SetFrom("hemant12122006@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="OTP for E-shop Account Verification" ;
	$mail->Body=$emailotp;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		echo "done";
	}else{
		// echo "Not Send Your Email";
	}
  }

?>