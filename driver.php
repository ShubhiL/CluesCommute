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
 
    if ($driverArray != false) {
        // user is found
        $response["error"] = FALSE;

		$columns = array($driverArray);
		echo json_encode($columns);

        // $response["employee_id"] = $user["employee_id"];
        // $response["user"]["name"] = $user["name"];
        // $response["user"]["address"] = $user["address"];
        // $response["user"]["designation"] = $user["designation"];
        // echo json_encode($response);
    } else {
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