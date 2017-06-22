<?php


require_once 'include/DB_Functions.php';
$db = new Db_Functions();

 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['employee_id']) && isset($_GET['email']) && isset($_GET['unique_id']) && isset($_GET['created_at']) && isset($_GET['updated_at'])) {
 
    // receiving the post params
    
    $email = $_GET['email'];
    $employee_id = $_GET['employee_id'];
    $unique_id = $_GET['unique_id'];
    $created_at = $_GET['created_at'];
    $updated_at = $_GET['updated_at'];

    if ($db->isEmployeeVerified($employee_id, $email, $unique_id, $created_at, $updated_at)) {

        $response["error"] = FALSE;
        $response['error_msg'] = "Your account has been activated!";
        echo json_encode($response);
    }

    else{

        $response["error"] = TRUE;
        $response['error_msg'] = "Account has already been activated or the URL is invalid!";
        echo json_encode($response);
    }

    
   }

?>
