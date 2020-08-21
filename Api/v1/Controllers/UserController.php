<?php
    namespace Controllers;
    use \Database\Connector;
    use \Controllers\TokenController;

    Class UserController{
        private $connection;

        public function __construct(){
            /* Genero la conexión del controlador en el constructor */
            $connector = new Connector;
            $this->connection = $connector->getConnection();
        }

        public function logIn(){

            $request = json_decode(file_get_contents('php://input'), true);

            $username = filter_var($request['username'],FILTER_SANITIZE_SPECIAL_CHARS);
            $password = md5(filter_var($request['password'],FILTER_SANITIZE_SPECIAL_CHARS));

            $user = new \Models\User($this->connection);
            $user_list = $user->autenticateUser($username,$password);
            $rowCount  = $user_list->rowCount();
            $response = [];

            if($rowCount==1){// Se hizo match con los datos de usuario enviados
                $response['record']=[];

                $row = $user_list->fetch(\PDO::FETCH_ASSOC);
                $row['id'] = (int)$row['id'];
                $row['admin'] = filter_var($row['admin'],FILTER_VALIDATE_BOOLEAN);
                //Quizá no es la forma segura, los datos podrían ir dentro del token.
                $response['record']=$row;
                $payload = [
                  "iss"=>$row['username'],
                  "admin"=>$row['admin'],
                  "exp"=>strtotime(date('Y-m-d H:i:s'). "+1 day"),
                  "lastlogin"=>$row['lastlogin']
                ];

                $token = new TokenController;
                $response['token']= $token->createToken($payload);

                //Luego de un login correcto, se actualiza la fecha/hora del último ingreso
                $user->updateLastLogin($row['id']);

                http_response_code(200);//OK
            }else{
                $response['message']="Nombre de usuario o contraseña incorrectos.";
                http_response_code(401);//No autorizado
            }
            echo json_encode($response);
        }

        public function getAll(){
            //validacion del token
            $token = new TokenController;
            $token->validateToken(Apache_request_headers());
            //$esadmin = $token->isAdmin();

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
        public function createUser(){
            //validacion del token
            $token = new TokenController;
            $token->validateToken(Apache_request_headers());
            $esadmin = $token->isAdmin();

            $request = json_decode(file_get_contents('php://input'), true);

            if(!$esadmin){
              $response['message']="No se encuentra autorizado para acciones de escritura.";
              http_response_code(401);//No autorizado
            }else{

              $username = filter_var($request['username'],FILTER_SANITIZE_SPECIAL_CHARS);
              $fullname = filter_var($request['fullname'],FILTER_SANITIZE_SPECIAL_CHARS);
              $password = md5(filter_var($request['password'],FILTER_SANITIZE_SPECIAL_CHARS));

              $admin = ($request['admin']=='true')?1:0;

              $user = new \Models\User($this->connection);
              $user->username = $username;
              $user->fullname = $fullname;
              $user->password = $password;
              $user->admin = $admin;
              $user->saveNewUser();
              $response['message']="Usuario Creado.";
              http_response_code(200);//OK
            }
            echo json_encode($response);
        }

        public function deleteUser(){
            $token = new TokenController;
            $token->validateToken(Apache_request_headers());
            $esadmin = $token->isAdmin();
            $request = json_decode(file_get_contents('php://input'), true);

            if(!$esadmin){
              $response['message']="No se encuentra autorizado para acciones de escritura.";
              http_response_code(401);//No autorizado
            }else{
              $id = filter_var($request['id'],FILTER_VALIDATE_INT);
              $user = new \Models\User($this->connection);
              $user->deleteUser($id);
              $response['message']="Usuario Eliminado.";
              http_response_code(200);//OK
            }
            echo json_encode($response);
        }

        public function getUser(){
            $token = new TokenController;
            $token->validateToken(Apache_request_headers());
            $esadmin = $token->isAdmin();
            $request = json_decode(file_get_contents('php://input'), true);

            if(!$esadmin){
              $response['message']="No se encuentra autorizado para acciones de escritura.";
              http_response_code(401);//No autorizado
            }else{
              $response['records']=[];
              $id = filter_var($request['id'],FILTER_VALIDATE_INT);

              $user = new \Models\User($this->connection);
              $userdata = $user->getUser($id);
              $row = $userdata->fetch(\PDO::FETCH_ASSOC);
              $response['records']=$row;

              http_response_code(200);//OK
            }
            echo json_encode($response);
        }

        public function updateUser(){
            //validacion del token
            $token = new TokenController;
            $token->validateToken(Apache_request_headers());
            $esadmin = $token->isAdmin();

            $request = json_decode(file_get_contents('php://input'), true);

            if(!$esadmin){
              $response['message']="No se encuentra autorizado para acciones de escritura.";
              http_response_code(401);//No autorizado
            }else{

              $id = filter_var($request['id'],FILTER_VALIDATE_INT);
              $fullname = filter_var($request['fullname'],FILTER_SANITIZE_SPECIAL_CHARS);
              $password = md5(filter_var($request['password'],FILTER_SANITIZE_SPECIAL_CHARS));

              $admin = ($request['admin']=='true')?1:0;

              $user = new \Models\User($this->connection);
              $user->id = $id;
              $user->fullname = $fullname;
              $user->password = $password;
              $user->admin = $admin;
              $user->saveUpdateUser();
              $response['message']="Usuario Editado.";
              http_response_code(200);//OK
            }
            echo json_encode($response);
        }
    }
?>
