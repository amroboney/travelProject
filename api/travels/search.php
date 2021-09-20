<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/Database.php';
include_once '../../models/travel.php';

$database = new Database();
$db = $database->getConnection();
  
$travel = new Travel($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->from) &&
    !empty($data->to) &&
    !empty($data->travel_date)
){
  
    // set product property values
    $travel->from = $data->from;
    $travel->to = $data->to;
    $travel->travel_date = $data->travel_date;
    // find the travel

    $stmt = $travel->find();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // products array
        $travels_arr=array();
        $travels_arr["responseCode"]= '100';
        $travels_arr["responseMessage"]= 'Success';
        $travels_arr["data"]=array();

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
                "travel_date" => $travel_date,
                "plan_id" => $plan_id,
                "ecnomic_price" => $ecnomic_price,
                "bussnis_price" => $bussnis_price
        );

        array_push($travels_arr["data"], $product_item);
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($travels_arr);
        }

    }else{
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Can not find any travel."));
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