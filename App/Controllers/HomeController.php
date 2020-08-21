<?php
    namespace App\Controllers;
    use \App\Controllers\ApiController as Api;

    Class HomeController{
      public function __construct($request){
          session_start();
          //se podría implentar una capa adicional verificando el token con la key de la api
          if(isset($_SESSION['activeuser'])){
            //Defino la variable $active user desde la sesion
            $activeuser = json_decode($_SESSION['activeuser']);
            //Genero la lista de usuarios para la tabla
            $response = $this->loadUserList($activeuser->token);
            $respnseUserlist = json_decode($response);
            $userlist = $respnseUserlist->records;
            $rowCount = $respnseUserlist->rowCount;
            //cargo la plantilla
            require_once 'App/Views/home.php';
          }else{
            http_response_code(401);//sin autorización
            header("Location: /login/logOut");
          }
      }
      public function loadUserList($token){
        $Api = new Api;
        $Api->url='http://localhost/api/v1/user/getAll';
        $Api->method='GET';
        $Api->token=$token;
        return $Api->hitEndPoint();
      }
    }
 ?>
