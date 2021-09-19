<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/Database.php';
include_once '../../models/customers.php';

$database = new Database();
$db = $database->getConnection();
  
$customer = new Customer($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->user_name) &&
    !empty($data->password)
){

    // set ID property of user to be edited
$customer->user_name = $data->user_name;
$customer->password = base64_encode($data->password);  

// read the details of user to be edited
$stmt = $customer->login();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $customer_arr=array(
        "responseCode" => 100,
        "responseMessage" => "Successfully Login!",
        "data" => [
            "id" => $row['id'],
            "user_name" => $row['user_name']
        ]
        
    );
}
else{
    $customer_arr=array(
        "status" => false,
        "message" => "Invalid Username or Password!",
    );
}

print_r(json_encode($customer_arr));

  


}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Data is incomplete."));
}
?>
  