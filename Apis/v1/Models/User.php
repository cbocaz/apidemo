<?php
    namespace Models;
    
    Class User{
        private $conn;
        private $table_name = "users";

        public $id;
        public $username;
        public $password;
        public $fullname;
        public $admin;

        public function __construct($db){
            $this->conn = $db;
        }

        public function autenticateUser($username,$password){
                $query = "SELECT id, username, fullname, admin FROM " . $this->table_name . " ";
                $query.= "WHERE username=:username and password=:password";
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", md5($password));

                $stmt->execute();
                return $stmt;
        }

        public function getAll(){
                $query = "SELECT id, username, fullname, admin FROM " . $this->table_name . ";";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt;
        }
    }
?>