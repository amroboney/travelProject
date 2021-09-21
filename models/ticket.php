<?php
class Ticket{


    // database connection and table name
    private $conn;
    private $table_name = "tickets";
  
    // object properties
    public $id;
    public $travel_id;
    public $is_adult;
    public $is_child;
    public $is_has_spesial_services;
    public $passport_number;
    public $passport_issue_date;
    public $passport_expiry_date;
    public $pagges_20_kg;
    public $pagges_30_kg;
    // public $ticket_date_time;
    public $customer_id;
    public $ticket_status_id = 1;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // create product
    function create(){
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    travel_id=:travel_id,
                    is_adult=:is_adult,
                    is_child=:is_child,
                    is_has_spesial_services=:is_has_spesial_services,
                    passport_issue_date=:passport_issue_date,
                    passport_number=:passport_number,
                    passport_expiry_date=:passport_expiry_date,
                    pagges_20_kg=:pagges_20_kg,
                    pagges_30_kg=:pagges_30_kg,
                    ticket_status_id=:ticket_status_id,
                    customer_id=:customer_id";
        echo $query;
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->travel_id=htmlspecialchars(strip_tags($this->travel_id));
        $this->is_adult=htmlspecialchars(strip_tags($this->is_adult));
        $this->is_child=htmlspecialchars(strip_tags($this->is_child));
        $this->is_has_spesial_services=htmlspecialchars(strip_tags($this->is_has_spesial_services));
        $this->passport_number=htmlspecialchars(strip_tags($this->passport_number));
        $this->passport_issue_date=htmlspecialchars(strip_tags($this->passport_issue_date));
        $this->passport_expiry_date=htmlspecialchars(strip_tags($this->passport_expiry_date));
        $this->pagges_20_kg=htmlspecialchars(strip_tags($this->pagges_20_kg));
        $this->pagges_30_kg=htmlspecialchars(strip_tags($this->pagges_30_kg));
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
    
        // bind values
        $stmt->bindParam(":travel_id", $this->travel_id);
        $stmt->bindParam(":is_adult", $this->is_adult);
        $stmt->bindParam(":is_child", $this->is_child);
        $stmt->bindParam(":is_has_spesial_services", $this->is_has_spesial_services);
        $stmt->bindParam(":passport_number", $this->passport_number);
        $stmt->bindParam(":passport_issue_date", $this->passport_issue_date);
        $stmt->bindParam(":passport_expiry_date", $this->passport_expiry_date);
        $stmt->bindParam(":pagges_20_kg", $this->pagges_20_kg);
        $stmt->bindParam(":pagges_30_kg", $this->pagges_30_kg);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":ticket_status_id", $this->ticket_status_id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // public function get(){

    // }
}