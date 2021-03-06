<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/Database.php';
include_once '../../models/countries.php';
include_once '../../config/Response.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$countries = new Countries($db);

// query products
$stmt = $countries->get();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
  
    // products array
    $countries_arr=array();
    $countries_arr["responseCode"]= '100';
    $countries_arr["responseMessage"]= 'Success';
    $countries_arr["data"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $product_item= array(
            "id" => $id,
            "name" => $name,
            "plag" => $plag
        );
        array_push($countries_arr["data"], $product_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($countries_arr);

}
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}





