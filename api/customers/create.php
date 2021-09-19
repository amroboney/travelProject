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
    !empty($data->name) &&
    !empty($data->user_name) &&
    !empty($data->phone) &&
    !empty($data->password)
){
  
    // set product property values
    $customer->name = $data->name;
    $customer->user_name = $data->user_name;
    $customer->phone = $data->phone;
    $customer->password =  $hash = base64_encode($data->password); ;
    // $customer->password =  $hash = password_hash($data->password, PASSWORD_DEFAULT); ;
    // $customer->created = date('Y-m-d H:i:s');base64_encode
  
    // create the customer
    if($customer->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "customer was created."));
    }
  
    // if unable to create the customer, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>
  