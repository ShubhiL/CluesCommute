<?php
require 'PHPMailer/PHPMailerAutoload.php';

//$emp_id='C2150';

//fetch the email
//$email="vaibhav@gmail.com";

$emp_id='ER133';

//fetch the email
$email="akriti@gmail.com";
$unique_id="5940dcbcda8a71.46043192"; 
$created_at="2017-06-14 12:20:36"; 
$time = explode(' ', $created_at);
$updated_at='2017-06-14 12:20:36';

if ($updated_at!=NULL){
$Utime = explode(' ', $updated_at);	
$url="http://localhost/android_login_api/verifytest.php?employee_id=$emp_id&email=$email&unique_id=$unique_id&created_at=$time[0]%20$time[1]&updated_at=$Utime[0]%20$Utime[1]";
}

else{

$url="http://localhost/android_login_api/verifytest.php?employee_id=$emp_id&email=$email&unique_id=$unique_id&created_at=$time[0]%20$time[1]&updated_at=";

}
//encryption
//$encrypt= sha1($emp_id.$email);

//$url="http://localhost/android_login_api/verifytest.php?employee_id=$emp_id&email=$email&unique_id=$unique_id&created_at=$time[0]%20$time[1]&updated_at=$updated_at";

//send mail
//function sendMail(){
	//$sender='shubhi@gmail.com';
	//$recepient="vaibhav@gmail.com";
	//$body="Hi please clieck here <a href= $url>Verify</a> to verify" ;
	//$subject="verification";

	//HIT THE API-- curl


		$mail = new PHPMailer;

		$mail->isSMTP();                            // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                     // Enable SMTP authentication
		$mail->Username = 'shopclueskhan007';          // SMTP username
		$mail->Password = 'shopclues0408'; // SMTP password
		$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                          // TCP port to connect to

		$mail->setFrom('shopclueskhan007@gmail.com', 'CodexWorld');
		$mail->addReplyTo('shopclueskhan007@gmail.com', 'CodexWorld');
		$mail->addAddress('shubhi.lohani@gmail.com');   // Add a recipient

		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = "Hi please click here <a href= $url>Verify</a> to verify";
		$bodyContent .= '<p>This is the HTML email sent from localhost using PHP script by <b>CodexWorld</b></p>';

		$mail->Subject = 'Email from Localhost by CodexWorld';
		$mail->Body    = $bodyContent;

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}

//}

/*VERIFY PAGE*/

 // $empId= $_GET['id'];
 // $encrypt= $_GET['encrypt'];

//fetch email
//encrypt
//match th encrypted code with the request variable
//if true then mark the employee as verified

?>