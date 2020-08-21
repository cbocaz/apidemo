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
        public $lastlogin;

        public function __construct($db){
                $this->conn = $db;
        }

        public function autenticateUser($username,$password){
                //Los password guardados con md5 no son tan seguros. Lo mejor sería concatener el pass con una key y ecnriptar
                $query = "SELECT id, username, fullname, admin, lastlogin FROM " . $this->table_name . " ";
                $query.= "WHERE username=:username and password=:password";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $password);
                $stmt->execute();

                return $stmt;
        }

        public function getAll(){
                $query = "SELECT id, username, fullname, admin, lastlogin FROM " . $this->table_name . ";";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt;
        }

        public function updateLastLogin($id){
                $query = "UPDATE " . $this->table_name . " SET lastlogin=now() WHERE id=:id;";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                return $stmt;
        }

        public function saveNewUser(){
                //TODO: crear manejador de errores, para cuando se intente crear un usuario existente
                $query = "INSERT INTO " . $this->table_name . " (username,fullname,password,admin,lastlogin) VALUES (:username,:fullname,:password,:admin,now());";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":fullname", $this->fullname);
                $stmt->bindParam(":password", $this->password);
                $stmt->bindParam(":admin", $this->admin,\PDO::PARAM_BOOL);
                $stmt->execute();

                // ob_start();
                // $stmt->debugDumpParams();
                // $r = ob_get_contents();
                // ob_end_clean();
                // error_log(print_r($r,true));

                return $stmt;
        }

        public function deleteUser($id){
                $query = "DELETE FROM " . $this->table_name . " WHERE id=:id;";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                return $stmt;
        }

        public function getUser($id){
                $query = "SELECT id, username, fullname, admin, lastlogin FROM " . $this->table_name . " WHERE id=:id;";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                return $stmt;
        }

        public function saveUpdateUser(){
                $query = "UPDATE " . $this->table_name . " SET fullname=:fullname, password=:password, admin=:admin WHERE id=:id;";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":fullname", $this->fullname);
                $stmt->bindParam(":password", $this->password);
                $stmt->bindParam(":admin", $this->admin,\PDO::PARAM_BOOL);
                $stmt->execute();
        }
    }
?>
