<?php
    namespace App\Controllers;
    use \App\Controllers\ApiController as Api;

    Class UserController{
      private $activeuser;

      public function __construct(){
          session_start();
          //se podría implentar una capa adicional verificando el token con la key de la api
          if(isset($_SESSION['activeuser'])){
            //Defino la variable $active user desde la sesion
            $this->activeuser = json_decode($_SESSION['activeuser']);
          }else{
            http_response_code(401);//sin autorización
            header("Location: /login/logOut");
          }
      }

      public function newUser(){
          $activeuser = $this->activeuser;
          require_once 'App/Views/new_user.php';
      }

      public function editUser($request){
          $activeuser = $this->activeuser;
          $id = $request['id'];

          $Api = new Api;
          $Api->url='http://localhost/api/v1/user/getUser';
          $Api->method='POST';
          $Api->params=$request;
          $Api->token=$activeuser->token;
          $response = $Api->hitEndPoint();
          $httpcode = $Api->http_status;

          $theUser = json_decode($response);

          require_once 'App/Views/edit_user.php';
      }

      public function createUser(){
          $activeuser = $this->activeuser;
          $Api = new Api;
          $Api->url='http://localhost/api/v1/user/createUser';
          $Api->method='POST';
          $Api->params=$_REQUEST;
          $Api->token=$activeuser->token;
          return $Api->hitEndPoint();
      }

      public function deleteUser($request){
          $activeuser = $this->activeuser;
          $Api = new Api;
          $Api->url='http://localhost/api/v1/user/deleteUser';
          $Api->method='POST';
          $Api->params=$request;
          $Api->token=$activeuser->token;
          $response = $Api->hitEndPoint();
          $httpcode = $Api->http_status;

          //se hace manejo de la respuesta de la api
          if($httpcode==200){//Está ok
            http_response_code($httpcode);
            header("Location: /Home");
            die();
          }else{//No está autorizado o ha habido algun error.
            http_response_code($httpcode);
            echo $response;
          }
      }

      public function updateUser(){
          $activeuser = $this->activeuser;
          $Api = new Api;
          $Api->url='http://localhost/api/v1/user/updateUser';
          $Api->method='POST';
          $Api->params=$_REQUEST;
          $Api->token=$activeuser->token;
          $response = $Api->hitEndPoint();
          $httpcode = $Api->http_status;

          //se hace manejo de la respuesta de la api
          if($httpcode==200){//Está ok
            http_response_code($httpcode);
            header("Location: /Home");
            die();
          }else{//No está autorizado o ha habido algun error.
            http_response_code($httpcode);
            echo $response;
          }
      }
    }
 ?>
