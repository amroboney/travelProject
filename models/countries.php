<?php
class Countries{
  
    // database connection and table name
    private $conn;
    private $table_name = "countries";
  
    // object properties
    public $id;
    public $name;
    public $plag;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function get(){
        // select all query
        $query = "SELECT * FROM " . $this->table_name ;
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
}