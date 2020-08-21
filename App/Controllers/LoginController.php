<?php
    namespace App\Controllers;
    use \App\Controllers\ApiController as Api;

    Class LoginController{
        public function makeLogin($request){

          $Api = new Api;
          $Api->url='http://localhost/api/v1/user/logIn';
          $Api->method='GET';
          $Api->params = $request;
          $Api->bearer = false;
          $response = $Api->hitEndPoint();
          $httpcode = $Api->http_status;

          //se hace manejo de la respuesta de la api
          if($httpcode==200){//Está ok, puede iniciar sesión dentro de la app
            session_start();
            $_SESSION['activeuser'] = $response;
            http_response_code($httpcode);
          }else{//No está autorizado o ha habido algun error.
            http_response_code($httpcode);
            echo $response;
          }
        }

        public function logOut(){
          session_start();
          unset($_SESSION);
          session_destroy();
          header("Location: /");
        }
    }
?>
