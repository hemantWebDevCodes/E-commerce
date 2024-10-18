<?php 
 
 include "database.php";
?>

<?php 

  $obj = new Database();

  $email = isset($_POST['email']) ? $_POST['email'] : '';

  $obj->select('user_registration','*',null,"",null,null);
  $check = $obj->getResult();
  if($check[0]['email']){

  include "smtp/PHPMailerAutoload.php";
  $password=$check[0]['password'];
  $html="Your Password is <strong>$password</strong>";
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
    $mail->SMTPDebug = 2;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="hemant12122006@gmail.com";
	$mail->Password="cdktzonvdkuabunu";
	$mail->SetFrom("hemant12122006@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="Your Password";
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
        echo 'done';
	} 
	}else{
        // echo "Your Email Id Not Registred With Us.";
  }

?>