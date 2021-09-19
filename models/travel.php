<?php
class Customer{
  
    // database connection and table name
    private $conn;
    private $table_name = "customers";
  
    // object properties
    public $id;
    public $name;
    public $user_name;
    public $phone;
    public $password;
    public $created_at;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function get(){
        // select all query
        $query = "SELECT id, name,phone, user_name,password, created_at FROM " . $this->table_name ;
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }


    // create product
    function create(){
        
        if($this->isAlreadyExist()){
            return false;
        }

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, user_name=:user_name, phone=:phone, password=:password";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":password", $this->password);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }


    // login user method
    function login(){
        // select all query with user inputed username and password
        $query = "SELECT
                    `id`, `user_name`, `password`, `created_at`
                FROM
                    " . $this->table_name . " 
                WHERE
                    user_name='".$this->user_name."' AND password='".$this->password."'";
        // prepare query statement
        // echo $query;
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // to check if user name is exist ot not
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                user_name='".$this->user_name."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}