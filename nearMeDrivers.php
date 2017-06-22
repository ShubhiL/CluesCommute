<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['employee_id'])) {
 
    // receiving the post params
    $employee_id = $_GET['employee_id'];
     
    // get the user by email and password
    $driverArray = $db->getSameZoneDrivers($employee_id);
    $number = count($driverArray);
    //print_r($driverArray);
 
    if ($driverArray != false) {
        
        $response["error"] = FALSE;

        for ($i=0; $i< $number; $i++){

        	$response["user"][$i] = array("employee_id"=>$driverArray[$i][0],"name"=>$driverArray[$i][1],"address"=>$driverArray[$i][6],"designation"=>$driverArray[$i][7]);
            

    	}
            //$str=json_encode($response);
            echo json_encode($response);die;


     } 
    else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "employee_id not correct. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter is missing!";
    echo json_encode($response);
}
?>
