<?php
 
require_once 'include/DB_Functions.php';
require 'PHPMailer/PHPMailerAutoload.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['employee_id'])) {
 
    // receiving the post params
    $name = $_GET['name'];
    $email = $_GET['email'];
    $password = $_GET['password'];
    $employee_id = $_GET['employee_id'];

    $domain = explode('@', $email);
    $match=strcmp("shopclues.com", $domain[1]);
 
    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response); 
    } 

    else if($match!=0){

             $response["error"] = TRUE;
             $response["error_msg"] = "Invalid email- " . $email;
             echo json_encode($response);
    } 

    else {
        // create a new user
        $user = $db->storeUser($name, $email, $password, $employee_id);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            $response["user"]["employee_id"] = $user["employee_id"];
            echo json_encode($response);
            
            //mail
            
            $row= $db->dataFetch($email);
            $emp_id=$row["employee_id"];
            $email=$row["email"];
            $unique_id=$row["unique_id"]; 
            $created_at=$row["created_at"]; 
            $time = explode(' ', $created_at);
            $updated_at=$row["updated_at"];

            if ($updated_at!=NULL){
                $Utime = explode(' ', $updated_at); 
                $url="http://localhost/android_login_api/verifytest.php?employee_id=$emp_id&email=$email&unique_id=$unique_id&created_at=$time[0]%20$time[1]&updated_at=$Utime[0]%20$Utime[1]";
            }
    
            else{
               $url="http://localhost/android_login_api/verifytest.php?employee_id=$emp_id&email=$email&unique_id=$unique_id&created_at=$time[0]%20$time[1]&updated_at=";
            }
            
            $mail = new PHPMailer;
            $mail->isSMTP();                            // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                     // Enable SMTP authentication
            $mail->Username = 'shopclueskhan007';          // SMTP username
            $mail->Password = 'shopclues0408'; // SMTP password
            $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                          // TCP port to connect to
    
            $mail->setFrom('shopclueskhan007@gmail.com', 'Clues Commute');
            $mail->addReplyTo('shopclueskhan007@gmail.com', 'Clues Commute');
            $mail->addAddress('shopclueskhan007@gmail.com');   // Add a recipient
    
            $mail->isHTML(true);  // Set email format to HTML
    
            $bodyContent = "Hi! Please click here <a href= $url>Verify</a> to verify";
            $bodyContent .= '<p>This is the HTML email sent from localhost using PHP script by <b>Clues Commute</b></p>';
    
            $mail->Subject = 'Email from Localhost by Clues Commute';
            $mail->Body    = $bodyContent;
    
            if(!$mail->send()){
                echo '\n Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } 
            else{
                echo ""."<br>"." Message has been sent";
            } 
        } 
        else{
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);}
        }
}
else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, password or employee_id) is missing!";
    echo json_encode($response);
    }
?>