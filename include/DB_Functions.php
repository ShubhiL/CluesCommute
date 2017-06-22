<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'include/DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password, $employee_id) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(name, unique_id, employee_id, email, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $name, $uuid, $employee_id, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);

            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }

    // Verifying employee 
    
    public function isEmployeeVerified($employee_id, $email, $unique_id, $created_at, $updated_at = NULL){

        if ($updated_at!=NULL){

        $stmt = $this->conn->prepare("SELECT * from users WHERE email = ? AND employee_id = ? AND unique_id = ? AND created_at = ? AND updated_at = ? AND active='0'");
 
        $stmt->bind_param("sssss", $email, $employee_id, $unique_id, $created_at, $updated_at);
    }
    else{

        $stmt = $this->conn->prepare("SELECT * from users WHERE email = ? AND employee_id = ? AND unique_id = ? AND created_at = ? AND active='0'");
 
        $stmt->bind_param("ssss", $email, $employee_id, $unique_id, $created_at);

    }
 
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows > 0) {
            
        // user existed 
        $stmt = $this->conn->prepare("UPDATE users SET active = '1' WHERE employee_id = ?");
        $stmt->bind_param("s", $employee_id);
        $result = $stmt->execute();
        $stmt->close();   
        return true;
        } 

    else {
            // user not existed
            $stmt->close();
            return false;
        }
  
    }

    //Fetching data of user

    public function dataFetch($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users where email = ?");
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $data = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $data;
        } else {
            $stmt->close();
            return NULL;
        }
    }

    //Fetching Drivers in same zone

    public function getSameZoneDrivers($employee_id){ 
        
        $stmt = $this->conn->prepare("SELECT zone_id FROM details where employee_id = ?");
        $stmt->bind_param("s", $employee_id);
 	    $stmt->execute();
        $data= $stmt->get_result()->fetch_assoc()["zone_id"];
        $stmt->close();     

        $stmt = $this->conn->prepare("SELECT * FROM details where zone_id= ? AND vehicle=1 AND employee_id != ?");
        $stmt->bind_param("ss", $data, $employee_id);
 
        if ($stmt->execute()) {

                $data = $stmt->get_result()->fetch_all();
                print_r($data);                         
                $stmt->close();
                return $data;
        }
                       
        else
            return false;
        
    }   

    //Fetching people in same zone

    public function getSameZonePeople($employee_id){ 

        $stmt = $this->conn->prepare("SELECT zone_id FROM details where employee_id = ?");
        $stmt->bind_param("s", $employee_id);
        $stmt->execute();
        $data= $stmt->get_result()->fetch_assoc()["zone_id"];
        $stmt->close();
        
        $stmt = $this->conn->prepare("SELECT employee_id, name, address, designation FROM details where zone_id= ? AND employee_id != ?");
        $stmt->bind_param("ss", $data, $employee_id);
 
        if ($stmt->execute()) {

                $data = $stmt->get_result()->fetch_all();
                $stmt->close();
                return $data;
        }
                       
        else
            return false;
        
    }         
    
}
 
?>