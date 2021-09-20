<?php
class Travel{
  
    // database connection and table name
    private $conn;
    private $table_name = "travels";
  
    // object properties
    public $id;
    public $code;
    public $from;
    public $to;
    public $departure_date;
    public $arrival_date;
    public $travel_date;
    public $plan_id;
    public $ecnomic_price;
    public $bussnis_price;
    public $created_at;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function find(){

        // query to insert record
        $query = "SELECT * FROM `travels` WHERE `from` = 1 AND `to` = 2 AND `travel_date` = '2021-09-20'";
        // $query = "SELECT * FROM
        //             " . $this->table_name . " 
        //         WHERE
        //             'from'=".$this->from." AND 'to'=".$this->to." AND 'travel_date' = '".$this->travel_date."'";
        // prepare query
        $stmt = $this->conn->prepare($query);
 
        // execute query
        $stmt->execute();
        return $stmt;
        
    }
}