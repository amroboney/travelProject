<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/Database.php';
include_once '../../models/ticket.php';

$database = new Database();
$db = $database->getConnection();
  
$ticket = new Ticket($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->travel_id) &&
    !empty($data->is_adult) &&
    !empty($data->is_child) &&
    !empty($data->is_has_spesial_services) &&
    !empty($data->passport_number) &&
    !empty($data->passport_issue_date) &&
    !empty($data->passport_expiry_date) &&
    !empty($data->pagges_20_kg) &&
    !empty($data->pagges_30_kg	) &&
    !empty($data->customer_id) 
){
  
    // set product property values
    $ticket->travel_id = $data->travel_id;
    $ticket->is_adult = $data->is_adult;
    $ticket->is_child = $data->is_child;
    $ticket->is_has_spesial_services = $data->is_has_spesial_services;
    $ticket->passport_number = $data->passport_number;
    $ticket->passport_issue_date = $data->passport_issue_date;
    $ticket->passport_expiry_date = $data->passport_expiry_date;
    $ticket->pagges_20_kg = $data->pagges_20_kg;
    $ticket->pagges_30_kg = $data->pagges_30_kg;
    $ticket->customer_id = $data->customer_id;
    // create the customer
    if($ticket->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "customer was created."));
    }




    // check if more than 0 record found
    if($num>0){
        // products array
        $ticket_arr=array();
        $ticket_arr["responseCode"]= '100';
        $ticket_arr["responseMessage"]= 'Success';
        $ticket_arr["data"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        
        $product_item= array(
                "id" => $id,
                "from" => $from,
                "to" => $to,
                "departure_date" => $departure_date,
                "arrival_date" => $arrival_date,
                "ticket_date" => $ticket_date,
                "plan_id" => $plan_id,
                "ecnomic_price" => $ecnomic_price,
                "bussnis_price" => $bussnis_price
        );

        array_push($ticket_arr["data"], $product_item);
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($ticket_arr);
        }

    }else{
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Can not find any ticket."));
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