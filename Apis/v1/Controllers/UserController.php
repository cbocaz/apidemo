<?php
    namespace Controllers;
    use \Database\Connector;

    Class UserController{
        private $connection;

        public function __construct(){
            /* Genero la conexión del controlador en el constructor */
            $connector = new Connector;
            $this->connection = $connector->getConnection();
        }        

        public function logIn(){
            $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
            $user = new \Models\User($this->connection);
            $user_list = $user->autenticateUser($username,$password);
            $rowCount  = $user_list->rowCount();
            $response = [];

            if($rowCount>0){
                $response['rowCount']=$rowCount;
                $response['records']=[];
    
                while($row = $user_list->fetch(\PDO::FETCH_ASSOC)){
                    $row['id'] = (int)$row['id'];
                    $row['admin'] = filter_var($row['admin'],FILTER_VALIDATE_BOOLEAN);
                    array_push($response['records'],$row);
                }
                http_response_code(200);//OK
            }else{
                $response['message']="Nombre de usuario o contraseña incorrectos.";
                http_response_code(404);//Not Found
            }
            echo json_encode($response);            
        }

        public function getAll(){
            $user = new \Models\User($this->connection);
            $user_list = $user->getAll();
            $rowCount  = $user_list->rowCount();
            $response = [];

            if($rowCount>0){
                $response['rowCount']=$rowCount;
                $response['records']=[];
    
                while($row = $user_list->fetch(\PDO::FETCH_ASSOC)){
                    $row['id'] = (int)$row['id'];
                    $row['admin'] = filter_var($row['admin'],FILTER_VALIDATE_BOOLEAN);
                    array_push($response['records'],$row);
                }
                http_response_code(200);//OK
            }else{
                $response['message']="No se encontraron registros.";
                http_response_code(404);//Not Found
            }
            echo json_encode($response);
        }
    }
?>